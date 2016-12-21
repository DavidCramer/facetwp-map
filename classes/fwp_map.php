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
			$height = isset( $atts['height'] ) ? $atts['height'] : 400;
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
	 * Render location data
	 *
	 * @since 1.0.0
	 *
	 */
	public function locations_data( $return, $params ) {

		$post_ids                  = $this->ids();
		$data                      = $this->admin_page->load_data();
		$return['settings']['map'] = array(
			'config'    => $data,
			'locations' => array(),
		);
		foreach ( $post_ids as $post_id ) {
			$location = $this->location( $post_id );
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

		if ( ! empty( $data['general']['result_count'] ) && 'all' == $data['general']['result_count'] && empty( $params['used_facets'] ) ) {
			$post_ids = $facets->query_args['post__in'];
		} else {
			// normals
			$post_ids = wp_list_pluck( $facets->query->get_posts(), 'ID' );
		}

		return $post_ids;
	}

	/**
	 * check if has valid location
	 *
	 * @since 1.0.0
	 *
	 */
	private function location( $post_id ) {
		$data   = $this->admin_page->load_data();
		$location = get_post_meta( $post_id, $data['general']['location_field'], true );
		// has field
		if ( empty( $location ) ) {
			return false;
		}
		// is format correct
		$location = explode( ',', $location );
		if ( ! isset( $location[1] ) ) {
			return false;
		}
		if ( 0 === floatval( trim( $location[0] ) ) || 0 === floatval( trim( $location[1] ) ) ) {
			return false;
		}

		return array(
			'lat' => floatval( trim( $location['0'] ) ),
			'lng' => floatval( trim( $location['1'] ) ),
		);
	}

	/**
	 * Get the content for a post
	 *
	 * @since 1.0.0
	 *
	 */
	private function get_content( $post_id ) {
		$content = '<div id="fwpm-infobox"><h1 class="fwpm-infobox-title">' . get_the_title( $post_id ) . '</h1><div class="facetwp-infobox-content">' . get_the_excerpt( $post_id ) . '</div></div>';

		return apply_filters( 'facetwp-map-infobox-content', $content, $post_id );
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

		return apply_filters( 'facetwp-map-marker', $base, $post_id );
	}

	/**
	 * add map assets to front display
	 *
	 * @since 1.0.0
	 *
	 */
	public function assets( $assets ) {

		$data = $this->admin_page->load_data();
		if ( isset( $assets['gmaps'] ) ) {
			$api_key         = $data['general']['api_key'];
			$assets['gmaps'] = '//maps.googleapis.com/maps/api/js?libraries=places&key=' . $api_key;
		}
		// check for clustering
		if ( ! empty( $data['general']['group_markers'] ) ) {
			$assets['cluster-gmaps'] = '//developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js';
		}
		// add front styles
		$assets['fwpm-front.css'] = FWP_MAP_URL . 'assets/css/front.css';
		// add front js
		$assets['fwpm-front.js'] = FWP_MAP_URL . 'assets/js/front.js';

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

		$this->admin_page = facetwp_map()->add( 'page', 'fwp_map', $this->admin_core_page() );

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
			'section'    => array(
				'general' => include FWP_MAP_PATH . 'settings/general.php',
				//'display' => include FWP_MAP_PATH . 'settings/display.php',
			),
		);

		return $structure;
	}


}

// init
FWP_Map::init();
