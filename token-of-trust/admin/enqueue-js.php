<?php

add_action( 'admin_enqueue_scripts', 'tot_load_wp_admin_scripts' );

function tot_load_wp_admin_scripts() {
	wp_enqueue_script( 'admin-token-of-trust', plugins_url( '/token-of-trust.js', __FILE__ ) );
}