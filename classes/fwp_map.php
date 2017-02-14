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
     * @var     \facetwp_map\ui\page
     */
    private $admin_page;

    /**
     * Holds the ID's of the current run
     *
     * @since   1.0.0
     *
     * @var     array
     */
    private $ids = array();


    /**
     * FWP_Map constructor.
     */
    public function __construct() {

        // create admin objects
        add_action( 'plugins_loaded', array( $this, 'register_admin' ) );
        // add filter for facet template
        add_filter( 'facetwp_shortcode_html', array( $this, 'shortcode' ), 10, 2 );
        // add filter to get the ID's
        add_filter( 'facetwp_render_output', array( $this, 'locations_data' ), 10, 2 );
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
     * Render shortcode
     *
     * @since 1.0.0
     *
     */
    public function shortcode( $output, $atts ) {

        if ( isset( $atts['map'] ) ) {
            $map_config = $this->map_config();
            $height     = isset( $atts['height'] ) ? $atts['height'] : $map_config['height'];
            // add maps to facet assets
            add_filter( 'facetwp_assets', array( $this, 'assets' ) );
            ob_start();
            ?>
            <div id="facetwp-map" style="height:<?php echo esc_attr( $height ); ?>px;"></div>
            <?php
            $output .= ob_get_clean();
        }

        return $output;

    }

    /**
     * get general map config
     *
     * @since 1.0.0
     *
     */
    private function map_config() {
        $data = $this->admin_page->load_data();

        return apply_filters( 'facetwp_map_config_args', $data['map'] );
    }

    /**
     * Render location data
     *
     * @since 1.0.0
     *
     */
    public function locations_data( $return, $params ) {

        $post_ids = $this->ids();

        $return['settings']['map'] = array(
            'config'    => $this->map_config(),
            'init'      => $this->map_init(),
            'locations' => array(),
        );
        foreach ( $post_ids as $post_id ) {
            $location = $this->get_location( $post_id );
            if ( false === $location ) {
                continue;
            }
            $return['settings']['map']['locations'][] = $this->get_structure( $post_id, $location );
        }

        return $return;
    }

    /**
     * Get ids of current set
     *
     * @since 1.0.0
     *
     */
    private function ids() {
        $facets = FWP()->facet;
        $data   = $this->admin_page->load_data();

        if ( ! empty( $data['map']['result_count'] ) && 'all' == $data['map']['result_count'] && empty( $params['used_facets'] ) ) {
            $post_ids = $facets->query_args['post__in'];
        } else {
            // normals
            $post_ids = wp_list_pluck( $facets->query->get_posts(), 'ID' );
        }

        return $post_ids;
    }

    /**
     * get display/init map config
     *
     * @since 1.0.0
     *
     */
    private function map_init() {
        $data = $this->admin_page->load_data();
        // convert styles json
        $data['map_style']['styles'] = json_decode( $data['map_style']['styles'] );
	    // set zoom
	    if ( ! isset( $data['map']['zoom'] ) ) {
		    $data['map']['zoom'] = 14;
	    }
	    $data['map_style']['maxZoom'] = (int) $data['map']['zoom'];

        return apply_filters( 'facetwp_map_init_args', $data['map_style'] );
    }

    /**
     * check if has valid location
     *
     * @since 1.0.0
     *
     */
    private function get_location( $post_id ) {
        $data = $this->admin_page->load_data();

        switch ( $data['source']['source_type'] ) {
            case 'single';
                return $this->get_single_location( $post_id );
            case 'split';
                return $this->get_split_location( $post_id );
        }

        return false;
    }

    /**
     * build the single location
     *
     * @since 1.0.0
     *
     */
    private function get_single_location( $post_id ) {
        $data = $this->admin_page->load_data();

        if( substr( $data['source']['location_field']['single'], 0, 4 ) === 'acf/' && function_exists( 'get_field' ) ){
            $field = get_field( substr( $data['source']['location_field']['single'],4 ), $post_id );
            if( !empty( $field['address'] ) ){
                unset( $field['address'] );
                $location = implode(',', $field );
                $data['source']['single_order'] = 'lat_lng';
            }
        }else {
            $location = get_post_meta( $post_id, $this->unprefix_field( $data['source']['location_field']['single'] ), true );
        }
        // has field
        if ( empty( $location ) ) {
            return false;
        }
        // is format correct
        $location = explode( ',', trim( $location, '()' ) );
        if ( ! isset( $location[1] ) ) {
            return false;
        }
        // create parts
        $parts = array(
            floatval( trim( $location['0'] ) ),
            floatval( trim( $location['1'] ) ),
        );
        // no part can have a 0
        if ( in_array( 0, $parts ) ) {
            return false;
        }

        // check order
        switch ( $data['source']['single_order'] ) {
            case 'lat_lng';
                return array(
                    'lat' => $parts['0'],
                    'lng' => $parts['1'],
                );
            case 'lng_lat';
                return array(
                    'lat' => $parts['1'],
                    'lng' => $parts['0'],
                );
        }

        // nothing worked.
        return false;

    }

    /**
     * unprefix field source
     *
     * @since 1.0.0
     *
     */
    private function unprefix_field( $field ) {

        if ( 'cf/' == substr( $field, 0, 3 ) ) {
            $field = substr( $field, 3 );
        }

        // make support for more custom types

        return $field;
    }

    /**
     * construct the split location
     *
     * @since 1.0.0
     *
     */
    private function get_split_location( $post_id ) {
        $data = $this->admin_page->load_data();

        $lat = get_post_meta( $post_id, $this->unprefix_field( $data['source']['location_field']['lat'] ), true );
        $lng = get_post_meta( $post_id, $this->unprefix_field( $data['source']['location_field']['lng'] ), true );

        // filter maybe?
        return array(
            'lat' => floatval( $lat ),
            'lng' => floatval( $lng ),
        );
    }

    /**
     * get post marker structure
     *
     * @since 1.0.0
     *
     */
    public function get_structure( $post_id, $location ) {
        $base = array(
            'title'    => get_the_title( $post_id ),
            'content'  => $this->get_content( $post_id ),
            'position' => $location,
        );

        return apply_filters( 'facetwp_map_marker_args', $base, $post_id );
    }

    /**
     * Get the content for a post
     *
     * @since 1.0.0
     *
     */
    private function get_content( $post_id ) {
        $data = $this->admin_page->load_data();
        global $post;
        $main_post = $post;
        $post      = get_post( $post_id );
        ob_start();
        $code = preg_replace( "/\xC2\xA0/", ' ', $data['marker']['content'] );
        eval( '?>' . $code );
        $html = apply_filters( 'facetwp_map_marker_html', ob_get_clean(), $post );
        // reset to main post in case
        $post = $main_post;

        return $html;
    }

    /**
     * add map assets to front display
     *
     * @since 1.0.0
     *
     */
    public function assets( $assets ) {

        $data = $this->admin_page->load_data();
        if ( ! isset( $assets['gmaps'] ) ) {
            $api_key         = defined( 'GMAPS_API_KEY' ) ? GMAPS_API_KEY : $data['map']['api_key'];
            $assets['gmaps'] = '//maps.googleapis.com/maps/api/js?libraries=places&key=' . $api_key;
        }
        // check for clustering
        if ( ! empty( $data['map']['group_markers'] ) ) {
            $assets['markerclusterer.js'] = FWP_MAP_URL . 'assets/js/markerclusterer.js';
        }
        // add front styles
        $assets['fwpm-front.css'] = FWP_MAP_URL . 'assets/css/front.min.css';
        // add front js
        $assets['fwpm-front.js'] = FWP_MAP_URL . 'assets/js/front.min.js';

        return $assets;

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
        // check FacetWP is installed and activated.
        if ( ! defined( 'FACETWP_VERSION' ) ) {
            if ( is_admin() ) {
                global $fwpm_message;
                $fwpm_message = __( 'FacetWP Map requires that FacetWP be installed and activated.', 'facetwp' );
                add_action( 'admin_notices', 'fwp_map_php_ver' );
            }
        } else {
            $this->admin_page = facetwp_map()->add( 'page', 'fwp_map', $this->admin_core_page() );
        }

    }

    /**
     * @return facetwp_map
     *
     * @since 1.0.0
     */
    public function admin_core_page() {

        $structure = array(
            'page_title' => __( 'FacetWP - Map', 'facetwp' ),
            'menu_title' => __( 'FacetWP - Map', 'facetwp' ),
            'parent'     => 'options-general.php',
            'base_color' => '#906dbe',
            'attributes' => array(
                'data-autosave' => true,
            ),
            'header'     => array(
                'id'          => 'admin_header',
                'label'       => __( 'FacetWP - Map', 'facetwp' ),
                'description' => __( '1.0', 'facetwp' ),
                'control'     => array(
                    array(
                        'type' => 'separator',
                    ),
                ),
            ),
            'style'      => array(
                'admin' => FWP_MAP_URL . 'assets/css/admin.min.css',
            ),
            'section'    => include FWP_MAP_PATH . 'settings/settings.php',
        );

        return $structure;
    }

}

// init
FWP_Map::init();
