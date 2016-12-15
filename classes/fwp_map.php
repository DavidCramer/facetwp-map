<?php

/**
 * FWP_Map Main Class
 *
 * @package   facetwp_map
 * @author    David Cramer
 * @license   GPL-2.0+
 * @link
 * @copyright 2016 David Cramer
 */
class FWP_Map {

	/**
	 * Holds instance of the class
	 *
	 * @since   1.0.0
	 *
	 * @var     FWP_Map
	 */
	private static $instance;

	/**
	 * Holds the admin page object
	 *
	 * @since   1.0.0
	 *
	 * @var     \uix\ui\page
	 */
	private $admin_page;

	/**
	 * FWP_Map constructor.
	 */
	public function __construct() {

		// create admin objects
		add_action( 'plugins_loaded', array( $this, 'register_admin' ) );
		// setup notifications
		add_action( 'init', array( $this, 'setup' ) );
		// add required fields check
		add_action( 'uix_control_item_submit_config', array( $this, 'verify_config' ) );
	}

	/**
	 * Return an instance of this class.
	 *
	 * @since 1.0.0
	 *
	 * @return  FWP_Map  A single instance
	 */
	public static function init() {

		// If the single instance hasn't been set, set it now.
		if ( ! isset( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;

	}

	/**
	 * Verifies required fields are entered when adding an event notifier
	 *
	 * @since 1.0.0
	 *
	 */
	public function verify_config( $data ) {

		$message = array();
		// check if a hook is set.

		// remove empty
		$message = array_filter( $message );

		if ( ! empty( $message ) ) {
			wp_send_json_error( implode( '<br>', $message ) );
		}


	}

	/**
	 * Register the admin pages
	 *
	 * @since 1.0.0
	 */
	public function register_admin() {

		$this->admin_page = uix()->add( 'page', 'fwp_map', $this->admin_core_page() );

	}

	/**
	 * @return facetwp_map
	 *
	 * @since 1.0.0
	 */
	public function admin_core_page() {

		$structure = array(
			'page_title' => __( 'FacetWP Map', 'facetwp' ),
			'menu_title' => __( 'FacetWP Map', 'facetwp' ),
			'parent'     => 'options-general.php',
			'base_color' => '#906dbe',
			'attributes' => array(
				'data-autosave' => true,
			),
			'header'     => array(
				'id'          => 'admin_header',
				'label'       => __( 'FacetWP Map', 'facetwp' ),
				'description' => __( '1.0.0', 'facetwp' ),
				'control'     => array(
					array(
						'type' => 'separator',
					),
				),
			),
			'style'      => array(
				'admin' => FWP_MAP_URL . 'assets/css/admin.css',
			),
			'section'    => array(
				'general' => include FWP_MAP_PATH . 'settings/general.php',
				'display' => include FWP_MAP_PATH . 'settings/display.php',
			),
		);

		return $structure;
	}

	/**
	 * Setup hooks
	 *
	 * @since 1.0.0
	 */
	public function setup() {

		$data = $this->admin_page->load_data();
		// @todo - the setup logic.
	}

}

// init
FWP_Map::init();
