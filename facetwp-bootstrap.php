<?php
/**
 * fwp_map Bootstrapper
 *
 * @package   facetwp
 * @author    David Cramer
 * @license   GPL-2.0+
 * @link
 * @copyright 2016 David Cramer
 *
 */
// If this file is called directly, abort.
if ( defined( 'WPINC' ) ) {

	if ( ! defined( 'fwp_map_CORE' ) ) {
		define( 'fwp_map_CORE', __FILE__ );
		define( 'fwp_map_PATH', plugin_dir_path( __FILE__ ) );
		define( 'fwp_map_URL', plugin_dir_url( __FILE__ ) );
		define( 'fwp_map_VER', '1.0.0' );
	}
	if ( ! defined( 'fwp_map_ASSET_DEBUG' ) ) {
		if ( ! defined( 'DEBUG_SCRIPTS' ) ) {
			define( 'fwp_map_ASSET_DEBUG', '.min' );
		} else {
			define( 'fwp_map_ASSET_DEBUG', '' );
		}
	}


	// include facetwp helper functions and autoloader.
	require_once( fwp_map_PATH . 'includes/functions.php' );

	// register facetwp autoloader
	spl_autoload_register( 'facetwp_autoload_class', true, false );

	// bootstrap plugin load
	add_action( 'plugins_loaded', 'facetwp' );

}
