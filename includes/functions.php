<?php
/**
 * fwp_map Helper Functions
 *
 * @package   facetwp
 * @author    David Cramer
 * @license   GPL-2.0+
 * @copyright 2016 David Cramer
 */


/**
 * fwp_map Object class autoloader.
 * It locates and finds class via classes folder structure.
 *
 * @since 1.0.0
 *
 * @param string $class class name to be checked and autoloaded
 */
function facetwp_autoload_class( $class ) {
	$parts = explode( '\\', $class );
	$name  = array_shift( $parts );
	if ( file_exists( fwp_map_PATH . 'classes/' . $name ) ) {
		if ( ! empty( $parts ) ) {
			$name .= '/' . implode( '/', $parts );
		}
		$class_file = fwp_map_PATH . 'classes/' . $name . '.php';
		if ( file_exists( $class_file ) ) {
			include_once $class_file;
		}
	}
}

/**
 * fwp_map Helper to minipulate the overall UI instance.
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
	return \facetwp\ui::get_instance( $request_data );
}

/**
 * fwp_map Helper to minipulate the overall UI instance.
 *
 * @since 1.0.0
 */
function facetwp_share() {
	// init UI
	return \facetwp\share\share::get_instance();
}

