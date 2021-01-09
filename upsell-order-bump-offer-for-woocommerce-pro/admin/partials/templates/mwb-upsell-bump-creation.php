<?php
/**
 * The admin-specific template of the plugin for creation of order bumps.
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

/**
 * Bump Creation Template.
 *
 * This template is used for creating new bump as well
 * as viewing/editing previous bump.
 */

// New Bump id.
if ( ! isset( $_GET['bump_id'] ) ) {

	// Get all Bump.
	$mwb_upsell_bumps_list = get_option( 'mwb_ubo_bump_list', array() );

	if ( ! empty( $mwb_upsell_bumps_list ) ) {

		// Temp bump variable.
		$mwb_upsell_bumps_list_duplicate = $mwb_upsell_bumps_list;

		// Make key pointer point to the end bump.
		end( $mwb_upsell_bumps_list_duplicate );

		// Now key function will return last bump key.
		$mwb_upsell_bumps_last_index = key( $mwb_upsell_bumps_list_duplicate );

		/**
		 * So new bump id will be last key+1.
		 *
		 *Bump key in array is bump id. ( not really.. need to find, if bump is deleted then keys change)
		 */
		$mwb_upsell_bump_id = $mwb_upsell_bumps_last_index + 1;
	} else {

		// First bump.
		// Firstly it was 0 now changed it to 1, make sure that doesn't cause any issues.
		$mwb_upsell_bump_id = 1;
	}
} else {

	// Retrieve new bump id from GET parameter when redirected from bump list's page.
	$mwb_upsell_bump_id = sanitize_text_field( wp_unslash( $_GET['bump_id'] ) );
}

// When save changes is clicked.
if ( isset( $_POST['mwb_upsell_bump_creation_setting_save'] ) ) {

	unset( $_POST['mwb_upsell_bump_creation_setting_save'] );

	// Nonce verification.
	check_admin_referer( 'mwb_upsell_bump_creation_nonce', 'mwb_upsell_bump_nonce' );

	// Saved bump id.
	$mwb_upsell_bump_id = ! empty( $_POST['mwb_upsell_bump_id'] ) ? sanitize_text_field( wp_unslash( $_POST['mwb_upsell_bump_id'] ) ) : 1;

	if ( empty( $_POST['mwb_upsell_bump_target_categories'] ) ) {

		$_POST['mwb_upsell_bump_target_categories'] = array();
	}

	if ( empty( $_POST['mwb_upsell_bump_target_ids'] ) ) {

		$_POST['mwb_upsell_bump_target_ids'] = array();
	}

	if ( empty( $_POST['mwb_upsell_bump_status'] ) ) {

		$_POST['mwb_upsell_bump_status'] = 'no';
	}

	// When price is saved.
	if ( empty( $_POST['mwb_upsell_bump_offer_discount_price'] ) ) {

		if ( '' == $_POST['mwb_upsell_bump_offer_discount_price'] ) {

			$_POST['mwb_upsell_bump_offer_discount_price'] = '20';

		} else {

			$_POST['mwb_upsell_bump_offer_discount_price'] = '0';
		}
	}

	// From these versions we will be having multiselect for schedules.
	if ( empty( $_POST['mwb_upsell_bump_schedule'] ) ) {

		if ( '' == $_POST['mwb_upsell_bump_schedule'] ) {

			$_POST['mwb_upsell_bump_schedule'] = array( '0' );

		}
	}

	// New bump to be made.
	$mwb_upsell_new_bump = array();

	// Sanitize and strip slashes for Texts.
	$mwb_upsell_new_bump['mwb_upsell_bump_status'] = ! empty( $_POST['mwb_upsell_bump_status'] ) ? sanitize_text_field( wp_unslash( $_POST['mwb_upsell_bump_status'] ) ) : '';

	$mwb_upsell_new_bump['mwb_upsell_bump_name'] = ! empty( $_POST['mwb_upsell_bump_name'] ) ? sanitize_text_field( wp_unslash( $_POST['mwb_upsell_bump_name'] ) ) : '';

	// Updated after v1.2.0.
	$mwb_upsell_new_bump['mwb_upsell_bump_schedule'] = ! empty( $_POST['mwb_upsell_bump_schedule'] ) ? array_map( 'sanitize_text_field', wp_unslash( $_POST['mwb_upsell_bump_schedule'] ) ) : array( '0' );

	$mwb_upsell_new_bump['mwb_upsell_bump_offer_discount_price'] = ! empty( $_POST['mwb_upsell_bump_offer_discount_price'] ) ? sanitize_text_field( wp_unslash( $_POST['mwb_upsell_bump_offer_discount_price'] ) ) : '';

	$mwb_upsell_new_bump['mwb_upsell_bump_products_in_offer'] = ! empty( $_POST['mwb_upsell_bump_products_in_offer'] ) ? sanitize_text_field( wp_unslash( $_POST['mwb_upsell_bump_products_in_offer'] ) ) : '';

	$mwb_upsell_new_bump['mwb_upsell_offer_price_type'] = ! empty( $_POST['mwb_upsell_offer_price_type'] ) ? sanitize_text_field( wp_unslash( $_POST['mwb_upsell_offer_price_type'] ) ) : '';

	$mwb_upsell_new_bump['mwb_ubo_discount_title_for_percent'] = ! empty( $_POST['mwb_ubo_discount_title_for_percent'] ) ? sanitize_text_field( wp_unslash( $_POST['mwb_ubo_discount_title_for_percent'] ) ) : '';

	$mwb_upsell_new_bump['mwb_bump_offer_decsription_text'] = ! empty( $_POST['mwb_bump_offer_decsription_text'] ) ? sanitize_textarea_field( wp_unslash( $_POST['mwb_bump_offer_decsription_text'] ) ) : '';

	$mwb_upsell_new_bump['mwb_upsell_bump_offer_description'] = ! empty( $_POST['mwb_upsell_bump_offer_description'] ) ? sanitize_textarea_field( wp_unslash( $_POST['mwb_upsell_bump_offer_description'] ) ) : '';

	$mwb_upsell_new_bump['mwb_bump_upsell_selected_template'] = ! empty( $_POST['mwb_bump_upsell_selected_template'] ) ? sanitize_textarea_field( wp_unslash( $_POST['mwb_bump_upsell_selected_template'] ) ) : '';

	$mwb_upsell_new_bump['mwb_ubo_selected_template'] = ! empty( $_POST['mwb_ubo_selected_template'] ) ? sanitize_textarea_field( wp_unslash( $_POST['mwb_ubo_selected_template'] ) ) : '';

	// Sanitize and stripe slashes all the arrays.
	$mwb_upsell_new_bump['mwb_upsell_bump_target_categories'] = ! empty( $_POST['mwb_upsell_bump_target_categories'] ) ? array_map( 'sanitize_text_field', wp_unslash( $_POST['mwb_upsell_bump_target_categories'] ) ) : '';

	$mwb_upsell_new_bump['mwb_upsell_bump_target_ids'] = ! empty( $_POST['mwb_upsell_bump_target_ids'] ) ? array_map( 'sanitize_text_field', wp_unslash( $_POST['mwb_upsell_bump_target_ids'] ) ) : '';

	// After v1.2.0.
	$mwb_upsell_new_bump['mwb_ubo_offer_replace_target'] = ! empty( $_POST['mwb_ubo_offer_replace_target'] ) ? sanitize_text_field( wp_unslash( $_POST['mwb_ubo_offer_replace_target'] ) ) : 'no';

	// When Bump is saved for the first time so load default Design Settings.
	if ( empty( $_POST['parent_border_type'] ) ) {

		$design_settings = mwb_ubo_lite_offer_template_1();

		$mwb_upsell_new_bump['design_css'] = $design_settings;

		$mwb_upsell_new_bump['design_text'] = mwb_ubo_lite_offer_default_text();

	} else {    // When design Settings is saved from Post.

		// PARENT WRAPPER DIV CSS( parent_wrapper_div ).
		$design_settings_post['parent_border_type'] = ! empty( $_POST['parent_border_type'] ) ? sanitize_text_field( wp_unslash( $_POST['parent_border_type'] ) ) : '';
		$design_settings_post['parent_border_color'] = ! empty( $_POST['parent_border_color'] ) ? sanitize_text_field( wp_unslash( $_POST['parent_border_color'] ) ) : '';
		$design_settings_post['top_vertical_spacing'] = ! empty( $_POST['top_vertical_spacing'] ) ? sanitize_text_field( wp_unslash( $_POST['top_vertical_spacing'] ) ) : '';
		$design_settings_post['bottom_vertical_spacing'] = ! empty( $_POST['bottom_vertical_spacing'] ) ? sanitize_text_field( wp_unslash( $_POST['bottom_vertical_spacing'] ) ) : '';

		unset( $_POST['parent_border_type'] );
		unset( $_POST['parent_border_color'] );
		unset( $_POST['top_vertical_spacing'] );
		unset( $_POST['bottom_vertical_spacing'] );

		// DISCOUNT SECTION( discount_section ).
		$design_settings_post['discount_section_background_color'] = ! empty( $_POST['discount_section_background_color'] ) ? sanitize_text_field( wp_unslash( $_POST['discount_section_background_color'] ) ) : '';
		$design_settings_post['discount_section_text_color'] = ! empty( $_POST['discount_section_text_color'] ) ? sanitize_text_field( wp_unslash( $_POST['discount_section_text_color'] ) ) : '';
		$design_settings_post['discount_section_text_size'] = ! empty( $_POST['discount_section_text_size'] ) ? sanitize_text_field( wp_unslash( $_POST['discount_section_text_size'] ) ) : '';

		unset( $_POST['discount_section_background_color'] );
		unset( $_POST['discount_section_text_color'] );
		unset( $_POST['discount_section_text_size'] );


		// PRODUCT SECTION(product_section).
		$design_settings_post['product_section_text_color'] = ! empty( $_POST['product_section_text_color'] ) ? sanitize_text_field( wp_unslash( $_POST['product_section_text_color'] ) ) : '';
		$design_settings_post['product_section_text_size'] = ! empty( $_POST['product_section_text_size'] ) ? sanitize_text_field( wp_unslash( $_POST['product_section_text_size'] ) ) : '';

		unset( $_POST['product_section_text_color'] );
		unset( $_POST['product_section_text_size'] );

		// Accept Offer Section(primary_section).
		$design_settings_post['primary_section_background_color'] = ! empty( $_POST['primary_section_background_color'] ) ? sanitize_text_field( wp_unslash( $_POST['primary_section_background_color'] ) ) : '';
		$design_settings_post['primary_section_text_color'] = ! empty( $_POST['primary_section_text_color'] ) ? sanitize_text_field( wp_unslash( $_POST['primary_section_text_color'] ) ) : '';
		$design_settings_post['primary_section_text_size'] = ! empty( $_POST['primary_section_text_size'] ) ? sanitize_text_field( wp_unslash( $_POST['primary_section_text_size'] ) ) : '';

		unset( $_POST['primary_section_background_color'] );
		unset( $_POST['primary_section_text_color'] );
		unset( $_POST['primary_section_text_size'] );

		// SECONDARY SECTION(secondary_section).
		$design_settings_post['secondary_section_background_color'] = ! empty( $_POST['secondary_section_background_color'] ) ? sanitize_text_field( wp_unslash( $_POST['secondary_section_background_color'] ) ) : '';
		$design_settings_post['secondary_section_text_color'] = ! empty( $_POST['secondary_section_text_color'] ) ? sanitize_text_field( wp_unslash( $_POST['secondary_section_text_color'] ) ) : '';
		$design_settings_post['secondary_section_text_size'] = ! empty( $_POST['secondary_section_text_size'] ) ? sanitize_text_field( wp_unslash( $_POST['secondary_section_text_size'] ) ) : '';

		unset( $_POST['secondary_section_background_color'] );
		unset( $_POST['secondary_section_text_color'] );
		unset( $_POST['secondary_section_text_size'] );

		$mwb_upsell_new_bump['design_css'] = $design_settings_post;

		$text_settings_post = array(

			'mwb_ubo_discount_title_for_fixed'  => ! empty( $_POST['mwb_ubo_discount_title_for_fixed'] ) ? sanitize_text_field( wp_unslash( $_POST['mwb_ubo_discount_title_for_fixed'] ) ) : '',

			'mwb_ubo_discount_title_for_percent'    => ! empty( $_POST['mwb_ubo_discount_title_for_percent'] ) ? sanitize_text_field( wp_unslash( $_POST['mwb_ubo_discount_title_for_percent'] ) ) : '',

			'mwb_bump_offer_decsription_text'   => ! empty( $_POST['mwb_bump_offer_decsription_text'] ) ? sanitize_textarea_field( wp_unslash( $_POST['mwb_bump_offer_decsription_text'] ) ) : '',

			'mwb_upsell_offer_title'    => ! empty( $_POST['mwb_upsell_offer_title'] ) ? sanitize_text_field( wp_unslash( $_POST['mwb_upsell_offer_title'] ) ) : '',

			'mwb_upsell_bump_offer_description' => ! empty( $_POST['mwb_upsell_bump_offer_description'] ) ? sanitize_textarea_field( wp_unslash( $_POST['mwb_upsell_bump_offer_description'] ) ) : '',
		);

		unset( $_POST['mwb_ubo_discount_title_for_fixed'] );
		unset( $_POST['mwb_ubo_discount_title_for_percent'] );
		unset( $_POST['mwb_bump_offer_decsription_text'] );
		unset( $_POST['mwb_upsell_offer_title'] );
		unset( $_POST['mwb_upsell_bump_offer_description'] );
		$mwb_upsell_new_bump['design_text'] = $text_settings_post;
	}

	// Get all bumps.
	$mwb_created_upsell_bumps = get_option( 'mwb_ubo_bump_list', array() );

	// If Order Bump already exists then save Sales By Bump - Stats if present.
	if ( ! empty( $mwb_created_upsell_bumps[ $mwb_upsell_bump_id ]['offer_view_count'] ) ) {

		$sales_stats_bump = $mwb_created_upsell_bumps[ $mwb_upsell_bump_id ];

		// Not Post data, so no need to Sanitize and Strip slashes.

		// Empty for this already checked above.
		$mwb_upsell_new_bump['offer_view_count'] = $sales_stats_bump['offer_view_count'];

		$mwb_upsell_new_bump['offer_accept_count'] = ! empty( $sales_stats_bump['offer_accept_count'] ) ? $sales_stats_bump['offer_accept_count'] : 0;

		$mwb_upsell_new_bump['offer_remove_count'] = ! empty( $sales_stats_bump['offer_remove_count'] ) ? $sales_stats_bump['offer_remove_count'] : 0;

		$mwb_upsell_new_bump['bump_success_count'] = ! empty( $sales_stats_bump['bump_success_count'] ) ? $sales_stats_bump['bump_success_count'] : 0;

		$mwb_upsell_new_bump['bump_total_sales'] = ! empty( $sales_stats_bump['bump_total_sales'] ) ? $sales_stats_bump['bump_total_sales'] : 0;
	}

	// When Bump is saved for the first time so load default text Settings.
	$mwb_upsell_bump_series = array();

	// POST bump as array at bump id key.
	$mwb_upsell_bump_series[ $mwb_upsell_bump_id ] = $mwb_upsell_new_bump;

	// If there are other bumps.
	if ( is_array( $mwb_created_upsell_bumps ) && count( $mwb_created_upsell_bumps ) ) {

		$flag = 0;

		foreach ( $mwb_created_upsell_bumps as $key => $data ) {

			// If bump id key is already present, then replace that key in array.
			if ( $key == $mwb_upsell_bump_id ) {

				$mwb_created_upsell_bumps[ $key ] = $mwb_upsell_bump_series[ $mwb_upsell_bump_id ];
				$flag = 1;
				break;
			}
		}

		// If Bump id key not present then merge array.
		if ( 1 != $flag ) {

			// Array merge was reindexing keys so using array union operator.
			$mwb_created_upsell_bumps = $mwb_created_upsell_bumps + $mwb_upsell_bump_series;
		}

		update_option( 'mwb_ubo_bump_list', $mwb_created_upsell_bumps );

	} else {

		// If there are no other bumps.
		update_option( 'mwb_ubo_bump_list', $mwb_upsell_bump_series );
	}

	?>

	<!-- Settings saved notice. -->
	<div class="notice notice-success is-dismissible"> 
		<p><strong><?php esc_html_e( 'Settings saved', 'upsell-order-bump-offer-for-woocommerce-pro' ); ?></strong></p>
	</div>

	<?php
}

