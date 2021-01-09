<?php
/**
 * The admin-specific template of the plugin for order bump listing.
 *
 * @link       https://makewebbetter.com/
 * @since      1.0.0
 *
 * @package    Upsell_Order_Bump_Offer_For_Woocommerce_Pro
 * @subpackage Upsell_Order_Bump_Offer_For_Woocommerce_Pro/admin/partials/templates
 */

/**
 * Exit if accessed directly.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Bumps Listing Template.
 *
 * This template is used for listing all existing bumps with
 * view/edit and delete option.
 */

// Delete bumps.
if ( isset( $_GET['del_bump_id'] ) ) {

	$bump_id = sanitize_text_field( wp_unslash( $_GET['del_bump_id'] ) );

	// Get all bumps.
	$mwb_upsell_bumps = get_option( 'mwb_ubo_bump_list' );

	foreach ( $mwb_upsell_bumps as $single_bump => $data ) {

		if ( $bump_id == $single_bump ) {

			unset( $mwb_upsell_bumps[ $single_bump ] );
			break;
		}
	}

	update_option( 'mwb_ubo_bump_list', $mwb_upsell_bumps );

	wp_redirect( admin_url( 'admin.php' ) . '?page=upsell-order-bump-offer-for-woocommerce-setting&tab=bump-list' );

	exit();
}


// Get all bumps.
$mwb_upsell_bumps_list = get_option( 'mwb_ubo_bump_list' );

if ( ! empty( $mwb_upsell_bumps_list ) ) {

	// Temp bump variable.
	$mwb_upsell_bumps_list_duplicate = $mwb_upsell_bumps_list;

	// Make key pointer point to the end bump.
	end( $mwb_upsell_bumps_list_duplicate );

	// Now key function will return last bump key.
	$mwb_upsell_bumps_last_index = key( $mwb_upsell_bumps_list_duplicate );

} else {

	// When no bump is there then new bump id will be 1 (0+1).
	$mwb_upsell_bumps_last_index = 0;
}

?>

