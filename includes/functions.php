<?php
/**
 * FWP_MAP Helper Functions
 *
 * @package   facetwp_map
 * @author    David Cramer
 * @license   GPL-2.0+
 * @copyright 2016 David Cramer
 */


/**
 * FWP_MAP Object class autoloader.
 * It locates and finds class via classes folder structure.
 *
 * @since 1.0.0
 *
 * @param string $class class name to be checked and autoloaded
 */
function facetwp_map_autoload_class( $class ) {
	$parts = explode( '\\', $class );
	$name  = array_shift( $parts );
	if ( file_exists( FWP_MAP_PATH . 'classes/' . $name ) ) {
		if ( ! empty( $parts ) ) {
			$name .= '/' . implode( '/', $parts );
		}
		$class_file = FWP_MAP_PATH . 'classes/' . $name . '.php';
		if ( file_exists( $class_file ) ) {
			include_once $class_file;
		}
	}
}

/**
 * FWP_MAP Helper to minipulate the overall UI instance.
 *
 * @since 1.0.0
 */
function facetwp_map() {
	$request_data = array(
		'post'    => $_POST,
		'get'     => $_GET,
		'files'   => $_FILES,
		'request' => $_REQUEST,
		'server'  => $_SERVER,
	);

	// init UI
	return \facetwp_map\ui::get_instance( $request_data );
}

/**
 * FWP_MAP Helper to minipulate the overall UI instance.
 *
 * @since 1.0.0
 */
function facetwp_map_share() {
	// init UI
	return \facetwp_map\share\share::get_instance();
}

