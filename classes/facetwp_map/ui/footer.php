<?php
/**
 * FWP_MAP Footer
 *
 * @package   ui
 * @author    David Cramer
 * @license   GPL-2.0+
 * @link
 * @copyright 2016 David Cramer
 */
namespace facetwp_map\ui;

/**
 * Footer type used for creating footer based sections. Mainly used in modals and pages
 *
 * @package facetwp_map\ui
 * @author  David Cramer
 */
class footer extends section {

    /**
     * The type of object
     *
     * @since 1.0.0
     * @access public
     * @var      string
     */
    public $type = 'footer';


    /**
     * Render the Control
     *
     * @since 1.0.0
     * @see \facetwp_map\ui\facetwp_map
     * @access public
     * @return string HTML of rendered box
     */
    public function render() {

        $output = $this->render_template();
        if ( ! empty( $this->child ) ) {
            $output .= $this->render_children();
        }

        return $output;
    }

}