// Get all Bump.
$mwb_upsell_bumps_list = get_option( 'mwb_ubo_bump_list', array() );
$mwb_bump_offer_type = ! empty( $mwb_upsell_bumps_list[ $mwb_upsell_bump_id ]['mwb_upsell_offer_price_type'] ) ? $mwb_upsell_bumps_list[ $mwb_upsell_bump_id ]['mwb_upsell_offer_price_type'] : '';

$mwb_upsell_bump_schedule_options = array(
	'0'     => __( 'Daily', 'upsell-order-bump-offer-for-woocommerce-pro' ),
	'1'     => __( 'Monday', 'upsell-order-bump-offer-for-woocommerce-pro' ),
	'2'     => __( 'Tuesday', 'upsell-order-bump-offer-for-woocommerce-pro' ),
	'3'     => __( 'Wednesday', 'upsell-order-bump-offer-for-woocommerce-pro' ),
	'4'     => __( 'Thursday', 'upsell-order-bump-offer-for-woocommerce-pro' ),
	'5'     => __( 'Friday', 'upsell-order-bump-offer-for-woocommerce-pro' ),
	'6'     => __( 'Saturday', 'upsell-order-bump-offer-for-woocommerce-pro' ),
	'7'     => __( 'Sunday', 'upsell-order-bump-offer-for-woocommerce-pro' ),
);

?>

