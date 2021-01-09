<?php

function tot_add_settings_link( $links ) {

	return array_merge(

		array(
			'<a href="' . admin_url( 'options-general.php?page=totsettings' ) . '">' . __( 'General Settings', 'token-of-trust') . '</a>'
		), $links
	);

	return $links;
}

add_filter( 'plugin_action_links_' . $tot_plugin_slug, 'tot_add_settings_link' );