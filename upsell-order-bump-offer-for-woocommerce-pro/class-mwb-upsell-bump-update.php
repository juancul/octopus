<?php
/**
 * The admin-specific template of the plugin for License handling.
 *
 * @link       https://makewebbetter.com/
 * @since      1.0.0
 *
 * @package    Upsell_Order_Bump_Offer_For_Woocommerce_Pro
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists( 'Mwb_Upsell_Bump_Update' ) ) {

	/**
	 * The update-specific functionality of the plugin.
	 *
	 * @package    Upsell_Order_Bump_Offer_For_Woocommerce_Pro
	 * @author     Make Web Better <webmaster@makewebbetter.com>
	 */
	class Mwb_Upsell_Bump_Update {

		/**
		 * Initialize the class and set its properties.
		 *
		 * @since    1.0.0
		 */
		public function __construct() {

			register_activation_hook( UPSELL_ORDER_BUMP_OFFER_FOR_WOOCOMMERCE_PRO_BASE_FILE, array( $this, 'mwb_check_activation' ) );

			add_action( 'mwb_upsell_bump_check_event', array( $this, 'mwb_check_update' ) );
			add_filter( 'http_request_args', array( $this, 'mwb_updates_exclude' ), 5, 2 );
			register_deactivation_hook( UPSELL_ORDER_BUMP_OFFER_FOR_WOOCOMMERCE_PRO_BASE_FILE, array( $this, 'mwb_check_deactivation' ) );

			$plugin_update = get_option( 'mwb_bump_plugin_update', 'false' );

			if ( 'true' === $plugin_update ) {

				// To add view details content in plugin update notice on plugins page.
				add_action( 'install_plugins_pre_plugin-information', array( $this, 'mwb_upsell_bump_offers_details' ) );

				// To add plugin update notice after plugin update message.
				add_action( 'in_plugin_update_message-upsell-order-bump-offer-for-woocommerce-pro/upsell-order-bump-offer-for-woocommerce-pro.php', array( $this, 'mwb_upsell_bump_offer_in_plugin_update_notice' ), 10, 2 );
			}
		}

		/**
		 * Get plugin deactivate on update.
		 *
		 * @since    1.0.0
		 */
		public function mwb_check_deactivation() {

			wp_clear_scheduled_hook( 'mwb_upsell_bump_check_event' );
		}

		/**
		 * Get plugin activate on update.
		 *
		 * @since    1.0.0
		 */
		public function mwb_check_activation() {

			wp_schedule_event( time(), 'daily', 'mwb_upsell_bump_check_event' );
		}

		/**
		 * Get plugin update exclusion info.
		 *
		 * @since    1.0.0
		 */
		public function mwb_upsell_bump_offers_details() {

			global $tab;

			// change $_REQUEST['plugin] to your plugin slug name.
			if ( 'plugin-information' == $tab && ! empty( $_REQUEST['plugin'] ) && 'upsell-order-bump-offer-for-woocommerce-pro' == $_REQUEST['plugin'] ) {

				$data = $this->get_plugin_update_data();

				if ( is_wp_error( $data ) || empty( $data ) ) {

					return;
				}

				if ( ! empty( $data['body'] ) ) {

					$all_data = json_decode( $data['body'], true );

					if ( ! empty( $all_data ) && is_array( $all_data ) ) {

						$this->create_html_data( $all_data );

						wp_die();
					}
				}
			}
		}

		/**
		 * Get plugin update data info.
		 *
		 * @since    1.0.0
		 */
		public function get_plugin_update_data() {

			// replace with your plugin url.
			$url = 'https://makewebbetter.com/pluginupdates/upsell-order-bump-offer-for-woocommerce-pro/upsell-order-bump-offer-for-woocommerce-pro.json';
			$postdata = array(
				'action' => 'check_update',
				'license_code' => UPSELL_ORDER_BUMP_OFFER_FOR_WOOCOMMERCE_PRO_LICENSE_KEY,
			);

			$args = array(
				'method' => 'POST',
				'body' => $postdata,
			);

			$data = wp_remote_post( $url, $args );

			return $data;
		}

		/**
		 * Render HTML content.
		 *
		 * @since    1.0.0
		 * @param    object $all_data       The update and change log data to be listed.
		 */
		public function create_html_data( $all_data ) {
			?>
			<style>
				#TB_window{
					top : 4% !important;
				}
				.mwb_upsell_bump_banner > img {
					width: 50%;
				}
				.mwb_upsell_bump_banner > h1 {
					margin-top: 0px;
				}
				.mwb_upsell_bump_banner {
					text-align: center;
				}
				.mwb_upsell_bump_description > h4 {
					background-color: #3779B5;
					padding: 5px;
					color: #ffffff;
					border-radius: 5px;
				}
				.mwb_upsell_bump_changelog_details > h4 {
					background-color: #3779B5;
					padding: 5px;
					color: #ffffff;
					border-radius: 5px;
				}
			</style>
			<div class="mwb_upsell_bump_details_wrapper">
				<div class="mwb_upsell_bump_banner" >
					<h1><?php echo esc_html( $all_data['name'] ) . ' ' . esc_html( $all_data['version'] ); ?></h1>
					<img src="<?php echo esc_url( $all_data['banners']['logo'] ); ?>">
				</div>

				<div class="mwb_upsell_bump_description">
					<h4><?php esc_html_e( 'Plugin Description', 'upsell-order-bump-offer-for-woocommerce-pro' ); ?></h4>
					<span><?php echo $all_data['sections']['description']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
				</div>
				<div class="mwb_upsell_bump_changelog_details">
					<h4><?php esc_html_e( 'Plugin Change Log', 'upsell-order-bump-offer-for-woocommerce-pro' ); ?></h4>
					<span><?php echo $all_data['sections']['changelog']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
				</div>
			</div>
			<?php
		}

		/**
		 * Get plugin update notice info.
		 *
		 * @since    1.0.0
		 */
		public function mwb_upsell_bump_offer_in_plugin_update_notice() {

			$data = $this->get_plugin_update_data();

			if ( is_wp_error( $data ) || empty( $data ) ) {

				return;
			}

			if ( isset( $data['body'] ) ) {

				$all_data = json_decode( $data['body'], true );

				if ( is_array( $all_data ) && ! empty( $all_data['sections']['update_notice'] ) ) {

					?>

					<style type="text/css">
						
						#mwb-upsell-bump-offers-update .dummy {
							display: none;
						}

						#mwb_upsell_bump_in_plugin_update_div p:before {
							content: none;
						}

						#mwb_upsell_bump_in_plugin_update_div {
							border-top: 1px solid #ffb900;
							margin-left: -13px;
							padding-left: 20px;
							padding-top: 10px;
							padding-bottom: 5px;
						}

						#mwb_upsell_bump_in_plugin_update_div ul {
							list-style-type: decimal;
							padding-left: 20px;
						}

					</style>

					<?php

					echo '</p><div id="mwb_upsell_bump_in_plugin_update_div">' . $all_data['sections']['update_notice'] . '</div><p class="dummy">'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				}
			}
		}

		/**
		 * Get plugin check update.
		 *
		 * @since    1.0.0
		 */
		public function mwb_check_update() {

			global $wp_version;
			global $update_check_bump;

			$update_check_bump = 'https://makewebbetter.com/pluginupdates/upsell-order-bump-offer-for-woocommerce-pro/update.php';

			$plugin_folder = plugin_basename( dirname( UPSELL_ORDER_BUMP_OFFER_FOR_WOOCOMMERCE_PRO_BASE_FILE ) );

			$plugin_file = basename( ( UPSELL_ORDER_BUMP_OFFER_FOR_WOOCOMMERCE_PRO_BASE_FILE ) );

			if ( defined( 'WP_INSTALLING' ) ) {
				return false;
			}
			$postdata = array(
				'action' => 'check_update',
				'license_key' => UPSELL_ORDER_BUMP_OFFER_FOR_WOOCOMMERCE_PRO_LICENSE_KEY,
			);

			$args = array(
				'method' => 'POST',
				'body' => $postdata,
			);

			$response = wp_remote_post( $update_check_bump, $args );

			if ( is_wp_error( $response ) || empty( $response['body'] ) ) {

				return;
			}

			list($version, $url) = explode( '~', $response['body'] );

			if ( $this->mwb_plugin_get( 'Version' ) >= $version ) {

				update_option( 'mwb_bump_plugin_update', 'false' );

				return false;
			}

			update_option( 'mwb_bump_plugin_update', 'true' );

			$plugin_transient = get_site_transient( 'update_plugins' );
			$a = array(
				'slug' => $plugin_folder,
				'new_version' => $version,
				'url' => $this->mwb_plugin_get( 'AuthorURI' ),
				'package' => $url,
			);
			$o = (object) $a;
			$plugin_transient->response[ $plugin_folder . '/' . $plugin_file ] = $o;
			set_site_transient( 'update_plugins', $plugin_transient );
		}

		/**
		 * Get plugin update exclusion info.
		 *
		 * @since    1.0.0
		 * @param    string $r       The update basename of plugin.
		 * @param    string $url     The update url of plugin.
		 */
		public function mwb_updates_exclude( $r, $url ) {

			if ( 0 !== strpos( $url, 'http://api.wordpress.org/plugins/update-check' ) ) {
				return $r;
			}
			$plugins = unserialize( $r['body']['plugins'] );
			unset( $plugins->plugins[ plugin_basename( __FILE__ ) ] );
			unset( $plugins->active[ array_search( plugin_basename( __FILE__ ), $plugins->active ) ] );
			$r['body']['plugins'] = serialize( $plugins );
			return $r;
		}

		/**
		 * Get plugin update info.
		 *
		 * @since    1.0.0
		 * @param    string $i   The update directory of plugin.
		 */
		public function mwb_plugin_get( $i ) {

			if ( ! function_exists( 'get_plugins' ) ) {
				require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
			}
			$plugin_folder = get_plugins( '/' . plugin_basename( dirname( UPSELL_ORDER_BUMP_OFFER_FOR_WOOCOMMERCE_PRO_BASE_FILE ) ) );
			$plugin_file = basename( ( UPSELL_ORDER_BUMP_OFFER_FOR_WOOCOMMERCE_PRO_BASE_FILE ) );
			return $plugin_folder[ $plugin_file ][ $i ];
		}
	}
	new Mwb_Upsell_Bump_Update();
}
?>
