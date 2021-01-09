<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://makewebbetter.com/
 * @since             1.0.0
 * @package           upsell-order-bump-offer-for-woocommerce-pro
 *
 * @wordpress-plugin
 * Plugin Name:       Upsell Order Bump Offer For Woocommerce Pro
 * Plugin URI:        https://makewebbetter.com/product/woocommerce-upsell-order-bump-offer-pro/
 * Description:       Add premium features to the Upsell Order Bump Offer plugin such as Multiple Order Bumps, Smart Offer Upgrade and Smart Skip if Already Purchased.
 *
 * Requires at least:       4.4
 * Tested up to:            5.5.1
 * WC requires at least:    3.0
 * WC tested up to:         4.5.2
 *
 * Version:           1.3.0
 * Author:            MakeWebBetter
 * Author URI:        https://makewebbetter.com/
 * License:           MakeWebBetter License
 * License URI:       https://makewebbetter.com/license-agreement.txt
 * Text Domain:       upsell-order-bump-offer-for-woocommerce-pro
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Plugin Active Detection.
 *
 * @since    1.0.0
 * @param    string $plugin_slug index file of plugin.
 */
function mwb_ubo_is_plugin_active( $plugin_slug = '' ) {

	if ( empty( $plugin_slug ) ) {

		return false;
	}

	$active_plugins = (array) get_option( 'active_plugins', array() );

	if ( is_multisite() ) {

		$active_plugins = array_merge( $active_plugins, get_site_option( 'active_sitewide_plugins', array() ) );

	}

	return in_array( $plugin_slug, $active_plugins ) || array_key_exists( $plugin_slug, $active_plugins );

}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'UPSELL_ORDER_BUMP_OFFER_FOR_WOOCOMMERCE_PRO_VERSION', '1.3.0' );

/**
 * The code that runs during plugin activation.
 */
function activate_upsell_order_bump_offer_for_woocommerce_pro() {

	require_once plugin_dir_path( __FILE__ ) . 'includes/class-upsell-order-bump-offer-for-woocommerce-pro-activator.php';
	Upsell_Order_Bump_Offer_For_Woocommerce_Pro_Activator::activate();

	if ( ! wp_next_scheduled( 'mwb_upsell_bump_check_license_hook' ) ) {

		wp_schedule_event( time(), 'daily', 'mwb_upsell_bump_check_license_hook' );
	}
}

/**
 * Conditional dependency for plugin activation.
 */
function mwb_bump_pro_plugin_activation() {

	$activation['status'] = true;
	$activation['message'] = '';

	// If org plugin is inactive, load nothing.
	if ( ! mwb_ubo_is_plugin_active( 'upsell-order-bump-offer-for-woocommerce/upsell-order-bump-offer-for-woocommerce.php' ) ) {

		$activation['status'] = false;
		$activation['message'] = 'org_inactive';
	}

	// Dependant plugin.
	if ( ! mwb_ubo_is_plugin_active( 'woocommerce/woocommerce.php' ) ) {

		$activation['status'] = false;
		$activation['message'] = 'woo_inactive';
	}

	return $activation;
}

// Check dependency during activation.
$mwb_bump_plugin_activation = mwb_bump_pro_plugin_activation();

