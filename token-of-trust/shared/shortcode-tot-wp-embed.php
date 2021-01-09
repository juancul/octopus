<?php

add_shortcode( 'tot-wp-embed', 'tot_wp_embed_shortcode' );

function tot_wp_embed_shortcode( $attrs, $content = null ) {

	// normalize attribute keys, lowercase
	$attrs = array_change_key_case( $attrs, CASE_LOWER );

	$settings = shortcode_atts(
		array(
			'tot-widget'                 => 'reputationSummary',
			'wp-userid'                  => get_current_user_id(),
			'show-pending'               => 'false',
			'tot-show-when-not-verified' => 'false',
			'tot-transaction-id'         => '',
			'show-admin-buttons'         => 'false',
			'verification-model'         => null,
			'wp-reported-userid'         => null,
			'app-custom-1'               => null,
			'tot-override-status'        => null,
		),
		$attrs
	);

	if ( ! isset( $settings['app-userid'] ) ) {
		$settings['app-userid'] = tot_user_id( $settings['wp-userid'] );
	}
	if ( ! tot_get_option( 'tot_field_approval' ) ) {
		$settings['tot-override-status'] = '';
	} elseif ( ! isset( $settings['tot-override-status'] ) ) {
		$settings['tot-override-status'] = tot_get_user_approval_status( $settings['wp-userid'] );
	}

	$addl_settings = '';
	if ( 'accountConnector' === $settings['tot-widget'] ) {
		$access_token   = tot_set_connection( $settings['wp-userid'] );
		$addl_settings .= ' data-tot-override-status="' . $settings['tot-override-status'] . '"';
		$addl_settings .= ' data-app-userid="' . $settings['app-userid'] . '"';
		if( $settings['verification-model'] ) {
			$addl_settings .=  ' data-tot-verification-model="' . $settings['verification-model'] . '"';
		}
		if ( is_wp_error( $access_token ) ) {
			tot_display_error( $access_token );
		} else {
			$addl_settings .= ' data-tot-access-token="' . $access_token . '"';
		}
	} elseif ( 'verifiedIndicator' === $settings['tot-widget'] ) {

		$addl_settings .= ' data-tot-show-when-not-verified="' . $settings['tot-show-when-not-verified'] . '"';
		$addl_settings .= ' data-tot-show-pending="' . $settings['show-pending'] . '"';
		$addl_settings .= ' data-app-userid="' . $settings['app-userid'] . '"';
		$addl_settings .= ' data-tot-override-status="' . $settings['tot-override-status'] . '"';
		if ( 'true' === $settings['show-admin-buttons'] ) {
			$addl_settings .= ' data-tot-show-admin-buttons="' . $settings['show-admin-buttons'] . '"';
		}

	} elseif ( 'reportAbuse' === $settings['tot-widget'] ) {

		$settings['reported-userid'] = isset( $settings['wp-reported-userid'] ) ? tot_user_id( $settings['wp-reported-userid'] ) : '';

		$addl_settings .= ' data-app-userid="' . $settings['reported-userid'] . '"';
		$addl_settings .= ' data-app-reporter-userid="' . $settings['app-userid'] . '"';
		$app_custom_1   = $settings['app-custom-1'];

		if ( ! isset( $app_custom_1 ) ) {
			$reporter_wp_id = isset( $settings['wp-userid'] ) ? $settings['wp-userid'] : 'blank';
			$reportee_wp_id = isset( $settings['wp-reported-userid'] ) ? $settings['wp-reported-userid'] : 'blank';
			$app_custom_1   = 'Reporter WordPress user id ' . $reporter_wp_id . ' and reportee WordPress user id ' . $reportee_wp_id . '.';
		}
		$addl_settings .= ' data-app-custom-1="' . $app_custom_1 . '"';

	} elseif ( 'reputationSummary' === $settings['tot-widget'] ) {

		$addl_settings .= ' data-app-userid="' . $settings['app-userid'] . '"';
		$addl_settings .= ' data-tot-override-status="' . $settings['tot-override-status'] . '"';

		if ( '' !== $settings['tot-transaction-id'] ) {
			$addl_settings .= ' data-app-transaction-id="' . $settings['tot-transaction-id'] . '"';
		}
		if ( 'true' === $settings['show-admin-buttons'] ) {
			$addl_settings .= ' data-tot-show-admin-buttons="' . $settings['show-admin-buttons'] . '"';
		}
	} else {
		$addl_settings .= ' data-app-userid="' . $settings['app-userid'] . '"';
		$addl_settings .= ' data-tot-override-status="' . $settings['tot-override-status'] . '"';
	}

	return '<div'
	. ' data-tot-widget="' . $settings['tot-widget'] . '"'
	. $addl_settings
	. '></div>';
}