<!-- For Single Bump. -->
<form action="" method="POST">
	<div class="mwb_upsell_table">
		<table class="form-table mwb_upsell_bump_creation_setting" >
			<tbody>

				<!-- Nonce field here. -->
				<?php wp_nonce_field( 'mwb_upsell_bump_creation_nonce', 'mwb_upsell_bump_nonce' ); ?>

				<input type="hidden" name="mwb_upsell_bump_id" value="<?php echo esc_html( $mwb_upsell_bump_id ); ?>">

				<?php

				$bump_name = ! empty( $mwb_upsell_bumps_list[ $mwb_upsell_bump_id ]['mwb_upsell_bump_name'] ) ? sanitize_text_field( $mwb_upsell_bumps_list[ $mwb_upsell_bump_id ]['mwb_upsell_bump_name'] ) : esc_html__( 'Order Bump', 'upsell-order-bump-offer-for-woocommerce-pro' ) . " #$mwb_upsell_bump_id";

				$bump_status = ! empty( $mwb_upsell_bumps_list[ $mwb_upsell_bump_id ]['mwb_upsell_bump_status'] ) ? sanitize_text_field( $mwb_upsell_bumps_list[ $mwb_upsell_bump_id ]['mwb_upsell_bump_status'] ) : 'no';

				?>

				<!-- Bump Header start.-->
				<div id="mwb_upsell_bump_name_heading">
					<h2><?php echo esc_html( $bump_name ); ?></h2>
					<div id="mwb_upsell_bump_status" >
						<label>
							<input type="checkbox" id="mwb_upsell_bump_status_input" name="mwb_upsell_bump_status" value="yes" <?php checked( 'yes', $bump_status ); ?> >
							<span class="mwb_upsell_bump_span"></span>
						</label>

						<span class="mwb_upsell_bump_status_on <?php echo 'yes' == $bump_status ? 'active' : ''; ?>"><?php esc_html_e( 'Live', 'upsell-order-bump-offer-for-woocommerce-pro' ); ?></span>
						<span class="mwb_upsell_bump_status_off <?php echo 'no' == $bump_status ? 'active' : ''; ?>"><?php esc_html_e( 'Sandbox', 'upsell-order-bump-offer-for-woocommerce-pro' ); ?></span>
					</div>
				</div>

				<!-- Bump Name start.-->
				<tr valign="top">

					<th scope="row" class="titledesc">
						<label for="mwb_upsell_bump_name"><?php esc_html_e( 'Name of the Order Bump', 'upsell-order-bump-offer-for-woocommerce-pro' ); ?></label>
					</th>

					<td class="forminp forminp-text">

						<?php

						$description = esc_html__( 'Provide the name of your Order Bump.', 'upsell-order-bump-offer-for-woocommerce-pro' );

						mwb_ubo_lite_help_tip( $description );

						?>

						<input type="text" id="mwb_upsell_bump_name" name="mwb_upsell_bump_name" value="<?php echo esc_attr( $bump_name ); ?>" class="input-text mwb_upsell_bump_commone_class" required="" maxlength="30">
					</td>
				</tr>
				<!-- Bump Name end.-->

				<!-- Select Target product start. -->
				<tr valign="top">

					<th scope="row" class="titledesc">
						<label for="mwb_upsell_bump_target_ids_search"><?php esc_html_e( 'Select target product(s)', 'upsell-order-bump-offer-for-woocommerce-pro' ); ?></label>
					</th>

					<td class="forminp forminp-text">

						<?php

						$description = esc_html__( 'If any one of these Target Products is checked out then this Order Bump will be triggered and the below offer will be shown.', 'upsell-order-bump-offer-for-woocommerce-pro' );

						mwb_ubo_lite_help_tip( $description );

						?>

						<select id="mwb_upsell_bump_target_ids_search" class="wc-bump-product-search" multiple="multiple" name="mwb_upsell_bump_target_ids[]" data-placeholder="<?php esc_attr_e( 'Search for a product&hellip;', 'upsell-order-bump-offer-for-woocommerce-pro' ); ?>">

							<?php

							if ( ! empty( $mwb_upsell_bumps_list ) ) {

								$mwb_upsell_bump_target_products = isset( $mwb_upsell_bumps_list[ $mwb_upsell_bump_id ]['mwb_upsell_bump_target_ids'] ) ? $mwb_upsell_bumps_list[ $mwb_upsell_bump_id ]['mwb_upsell_bump_target_ids'] : array();

								// Array_map with absint converts negative array values to positive, so that we dont get negative ids.
								$mwb_upsell_bump_target_products_ids = ! empty( $mwb_upsell_bump_target_products ) ? array_map( 'absint', $mwb_upsell_bump_target_products ) : null;

								if ( $mwb_upsell_bump_target_products_ids ) {

									foreach ( $mwb_upsell_bump_target_products_ids as $mwb_upsell_bump_single_target_products_ids ) {

										if ( function_exists( 'mwb_ubo_lite_get_title' ) ) {

											$product_name = mwb_ubo_lite_get_title( $mwb_upsell_bump_single_target_products_ids );

										} else {

											$product_name = ! empty( get_the_title( $mwb_upsell_bump_single_target_products_ids ) ) ? get_the_title( $mwb_upsell_bump_single_target_products_ids ) : esc_html__( 'Product Not Found', 'upsell-order-bump-offer-for-woocommerce-pro' );
										}

										?>

										<option value="<?php echo esc_html( $mwb_upsell_bump_single_target_products_ids ); ?>" selected="selected"><?php echo( esc_html( $product_name ) . '(#' . esc_html( $mwb_upsell_bump_single_target_products_ids ) . ')' ); ?></option>';

										<?php
									}
								}
							}

							?>
						</select>		
					</td>	
				</tr>

				<!-- Target category starts. -->
				<tr valign="top">

					<th scope="row" class="titledesc">
						<label for="mwb_upsell_bump_target_categories_search"><?php esc_html_e( 'Select target categories', 'upsell-order-bump-offer-for-woocommerce-pro' ); ?></label>
					</th>

					<td class="forminp forminp-text">

						<?php

						$description = esc_html__( 'If any one of these Target categories is checked out then this Order Bump will be triggered and the below offer will be shown.', 'upsell-order-bump-offer-for-woocommerce-pro' );

						mwb_ubo_lite_help_tip( $description );

						?>

						<select id="mwb_upsell_bump_target_categories_search" class="wc-bump-product-category-search" multiple="multiple" name="mwb_upsell_bump_target_categories[]" data-placeholder="<?php esc_attr_e( 'Search for a category&hellip;', 'upsell-order-bump-offer-for-woocommerce-pro' ); ?>">

							<?php

							if ( ! empty( $mwb_upsell_bumps_list ) ) {

								$mwb_upsell_bump_target_categories = isset( $mwb_upsell_bumps_list[ $mwb_upsell_bump_id ]['mwb_upsell_bump_target_categories'] ) ? $mwb_upsell_bumps_list[ $mwb_upsell_bump_id ]['mwb_upsell_bump_target_categories'] : array();

								// Array_map with absint converts negative array values to positive, so that we dont get negative ids.
								$mwb_upsell_bump_target_categories = ! empty( $mwb_upsell_bump_target_categories ) ? array_map( 'absint', $mwb_upsell_bump_target_categories ) : null;

								if ( $mwb_upsell_bump_target_categories ) {

									foreach ( $mwb_upsell_bump_target_categories as $single_target_category_id ) {

										if ( function_exists( 'mwb_ubo_lite_getcat_title' ) ) {

											$single_category_name = mwb_ubo_lite_getcat_title( $single_target_category_id );

										} else {

											$single_category_name = ! empty( get_the_category_by_ID( $single_target_category_id ) ) ? get_the_category_by_ID( $single_target_category_id ) : esc_html__( 'Category Not Found', 'upsell-order-bump-offer-for-woocommerce-pro' );
										}

										?>
										<option value="<?php echo esc_html( $single_target_category_id ); ?>" selected="selected"><?php echo( esc_html( $single_category_name ) . '(#' . esc_html( $single_target_category_id ) . ')' ); ?></option>';
										<?php
									}
								}
							}

							?>
						</select>		
					</td>	
				</tr>
				<!-- Target category ends. -->

				<!-- Schedule your Bump start. -->
				<tr valign="top">

					<th scope="row" class="titledesc">
						<label for="mwb_upsell_bump_schedule_select"><?php esc_html_e( 'Order Bump Schedule', 'upsell-order-bump-offer-for-woocommerce-pro' ); ?></label>
					</th>

					<td class="forminp forminp-text">

						<?php

						$description = __( 'Schedule your Order Bump for specific weekdays.', 'upsell-order-bump-offer-for-woocommerce-pro' );

						mwb_ubo_lite_help_tip( $description );

						?>

						<?php

						// For earlier versions we will get a string over here.
						if ( ! empty( $mwb_upsell_bumps_list[ $mwb_upsell_bump_id ]['mwb_upsell_bump_schedule'] ) && ! is_array( $mwb_upsell_bumps_list[ $mwb_upsell_bump_id ]['mwb_upsell_bump_schedule'] ) ) {

							// Whatever was the selected day, add as an array.
							$mwb_ubo_selected_schedule = array( $mwb_upsell_bumps_list[ $mwb_upsell_bump_id ]['mwb_upsell_bump_schedule'] );

						} else {

							$mwb_ubo_selected_schedule = ! empty( $mwb_upsell_bumps_list[ $mwb_upsell_bump_id ]['mwb_upsell_bump_schedule'] ) ? ( $mwb_upsell_bumps_list[ $mwb_upsell_bump_id ]['mwb_upsell_bump_schedule'] ) : array( '0' );
						}

						?>

						<select id="mwb_upsell_bump_schedule_select" class="wc-bump-schedule-search mwb_upsell_bump_schedule" multiple="multiple" name="mwb_upsell_bump_schedule[]" data-placeholder="<?php esc_attr_e( 'Search for a specific days&hellip;', 'upsell-order-bump-offer-for-woocommerce-pro' ); ?>">

							<?php foreach ( $mwb_upsell_bump_schedule_options as $key => $day ) : ?>

								<option <?php echo in_array( $key, $mwb_ubo_selected_schedule ) ? 'selected' : ''; ?> value="<?php echo esc_html( $key ); ?>"><?php echo esc_html( $day ); ?></option>

							<?php endforeach; ?>

						</select>
					</td>
				</tr>
				<!-- Schedule your Bump end. -->

				<!-- After v1.2.0 -->

				<!-- Replace with target start. -->
				<tr valign="top">

				<!-- Add version compare to dependent plugin -->
				<?php
					$is_update_needed = 'false';
				if ( version_compare( UPSELL_ORDER_BUMP_OFFER_FOR_WOOCOMMERCE_VERSION, '1.2.0' ) < 0 ) {

					$is_update_needed = 'true';
				}
				?>
				
				<input type="hidden" id="is_update_needed" value="<?php echo esc_html( $is_update_needed ); ?>">

					<th scope="row" class="titledesc">

						<span class="mwb_ubo_premium_strip"><?php esc_html_e( 'Pro', 'upsell-order-bump-offer-for-woocommerce-pro' ); ?></span>
						
						<label for="mwb_ubo_offer_replace_target"><?php esc_html_e( 'Smart Offer Upgrade', 'upsell-order-bump-offer-for-woocommerce-pro' ); ?></label>
					</th>

					<td class="forminp forminp-text">

						<?php
							$attribute_description = esc_html__( 'Replace the existing target product with the offer product as soon as the customer accepts the Order Bump offer.', 'upsell-order-bump-offer-for-woocommerce-pro' );
							mwb_ubo_lite_help_tip( $attribute_description );

							$bump_offer_replace_target = ! empty( $mwb_upsell_bumps_list[ $mwb_upsell_bump_id ]['mwb_ubo_offer_replace_target'] ) ? $mwb_upsell_bumps_list[ $mwb_upsell_bump_id ]['mwb_ubo_offer_replace_target'] : 'no';
						?>

						<label class="mwb-upsell-smart-offer-upgrade" for="mwb_ubo_offer_replace_target">
						<input class="mwb-upsell-smart-offer-upgrade-wrap" type='checkbox' <?php echo mwb_ubo_lite_if_pro_exists() && ! empty( $bump_offer_replace_target ) && 'yes' == $bump_offer_replace_target ? 'checked' : ''; ?> id='mwb_ubo_offer_replace_target' value='yes' name='mwb_ubo_offer_replace_target'>
						<span class="upsell-smart-offer-upgrade-btn"></span>
						</label>

					</td>
				</tr>
				<!-- Replace with target end. -->

			</tbody>
		</table>

		<div class="mwb_upsell_bump_offers"><h1><?php esc_html_e( 'Order Bump Offer', 'upsell-order-bump-offer-for-woocommerce-pro' ); ?></h1>
		</div>

		<?php

		// Offers with discount.
		$mwb_upsell_bump_product_in_offer = ! empty( $mwb_upsell_bumps_list[ $mwb_upsell_bump_id ]['mwb_upsell_bump_products_in_offer'] ) ? sanitize_text_field( $mwb_upsell_bumps_list[ $mwb_upsell_bump_id ]['mwb_upsell_bump_products_in_offer'] ) : '';

		// Offers with discount.
		$mwb_upsell_bump_products_discount = ( ! empty( $mwb_upsell_bumps_list[ $mwb_upsell_bump_id ] ) && '' != $mwb_upsell_bumps_list[ $mwb_upsell_bump_id ]['mwb_upsell_bump_offer_discount_price'] ) ? $mwb_upsell_bumps_list[ $mwb_upsell_bump_id ]['mwb_upsell_bump_offer_discount_price'] : '20';

		?>
		<!-- Loader for template generation starts. -->
		<div class="mwb_ubo_animation_loader">
			<img src="images/spinner-2x.gif">
		</div>
		<!-- Loader for template generation ends. -->
		
		<!-- Bump Offers Start.-->
		<div class="new_offers">

			<!-- Single offer html start. -->
			<div class="new_created_offers mwb_upsell_single_offer" data-scroll-id="#offer-section-1" >

				<h2 class="mwb_upsell_offer_title" >
					<?php esc_html_e( 'Offer Section', 'upsell-order-bump-offer-for-woocommerce-pro' ); ?>
				</h2>

				<table>
					<!-- Offer product start. -->
					<tr>

						<th scope="row" class="titledesc">
							<label for="mwb_upsell_offer_product_select"><?php esc_html_e( 'Offer Product', 'upsell-order-bump-offer-for-woocommerce-pro' ); ?></label>
						</th>

						<td class="forminp forminp-text">

							<select class="wc-offer-product-search mwb_upsell_offer_product" id="mwb_upsell_offer_product_select" name="mwb_upsell_bump_products_in_offer" data-placeholder="<?php esc_html_e( 'Search for a product&hellip;', 'upsell-order-bump-offer-for-woocommerce-pro' ); ?>">

								<?php
								$current_offer_product_id = ! empty( $mwb_upsell_bumps_list[ $mwb_upsell_bump_id ]['mwb_upsell_bump_products_in_offer'] ) ? sanitize_text_field( $mwb_upsell_bumps_list[ $mwb_upsell_bump_id ]['mwb_upsell_bump_products_in_offer'] ) : '';

								if ( ! empty( $current_offer_product_id ) ) {

									if ( function_exists( 'mwb_ubo_lite_get_title' ) ) {

										$product_title = mwb_ubo_lite_get_title( $current_offer_product_id );

									} else {

										$product_title = ! empty( get_the_title( $current_offer_product_id ) ) ? get_the_title( $current_offer_product_id ) : esc_html__( 'Product Not Found', 'upsell-order-bump-offer-for-woocommerce-pro' );
									}

									?>

									<option value="<?php echo esc_html( $current_offer_product_id ); ?>" selected="selected"><?php echo esc_html( $product_title ) . '( #' . esc_html( $current_offer_product_id ) . ' )'; ?>
									</option>

									<?php

								}
								?>
							</select>

							<span class="mwb_upsell_offer_description mwb_upsell_offer_desc_text"><?php esc_html_e( 'Select the product you want to show as offer.', 'upsell-order-bump-offer-for-woocommerce-pro' ); ?></span>
						</td>
					</tr>
					<!-- Offer product end. -->

					<!-- Offer price start. -->
					<tr>
						<th scope="row" class="titledesc">
							<label for="mwb_upsell_offer_price_type_id"><?php esc_html_e( 'Offer Price/Discount', 'upsell-order-bump-offer-for-woocommerce-pro' ); ?></label>
						</th>

						<td class="forminp forminp-text">
							<select name="mwb_upsell_offer_price_type" id = 'mwb_upsell_offer_price_type_id' >

								<option <?php echo esc_html( '%' == $mwb_bump_offer_type ? 'selected' : '' ); ?> value="%"><?php esc_html_e( 'Discount %', 'upsell-order-bump-offer-for-woocommerce-pro' ); ?></option>

								<option <?php echo esc_html( 'fixed' == $mwb_bump_offer_type ? 'selected' : '' ); ?> value="fixed"><?php esc_html_e( 'Fixed price', 'upsell-order-bump-offer-for-woocommerce-pro' ); ?></option>

							</select>
							<input type="text" class = "mwb_upsell_offer_input_type" class="mwb_upsell_offer_price" name="mwb_upsell_bump_offer_discount_price" value="<?php echo esc_html( $mwb_upsell_bump_products_discount ); ?>">
							<span class="mwb_upsell_offer_description"><?php esc_html_e( 'Specify new offer price or discount %', 'upsell-order-bump-offer-for-woocommerce-pro' ); ?></span>

						</td>
					</tr>
					<!-- Offer price end. -->

				</table>

			</div>
			<!-- Single offer html end. -->
		</div>	

		<!-- Appearance Section starts.	-->
		<?php

		// If Offer product is Saved only then show Appearance section.
		if ( ! empty( $mwb_upsell_bumps_list[ $mwb_upsell_bump_id ]['mwb_upsell_bump_products_in_offer'] ) ) :

			?>

			<div class="mwb_upsell_offer_templates"><?php esc_html_e( 'Appearance', 'upsell-order-bump-offer-for-woocommerce-pro' ); ?></div>

			<!-- Nav starts. -->
			<nav class="nav-tab-wrapper mwb-ubo-appearance-nav-tab">
				<a class="nav-tab mwb-ubo-appearance-template nav-tab-active" href="javascript:void(0);"><?php esc_html_e( 'Template', 'upsell-order-bump-offer-for-woocommerce-pro' ); ?></a>
				<a class="nav-tab mwb-ubo-appearance-design" href="javascript:void(0);"><?php esc_html_e( 'Design', 'upsell-order-bump-offer-for-woocommerce-pro' ); ?></a>
				<a class="nav-tab mwb-ubo-appearance-text" href="javascript:void(0);"><?php esc_html_e( 'Content', 'upsell-order-bump-offer-for-woocommerce-pro' ); ?></a>
			</nav>
			<!-- Nav ends. -->

			<!-- Appearance Starts. -->		
			<div class="mwb_upsell_template_div_wrapper" >
				<!-- Template start -->
				<div class="mwb-ubo-template-section" >
					<?php

						$mwb_bump_upsell_selected_template = ! empty( $mwb_upsell_bumps_list[ $mwb_upsell_bump_id ]['mwb_bump_upsell_selected_template'] ) ? $mwb_upsell_bumps_list[ $mwb_upsell_bump_id ]['mwb_bump_upsell_selected_template'] : '';

						$mwb_ubo_selected_template = ! empty( $mwb_upsell_bumps_list[ $mwb_upsell_bump_id ]['mwb_ubo_selected_template'] ) ? $mwb_upsell_bumps_list[ $mwb_upsell_bump_id ]['mwb_ubo_selected_template'] : '1';

					?>

					<!-- Image wrapper -->
					<div id="available_tab" class="mwb_ubo_temp_class mwb_upsell_template_select-wrapper" >

						<!-- Template one. -->
						<div class="mwb_upsell_template_select <?php echo esc_html( 1 == $mwb_ubo_selected_template ? 'mwb_ubo_selected_class' : '' ); ?>">

							<input type="hidden" class="mwb_ubo_template" name="mwb_bump_upsell_selected_template" value="<?php echo esc_html( $mwb_bump_upsell_selected_template ); ?>" >

							<input type="hidden" class="mwb_ubo_selected_template" name="mwb_ubo_selected_template" value="<?php echo esc_html( $mwb_ubo_selected_template ); ?>">

							<p class="mwb_ubo_template_name" ><?php esc_html_e( 'Dazzling Bliss', 'upsell-order-bump-offer-for-woocommerce-pro' ); ?></p>
							<a href="javascript:void" class="mwb_ubo_template_link" data_link = '1' >
							<?php if ( file_exists( UPSELL_ORDER_BUMP_OFFER_FOR_WOOCOMMERCE_DIR_PATH . 'admin/resources/offer-templates/template-1.png' ) ) : ?>
								<img src="<?php echo esc_url( UPSELL_ORDER_BUMP_OFFER_FOR_WOOCOMMERCE_URL . 'admin/resources/offer-templates/template-1.png' ); ?>">
								<?php else : ?>
								<img src="<?php echo esc_url( UPSELL_ORDER_BUMP_OFFER_FOR_WOOCOMMERCE_URL . 'admin/resources/Offer templates/Template1.png' ); ?>">
							<?php endif; ?>
							</a>
						</div>

						<!-- Template two. -->
						<div class="mwb_upsell_template_select <?php echo esc_html( 2 == $mwb_ubo_selected_template ? 'mwb_ubo_selected_class' : '' ); ?> ">

							<p class="mwb_ubo_template_name" ><?php esc_html_e( 'Alluring Lakeside', 'upsell-order-bump-offer-for-woocommerce-pro' ); ?></p>
							<a href="javascript:void" class="mwb_ubo_template_link" data_link = '2' >
								<?php if ( file_exists( UPSELL_ORDER_BUMP_OFFER_FOR_WOOCOMMERCE_DIR_PATH . 'admin/resources/offer-templates/template-1.png' ) ) : ?>
								<img src="<?php echo esc_url( UPSELL_ORDER_BUMP_OFFER_FOR_WOOCOMMERCE_URL . 'admin/resources/offer-templates/template-2.png' ); ?>">
								<?php else : ?>
								<img src="<?php echo esc_url( UPSELL_ORDER_BUMP_OFFER_FOR_WOOCOMMERCE_URL . 'admin/resources/Offer templates/Template2.png' ); ?>">
							<?php endif; ?>
							</a>
						</div>
					
						<!-- Template three. -->
						<div class="mwb_upsell_template_select <?php echo esc_html( 3 == $mwb_ubo_selected_template ? 'mwb_ubo_selected_class' : '' ); ?> ">

							<p class="mwb_ubo_template_name" ><?php esc_html_e( 'Elegant Summers', 'upsell-order-bump-offer-for-woocommerce-pro' ); ?></p>

							<a href="javascript:void" class="mwb_ubo_template_link" data_link = '3' >
								<?php if ( file_exists( UPSELL_ORDER_BUMP_OFFER_FOR_WOOCOMMERCE_DIR_PATH . 'admin/resources/offer-templates/template-1.png' ) ) : ?>
								<img src="<?php echo esc_url( UPSELL_ORDER_BUMP_OFFER_FOR_WOOCOMMERCE_URL . 'admin/resources/offer-templates/template-3.png' ); ?>">
								<?php else : ?>
								<img src="<?php echo esc_url( UPSELL_ORDER_BUMP_OFFER_FOR_WOOCOMMERCE_URL . 'admin/resources/Offer templates/Template3.png' ); ?>">
							<?php endif; ?>
							</a>
						</div>
					</div>
				</div>
				<!-- Template end -->

				<!-- Design start -->
				<div class="mwb_upsell_table_column_wrapper mwb-ubo-appearance-section-hidden">

					<div class="mwb_upsell_table mwb_upsell_table--border mwb_upsell_custom_template_settings ">

						<div class="mwb_upsell_offer_sections"><?php esc_html_e( 'Bump Offer Box', 'upsell-order-bump-offer-for-woocommerce-pro' ); ?></div>
						<table class="form-table mwb_upsell_bump_creation_setting">
							<tbody>

								<!-- Populate rest fields with available templates if not custom is checked. -->
								<?php

								if ( ! empty( $mwb_bump_upsell_selected_template ) ) {

									// Load the css of selected template.
									$template_callb_func = 'mwb_ubo_lite_offer_template_' . $mwb_bump_upsell_selected_template;

									$mwb_bump_enable_available_design = $template_callb_func();

									$mwb_upsell_bumps_list[ $mwb_upsell_bump_id ]['design_css'] = $mwb_bump_enable_available_design;
								}

								?>
								<!-- Border style start. -->
								<tr valign="top">

									<th scope="row" class="titledesc">
										<label><?php esc_html_e( 'Select Border type', 'upsell-order-bump-offer-for-woocommerce-pro' ); ?></label>
									</th>

									<td class="forminp forminp-text">
										<?php
											$attribute_description = esc_html__( 'Select among different border types for Bump Offer.', 'upsell-order-bump-offer-for-woocommerce-pro' );

											mwb_ubo_lite_help_tip( $attribute_description );

										?>

										<label>
											
											<!-- Select options for border. -->
											<select name="parent_border_type" class="mwb_ubo_preview_select_border_type" >

												<?php

												$border_type_array = array(
													'none'   => esc_html__( 'No Border', 'upsell-order-bump-offer-for-woocommerce-pro' ),
													'solid'  => esc_html__( 'Solid', 'upsell-order-bump-offer-for-woocommerce-pro' ),
													'dashed' => esc_html__( 'Dashed', 'upsell-order-bump-offer-for-woocommerce-pro' ),
													'double' => esc_html__( 'Double', 'upsell-order-bump-offer-for-woocommerce-pro' ),
													'dotted' => esc_html__( 'Dotted', 'upsell-order-bump-offer-for-woocommerce-pro' ),

												);

												?>
												<option value="" ><?php esc_html_e( '----Select Border Type----', 'upsell-order-bump-offer-for-woocommerce-pro' ); ?></option>

												<?php
												foreach ( $border_type_array as $value => $name ) :
													?>
													<option <?php echo esc_html( $mwb_upsell_bumps_list[ $mwb_upsell_bump_id ]['design_css']['parent_border_type'] == $value ? 'selected' : '' ); ?> value="<?php echo esc_html( $value ); ?>" ><?php echo esc_html( $name ); ?></option>
												<?php endforeach; ?>
											</select>

										</label>		
									</td>
								</tr>
							<!-- Border style end. -->

							<!-- Border color start. -->
								<tr valign="top">

									<th scope="row" class="titledesc">
										<label><?php esc_html_e( 'Select Border Color', 'upsell-order-bump-offer-for-woocommerce-pro' ); ?></label>
									</th>

									<td class="forminp forminp-text">
									<?php
										$attribute_description = esc_html__( 'Select border color for Bump Offer.', 'upsell-order-bump-offer-for-woocommerce-pro' );
										mwb_ubo_lite_help_tip( $attribute_description );
									?>
										<label>
											<!-- Color picker for description background. -->
											<input type="text" name="parent_border_color" class="mwb_ubo_colorpicker mwb_ubo_preview_select_border_color" value="<?php echo ! empty( $mwb_upsell_bumps_list[ $mwb_upsell_bump_id ]['design_css']['parent_border_color'] ) ? esc_html( $mwb_upsell_bumps_list[ $mwb_upsell_bump_id ]['design_css']['parent_border_color'] ) : ''; ?>">
										</label>			
									</td>

								</tr>
							<!-- Border color end. -->

							<!-- Top Vertical Spacing control start. -->
								<tr valign="top">

									<th scope="row" class="titledesc">
										<label><?php esc_html_e( 'Select Top Vertical Spacing', 'upsell-order-bump-offer-for-woocommerce-pro' ); ?></label>
									</th>

									<td class="forminp forminp-text">
										<?php
											$attribute_description = esc_html__( 'Add top spacing to the Bump Offer Box.', 'upsell-order-bump-offer-for-woocommerce-pro' );
											mwb_ubo_lite_help_tip( $attribute_description );
										?>

										<label>
											<!-- Slider for spacing. -->
											<input type="range" min="0" value="<?php echo esc_html( $mwb_upsell_bumps_list[ $mwb_upsell_bump_id ]['design_css']['top_vertical_spacing'] ); ?>"  max="40" value="" name='top_vertical_spacing' class="mwb_ubo_top_vertical_spacing_slider" />
											<span class="mwb_ubo_top_spacing_slider_size" ><?php echo esc_html( ! empty( $mwb_upsell_bumps_list[ $mwb_upsell_bump_id ]['design_css']['top_vertical_spacing'] ) ? esc_html( $mwb_upsell_bumps_list[ $mwb_upsell_bump_id ]['design_css']['top_vertical_spacing'] . 'px' ) : '0px' ); ?></span>
										</label>
									</td>
								</tr>
								<!-- Top Vertical Spacing control ends. -->

								<!-- Bottom Vertical Spacing control start. -->
								<tr valign="top">
									<th scope="row" class="titledesc">
										<label><?php esc_html_e( 'Select Bottom Vertical Spacing', 'upsell-order-bump-offer-for-woocommerce-pro' ); ?></label>
									</th>

									<td class="forminp forminp-text">
									<?php
										$attribute_description = esc_html__( 'Add bottom spacing to the Bump Offer Box.', 'upsell-order-bump-offer-for-woocommerce-pro' );
										mwb_ubo_lite_help_tip( $attribute_description );
									?>
									<label>	
										<!-- Slider for spacing. -->
										<input type="range" value="<?php echo esc_html( $mwb_upsell_bumps_list[ $mwb_upsell_bump_id ]['design_css']['bottom_vertical_spacing'] ); ?>" min="0" max="40" value="" name='bottom_vertical_spacing' class="mwb_ubo_bottom_vertical_spacing_slider" />
										<span class="mwb_ubo_bottom_spacing_slider_size" > 
										<?php echo esc_html( ! empty( $mwb_upsell_bumps_list[ $mwb_upsell_bump_id ]['design_css']['bottom_vertical_spacing'] ) ? esc_html( $mwb_upsell_bumps_list[ $mwb_upsell_bump_id ]['design_css']['bottom_vertical_spacing'] . 'px' ) : '0px' ); ?>
											</span>
										</label>		
									</td>
								</tr>
								<!-- Bottom Vertical Spacing control ends. -->

							</tbody>
						</table>
					</div>
					<!-- Global wrapper section. -->

					<!-- Discount_section section. -->
					<div class="mwb_upsell_table mwb_upsell_table--border mwb_upsell_custom_template_settings ">
						<div class="mwb_upsell_offer_sections"><?php esc_html_e( 'Discount Section', 'upsell-order-bump-offer-for-woocommerce-pro' ); ?></div>
						<table class="form-table mwb_upsell_bump_creation_setting">
							<tbody>
								<!-- Background color start. -->
								<tr valign="top">
									<th scope="row" class="titledesc">
										<label><?php esc_html_e( 'Select Background Color', 'upsell-order-bump-offer-for-woocommerce-pro' ); ?></label>
									</th>

									<td class="forminp forminp-text">
									<?php
										$attribute_description = esc_html__( 'Select background color for Discount section.', 'upsell-order-bump-offer-for-woocommerce-pro' );
										mwb_ubo_lite_help_tip( $attribute_description );
									?>
										<label>
											<!-- Color picker for description background. -->
											<input type="text" name="discount_section_background_color" class="mwb_ubo_colorpicker mwb_ubo_select_discount_bcolor" value="<?php echo ! empty( $mwb_upsell_bumps_list[ $mwb_upsell_bump_id ]['design_css']['discount_section_background_color'] ) ? esc_html( $mwb_upsell_bumps_list[ $mwb_upsell_bump_id ]['design_css']['discount_section_background_color'] ) : ''; ?>">

										</label>	
									</td>
								</tr>
								<!-- Background color end. -->

								<!-- Text color start. -->
								<tr valign="top">
									<th scope="row" class="titledesc">
										<label><?php esc_html_e( 'Select Text Color', 'upsell-order-bump-offer-for-woocommerce-pro' ); ?></label>
									</th>

									<td class="forminp forminp-text">
										<?php
											$attribute_description = esc_html__( 'Select text color for Discount section.', 'upsell-order-bump-offer-for-woocommerce-pro' );
											mwb_ubo_lite_help_tip( $attribute_description );
										?>
										<label>
											<!-- Color picker for description text. -->
											<input type="text" name="discount_section_text_color" class="mwb_ubo_colorpicker mwb_ubo_select_discount_tcolor" value="<?php echo ! empty( $mwb_upsell_bumps_list[ $mwb_upsell_bump_id ]['design_css']['discount_section_text_color'] ) ? esc_html( $mwb_upsell_bumps_list[ $mwb_upsell_bump_id ]['design_css']['discount_section_text_color'] ) : ''; ?>">
										</label>			
									</td>

								</tr>
								<!-- Text color end. -->

								<!-- Text size control start. -->
								<tr valign="top">
									<th scope="row" class="titledesc">
										<label><?php esc_html_e( 'Select Text Size', 'upsell-order-bump-offer-for-woocommerce-pro' ); ?></label>
									</th>

									<td class="forminp forminp-text">
										<?php
											$attribute_description = esc_html__( 'Select font size for Discount section.', 'upsell-order-bump-offer-for-woocommerce-pro' );
											mwb_ubo_lite_help_tip( $attribute_description );
										?>
										<label>
											<!-- Slider for spacing. -->
											<input type="range" min="20" value="<?php echo esc_html( $mwb_upsell_bumps_list[ $mwb_upsell_bump_id ]['design_css']['discount_section_text_size'] ); ?>"  max="50" value="" name = 'discount_section_text_size' class="mwb_ubo_text_slider mwb_ubo_discount_slider" />

											<span class="mwb_ubo_slider_size mwb_ubo_discount_slider_size" ><?php echo esc_html( $mwb_upsell_bumps_list[ $mwb_upsell_bump_id ]['design_css']['discount_section_text_size'] . 'px' ); ?></span>
										</label>		
									</td>
								</tr>
								<!-- Text size control ends. -->
							</tbody>
						</table>
					</div>
					<!-- Discount_section section. -->

					<!-- Product_section section -->
					<div class="mwb_upsell_table mwb_upsell_table--border mwb_upsell_custom_template_settings ">
						<div class="mwb_upsell_offer_sections"><?php esc_html_e( 'Product Section', 'upsell-order-bump-offer-for-woocommerce-pro' ); ?></div>
						<table class="form-table mwb_upsell_bump_creation_setting">
							<tbody>

								<!-- Text color start. -->
								<tr valign="top">
									<th scope="row" class="titledesc">
										<label><?php esc_html_e( 'Select Text Color', 'upsell-order-bump-offer-for-woocommerce-pro' ); ?></label>
									</th>

									<td class="forminp forminp-text">
										<?php
											$attribute_description = esc_html__( 'Select text color for Product section.', 'upsell-order-bump-offer-for-woocommerce-pro' );
											mwb_ubo_lite_help_tip( $attribute_description );
										?>
										<label>
											<!-- Color picker for description text. -->
											<input type="text" name="product_section_text_color" class="mwb_ubo_colorpicker mwb_ubo_select_product_tcolor" value="<?php echo ! empty( $mwb_upsell_bumps_list[ $mwb_upsell_bump_id ]['design_css']['product_section_text_color'] ) ? esc_html( $mwb_upsell_bumps_list[ $mwb_upsell_bump_id ]['design_css']['product_section_text_color'] ) : ''; ?>">
										</label>			
									</td>
								</tr>
								<!-- Text color end. -->

								<!-- Text size control start. -->
								<tr valign="top">

									<th scope="row" class="titledesc">
										<label><?php esc_html_e( 'Select Text Size', 'upsell-order-bump-offer-for-woocommerce-pro' ); ?></label>
									</th>

									<td class="forminp forminp-text">
										<?php
											$attribute_description = esc_html__( 'Select font size for Product section.', 'upsell-order-bump-offer-for-woocommerce-pro' );
											mwb_ubo_lite_help_tip( $attribute_description );
										?>

										<label>
											
											<!-- Slider for spacing. -->
											<input type="range" min="10" value="<?php echo esc_html( $mwb_upsell_bumps_list[ $mwb_upsell_bump_id ]['design_css']['product_section_text_size'] ); ?>"  max="30" value="" name = 'product_section_text_size' class="mwb_ubo_text_slider mwb_ubo_product_slider" />

											<span class="mwb_ubo_slider_size mwb_ubo_product_slider_size" ><?php echo esc_html( $mwb_upsell_bumps_list[ $mwb_upsell_bump_id ]['design_css']['product_section_text_size'] . 'px' ); ?> </span>
										</label>		
									</td>

								</tr>
								<!-- Text size control ends. -->
							</tbody>
						</table>
					</div>
					<!-- Product_section section. -->

					<!-- Primary_section section. -->
					<div class="mwb_upsell_table mwb_upsell_table--border mwb_upsell_custom_template_settings ">
						<div class="mwb_upsell_offer_sections"><?php esc_html_e( 'Accept Offer Section', 'upsell-order-bump-offer-for-woocommerce-pro' ); ?></div>

						<table class="form-table mwb_upsell_bump_creation_setting">
							<tbody>
								<!-- Background color start. -->
								<tr valign="top">
									<th scope="row" class="titledesc">
										<label><?php esc_html_e( 'Select Background Color', 'upsell-order-bump-offer-for-woocommerce-pro' ); ?></label>
									</th>

									<td class="forminp forminp-text">
										<?php
											$attribute_description = esc_html__( 'Select background color for Accept Offer section.', 'upsell-order-bump-offer-for-woocommerce-pro' );
											mwb_ubo_lite_help_tip( $attribute_description );
										?>
										<label>
											<!-- Color picker for description background. -->
											<input type="text" name="primary_section_background_color" class="mwb_ubo_colorpicker mwb_ubo_select_accept_offer_bcolor" value="<?php echo ! empty( $mwb_upsell_bumps_list[ $mwb_upsell_bump_id ]['design_css']['primary_section_background_color'] ) ? esc_html( $mwb_upsell_bumps_list[ $mwb_upsell_bump_id ]['design_css']['primary_section_background_color'] ) : ''; ?>">
										</label>			
									</td>
								</tr>
								<!-- Background color end. -->

								<!-- Text color start. -->
								<tr valign="top">
									<th scope="row" class="titledesc">
										<label><?php esc_html_e( 'Select Text Color', 'upsell-order-bump-offer-for-woocommerce-pro' ); ?></label>
									</th>

									<td class="forminp forminp-text">
										<?php
											$attribute_description = esc_html__( 'Select text color for Accept Offer section.', 'upsell-order-bump-offer-for-woocommerce-pro' );
											mwb_ubo_lite_help_tip( $attribute_description );
										?>
										<label>	
											<!-- Color picker for description text. -->
											<input type="text" name="primary_section_text_color" class="mwb_ubo_colorpicker mwb_ubo_select_accept_offer_tcolor" value="<?php echo ! empty( $mwb_upsell_bumps_list[ $mwb_upsell_bump_id ]['design_css']['primary_section_text_color'] ) ? esc_html( $mwb_upsell_bumps_list[ $mwb_upsell_bump_id ]['design_css']['primary_section_text_color'] ) : ''; ?>">
										</label>			
									</td>
								</tr>
								<!-- Text color end. -->

								<!-- Text size control start. -->
								<tr valign="top">
									<th scope="row" class="titledesc">
										<label><?php esc_html_e( 'Select Text Size', 'upsell-order-bump-offer-for-woocommerce-pro' ); ?></label>
									</th>
									<td class="forminp forminp-text">
										<?php
											$attribute_description = esc_html__( 'Select font size for Accept Offer section.', 'upsell-order-bump-offer-for-woocommerce-pro' );
											mwb_ubo_lite_help_tip( $attribute_description );
										?>
										<label>
											<!-- Slider for spacing. -->
											<input type="range" min="10" value="<?php echo esc_html( $mwb_upsell_bumps_list[ $mwb_upsell_bump_id ]['design_css']['primary_section_text_size'] ); ?>"  max="30" value="" name = 'primary_section_text_size' class="mwb_ubo_text_slider mwb_ubo_accept_offer_slider" />
											<span class="mwb_ubo_slider_size mwb_ubo_accept_offer_slider_size" ><?php echo esc_html( $mwb_upsell_bumps_list[ $mwb_upsell_bump_id ]['design_css']['primary_section_text_size'] . 'px' ); ?></span>
										</label>	
									</td>
								</tr>
								<!-- Text size control ends. -->
							</tbody>
						</table>
					</div>
					<!-- Primary_section section. -->

					<!-- Secondary_section section. -->
					<div class="mwb_upsell_table mwb_upsell_table--border mwb_upsell_custom_template_settings ">
						<div class="mwb_upsell_offer_sections"><?php esc_html_e( 'Offer Description Section', 'upsell-order-bump-offer-for-woocommerce-pro' ); ?></div>
						<table class="form-table mwb_upsell_bump_creation_setting">
							<tbody>
								<!-- Background color start. -->
								<tr valign="top">
									<th scope="row" class="titledesc">
										<label><?php esc_html_e( 'Select Background Color', 'upsell-order-bump-offer-for-woocommerce-pro' ); ?></label>
									</th>
									<td class="forminp forminp-text">
										<?php
											$attribute_description = esc_html__( 'Select background color for Offer Description section.', 'upsell-order-bump-offer-for-woocommerce-pro' );
											mwb_ubo_lite_help_tip( $attribute_description );
										?>
										<label>
											<!-- Color picker for description background. -->
											<input type="text" name="secondary_section_background_color" class="mwb_ubo_colorpicker mwb_ubo_select_offer_description_bcolor" value="<?php echo ! empty( $mwb_upsell_bumps_list[ $mwb_upsell_bump_id ]['design_css']['secondary_section_background_color'] ) ? esc_html( $mwb_upsell_bumps_list[ $mwb_upsell_bump_id ]['design_css']['secondary_section_background_color'] ) : ''; ?>">
										</label>			
									</td>
								</tr>
								<!-- Background color end. -->

								<!-- Text color start. -->
								<tr valign="top">
									<th scope="row" class="titledesc">
										<label><?php esc_html_e( 'Select Text Color', 'upsell-order-bump-offer-for-woocommerce-pro' ); ?></label>
									</th>
									<td class="forminp forminp-text">
										<?php
											$attribute_description = esc_html__( 'Select text color for Offer Description section.', 'upsell-order-bump-offer-for-woocommerce-pro' );
											mwb_ubo_lite_help_tip( $attribute_description );
										?>
										<!-- Color picker for description text. -->
										<input type="text" name="secondary_section_text_color" class="mwb_ubo_colorpicker mwb_ubo_select_offer_description_tcolor" value="<?php echo ! empty( $mwb_upsell_bumps_list[ $mwb_upsell_bump_id ]['design_css']['secondary_section_text_color'] ) ? esc_html( $mwb_upsell_bumps_list[ $mwb_upsell_bump_id ]['design_css']['secondary_section_text_color'] ) : ''; ?>">
									</td>
								</tr>
								<!-- Text color end. -->

								<!-- Text size control start -->
								<tr valign="top">
									<th scope="row" class="titledesc">
										<label><?php esc_html_e( 'Select Text Size', 'upsell-order-bump-offer-for-woocommerce-pro' ); ?></label>
									</th>
									<td class="forminp forminp-text">
										<?php
											$attribute_description = esc_html__( 'Select font size for Offer Description section.', 'upsell-order-bump-offer-for-woocommerce-pro' );
											mwb_ubo_lite_help_tip( $attribute_description );
										?>
										<!-- Slider for spacing. -->
										<input type="range" min="10" value="<?php echo esc_html( $mwb_upsell_bumps_list[ $mwb_upsell_bump_id ]['design_css']['secondary_section_text_size'] ); ?>"  max="30" value="" name = 'secondary_section_text_size' class="mwb_ubo_text_slider mwb_ubo_offer_description_slider" />

										<span class="mwb_ubo_slider_size mwb_ubo_offer_description_slider_size" ><?php echo esc_html( $mwb_upsell_bumps_list[ $mwb_upsell_bump_id ]['design_css']['secondary_section_text_size'] . 'px' ); ?></span>
									</td>
								</tr>
								<!-- Text size control ends. -->
							</tbody>
						</table>
					</div>
					<!-- Secondary_section section ends. -->
				</div>
				<!-- Design end -->

				<!-- Text start -->
				<div class="mwb-ubo-text-section mwb_upsell_table--border mwb-ubo-appearance-section-hidden mwb_upsell_table" >
					<table>
						<!-- Discount Title start. -->
						<tr valign="top">
							<th scope="row" class="titledesc">
								<p class='mwb_ubo_row_heads' ><?php esc_html_e( 'Discount Title', 'upsell-order-bump-offer-for-woocommerce-pro' ); ?></p>
							</th>

							<td class="forminp forminp-text">
								<?php
									$attribute_description = sprintf(
										'%s<br>%s %s<br>%s %s',
										esc_html__( 'Discount title content. Please use at respective places :', 'upsell-order-bump-offer-for-woocommerce-pro' ),
										'&rarr; {dc_%}',
										esc_html__( 'for % discount.', 'upsell-order-bump-offer-for-woocommerce-pro' ),
										'&rarr; {dc_price}',
										esc_html__( 'for fixed discount price.', 'upsell-order-bump-offer-for-woocommerce-pro' )
									);

									mwb_ubo_lite_help_tip( $attribute_description );

									$mwb_ubo_discount_title_for_fixed = ! empty( $mwb_upsell_bumps_list[ $mwb_upsell_bump_id ]['design_text']['mwb_ubo_discount_title_for_fixed'] ) ? $mwb_upsell_bumps_list[ $mwb_upsell_bump_id ]['design_text']['mwb_ubo_discount_title_for_fixed'] : '';

									$mwb_ubo_discount_title_for_percent = ! empty( $mwb_upsell_bumps_list[ $mwb_upsell_bump_id ]['design_text']['mwb_ubo_discount_title_for_percent'] ) ? $mwb_upsell_bumps_list[ $mwb_upsell_bump_id ]['design_text']['mwb_ubo_discount_title_for_percent'] : '';

								?>
								<div class="d-inline-block">
									<p><?php esc_html_e( 'For Discount %', 'upsell-order-bump-offer-for-woocommerce-pro' ); ?></p>

									<input class="mwb_upsell_offer_input_type" type="text" text_id ="percent" name="mwb_ubo_discount_title_for_percent" value="<?php echo esc_attr( $mwb_ubo_discount_title_for_percent ); ?>">

									<p>
										<?php esc_html_e( 'For Fixed Price', 'upsell-order-bump-offer-for-woocommerce-pro' ); ?>
									</p>

									<input class="mwb_upsell_offer_input_type" type="text" name="mwb_ubo_discount_title_for_fixed" text_id ="fixed" value="<?php echo esc_html( $mwb_ubo_discount_title_for_fixed ); ?>">			
								</div>				
							</td>
						</tr>
						<!--Discount Title end. -->

						<!-- Product Description start. -->
						<tr valign="top">
							<th scope="row" class="titledesc">
								<p class='mwb_ubo_row_heads' ><?php esc_html_e( 'Product Description', 'upsell-order-bump-offer-for-woocommerce-pro' ); ?>
								</p>
							</th>

							<td class="forminp forminp-text" colspan="2" >

								<?php
									$attribute_description = esc_html__( 'Bump Offer Product description content.', 'upsell-order-bump-offer-for-woocommerce-pro' );

									mwb_ubo_lite_help_tip( $attribute_description );

									$mwb_bump_offer_decsription_text = ! empty( $mwb_upsell_bumps_list[ $mwb_upsell_bump_id ]['design_text']['mwb_bump_offer_decsription_text'] ) ? $mwb_upsell_bumps_list[ $mwb_upsell_bump_id ]['design_text']['mwb_bump_offer_decsription_text'] : '';
								?>

								<textarea class="mwb_textarea_class" text_id ="pro_desc" rows="4" cols="50" name="mwb_bump_offer_decsription_text" ><?php echo esc_html( $mwb_bump_offer_decsription_text ); ?></textarea>

							</td>
						</tr>
						<!-- Product Description end. -->

						<!-- Lead Title start. -->
						<tr valign="top">
							<th scope="row" class="titledesc">
								<p class='mwb_ubo_row_heads' ><?php esc_html_e( ' Lead Title ', 'upsell-order-bump-offer-for-woocommerce-pro' ); ?></p>
							</th>

							<td class="forminp forminp-text">
								<?php
									$attribute_description = esc_html__( 'Bump offer Lead title content.', 'upsell-order-bump-offer-for-woocommerce-pro' );
									mwb_ubo_lite_help_tip( $attribute_description );
								?>

								<?php

									$offer_lead_title = ! empty( $mwb_upsell_bumps_list[ $mwb_upsell_bump_id ]['design_text']['mwb_upsell_offer_title'] ) ? $mwb_upsell_bumps_list[ $mwb_upsell_bump_id ]['design_text']['mwb_upsell_offer_title'] : '';

								?>
														
									
								<input type="text" class="mwb_upsell_offer_input_type" name="mwb_upsell_offer_title" text_id ="lead" value = "<?php echo esc_html( $offer_lead_title ); ?>">

							</td>
						</tr>
						<!--Lead Title ends.-->

						<!-- Offer Description start. -->
						<tr valign="top">
							<th scope="row" class="titledesc">
								<p class='mwb_ubo_row_heads' ><?php esc_html_e( 'Offer Description ', 'upsell-order-bump-offer-for-woocommerce-pro' ); ?></p>
							</th>

							<td class="forminp forminp-text" colspan="2" >
								<?php
								$attribute_description = esc_html__( 'Bump Offer description content.', 'upsell-order-bump-offer-for-woocommerce-pro' );
								mwb_ubo_lite_help_tip( $attribute_description );

								$mwb_upsell_bump_offer_description = ! empty( $mwb_upsell_bumps_list[ $mwb_upsell_bump_id ]['design_text']['mwb_upsell_bump_offer_description'] ) ? esc_html( $mwb_upsell_bumps_list[ $mwb_upsell_bump_id ]['design_text']['mwb_upsell_bump_offer_description'] ) : '';
								?>
								<textarea class="mwb_textarea_class"  name="mwb_upsell_bump_offer_description" text_id ="off_desc" rows="5" cols="50" ><?php echo esc_html( $mwb_upsell_bump_offer_description ); ?></textarea>
							</td>
						</tr>
						<!-- Offer Description end. -->
					</table>
				</div>
				<!-- Text end -->

				<!-- Preview start -->
				<div class="mwb_ubo_bump_offer_preview" >
					
					<?php

					// Send current Bump Offer id.
					$bump = mwb_ubo_lite_fetch_bump_offer_details( $mwb_upsell_bump_id, '' );

					$bumphtml = mwb_ubo_lite_bump_offer_html( $bump );

					?>
					<h3 class="mwb_ubo_offer_preview_heading"><?php esc_html_e( 'Offer Preview', 'upsell-order-bump-offer-for-woocommerce-pro' ); ?></h3>

					<!-- Generate a live preview. -->
					<?php
						$allowed_html = mwb_ubo_lite_allowed_html();
						echo wp_kses( $bumphtml, $allowed_html );
					?>
				</div>
				<!-- Preview end -->

			</div>
			<!-- Appearance Ends. -->

			<?php
		endif;

		?>

		<!-- Save Changes for whole Bump. -->
		<p class="submit">
			<input type="submit" value="<?php esc_html_e( 'Save Changes', 'upsell-order-bump-offer-for-woocommerce-pro' ); ?>" class="button-primary woocommerce-save-button" name="mwb_upsell_bump_creation_setting_save" id="mwb_upsell_bump_creation_setting_save" >
		</p>
	</div>
