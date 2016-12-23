<?php
/*
 * Plugin Name: FacetWP - Map
 * Plugin URI: 
 * Description: Generates a map alongside FacetWP results
 * Version: 1.0
 * Author: David Cramer
 * Author URI: 
 * Text Domain: facetwp
 * License: GPL2+
*/

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

// Constants
define( 'FWP_MAP_PATH', plugin_dir_path( __FILE__ ) );
define( 'FWP_MAP_CORE', __FILE__ );
define( 'FWP_MAP_URL', plugin_dir_url( __FILE__ ) );
define( 'FWP_MAP_VER', '1.0.0' );

if ( ! version_compare( PHP_VERSION, '5.3.0', '>=' ) ) {
	if ( is_admin() ) {
		global $fwpm_message;
		$fwpm_message = __( 'FacetWP Map requires PHP version 5.3 or later. We strongly recommend PHP 5.5 or later for security and performance reasons.', 'facetwp' );
		add_action( 'admin_notices', 'fwp_map_php_ver' );
	}
} else {
	//Includes and run
	include_once FWP_MAP_PATH . 'facetwp_map-bootstrap.php';
	include_once FWP_MAP_PATH . 'classes/fwp_map.php';
}

function fwp_map_php_ver() {
	global $fwpm_message;
	echo '<div id="fwp_map_error" class="error notice notice-error"><p>' . $fwpm_message . '</p></div>';

}