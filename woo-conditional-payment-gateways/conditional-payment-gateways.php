<?php

/*
  Plugin Name: WooCommerce Conditional Payment Methods
  Plugin URI: https://wpsuperadmins.com/plugins/woocommerce-conditional-payment-gateways/?utm_source=wp-admin&utm_campaign=plugins-list&utm_medium=web
  Description: Enable/disable payment gateways based on cart conditions
  Version: 1.10.0
  WC requires at least: 3.0
  WC tested up to: 4.9
  Author: WP Super Admins
  Author URI: https://wpsuperadmins.com/?utm_source=wp-admin&utm_campaign=plugins-list&utm_medium=web&utm_term=conditional-payment-gateways
    */


if (!defined('WCCPG_MAIN_FILE')) {
	define('WCCPG_MAIN_FILE', __FILE__);
}
if (!defined('WCCPG_DIST_DIR')) {
	define('WCCPG_DIST_DIR', __DIR__);
}
if (!defined('WCCPG_TEXTDOMAIN')) {
	define('WCCPG_TEXTDOMAIN', 'wc_conditional_payment_gateways');
}

require_once WCCPG_DIST_DIR . '/vendor/vg-plugin-sdk/index.php';
require_once WCCPG_DIST_DIR . '/inc/freemius-init.php';

if (!class_exists('WC_Conditional_Payment_Gateways_Dist')) {

	class WC_Conditional_Payment_Gateways_Dist {

		static private $instance = false;
		static $dir = __DIR__;
		static $version = '1.10.0';
		static $name = 'Conditional Payment Methods';
		var $args = null;
		var $vg_plugin_sdk = null;

		private function __construct() {
			
		}

		/**
		 * Creates or returns an instance of this class.
		 */
		static function get_instance() {
			if (null == WC_Conditional_Payment_Gateways_Dist::$instance) {
				WC_Conditional_Payment_Gateways_Dist::$instance = new WC_Conditional_Payment_Gateways_Dist();
				WC_Conditional_Payment_Gateways_Dist::$instance->init();
			}
			return WC_Conditional_Payment_Gateways_Dist::$instance;
		}

		function init() {


			$this->args = array(
				'main_plugin_file' => __FILE__,
				'show_welcome_page' => true,
				'welcome_page_file' => WC_Conditional_Payment_Gateways_Dist::$dir . '/views/welcome-page-content.php',
				'welcome_page_url' => admin_url('admin.php?page=wp_cpg_settings_menu'),
				'plugin_name' => WC_Conditional_Payment_Gateways_Dist::$name,
				'plugin_prefix' => 'wccpg_',
				'plugin_version' => WC_Conditional_Payment_Gateways_Dist::$version,
				'plugin_options' => get_option('wp_cpg_enable_conditional_payment_gateways', false),
				'buy_url' => wccpg_fs()->checkout_url(WP_FS__PERIOD_ANNUALLY, true),
				'buy_text' => __('Try premium plugin for FREE - 7 Days'),
				'can_use_premium_code' => wccpg_fs()->can_use_premium_code__premium_only()
			);

			$this->vg_plugin_sdk = new VG_Freemium_Plugin_SDK($this->args);

			$modules = $this->get_modules_list();

			if (empty($modules)) {
				return;
			}

			// Load all modules
			foreach ($modules as $module) {
				$path = ( file_exists(__DIR__ . "/modules/$module/$module.php")) ? __DIR__ . "/modules/$module/$module.php" : __DIR__ . "/modules/$module/index.php";

				if (file_exists($path)) {
					require $path;
				}
			}

			$rotate_gateways_path = __DIR__ . '/inc/rotate-gateways/rotate-payment-methods.php';
			if (file_exists($rotate_gateways_path)) {
				require_once $rotate_gateways_path;
			}

			add_action('plugins_loaded', array($this, 'late_init'));
		}

		function late_init() {

			$inc_files = array_merge(glob(__DIR__ . '/inc/*'), glob(__DIR__ . '/backend/*'));
			foreach ($inc_files as $inc_file) {
				if (!is_file($inc_file)) {
					continue;
				}

				require_once $inc_file;
			}

			load_plugin_textdomain(WCCPG_TEXTDOMAIN, false, basename(dirname(__FILE__)) . '/lang');
		}

		/**
		 * Get all modules in the folder
		 * @return array
		 */
		function get_modules_list() {
			$directories = glob(__DIR__ . '/modules/*', GLOB_ONLYDIR);

			if (!empty($directories)) {
				$directories = array_map('basename', $directories);
			}
			return $directories;
		}

		function __set($name, $value) {
			$this->$name = $value;
		}

		function __get($name) {
			return $this->$name;
		}

	}

}

if (!function_exists('WCCPG')) {

	function WCCPG() {
		return WC_Conditional_Payment_Gateways_Dist::get_instance();
	}

}
WCCPG();
