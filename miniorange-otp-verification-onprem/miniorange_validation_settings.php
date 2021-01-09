<?php
/**
 * Plugin Name: Email Verification / SMS verification / Mobile Verification
 * Plugin URI: http://miniorange.com
 * Description: Email & SMS OTP verification for all forms. Passwordless Login. SMS Notifications. Support for External Gateway Providers. Enterprise grade. Active Support
 * Version: 12.3.4
 * Author: miniOrange
 * Author URI: http://miniorange.com
 * Text Domain: miniorange-otp-verification
 * Domain Path: /lang
 * WC requires at least: 2.0.0
 * WC tested up to: 4.0
 * License: miniorange
 */


use OTP\MoOTP;
if (defined("\101\102\123\x50\101\x54\110")) {
    goto jN;
}
die;
jN:
define("\x4d\x4f\126\137\120\x4c\125\107\111\116\x5f\116\x41\115\x45", plugin_basename(__FILE__));
$Gi = substr(MOV_PLUGIN_NAME, 0, strpos(MOV_PLUGIN_NAME, "\57"));
define("\x4d\117\x56\137\116\101\x4d\105", $Gi);
include "\137\x61\x75\x74\x6f\154\157\x61\x64\56\x70\150\x70";
MoOTP::instance();
