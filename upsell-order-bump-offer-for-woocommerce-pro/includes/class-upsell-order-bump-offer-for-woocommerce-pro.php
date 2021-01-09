<?php
/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://makewebbetter.com/
 * @since      1.0.0
 *
 * @package    Upsell_Order_Bump_Offer_For_Woocommerce_Pro
 * @subpackage Upsell_Order_Bump_Offer_For_Woocommerce_Pro/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Upsell_Order_Bump_Offer_For_Woocommerce_Pro
 * @subpackage Upsell_Order_Bump_Offer_For_Woocommerce_Pro/includes
 * @author     Make Web Better <webmaster@makewebbetter.com>
 */
class Upsell_Order_Bump_Offer_For_Woocommerce_Pro {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @var      Upsell_Order_Bump_Offer_For_Woocommerce_Pro_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		if ( defined( 'UPSELL_ORDER_BUMP_OFFER_FOR_WOOCOMMERCE_PRO_VERSION' ) ) {

			$this->version = UPSELL_ORDER_BUMP_OFFER_FOR_WOOCOMMERCE_PRO_VERSION;

		} else {

			$this->version = '1.0.0';
		}

		$this->plugin_name = 'upsell-order-bump-offer-for-woocommerce-pro';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Upsell_Order_Bump_Offer_For_Woocommerce_Pro_Loader. Orchestrates the hooks of the plugin.
	 * - Upsell_Order_Bump_Offer_For_Woocommerce_Pro_I18n. Defines internationalization functionality.
	 * - Upsell_Order_Bump_Offer_For_Woocommerce_Pro_Admin. Defines all hooks for the admin area.
	 * - Upsell_Order_Bump_Offer_For_Woocommerce_Pro_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-upsell-order-bump-offer-for-woocommerce-pro-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-upsell-order-bump-offer-for-woocommerce-pro-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-upsell-order-bump-offer-for-woocommerce-pro-admin.php';

