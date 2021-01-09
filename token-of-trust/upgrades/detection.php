<?php

require 'notice-first-activation.php';
require 'notice-no-key.php';
require 'ssl-not-configured.php';
require 'create-email-redirect-page.php';
require 'create-signup-required-page.php';

//delete_option('tot_activated');
//delete_option('tot_version');
//update_option('tot_version', '0.0.1', false);
//delete_option('tot-dismissed-first_activation');
//delete_option('tot-dismissed-no_key');

add_action( 'admin_init', 'tot_run_upgrades' );

function tot_upgrade_steps() {
	return array(
		'1.4.4'
	);
}

function tot_run_upgrades() {

	$option_name = 'tot_version';

	$previous_version   = get_option( $option_name );
	$tot_version        = tot_plugin_get_version();

	if( $previous_version === false ) {
		add_action( 'admin_notices', 'tot_notice_first_activation' );
		update_option( $option_name, '0.0.0', false );
		$previous_version = '0.0.0';
		tot_create_email_redirect_page();
	} else {
		tot_license_notice();
		tot_ssl_present_notice();
	}

	// Run these everytime we upgrade.
    tot_create_signup_required_page();
    tot_bp_setDefaultVals();
    tot_um_setDefaultVals();

	if(version_compare( $tot_version, $previous_version, '>' ) ) {
		$upgrade_steps = tot_upgrade_steps();

		foreach( $upgrade_steps as $version ) {
			if( version_compare( $version, $previous_version, '>=' ) ) {
                $path = 'scripts/' . preg_replace('/\./', '-', $version)  . '.php';
				include $path;
			}
		}
		update_option( $option_name, $tot_version, false );
	}
}

function tot_ssl_present_notice(){
    //adds notice to screen if SSL is not properly configured
    $ssl_configured = get_option('tot_ssl_misconfiguration');
    if( isset($ssl_configured) && ($ssl_configured === true) ) {
        $is_TOT_settings_page = strpos($_SERVER['REQUEST_URI'], 'totsettings');
        if (!$ssl_configured && $is_TOT_settings_page) {
            add_action('admin_notices', 'tot_ssl_not_configured_notice');
        }
    }
}

function tot_license_notice() {

	$has_dismissed_no_key = get_option( 'tot-dismissed-no_key' );

	if( ($has_dismissed_no_key === false) && !tot_license_is_added() ) {
		add_action( 'admin_notices', 'tot_notice_no_key' );
	}
}

function tot_license_is_added() {
	$options = get_option('tot_options');
	if( isset( $options ) ) {
		return !!(isset($options['tot_field_license_key']) && ($options['tot_field_license_key'] !== ''));
	}else {
		return false;
	}
}