<div class="mwb_upsell_bumps_list" >

	<?php if ( empty( $mwb_upsell_bumps_list ) ) : ?>

		<p class="mwb_upsell_bump_no_bump"><?php esc_html_e( 'No Order Bumps added', 'upsell-order-bump-offer-for-woocommerce-pro' ); ?></p>

	<?php endif; ?>

	<?php if ( ! empty( $mwb_upsell_bumps_list ) ) : ?>
		<table>
			<tr>
				<th><?php esc_html_e( 'Name', 'upsell-order-bump-offer-for-woocommerce-pro' ); ?></th>
				<th><?php esc_html_e( 'Status', 'upsell-order-bump-offer-for-woocommerce-pro' ); ?></th>
				<th id="mwb_upsell_bump_list_target_th"><?php esc_html_e( 'Target Product(s) and Categories', 'upsell-order-bump-offer-for-woocommerce-pro' ); ?></th>
				<th><?php esc_html_e( 'Offers', 'upsell-order-bump-offer-for-woocommerce-pro' ); ?></th>
				<th><?php esc_html_e( 'Action', 'upsell-order-bump-offer-for-woocommerce-pro' ); ?></th>
			</tr>

			<!-- Foreach Bump start. -->
			<?php
			foreach ( $mwb_upsell_bumps_list as $key => $value ) :

				$offer_present = ! empty( $value['mwb_upsell_bump_products_in_offer'] ) ? $value['mwb_upsell_bump_products_in_offer'] : 'no offer selected';
				?>
			
			<tr>		
				<!-- Bump Name. -->
				<td><a class="mwb_upsell_bump_list_name" href="?page=upsell-order-bump-offer-for-woocommerce-setting&tab=creation-setting&bump_id=<?php echo esc_html( $key ); ?>"><?php echo esc_html( $value['mwb_upsell_bump_name'] ); ?></a></td>

				<!-- Bump Status. -->
				<td>
					<?php

					$bump_status = ! empty( $value['mwb_upsell_bump_status'] ) ? $value['mwb_upsell_bump_status'] : 'no';
					$smart_offer_upgrade = ! empty( $value['mwb_ubo_offer_replace_target'] ) ? $value['mwb_ubo_offer_replace_target'] : 'no';

					if ( 'yes' == $bump_status ) {

						echo '<span class="mwb_upsell_bump_list_live"></span><span class="mwb_upsell_bump_list_live_name">' . esc_html__( 'Live', 'upsell-order-bump-offer-for-woocommerce-pro' ) . '</span>';
					} else {

						echo '<span class="mwb_upsell_bump_list_sandbox"></span><span class="mwb_upsell_bump_list_sandbox_name">' . esc_html__( 'Sandbox', 'upsell-order-bump-offer-for-woocommerce-pro' ) . '</span>';
					}

					echo '<div class="mwb-upsell-bump-attributes ' . esc_html( $bump_status ) . '">';

					if ( 'yes' == $smart_offer_upgrade ) {

						echo '<p>' . esc_html__( 'Smart Offer Upgrade', 'upsell-order-bump-offer-for-woocommerce-pro' ) . '</p>';
					}

					echo '</div>';

					?>
				
				</td>

				<!-- Bump Target products. -->
				<td>
				<?php

					// Target Product(s).
				if ( ! empty( $value['mwb_upsell_bump_target_ids'] ) ) {

					echo '<div class="mwb_upsell_bump_list_targets">';

					foreach ( $value['mwb_upsell_bump_target_ids'] as $single_target_product ) :
						?>

						<?php
						if ( function_exists( 'mwb_ubo_lite_get_title' ) ) {

							$single_target_product_title = mwb_ubo_lite_get_title( $single_target_product );

						} else {

							$single_target_product_title = ! empty( get_the_title( $single_target_product ) ) ? get_the_title( $single_target_product ) : esc_html__( 'Product Not Found', 'upsell-order-bump-offer-for-woocommerce-pro' );
						}
						?>

						<p><?php echo esc_html( $single_target_product_title . "( #$single_target_product )" ); ?></p>
						<?php

					endforeach;

					echo '</div>';

				} else {

					?>
					<p><i><?php esc_html_e( 'No Product(s) added', 'upsell-order-bump-offer-for-woocommerce-pro' ); ?></i></p>
					<?php
				}

					echo '<hr>';

					// Target Categories.

				if ( ! empty( $value['mwb_upsell_bump_target_categories'] ) ) {

					echo '<p><i>' . esc_html__( 'Target Categories -', 'upsell-order-bump-offer-for-woocommerce-pro' ) . '</i></p>';

					echo '<div class="mwb_upsell_bump_list_targets">';

					foreach ( $value['mwb_upsell_bump_target_categories'] as $single_target_category_id ) :
						?>
						<?php

						if ( function_exists( 'mwb_ubo_lite_getcat_title' ) ) {

							$single_target_category_name = mwb_ubo_lite_getcat_title( $single_target_category_id );

						} else {

							$single_target_category_name = ! empty( get_the_category_by_ID( $single_target_category_id ) ) ? get_the_category_by_ID( $single_target_category_id ) : esc_html__( 'Category Not Found', 'upsell-order-bump-offer-for-woocommerce-pro' );
						}
						?>

						<p><?php echo esc_html( $single_target_category_name . "( #$single_target_category_id )" ); ?></p>
						<?php

					endforeach;

					echo '</div>';

				} else {

					?>
					<p><i><?php esc_html_e( 'No Categories added', 'upsell-order-bump-offer-for-woocommerce-pro' ); ?></i></p>
					<?php
				}

				?>
				</td>

				<!-- Bump Offer Product. -->
				<td>
					<p>
					<?php
					if ( ! empty( $value['mwb_upsell_bump_products_in_offer'] ) ) {

						$single_offer_product = $value['mwb_upsell_bump_products_in_offer'];

						if ( function_exists( 'mwb_ubo_lite_get_title' ) ) {

							$single_offer_product_title = mwb_ubo_lite_get_title( $single_offer_product );

						} else {

							$single_offer_product_title = ! empty( get_the_title( $single_offer_product ) ) ? get_the_title( $single_offer_product ) : esc_html__( 'Product Not Found', 'upsell-order-bump-offer-for-woocommerce-pro' );
						}
						?>
						<p><?php echo esc_html( $single_offer_product_title . "( #$single_offer_product )" ); ?></p>
						<?php
					} else {

						esc_html_e( 'No offers Added', 'upsell-order-bump-offer-for-woocommerce-pro' );
					}

					?>
					</p>
				</td>

				<!-- Bump Action. -->
				<td>
					<!-- Bump View/Edit link. -->
					<a class="mwb_upsell_bump_links" href="?page=upsell-order-bump-offer-for-woocommerce-setting&tab=creation-setting&bump_id=<?php echo esc_html( $key ); ?>"><?php esc_html_e( 'View / Edit', 'upsell-order-bump-offer-for-woocommerce-pro' ); ?></a>

					<!-- Bump Delete link. -->
					<a class="mwb_upsell_bump_links" href="?page=upsell-order-bump-offer-for-woocommerce-setting&tab=bump-list&del_bump_id=<?php echo esc_html( $key ); ?>"><?php esc_html_e( 'Delete', 'upsell-order-bump-offer-for-woocommerce-pro' ); ?></a>
				</td>

				<?php do_action( 'mwb_ubo_add_more_col_data' ); ?>
			</tr>
			<?php endforeach; ?>
			<!-- Foreach Bump end. -->
		</table>
	<?php endif; ?>
</div>

<!-- Create New Bump. -->
<div class="mwb_upsell_bump_create_new_bump">
	
	<a href="?page=upsell-order-bump-offer-for-woocommerce-setting&tab=creation-setting&bump_id=<?php echo esc_html( $mwb_upsell_bumps_last_index + 1 ); ?>"><?php esc_html_e( '+Create New Order Bump', 'upsell-order-bump-offer-for-woocommerce-pro' ); ?></a>
</div>