		$this->loader = new Upsell_Order_Bump_Offer_For_Woocommerce_Pro_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Upsell_Order_Bump_Offer_For_Woocommerce_Pro_I18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 */
	private function set_locale() {

		$plugin_i18n = new Upsell_Order_Bump_Offer_For_Woocommerce_Pro_I18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality of the plugin.
	 *
	 * @since    1.0.0
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Upsell_Order_Bump_Offer_For_Woocommerce_Pro_Admin( $this->get_plugin_name(), $this->get_version() );

		// Validate License Key.
		$this->loader->add_action( 'wp_ajax_mwb_upsell_bump_validate_license_key', $plugin_admin, 'mwb_upsell_bump_validate_license_key' );

		// Check daily that license is correct.
		$this->loader->add_action( 'mwb_upsell_bump_check_license_hook', $plugin_admin, 'mwb_upsell_bump_check_license' );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		$this->loader->add_action( 'plugins_loaded', $plugin_admin, 'license_redirect_pathvia_notice' );

		// Validate Free version compatibility.
		$this->loader->add_action( 'plugins_loaded', $plugin_admin, 'validate_version_compatibility' );

		$mwb_upsell_bump_callname_lic = self::$mwb_upsell_bump_lic_callback_function;

		$mwb_upsell_bump_callname_lic_initial = self::$mwb_upsell_bump_lic_ini_callback_function;

		$day_count = self::$mwb_upsell_bump_callname_lic_initial();

		if ( self::$mwb_upsell_bump_callname_lic() || 0 <= $day_count ) {

			$this->loader->add_filter( 'mwb_ubo_lite_heading', $plugin_admin, 'pro_heading' );

		}

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Upsell_Order_Bump_Offer_For_Woocommerce_Pro_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

	/**
	 * Public static variable to be accessed in this plugin.
	 *
	 * @var     callback string
	 * @since   1.0.0
	 */
	public static $mwb_upsell_bump_lic_callback_function = 'mwb_upsell_bump_check_lcns_validity';

	/**
	 * Public static variable to be accessed in this plugin.
	 *
	 * @var     callback string
	 * @since   1.0.0
	 */
	public static $mwb_upsell_bump_lic_ini_callback_function = 'mwb_upsell_bump_check_lcns_initial_days';

	/**
	 * Validate the use of features of this plugin.
	 *
	 * @since    1.0.0
	 */
	public static function mwb_upsell_bump_check_lcns_validity() {

		$mwb_upsell_bump_lcns_key = get_option( 'mwb_upsell_bump_license_key', '' );

		$mwb_upsell_bump_lcns_status = get_option( 'mwb_upsell_bump_license_check', '' );

		if ( $mwb_upsell_bump_lcns_key && true == $mwb_upsell_bump_lcns_status ) {

			return true;

		} else {

			return false;
		}
	}

	/**
	 * Validate the use of features of this plugin for initial days.
	 *
	 * @since    1.0.0
	 */
	public static function mwb_upsell_bump_check_lcns_initial_days() {

		$thirty_days = get_option( 'mwb_upsell_bump_activated_timestamp', 0 );

		$current_time = current_time( 'timestamp' );

		$day_count = ( $thirty_days - $current_time ) / ( 24 * 60 * 60 );

		return $day_count;
	}

	/**
	 * Skip offer product in case of the purchased in prevous orders.
	 *
	 * @param      string $offer_product_id    The Offer product id to check.
	 *
	 * @since    1.0.1
	 */
	public static function mwb_ubo_skip_for_pre_order( $offer_product_id = '' ) {

		if ( empty( $offer_product_id ) ) {

			return;
		}

		$offer_product = wc_get_product( $offer_product_id );

		// Current user ID.
		$customer_user_id = get_current_user_id();

		// Getting current customer orders.
		$order_statuses = array( 'wc-on-hold', 'wc-processing', 'wc-completed' );

		$customer_orders = get_posts(
			array(
				'numberposts' => -1,
				'fields' => 'ids', // Return only order ids.
				'meta_key' => '_customer_user',
				'meta_value' => $customer_user_id,
				'post_type' => wc_get_order_types(),
				'post_status' => $order_statuses,
				'order' => 'DESC', // Get last order first.
			)
		);

		// Past Orders.
		foreach ( $customer_orders as $key => $single_order_id ) {

			// Continue if order is not a valid one.
			if ( ! $single_order_id ) {

				continue;
			}

			$single_order = wc_get_order( $single_order_id );

			// Continue if Order object is not a valid one.
			if ( empty( $single_order ) || ! is_object( $single_order ) || is_wp_error( $single_order ) ) {

				continue;
			}

			$items_purchased = $single_order->get_items();

			foreach ( $items_purchased as $key => $single_item ) {

				$product_id = ! empty( $single_item['product_id'] ) ? $single_item['product_id'] : '';
				$variation_id = ! empty( $single_item['variation_id'] ) ? $single_item['variation_id'] : '';

				if ( $product_id == $offer_product_id || $variation_id == $offer_product_id ) {

					return true;
				}
			}
		}

		return false;
	}

	/**
	 * Replace target product with offer product.
	 *
	 * @since    1.0.1
	 */
	public static function mwb_ubo_upgrade_offer( $offer_cart_key = '', $target_cart_key = '' ) {

		// Set Smart Offer Upgrade cart item meta for Offer product.
		if ( ! empty( WC()->cart->cart_contents[ $offer_cart_key ] ) ) {

			WC()->cart->cart_contents[ $offer_cart_key ]['mwb_ubo_sou_offer'] = true;
		}

		// Set Smart Offer Upgrade cart item meta for Target product.
		if ( ! empty( WC()->cart->cart_contents[ $target_cart_key ] ) ) {

			WC()->cart->cart_contents[ $target_cart_key ]['mwb_ubo_sou_target'] = true;
		}

		// Remove Target Product.
		if ( ! empty( $target_cart_key ) ) {

			WC()->cart->remove_cart_item( $target_cart_key );
		}

	}

	/**
	 * Retrieve Target product when offer is removed.
	 *
	 * @since    1.0.1
	 */
	public static function mwb_ubo_retrieve_target( $target_cart_key = '' ) {

		// Restore Target product.
		if ( ! empty( $target_cart_key ) ) {

			WC()->cart->restore_cart_item( $target_cart_key );
		}
	}

	// End of class.
}
