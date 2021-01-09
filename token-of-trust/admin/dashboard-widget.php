<?php

add_action( 'wp_dashboard_setup', 'tot_add_dashboard_widgets' );

function tot_add_dashboard_widgets() {
	wp_add_dashboard_widget (
		'tot_dashboard',
		'Your Token of Trust profile',
		'tot_dashboard_cb'
	);
}

function tot_dashboard_cb () {
	echo do_shortcode('[tot-wp-embed tot-widget="accountConnector"][/tot-wp-embed]');
//	echo "<script>tot('modalOpen', 'accountConnector', {accessToken: '" . tot_set_connection() . "'});</script>";
}