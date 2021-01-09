<?php
/**
 * Fired during plugin activation.
 *
 * @link       https://makewebbetter.com/
 * @since      1.0.0
 *
 * @package    Upsell_Order_Bump_Offer_For_Woocommerce_Pro
 * @subpackage Upsell_Order_Bump_Offer_For_Woocommerce_Pro/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Upsell_Order_Bump_Offer_For_Woocommerce_Pro
 * @subpackage Upsell_Order_Bump_Offer_For_Woocommerce_Pro/includes
 * @author     Make Web Better <webmaster@makewebbetter.com>
 */
class Upsell_Order_Bump_Offer_For_Woocommerce_Pro_Activator {

	/**
	 * Just set a transient to get tabs operative.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {

		// Set default timestamp.
		$timestamp = get_option( 'mwb_upsell_bump_activated_timestamp', 'not_set' );

		if ( 'not_set' === $timestamp ) {

			$current_time = current_time( 'timestamp' );

			$thirty_days = strtotime( '+30 days', $current_time );

			update_option( 'mwb_upsell_bump_activated_timestamp', $thirty_days );
		}
	}
}
