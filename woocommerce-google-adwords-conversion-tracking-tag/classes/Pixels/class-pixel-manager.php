<?php

namespace WGACT\Classes\Pixels;

use  stdClass ;
use  WC_Order ;

if ( !defined( 'ABSPATH' ) ) {
    exit;
    // Exit if accessed directly
}

class Pixel_Manager
{
    protected  $options ;
    protected  $options_obj ;
    protected  $cart ;
    protected  $facebook_active ;
    protected  $google_active ;
    protected  $transaction_deduper_timeout = 2000 ;
    public function __construct( $options )
    {
        $this->options = $options;
        //        error_log(print_r($options, true));
        $this->options_obj = json_decode( json_encode( $this->options ) );
        $this->options_obj->shop->currency = new stdClass();
        $this->options_obj->shop->currency = get_woocommerce_currency();
        $this->facebook_active = !empty($this->options_obj->facebook->pixel_id);
        $this->google_active = $this->google_active();
        add_action( 'wp_enqueue_scripts', [ $this, 'wgact_front_end_scripts' ] );
        add_action( 'wp_head', function () {
            $this->inject_head_pixels();
        } );
        if ( did_action( 'wp_body_open' ) ) {
            add_action( 'wp_body_open', function () {
                $this->inject_body_pixels();
            } );
        }
    }
    
    public function wgact_front_end_scripts()
    {
        wp_enqueue_script(
            'front-end-scripts',
            plugin_dir_url( __DIR__ ) . '../js/public/wgact.js',
            array(),
            WGACT_CURRENT_VERSION,
            false
        );
    }
    
    public function inject_head_pixels()
    {
        global  $woocommerce ;
        $cart = $woocommerce->cart->get_cart();
        $cart_total = WC()->cart->get_cart_contents_total();
        echo  PHP_EOL . '<!-- START woopt Pixel Manager -->' . PHP_EOL ;
        $this->inject_wgact_order_deduplication_script();
        $this->inject_noptimize_opening_tag();
        if ( $this->google_active ) {
            ( new Google( $this->options, $this->options_obj ) )->inject_everywhere();
        }
        if ( $this->facebook_active ) {
            ( new Facebook_Pixel_Manager( $this->options, $this->options_obj ) )->inject_everywhere();
        }
        
        if ( is_product_category() ) {
            if ( $this->google_active ) {
                ( new Google( $this->options, $this->options_obj ) )->inject_product_category();
            }
        } elseif ( is_search() ) {
            if ( $this->google_active ) {
                ( new Google( $this->options, $this->options_obj ) )->inject_search();
            }
            if ( $this->facebook_active ) {
                ( new Facebook_Pixel_Manager( $this->options, $this->options_obj ) )->inject_search();
            }
        } elseif ( is_product() && !isset( $_POST['add-to-cart'] ) ) {
            $product_id = get_the_ID();
            $product = wc_get_product( $product_id );
            $product_id_compiled = $this->get_compiled_product_id( $product_id, $product->get_sku() );
            if ( is_bool( $product ) ) {
                //               error_log( 'WooCommerce detects the page ID ' . $product_id . ' as product, but when invoked by wc_get_product( ' . $product_id . ' ) it returns no product object' );
                return;
            }
            if ( $this->google_active ) {
                ( new Google( $this->options, $this->options_obj ) )->inject_product( $product_id_compiled, $product );
            }
            if ( $this->facebook_active ) {
                ( new Facebook_Pixel_Manager( $this->options, $this->options_obj ) )->inject_product( $product_id_compiled, $product );
            }
        } elseif ( is_cart() && !empty($cart) ) {
            if ( $this->google_active ) {
                ( new Google( $this->options, $this->options_obj ) )->inject_cart( $cart, $cart_total );
            }
            if ( $this->facebook_active ) {
                ( new Facebook_Pixel_Manager( $this->options, $this->options_obj ) )->inject_cart( $cart, $cart_total );
            }
        } elseif ( is_order_received_page() ) {
            // get order from URL and evaluate order total
            
            if ( isset( $_GET['key'] ) ) {
                $order_key = $_GET['key'];
                $order = new WC_Order( wc_get_order_id_by_order_key( $order_key ) );
                $conversion_prevention = false;
                $conversion_prevention = apply_filters( 'wgact_conversion_prevention', $conversion_prevention, $order );
                
                if ( !$order->has_status( 'failed' ) && !current_user_can( 'edit_others_pages' ) && $conversion_prevention == false && (!$this->options['shop']['order_deduplication'] || get_post_meta( $order->get_id(), '_WGACT_conversion_pixel_fired', true ) != true) ) {
                    
                    if ( is_user_logged_in() ) {
                        $user = get_current_user_id();
                    } else {
                        $user = $order->get_billing_email();
                    }
                    
                    $is_new_customer = !$this->has_bought( $user );
                    $order_total = ( 0 == $this->options_obj->shop->order_total_logic ? $order->get_subtotal() - $order->get_total_discount() : $order->get_total() );
                    // filter to adjust the order value
                    $order_total = apply_filters( 'wgact_conversion_value_filter', $order_total, $order );
                    $order_item_ids = $this->get_order_item_ids( $order );
                    if ( $this->google_active ) {
                        ( new Google( $this->options, $this->options_obj ) )->inject_order_received_page(
                            $order,
                            $order_total,
                            $order_item_ids,
                            $is_new_customer
                        );
                    }
                    if ( $this->facebook_active ) {
                        ( new Facebook_Pixel_Manager( $this->options, $this->options_obj ) )->inject_order_received_page( $order, $order_total, $order_item_ids );
                    }
                    $this->inject_transaction_deduper_script( $order->get_id() );
                } else {
                }
            
            }
        
        }
        
        $this->inject_noptimize_closing_tag();
        echo  PHP_EOL . '<!-- END woopt Pixel Manager -->' . PHP_EOL ;
    }
    
