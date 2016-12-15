<?php
/**
 * fwp_map Control
 *
 * @package   controls
 * @author    David Cramer
 * @license   GPL-2.0+
 * @link
 * @copyright 2016 David Cramer
 */
namespace facetwp\ui\control;

/**
 * WordPress Content Editor
 *
 * @since 1.0.0
 */
class editor extends \facetwp\ui\control\textarea {

	/**
	 * The type of object
	 *
	 * @since       1.0.0
	 * @access public
	 * @var         string
	 */
	public $type = 'editor';

	/**
	 * Returns the main input field for rendering
	 *
	 * @since 1.0.0
	 * @see \facetwp\ui\facetwp
	 * @access public
	 */
	public function input() {

		$settings = array( 'textarea_name' => $this->name() );
		if ( ! empty( $this->struct['settings'] ) && is_array( $this->struct['settings'] ) ) {
			$settings = array_merge( $this->struct['settings'], $settings );
		}

		ob_start();

		wp_editor( $this->get_value(), 'control-' . $this->id(), $settings );

		return ob_get_clean();

	}

	/**
	 * Define core fwp_map scripts - override to register core ( common scripts for facetwp type )
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function set_assets() {

		// set scripts
		$this->assets['script']['editor-init']      = $this->url . 'assets/controls/editor/js/editor' . fwp_map_ASSET_DEBUG . '.js';

		parent::set_assets();
	}

}
