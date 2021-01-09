<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://makewebbetter.com/
 * @since      1.0.0
 *
 * @package    Upsell_Order_Bump_Offer_For_Woocommerce_Pro
 * @subpackage Upsell_Order_Bump_Offer_For_Woocommerce_Pro/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Upsell_Order_Bump_Offer_For_Woocommerce_Pro
 * @subpackage Upsell_Order_Bump_Offer_For_Woocommerce_Pro/admin
 * @author     Make Web Better <webmaster@makewebbetter.com>
 */
class Upsell_Order_Bump_Offer_For_Woocommerce_Pro_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string $plugin_name       The name of this plugin.
	 * @param      string $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Upsell_Order_Bump_Offer_For_Woocommerce_Pro_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Upsell_Order_Bump_Offer_For_Woocommerce_Pro_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		$screen = get_current_screen();

		if ( isset( $screen->id ) ) {

			$pagescreen = $screen->id;

			if ( 'toplevel_page_upsell-order-bump-offer-for-woocommerce-setting' == $pagescreen ) {

				wp_enqueue_style( 'mwb_upsell_bump_pro_admin_style', plugin_dir_url( __FILE__ ) . 'css/upsell-order-bump-offer-for-woocommerce-pro-admin.css', array(), $this->version, 'all' );

				wp_enqueue_style( 'mwb_upsell_bump_pro_admin_style' );

				wp_enqueue_style( 'woocommerce_admin_menu_styles' );

				wp_register_style( 'woocommerce_admin_styles', WC()->plugin_url() . '/assets/css/admin.css', array(), WC_VERSION );

				wp_enqueue_style( 'woocommerce_admin_styles' );

				wp_enqueue_style( 'wp-color-picker' );

			}
		}
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Upsell_Order_Bump_Offer_For_Woocommerce_Pro_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Upsell_Order_Bump_Offer_For_Woocommerce_Pro_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		$screen = get_current_screen();

		if ( isset( $screen->id ) ) {

			$pagescreen = $screen->id;

			if ( 'toplevel_page_upsell-order-bump-offer-for-woocommerce-setting' == $pagescreen ) {

				$is_update_needed = 'false';

				if ( version_compare( UPSELL_ORDER_BUMP_OFFER_FOR_WOOCOMMERCE_VERSION, '1.2.0' ) < 0 ) {

					$is_update_needed = 'true';
				}

				wp_enqueue_script( 'mwb-upsell-bump-license-script', plugin_dir_url( __FILE__ ) . 'js/upsell-order-bump-offer-for-woocommerce-pro-admin.js', array( 'jquery' ), $this->version, false );
				wp_localize_script(
					'mwb-upsell-bump-license-script',
					'mwb_upsell_bump_ajaxurl',
					array(
						'ajaxurl'       => admin_url( 'admin-ajax.php' ),
						'auth_nonce'    => wp_create_nonce( 'mwb_ubo_license_nonce' ),
						'is_org_needs_update'    => $is_update_needed,
						'mwb_upsell_bump_location' => admin_url( 'admin.php' ) . '?page=upsell-order-bump-offer-for-woocommerce-setting&tab=settings',
					)
				);
			}
		}
	}

	/**
	 * Only checks the key is valid or not and saves the key if valid and activates.
	 *
	 * @since    1.0.0
	 */
	public function mwb_upsell_bump_validate_license_key() {

		check_ajax_referer( 'mwb_ubo_license_nonce', 'nonce' );

		$mwb_upsell_bump_purchase_code = ! empty( $_POST['purchase_code'] ) ? sanitize_text_field( wp_unslash( $_POST['purchase_code'] ) ) : '';

		$api_params = array(
			'slm_action'        => 'slm_activate',
			'secret_key'        => UPSELL_ORDER_BUMP_OFFER_FOR_WOOCOMMERCE_PRO_SPECIAL_SECRET_KEY,
			'license_key'       => $mwb_upsell_bump_purchase_code,
			'_registered_domain' => ! empty( $_SERVER['SERVER_NAME'] ) ? sanitize_text_field( wp_unslash( $_SERVER['SERVER_NAME'] ) ) : '',
			'item_reference'    => urlencode( UPSELL_ORDER_BUMP_OFFER_FOR_WOOCOMMERCE_PRO_ITEM_REFERENCE ),
			'product_reference' => 'MWBPK-23841',
		);

		$query = esc_url_raw( add_query_arg( $api_params, UPSELL_ORDER_BUMP_OFFER_FOR_WOOCOMMERCE_PRO_LICENSE_SERVER_URL ) );

		$mwb_mwb_upsell_bump_purchase_code_response = wp_remote_get(
			$query,
			array(
				'timeout' => 20,
				'sslverify' => false,
			)
		);

		if ( is_wp_error( $mwb_mwb_upsell_bump_purchase_code_response ) ) {
			echo json_encode(
				array(
					'status' => false,
					'msg' => __(
						'An unexpected error occurred. Please try again.',
						'upsell-order-bump-offer-for-woocommerce-pro'
					),
				)
			);
		} else {
			$mwb_upsell_bump_license_data = json_decode( wp_remote_retrieve_body( $mwb_mwb_upsell_bump_purchase_code_response ) );

			if ( isset( $mwb_upsell_bump_license_data->result ) && 'success' == $mwb_upsell_bump_license_data->result ) {
				update_option( 'mwb_upsell_bump_license_key', $mwb_upsell_bump_purchase_code );
				update_option( 'mwb_upsell_bump_license_check', true );

				echo json_encode(
					array(
						'status' => true,
						'msg' => __(
							'Successfully Verified. Please Wait.',
							'upsell-order-bump-offer-for-woocommerce-pro'
						),
					)
				);
			} else {
				echo json_encode(
					array(
						'status' => false,
						'msg' => $mwb_upsell_bump_license_data->message,
					)
				);
			}
		}

		wp_die();
	}


	/**
	 * Checking makewebbetter license on daily basis.
	 *
	 * @since    1.0.0
	 */
	public function mwb_upsell_bump_check_license() {

		$user_license_key = get_option( 'mwb_upsell_bump_license_key', '' );

		$api_params = array(
			'slm_action'         => 'slm_check',
			'secret_key'         => UPSELL_ORDER_BUMP_OFFER_FOR_WOOCOMMERCE_PRO_SPECIAL_SECRET_KEY,
			'license_key'        => $user_license_key,
			'_registered_domain' => ! empty( $_SERVER['SERVER_NAME'] ) ? sanitize_text_field( wp_unslash( $_SERVER['SERVER_NAME'] ) ) : '',
			'item_reference'     => urlencode( UPSELL_ORDER_BUMP_OFFER_FOR_WOOCOMMERCE_PRO_ITEM_REFERENCE ),
			'product_reference'  => 'MWBPK-23841',
		);

		$query = esc_url_raw( add_query_arg( $api_params, UPSELL_ORDER_BUMP_OFFER_FOR_WOOCOMMERCE_PRO_LICENSE_SERVER_URL ) );

		$mwb_response = wp_remote_get(
			$query,
			array(
				'timeout' => 20,
				'sslverify' => false,
			)
		);

		$license_data = json_decode( wp_remote_retrieve_body( $mwb_response ) );

		if ( isset( $license_data->result ) && 'success' === $license_data->result && isset( $license_data->status ) && 'active' === $license_data->status ) {

			update_option( 'mwb_upsell_bump_license_check', true );
		} else {

			delete_option( 'mwb_upsell_bump_license_check' );
		}

	}

	/**
	 * Modify the plugin heading if pro version is available.
	 *
	 * @param      string $heading       The name of this plugin.
	 * @since    1.0.0
	 */
	public function pro_heading( $heading ) {

		$heading = esc_html__( 'Upsell Order Bump Offers Pro', 'upsell-order-bump-offer-for-woocommerce-pro' );

		return $heading;
	}

	/**
	 * Modify the license redirection via notice.
	 *
	 * @since    1.0.0
	 */
	public function license_redirect_pathvia_notice() {

		global $pagenow;
		$get_view = ! empty( $_GET['page'] ) ? sanitize_text_field( wp_unslash( $_GET['page'] ) ) : '';
		$get_tab = ! empty( $_GET['tab'] ) ? sanitize_text_field( wp_unslash( $_GET['tab'] ) ) : '';

		if ( 'admin.php' == $pagenow && 'mwb-bump-offer-setting' == $get_view && 'license' == $get_tab ) : ?>
			   <div style="text-align: center;margin-top: 30px;">
				<h2 style="font-weight: 200;"><?php esc_html_e( 'Sorry, License panel is moved.', 'upsell-order-bump-offer-for-woocommerce-pro' ); ?></h2>
				<a class="button wc-backward" href="<?php echo esc_url( admin_url( 'admin.php' ) . '?page=upsell-order-bump-offer-for-woocommerce-setting&tab=license' ); ?>"><?php esc_html_e( 'Go to License tab →', 'upsell-order-bump-offer-for-woocommerce-pro' ); ?></a>
			</div>
			<?php
			wp_die();
		endif;
	}

	/**
	 * Checks Whether if Free version is incompatible.
	 *
	 * @since    1.3.0
	 */
	public function free_version_incompatible() {

		// When Free plugin is outdated.
		if ( defined( 'UPSELL_ORDER_BUMP_OFFER_FOR_WOOCOMMERCE_VERSION' ) && version_compare( UPSELL_ORDER_BUMP_OFFER_FOR_WOOCOMMERCE_VERSION, '1.4.0' ) < 0 ) {

			return true;
		}

		return false;
	}

	/**
	 * Validate Free version compatibility.
	 *
	 * @since    1.3.0
	 */
	public function validate_version_compatibility() {

		// When Free version in incompatible.
		if ( $this->free_version_incompatible() ) {

			// Deactivate Free Order Bump Plugin.
			add_action( 'admin_init', array( $this, 'deactivate_free_plugin' ) );
			// Deactivate Free Order Bump Plugin admin notice.
			add_action( 'admin_notices', array( $this, 'deactivate_free_admin_notice' ) );
		}
	}

	/**
	 * Deactivate Free Order Bump Plugin.
	 *
	 * @since    1.3.0
	 */
	public function deactivate_free_plugin() {

		// To hide Plugin activated notice.
		if ( ! empty( $_GET['activate'] ) ) {

			unset( $_GET['activate'] );
		}

		deactivate_plugins( 'upsell-order-bump-offer-for-woocommerce/upsell-order-bump-offer-for-woocommerce.php' );
	}

	/**
	 * Deactivate Free Order Bump Plugin admin notice.
	 *
	 * @since    1.3.0
	 */
	public function deactivate_free_admin_notice() {

		?>

			<div class="notice notice-error is-dismissible mwb-notice">
				<p><strong><?php esc_html_e( 'Upsell Order Bump Offer for WooCommerce', 'upsell-order-bump-offer-for-woocommerce-pro' ); ?></strong> <?php esc_html_e( 'is deactivated, Please Update the Free version as this version is outdated and will not work with the current', 'upsell-order-bump-offer-for-woocommerce-pro' ); ?><strong> <?php esc_html_e( 'Upsell Order Bump Offer for WooCommerce Pro', 'upsell-order-bump-offer-for-woocommerce-pro' ); ?></strong> <?php esc_html_e( 'version.', 'upsell-order-bump-offer-for-woocommerce-pro' ); ?></p>
			</div>

		<?php
	}
}