    private function inject_transaction_deduper_script( $order_id )
    {
        ?>
        <script>
            jQuery(function () {
                setTimeout(function () {
                    if (typeof wgact !== "undefined") {
                        wgact.writeOrderIdToStorage(<?php 
        echo  $order_id ;
        ?>);
                    }
                }, <?php 
        echo  $this->transaction_deduper_timeout ;
        ?>);
            });

        </script>
        <?php 
    }
    
    private function inject_wgact_order_deduplication_script()
    {
        ?>
        <script>
            let wgact_order_deduplication = <?php 
        echo  ( $this->options['shop']['order_deduplication'] ? 'true' : 'false' ) ;
        ?>;
        </script>
        <?php 
    }
    
    private function inject_body_pixels()
    {
        //        (new Google())->inject_google_optimize_anti_flicker_snippet();
    }
    
    private function inject_noptimize_opening_tag()
    {
        ?>
        <!--noptimize--><?php 
    }
    
    private function inject_noptimize_closing_tag()
    {
        ?>
        <!--/noptimize-->
        <?php 
    }
    
    protected function get_order_item_ids( $order )
    {
        $order_items = $order->get_items();
        $order_items_array = [];
        foreach ( (array) $order_items as $item ) {
            $product_id = $item['product_id'];
            $product = wc_get_product( $product_id );
            $product_id_compiled = $this->get_compiled_product_id( $item['product_id'], $product->get_sku() );
            array_push( $order_items_array, $product_id_compiled );
        }
        // apply filter to the $order_items_array array
        $order_items_array = apply_filters( 'wgact_filter', $order_items_array, 'order_items_array' );
        return $order_items_array;
    }
    
    private function google_active() : bool
    {
        
        if ( $this->options_obj->google->analytics->universal->property_id ) {
            return true;
        } elseif ( $this->options_obj->google->analytics->ga4->measurement_id ) {
            return true;
        } elseif ( $this->options_obj->google->ads->conversion_id ) {
            return true;
        } else {
            return false;
        }
    
    }
    
    protected function get_compiled_product_id( $product_id, $product_sku ) : string
    {
        // depending on setting use product IDs or SKUs
        
        if ( 0 == $this->options['google']['ads']['product_identifier'] ) {
            return (string) $product_id;
        } else {
            
            if ( 1 == $this->options['google']['ads']['product_identifier'] ) {
                return (string) 'woocommerce_gpf_' . $product_id;
            } else {
                
                if ( $product_sku ) {
                    return (string) $product_sku;
                } else {
                    return (string) $product_id;
                }
            
            }
        
        }
    
    }
    
    // https://stackoverflow.com/a/46216073/4688612
    private function has_bought( $value = 0 ) : bool
    {
        global  $wpdb ;
        // Based on user ID (registered users)
        
        if ( is_numeric( $value ) ) {
            $meta_key = '_customer_user';
            $meta_value = ( $value == 0 ? (int) get_current_user_id() : (int) $value );
        } else {
            $meta_key = '_billing_email';
            $meta_value = sanitize_email( $value );
        }
        
        $paid_order_statuses = array_map( 'esc_sql', wc_get_is_paid_statuses() );
        $count = $wpdb->get_var( $wpdb->prepare( "\n        SELECT COUNT(p.ID) FROM {$wpdb->prefix}posts AS p\n        INNER JOIN {$wpdb->prefix}postmeta AS pm ON p.ID = pm.post_id\n        WHERE p.post_status IN ( 'wc-" . implode( "','wc-", $paid_order_statuses ) . "' )\n        AND p.post_type LIKE 'shop_order'\n        AND pm.meta_key = '%s'\n        AND pm.meta_value = %s\n        LIMIT 1\n    ", $meta_key, $meta_value ) );
        // Return a boolean value based on orders count
        return ( $count > 0 ? true : false );
    }

}