</form>

<!-- Skin Change Popup -->
<div class="mwb_ubo_skin_popup_wrapper">
	<div class="mwb_ubo_skin_popup_inner">
		<!-- Popup icon -->
		<div class="mwb_ubo_skin_popup_head">
			<?php if ( file_exists( UPSELL_ORDER_BUMP_OFFER_FOR_WOOCOMMERCE_DIR_PATH . 'admin/resources/icons/warning.png' ) ) : ?>
				<img src="<?php echo esc_url( UPSELL_ORDER_BUMP_OFFER_FOR_WOOCOMMERCE_URL . 'admin/resources/icons/warning.png' ); ?>">
				<?php else : ?>
				<img src="<?php echo esc_url( UPSELL_ORDER_BUMP_OFFER_FOR_WOOCOMMERCE_URL . 'admin/resources/Icons/warning.png' ); ?>">
			<?php endif; ?>
		</div>
		<!-- Popup body. -->
		<div class="mwb_ubo_skin_popup_content">
			<div class="mwb_ubo_skin_popup_ques">
				<h5><?php esc_html_e( 'Do you really want to change template layout ?', 'upsell-order-bump-offer-for-woocommerce-pro' ); ?></h5>
				<p><?php esc_html_e( 'Changing layout will reset Design settings back to default.', 'upsell-order-bump-offer-for-woocommerce-pro' ); ?></p>
			</div>
			<div class="mwb_ubo_skin_popup_option">
				<!-- Yes button. -->
				<a href="javascript:void(0);" class="mwb_ubo_template_layout_yes"><?php esc_html_e( 'Yes', 'upsell-order-bump-offer-for-woocommerce-pro' ); ?></a>
				<!-- No button. -->
				<a href="javascript:void(0);" class="mwb_ubo_template_layout_no"><?php esc_html_e( 'No', 'upsell-order-bump-offer-for-woocommerce-pro' ); ?></a>
			</div>
		</div>
	</div>
