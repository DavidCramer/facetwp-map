<?php
/**
 * FWP_MAP header
 *
 * @package   ui
 * @author    David Cramer
 * @license   GPL-2.0+
 * @link
 * @copyright 2016 David Cramer
 */
namespace facetwp_map\ui;

/**
 * A generic holder for multiple controls. this panel type does not handle saving, but forms part of the data object tree.
 *
 * @since 1.0.0
 * @see \facetwp_map\facetwp_map
 */
class header extends section {

    /**
     * The type of object
     *
     * @since 1.0.0
     * @access public
     * @var      string
     */
    public $type = 'header';

    /**
     * type of header element
     *
     * @since 1.0.0
     * @access public
     * @var      string
     */
    public $element = 'h1';

    /**
     * List of attributes to apply to the wrapper element
     *
     * @since 1.0.0
     * @access public
     * @var array
     */
    public $attributes = array( 'class' => 'facetwp_map-title' );

    /**
     * Set the element type
     *
     * @since 1.0.0
     * @access public
     */
    public function init() {
        if ( ! empty( $this->struct['element'] ) ) {
            $this->element = $this->struct['element'];
        }
    }


    /**
     * Render the complete section
     *
     * @since 1.0.0
     * @access public
     * @return string|null HTML of rendered notice
     */
    public function render() {

        $output = '<' . $this->element . ' ' . $this->build_attributes() . '>';

        $output .= $this->label();

        $output .= $this->description();

        $output .= $this->render_template();

        if ( ! empty( $this->child ) ) {
            $output .= $this->render_children();
        }

        $output .= '</' . $this->element . '>';

        return $output;
    }

    /**
     * Render the panels label
     *
     * @since 1.0.0
     * @access public
     * @return string|null rendered html of label
     */
    public function label() {
        $output = null;
        if ( ! empty( $this->struct['label'] ) ) {
            $output .= '<span class="facetwp_map-text">' . esc_html( $this->struct['label'] ) . '</span>';
        }

        return $output;
    }

    /**
     * Render the panels Description
     *
     * @since 1.0.0
     * @access public
     * @return string|null HTML of rendered description
     */
    public function description() {
        $output = null;
        if ( ! empty( $this->struct['description'] ) ) {
            $output .= ' <small>' . esc_html( $this->struct['description'] ) . '</small>';
        }

        return $output;
    }

    /**
     * checks if the current section is active
     *
     * @since 1.0.0
     * @access public
     */
    public function is_active() {
        return $this->parent->is_active();
    }

}
