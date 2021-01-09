<?php

namespace TOT\Integrations\WooCommerce;

use TOT\Settings\Page;

class Settings
{
    private $text_domain;

    function __construct()
    {
        global $tot_plugin_text_domain;
        $this->text_domain = $tot_plugin_text_domain;
    }

    public function register_wordpress_hooks()
    {
        add_action('plugins_loaded', array($this, 'register_wordpress_hooks_after_load'));
    }

    public function register_wordpress_hooks_after_load()
    {
        if (!class_exists('WooCommerce')) {
            return;
        }

        add_action('admin_menu', array($this, 'create_page'));
        add_action('admin_notices', array($this, 'admin_notice'));
        add_action('admin_init', array($this, 'admin_init'));
    }

    public function admin_init()
    {
        if (isset($_GET['page']) && (sanitize_text_field($_GET['page']) != 'tot_settings_woocommerce')) {
            return;
        }

        if (!$this->is_beta_enabled()) {
            tot_refresh_keys();
        }
    }

    public function is_beta_enabled()
    {
        $keys = tot_get_keys();

        if (
            !is_wp_error($keys) &&
            isset($keys['wooCommerceBeta'])
            && (
                ($keys['wooCommerceBeta'] == 'enable')
                || ($keys['wooCommerceBeta'] == 'enabled')
            )
        ) {
            return true;
        }

        return false;
    }

    public function admin_notice()
    {

        if (!isset($_GET['page']) || (sanitize_text_field($_GET['page']) != 'tot_settings_woocommerce')) {
            return;
        }

        if ($this->is_beta_enabled()) {
            return;
        }


        ?>
        <div class="notice notice-warning">
            <h1>This feature is currently in beta.</h1>
            <p>Please contact us at <a href="mailto:support@tokenoftrust.com">support@tokenoftrust.com</a> if you’d like
                to participate in the WooCommerce Beta.</p>

            <h2>What does our WooCommerce support include?</h2>
            <p>Currently this feature is in support of the purchase of wine, cigars, e-cigs, cannabis or other goods
                where you must verify age before allowing shipment. To do this the plugin modifies the checkout process
                to verify guest age before releasing orders.</p>

            <h2>Can I choose which products to run verification on?</h2>
            <p>Yes. We support the ability to run verification conditionally based upon:</p>
            <ul>
                <li> - The overall cost of the order.</li>
                <li> - The category of the goods involved in the order.</li>
                <li> - Tags associated with goods involved in the order.</li>
            </ul>
        </div>
        <?php
    }

