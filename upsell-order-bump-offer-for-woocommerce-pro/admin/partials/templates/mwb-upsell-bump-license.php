<?php
/**
 * The admin-specific template of the plugin for license activation.
 *
 * @link       https://makewebbetter.com/
 * @since      1.0.0
 *
 * @package    Upsell_Order_Bump_Offer_For_Woocommerce_Pro
 * @subpackage Upsell_Order_Bump_Offer_For_Woocommerce_Pro/admin/partials/templates
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {

	exit;
}
?>

<!-- License panel html. -->
<div class="mwb-upsell-bump-wrap">
	<h1 class="mwb_upsell_offer_sections"><?php esc_html_e( 'Your License', 'upsell-order-bump-offer-for-woocommerce-pro' ); ?></h1  >
<div class="mwb_upsell_bump_license_text">

	<p>
	<?php
		esc_html_e( 'This is the License Activation Panel. After purchasing extension from MakeWebBetter you will get the purchase code of this extension. Please verify your purchase below so that you can use feature of this plugin.', 'upsell-order-bump-offer-for-woocommerce-pro' );
	?>
	</p>

	<form id="mwb_upsell_bump_license_form"> 
		<table class="mwb-upsell-bump-pro-form-table">
			<div id="mwb_upsell_bump_license_ajax_loader"><img src="images/spinner-2x.gif"></div>
			<tr>
				<th scope="row"><label for="puchase-code"><?php esc_html_e( 'Purchase Code : ', 'upsell-order-bump-offer-for-woocommerce-pro' ); ?></label></th>
				<td>
					<input type="text" id="mwb_bump_offer_license_key" name="purchase-code" required="" size="30" class="mwb-upsell-bump-pro-purchase-code" value="" placeholder="<?php esc_html_e( 'Enter your code here...', 'upsell-order-bump-offer-for-woocommerce-pro' ); ?>">
				</td>
			</tr>
		</table>

		<!-- Notify Here. -->
		<p id="mwb_upsell_bump_offer_license_activation_status"></p>
		<p class="submit">
			<button id="mwb_upsell_bump_license_activate" required="" class="button-primary woocommerce-save-button" name="mwb_bump_offer_license_settings"><?php esc_html_e( 'Validate', 'upsell-order-bump-offer-for-woocommerce-pro' ); ?></button>
		</p>
	</form>

</div>
	
</div>