</div>

<!-- Update required Popup -->
<div class="mwb_ubo_update_popup_wrapper">
	<div class="mwb_ubo_update_popup_inner">
		<!-- Popup icon -->
		<div class="mwb_ubo_update_popup_head">
			<?php if ( file_exists( UPSELL_ORDER_BUMP_OFFER_FOR_WOOCOMMERCE_DIR_PATH . 'admin/resources/icons/warning.png' ) ) : ?>
				<img src="<?php echo esc_url( UPSELL_ORDER_BUMP_OFFER_FOR_WOOCOMMERCE_URL . 'admin/resources/icons/warning.png' ); ?>">
				<?php else : ?>
				<img src="<?php echo esc_url( UPSELL_ORDER_BUMP_OFFER_FOR_WOOCOMMERCE_URL . 'admin/resources/Icons/warning.png' ); ?>">
			<?php endif; ?>
		</div>
		<!-- Popup body. -->
		<div class="mwb_ubo_update_popup_content">
			<div class="mwb_ubo_update_popup_ques">
				<h5><?php esc_html_e( 'Update Required!', 'upsell-order-bump-offer-for-woocommerce-pro' ); ?></h5>
				<p><?php esc_html_e( "Please Update 'Upsell Order Bump Offer for WooCommerce' to use this feature.", 'upsell-order-bump-offer-for-woocommerce-pro' ); ?></p>
			</div>
			<div class="mwb_ubo_update_popup_option">

				<!-- Update Button button. -->
				<a target="_blank" href="<?php echo esc_url( admin_url( 'plugin-install.php?s=Upsell+Order+Bump+Offer+for+WooCommerce+upselling+plugin&tab=search&type=term' ) ); ?>" class="mwb_ubo_update_yes"><?php esc_html_e( 'Update Now', 'upsell-order-bump-offer-for-woocommerce-pro' ); ?></a>
				<a href="javascript:void(0);" class="mwb_ubo_update_no"><?php esc_html_e( "Don't update", 'upsell-order-bump-offer-for-woocommerce-pro' ); ?></a>
			</div>
		</div>
	</div>
</div>