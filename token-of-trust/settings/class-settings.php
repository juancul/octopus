<?php
/**
 *
 * Settings
 *
 */

namespace TOT;

// TODO - temporary fix for early loading.
function get_query_var( $var, $default = '' ) {
    global $wp_query;
    if( ! isset( $wp_query ) || ! method_exists( $wp_query, 'get' ) ) return $default;
    return $wp_query->get( $var, $default );
}

class Settings {

	public static $key = 'tot_options';
    public static $prefix = 'tot_field_';

	private function __construct() {}

	public static function get_setting($key) {
        // Add prefix if it's not present (to maintain back compatibility).
        $prefixPos = strpos($key, self::$prefix);
        if ($prefixPos !== 0) {
            $key = self::$prefix . $key;
        }

        $options = get_option(self::$key);

        $cookie = self::get_param_or_cookie($key);

        if( isset($key) && $options && isset($options) && array_key_exists($key, $options)) {
            $option = $options[$key];
            $result = $cookie ? $cookie : $option;
			return $result;
		} else {
			return $cookie;
		}
	}

    /**
     * Strips 'tot_field_' off if present and looks for a query param and cookie of the given name.
     *
     * @param $key
     * @return object
     */
    public static function get_param_or_cookie($key) {
        $prefixPos = strpos($key, self::$prefix);
        if ($prefixPos === 0) {
            // Strip prefix so cookie names are consistent with variable names.
            $key = substr($key, strlen(self::$prefix));
        }
        $query_var = get_query_var($key, NULL);
        $cookie = isset($_COOKIE[$key]) ? $_COOKIE[$key] : NULL;
        $result = isset($query_var) ? $query_var : $cookie;
        return $result;
    }



    public static function set_setting($key, $value) {

		$options = get_option(self::$key);

		if(!isset($options) || !is_array($options)) {
			$options = array();
		}

		$options[$key] = $value;
		update_option('tot_options', $options);

	}

}