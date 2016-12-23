<?php
/**
 * FWP_MAP Bootstrapper
 *
 * @package   facetwp_map
 * @author    David Cramer
 * @license   GPL-2.0+
 * @link
 * @copyright 2016 David Cramer
 *
 */
// If this file is called directly, abort.
if ( defined( 'WPINC' ) ) {

    if ( ! defined( 'FWP_MAP_CORE' ) ) {
        define( 'FWP_MAP_CORE', __FILE__ );
        define( 'FWP_MAP_PATH', plugin_dir_path( __FILE__ ) );
        define( 'FWP_MAP_URL', plugin_dir_url( __FILE__ ) );
        define( 'FWP_MAP_VER', '1.0' );
    }
    if ( ! defined( 'FWP_MAP_ASSET_DEBUG' ) ) {
        if ( ! defined( 'DEBUG_SCRIPTS' ) ) {
            define( 'FWP_MAP_ASSET_DEBUG', '.min' );
        } else {
            define( 'FWP_MAP_ASSET_DEBUG', '' );
        }
    }


    // include facetwp_map helper functions and autoloader.
    require_once( FWP_MAP_PATH . 'includes/functions.php' );

    // register facetwp_map autoloader
    spl_autoload_register( 'facetwp_map_autoload_class', true, false );

    // bootstrap plugin load
    add_action( 'plugins_loaded', 'facetwp_map' );
}
