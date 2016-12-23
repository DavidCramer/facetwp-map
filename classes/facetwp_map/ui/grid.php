<?php
/**
 * FWP_MAP Grid
 *
 * @package   ui
 * @author    David Cramer
 * @license   GPL-2.0+
 * @link
 * @copyright 2016 David Cramer
 */
namespace facetwp_map\ui;

/**
 * A Grid system for layout control
 *
 * @since 1.0.0
 * @see \facetwp_map\facetwp_map
 */
class grid extends section {

	/**
	 * The type of object
	 *
	 * @since 1.0.0
	 * @access public
	 * @var      string
	 */
	public $type = 'grid';

	/**
	 * List of attributes to apply to the wrapper element
	 *
	 * @since 1.0.0
	 * @access public
	 * @var array
	 */
	public $attributes = array( 'class' => 'facetwp_map-grid' );


	/**
	 * Set the grid params
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function setup() {

		if ( ! empty( $this->struct['row'] ) ) {
			$this->struct['grid'] = $this->struct['row'];
		}

		if ( ! empty( $this->struct['column'] ) ) {
			$this->struct['grid'] = $this->struct['column'];
		}

		parent::setup();

	}

	/**
	 * Get Data from all controls of this section
	 *
	 * @since 1.0.0
	 * @see \facetwp_map\load
	 * @return array|null Array of sections data structured by the controls
	 */
	public function get_data() {

		$data = $this->get_child_data();
		if ( empty( $data ) ) {
			$data = null;
		}

		return $data;
	}

	/**
	 * Sets the data for all children
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function set_data( $data ) {

		foreach ( $this->child as $child ) {
			if ( method_exists( $child, 'set_data' ) ) {
				$child->set_data( $data );
			}
		}
		$this->data = $data;

	}

	/**
	 * Get Data from all controls of this section
	 *
	 * @since 1.0.0
	 * @see \facetwp_map\load
	 * @return array Array of sections data structured by the controls
	 */
	public function is_row_column() {
		return ! empty( $this->struct['row'] ) || ! empty( $this->struct['column'] );
	}

	/**
	 * Sets the wrappers attributes
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function set_attributes() {

		if ( ! empty( $this->struct['column'] ) ) {
			$this->attributes['class'] = 'row';
		}

		if ( ! empty( $this->struct['size'] ) ) {
			$this->attributes['class'] = $this->struct['size'];
		}

		parent::set_attributes();
	}

	/**
	 * Render the complete section
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string|null HTML of rendered notice
	 */
	public function render() {

		$output = '<div ' . $this->build_attributes() . '>';
		$output .= $this->render_children();
		$output .= '</div>';

		return $output;
	}

}