if ( true === $mwb_bump_plugin_activation['status'] ) {

	// Define all neccessary details.
	define( 'UPSELL_ORDER_BUMP_OFFER_FOR_WOOCOMMERCE_PRO_URL', plugin_dir_url( __FILE__ ) );

	define( 'UPSELL_ORDER_BUMP_OFFER_FOR_WOOCOMMERCE_PRO_DIRPATH', plugin_dir_path( __FILE__ ) );

	if ( ! defined( 'UPSELL_ORDER_BUMP_OFFER_FOR_WOOCOMMERCE_PRO_SPECIAL_SECRET_KEY' ) ) {

		define( 'UPSELL_ORDER_BUMP_OFFER_FOR_WOOCOMMERCE_PRO_SPECIAL_SECRET_KEY', '59f32ad2f20102.74284991' );
	}

	if ( ! defined( 'UPSELL_ORDER_BUMP_OFFER_FOR_WOOCOMMERCE_PRO_LICENSE_SERVER_URL' ) ) {

		define( 'UPSELL_ORDER_BUMP_OFFER_FOR_WOOCOMMERCE_PRO_LICENSE_SERVER_URL', 'https://makewebbetter.com' );
	}

	if ( ! defined( 'UPSELL_ORDER_BUMP_OFFER_FOR_WOOCOMMERCE_PRO_ITEM_REFERENCE' ) ) {

		define( 'UPSELL_ORDER_BUMP_OFFER_FOR_WOOCOMMERCE_PRO_ITEM_REFERENCE', 'Upsell Order Bump Offer For Woocommerce Pro' );
	}

	add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'mwb_ubo_plugin_action_links' );

	/**
	 * Add settings link in plugin list.
	 *
	 * @param    string $links       The settings page link.
	 */
	function mwb_ubo_plugin_action_links( $links ) {

		$plugin_links = array(
			'<a href="' . admin_url( 'admin.php?page=upsell-order-bump-offer-for-woocommerce-setting' ) . '">' . __( 'Settings', 'upsell-order-bump-offer-for-woocommerce-pro' ) . '</a>',
		);
		return array_merge( $plugin_links, $links );
	}

	add_filter( 'plugin_row_meta', 'mwb_ubo_add_important_links', 10, 2 );

	/**
	 * Add custom links for getting premium version.
	 *
	 * @param   string $links link to index file of plugin.
	 * @param   string $file index file of plugin.
	 *
	 * @since    1.3.0
	 */
	function mwb_ubo_add_important_links( $links, $file ) {

		if ( strpos( $file, 'upsell-order-bump-offer-for-woocommerce-pro.php' ) !== false ) {

			$row_meta = array(
				'doc' => '<a href="https://docs.makewebbetter.com/woocommerce-upsell-order-bump-offer-pro/?utm_source=MWB-orderbump-home&utm_medium=MWB-home-page&utm_campaign=MWB-orderbump-home" target="_blank">' . esc_html__( 'Documentation', 'upsell-order-bump-offer-for-woocommerce-pro' ) . '</a>',
				'support' => '<a href="https://makewebbetter.com/submit-query/" target="_blank">' . esc_html__( 'Support', 'upsell-order-bump-offer-for-woocommerce-pro' ) . '</a>',
			);

			return array_merge( $links, $row_meta );
		}

		return (array) $links;
	}

	register_activation_hook( __FILE__, 'activate_upsell_order_bump_offer_for_woocommerce_pro' );

	/**
	 * Plugin Auto Update.
	 */
	function auto_update_mwb_upsell_bump_offers_plugin() {

		$mwb_upsell_bump_license_key = get_option( 'mwb_upsell_bump_license_key', '' );

		define( 'UPSELL_ORDER_BUMP_OFFER_FOR_WOOCOMMERCE_PRO_LICENSE_KEY', $mwb_upsell_bump_license_key );

		define( 'UPSELL_ORDER_BUMP_OFFER_FOR_WOOCOMMERCE_PRO_BASE_FILE', __FILE__ );

		$update_check_bump = 'https://makewebbetter.com/pluginupdates/upsell-order-bump-offer-for-woocommerce-pro/update.php';

		require_once( 'class-mwb-upsell-bump-update.php' );
	}

	/**
	 * The core plugin class that is used to define internationalization,
	 * admin-specific hooks, and public-facing site hooks.
	 */
	require plugin_dir_path( __FILE__ ) . 'includes/class-upsell-order-bump-offer-for-woocommerce-pro.php';

	/**
	 * Begins execution of the plugin.
	 *
	 * Since everything within the plugin is registered via hooks,
	 * then kicking off the plugin from this point in the file does
	 * not affect the page life cycle.
	 *
	 * @since    1.0.0
	 */
	function run_upsell_order_bump_offer_for_woocommerce_pro() {

		// Plugin auto update.
		auto_update_mwb_upsell_bump_offers_plugin();
		$plugin = new Upsell_Order_Bump_Offer_For_Woocommerce_Pro();
		$plugin->run();

	}

	run_upsell_order_bump_offer_for_woocommerce_pro();

} else {

	add_action( 'admin_init', 'mwb_bump_plugin_activation_failure' );

	/**
	 * Deactivate this plugin.
	 */
	function mwb_bump_plugin_activation_failure() {

		global $mwb_bump_plugin_activation;

		if ( 'woo_inactive' == $mwb_bump_plugin_activation['message'] ) {

			// To hide Plugin activated notice.
			if ( ! empty( $_GET['activate'] ) ) {

				unset( $_GET['activate'] );
			}

			deactivate_plugins( plugin_basename( __FILE__ ) );
		}
	}

	// Add admin error notice.
	add_action( 'admin_notices', 'mwb_bump_plugin_activation_admin_notice' );

	/**
	 * This function is used to display plugin activation error notice.
	 */
	function mwb_bump_plugin_activation_admin_notice() {

		global $mwb_bump_plugin_activation;

		?>

		<?php if ( 'woo_inactive' == $mwb_bump_plugin_activation['message'] ) : ?>

			<div class="error">
				<p><strong><?php esc_html_e( 'WooCommerce', 'upsell-order-bump-offer-for-woocommerce-pro' ); ?></strong><?php esc_html_e( ' is not activated, Please activate WooCommerce first to activate ', 'upsell-order-bump-offer-for-woocommerce-pro' ); ?><strong><?php esc_html_e( 'Upsell Order Bump Offer for WooCommerce Pro' ); ?></strong><?php esc_html_e( '.', 'upsell-order-bump-offer-for-woocommerce-pro' ); ?></p>
			</div>

		<?php endif; ?>

		<?php
		if ( 'org_inactive' == $mwb_bump_plugin_activation['message'] ) :

			$screen = get_current_screen();
			?>

			<?php if ( 'plugins' == $screen->id ) : ?>

				<style type="text/css">
					.mwb_ubo_buttons{
						padding-top: 0px !important;
					}
				</style>
				<div class="notice notice-info is-dismissible">
					<p><strong><?php esc_html_e( 'Upsell Order Bump Offer for WooCommerce Pro', 'upsell-order-bump-offer-for-woocommerce-pro' ); ?></strong><?php esc_html_e( ' Plugin requires the', 'upsell-order-bump-offer-for-woocommerce-pro' ); ?> <strong><?php esc_html_e( 'Order Bump Free Org', 'upsell-order-bump-offer-for-woocommerce-pro' ); ?></strong><?php esc_html_e( ' plugin to work.', 'upsell-order-bump-offer-for-woocommerce-pro' ); ?></p>
					<p class="submit mwb_ubo_buttons"><a target="_blank" href="<?php echo esc_url( admin_url( 'plugin-install.php?s=Upsell+Order+Bump+Offer+for+WooCommerce+upselling+plugin&tab=search&type=term' ) ); ?>" class="button-primary"><?php esc_html_e( 'Install & Activate →', 'upsell-order-bump-offer-for-woocommerce-pro' ); ?></a>
						<a href="https://wordpress.org/plugins/upsell-order-bump-offer-for-woocommerce/" target="_blank" class="button"><?php esc_html_e( 'View on ORG page →', 'upsell-order-bump-offer-for-woocommerce-pro' ); ?></a></p>
					<button type="button" class="notice-dismiss"><span class="screen-reader-text"><?php esc_html_e( 'Dismiss this notice.', 'upsell-order-bump-offer-for-woocommerce-pro' ); ?></span></button>
				</div>
			<?php endif; ?>
			<?php
		endif;
	}
}

?>
