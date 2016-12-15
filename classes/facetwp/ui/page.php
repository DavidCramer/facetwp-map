<?php
/**
 * fwp_map Pages
 *
 * @package   ui
 * @author    David Cramer
 * @license   GPL-2.0+
 * @link
 * @copyright 2016 David Cramer
 */
namespace facetwp\ui;

/**
 * fwp_map Page class for creating admin/settings pages.
 * @package facetwp\ui
 * @author  David Cramer
 */
class page extends box implements \facetwp\data\save {

	/**
	 * The type of object
	 *
	 * @since 1.0.0
	 * @access public
	 * @var      string
	 */
	public $type = 'page';

	/**
	 * Holds the option screen prefix
	 *
	 * @since 1.0.0
	 * @access public
	 * @var      array
	 */
	public $screen_hook_suffix = array();

	/**
	 * Define core page styles
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function set_assets() {

		$this->assets['style']['page'] = $this->url . 'assets/css/page' . fwp_map_ASSET_DEBUG . '.css';

		parent::set_assets();
	}

	/**
	 * Sets the wrappers attributes
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function set_attributes() {

		parent::set_attributes();

		$this->attributes['class'] .= ' wrap';

		if ( empty( $this->struct['full_width'] ) ) {
			$this->attributes['class'] .= ' facetwp-half-page';
		}

		if ( ! empty( $this->struct['attributes'] ) ) {
			$this->attributes = array_merge( $this->attributes, $this->struct['attributes'] );
		}

	}

	/**
	 * get a fwp_map config store key
	 * @since 1.0.0
	 * @access public
	 * @return string $store_key the defiuned option name for this fwp_map object
	 */
	public function store_key() {

		if ( ! empty( $this->struct['store_key'] ) ) {
			$store_key = $this->struct['store_key'];
		} else {
			$store_key = 'facetwp-' . $this->type . '-' . sanitize_text_field( $this->slug );
		}

		return $store_key;
	}

	/**
	 * Determin if a page is to be loaded and set it active
	 * @since 1.0.0
	 * @access public
	 */
	public function is_active() {
		if ( ! is_admin() ) {
			return false;
		}

		// check that the screen object is valid to be safe.
		$screen = get_current_screen();

		return $screen->base === $this->screen_hook_suffix;

	}

	/**
	 * Add the settings page
	 *
	 * @since 1.0.0
	 * @access public
	 * @uses "admin_menu" hook
	 */
	public function add_settings_page() {

		$this->screen_hook_suffix = add_menu_page(
			$this->struct['args']['page_title'],
			$this->struct['args']['menu_title'],
			$this->struct['args']['capability'],
			$this->slug,
			array( $this, 'create_page' ),
			$this->struct['args']['icon'],
			$this->struct['args']['position']
		);

	}

	/**
	 * Add the sub settings page
	 *
	 * @since 1.0.0
	 * @access public
	 * @uses "admin_menu" hook
	 */
	public function add_sub_page() {

		$this->screen_hook_suffix = add_submenu_page(
			$this->struct['args']['parent'],
			$this->struct['args']['page_title'],
			$this->struct['args']['menu_title'],
			$this->struct['args']['capability'],
			$this->slug,
			array( $this, 'create_page' )
		);

	}

	/**
	 * create the admin page
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function create_page() {
		echo $this->render();
	}

	/**
	 * setup actions and hooks to add settings pate and save settings
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function actions() {
		// run parent actions ( keep 'admin_head' hook )
		parent::actions();

		if ( empty( $this->struct['page_title'] ) || empty( $this->struct['menu_title'] ) ) {
			return;
		}

		$this->setup_pages();

	}

	/**
	 * Adds settings page to admin
	 *
	 * @since 1.0.0
	 * @access private
	 */
	private function setup_pages() {

		$args                 = array(
			'capability' => 'manage_options',
			'icon'       => null,
			'position'   => null,
		);
		$this->struct['args'] = array_merge( $args, $this->struct );

		if ( ! isset( $this->struct['parent'] ) ) {
			add_action( 'admin_menu', array( $this, 'add_settings_page' ), 9 );
		} else {
			add_action( 'admin_menu', array( $this, 'add_sub_page' ), 9 );
		}

	}

	/**
	 * Enqueues specific tabs assets for the active pages
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function set_active_styles() {

		$styles = '<style type="text/css">';

		$styles .= '.facetwp-page #panel-' . $this->id() . ' > .facetwp-panel-tabs > li[aria-selected="true"] a {box-shadow: 0 -3px 0 ' . $this->base_color() . ' inset;}';
		$styles .= '.facetwp-page #panel-' . $this->id() . '.facetwp-top-tabs > .facetwp-panel-tabs > li[aria-selected="true"] a {box-shadow: 0 3px 0 ' . $this->base_color() . ' inset;}';

		$styles .= '.contextual-help-tabs .active {border-left: 6px solid ' . $this->base_color() . ' !important;}';
		$styles .= '#' . $this->id() . '.facetwp-page h1{box-shadow: 0 0 2px rgba(0, 2, 0, 0.1),11px 0 0 ' . $this->base_color() . ' inset;}';
		$styles .= '#' . $this->id() . '.facetwp-page .page-title-action:hover{background: ' . $this->base_color() . ';border-color: rgba(0,0,0,0.1);}';
		$styles .= '#' . $this->id() . '.facetwp-page .page-title-action:focus{box-shadow: 0 0 2px ' . $this->base_color() . ';border-color: ' . $this->base_color() . ';}';

		if ( $this->child_count() > 1 ) {
			$styles .= '#' . $this->id() . '.facetwp-page h1{ box-shadow: 0 0px 13px 12px ' . $this->base_color() . ', 11px 0 0 ' . $this->base_color() . ' inset;}';
		}

		facetwp_share()->set_active_styles( $styles );

	}

}