    public function create_page()
    {

        if (!$this->is_beta_enabled()) {
            new Page('WooCommerce', array());
            return;
        }

        $payment_options = array();
        $gateways = WC()->payment_gateways->payment_gateways();
        if (!is_wp_error($gateways)) {
            forEach ($gateways as $method) {
                if(isset( $method->enabled ) && 'yes' === $method->enabled  ) {
                    array_push($payment_options, array(
                        'label' => $method->title,
                        'value' => $method->id
                    ));
                }
            }
            // List disabled AFTER enabled.
            forEach ($gateways as $method) {
                if(!isset( $method->enabled ) || 'yes' !== $method->enabled  ) {
                    array_push($payment_options, array(
                        'label' => $method->title . ' (disabled)',
                        'value' => $method->id
                    ));
                }
            }
        }


        $category_options = array();
        $category_results = get_terms('product_cat', array(
            'orderby' => 'name',
            'order' => 'asc',
            'hide_empty' => false,
        ));
        if (!is_wp_error($category_results)) {
            forEach ($category_results as $category) {
                array_push($category_options, array(
                    'label' => $category->name,
                    'value' => $category->term_id
                ));
            }
        }

        $tag_options = array();
        $tag_results = get_terms('product_tag', array(
            'orderby' => 'name',
            'order' => 'asc',
            'hide_empty' => false,
        ));
        if (!is_wp_error($tag_results)) {
            forEach ($tag_results as $tag) {
                array_push($tag_options, array(
                    'label' => $tag->name,
                    'value' => $tag->term_id
                ));
            }
        }

        $try_order_verification_url = get_site_url() . '?checkout_require=1';
        $try_order_verifications_anchor = '<a href="' . $try_order_verification_url . '">' . $try_order_verification_url . '</a>';

        new Page('WooCommerce', array(
            __('Order Verification', $this->text_domain) => array(
                'description' => '',
                'fields' => array(
                    array(
                        'id' => 'checkout_require',
                        'type' => 'checkbox',
                        'label' => __('Enable checkout verification', $this->text_domain),
                        'options' => array(
                            'prepend' => array(),
                            'append' => array(
                                '<br>' . __('Advanced: To test without enabling for your entire site, copy this link, paste into a new incognito window and go through the checkout process. That incognito session will behave as if checkout verification is active for about 30 minutes: : ', $this->text_domain) . $try_order_verifications_anchor
                            )
                        )
                    ),
                ),
            ),
            __('Orders Considered for Verification', $this->text_domain) => array(
                'description' => __('Orders matching ANY of these conditions are considered for verification.', $this->text_domain),
                'fields' => array(
                    array(
                        'id' => 'checkout_require_total_amount',
                        'type' => 'currency',
                        'label' => __('Minimum order amount', $this->text_domain),
                        'options' => array(
                            'prepend' => array(),
                            'append' => array(
                                __('Example: 4.00', $this->text_domain),
                                __("Always require verification for orders that are more than this amount. Specify '0' for all orders.", $this->text_domain)
                            ),
                            'default_value' => ''
                        )
                    ),
                    array(
                        'id' => 'checkout_require_categories',
                        'type' => 'multiselect',
                        'label' => __('Categories', $this->text_domain),
                        'options' => array(
                            'prepend' => array(),
                            'append' => array(
                                __('Always require verification for orders containing a product with any of these categories.', $this->text_domain)
                            ),
                            'options' => $category_options
                        )
                    ),
                    array(
                        'id' => 'checkout_require_tags',
                        'type' => 'multiselect',
                        'label' => __('Tags', $this->text_domain),
                        'options' => array(
                            'prepend' => array(),
                            'append' => array(
                                __('Always require verification for orders containing a product with any of these tags.', $this->text_domain)
                            ),
                            'options' => $tag_options
                        )
                    )
                )
            ),
            __('Order Verification Requirements', $this->text_domain) => array(
                'description' => __('Leave these fields alone to verify all "Orders Considered for Verification" above. Add criteria below to limit considered orders to only those meeting these requirements.', $this->text_domain),
                'fields' => array(
                    array(
                        'id' => 'checkout_require_payment_methods',
                        'type' => 'multiselect',
                        'label' => __('Payment Methods Requiring Verification', $this->text_domain),
                        'options' => array(
                            'prepend' => array(),
                            'append' => array(
                                __('Require verification for orders using these payment methods. Leave empty to accept all current and future payment methods.', $this->text_domain)
                            ),
                            'options' => $payment_options
                        )
                    ),
                )
            ),
            __('Verification results', $this->text_domain) => array(
                'description' => '',
                'fields' => array(
                    array(
                        'id' => 'min_age',
                        'type' => 'number',
                        'label' => __('Minimum age', $this->text_domain),
                        'options' => array(
                            'prepend' => array(),
                            'append' => array(
                                __('Accept orders when the verified age is greater than this.', $this->text_domain)
                            )
                        )
                    ),
                    array(
                        'id' => 'dont_force_accept_on_app_approve',
                        'type' => 'checkbox',
                        'label' => __('(Advanced) Admin Review no override.', $this->text_domain),
                        'options' => array(
                            'prepend' => array(),
                            'append' => array(
                                __('When checked Admin Review of IDs means that documents (e.g. govt ID) are approved but other rules (e.g. age) are still verified independently to determine if the order can automatically move out of "Awaiting Verification".', $this->text_domain)
                            )
                        )
                    ),
                ),
            ),
        ));
    }

}
