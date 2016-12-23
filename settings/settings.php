<?php

/**
 * FWP_Map Settings config
 *
 * @package   facetwp_map
 * @author    David Cramer
 * @license   GPL-2.0+
 * @link
 * @copyright 2016 David Cramer
 */

$settings = array(
	'map'       => array(
		'label' => __( 'Setup', 'facetwp' ),
		'grid'  => array(
			'id'  => 'map_grid',
			'row' => array(
				array(
					'column' => array(
						array(
							'size'    => 'col-sm-6',
							'control' => array(
								'api_key' => array(
									'label'       => __( 'API Key', 'facetwp' ),
									'description' => __( 'Google Maps API Key.', 'facetwp' ),
									'type'        => 'text',
									'value'       => defined( 'GMAPS_API_KEY' ) ? GMAPS_API_KEY : '',
									'attributes'  => defined( 'GMAPS_API_KEY' ) ? array( 'disabled' => true ) : array(),
								),
							),
						),
						array(
							'size'    => 'col-sm-6',
							'control' => array(
								'height' => array(
									'label'       => __( 'Map Height', 'facetwp' ),
									'description' => __( 'Set the height of the map.', 'facetwp' ),
									'type'        => 'number',
									'value'       => 400,
								),
							),
						),
					),
				),
				array(
					'column' => array(
						array(
							'size'    => 'col-sm-6',
							'control' => array(
								'result_count' => array(
									'label'       => __( 'Result Count', 'facetwp' ),
									'description' => __( 'Set how many results are displayed on the map.', 'facetwp' ),
									'type'        => 'select',
									'value'       => 'page',
									'choices'     => array(
										'all'  => __( 'Display All results. No pagination', 'facetwp' ),
										'page' => __( 'Adapt to templates pagination and results count.', 'facetwp' ),
									),
								),
							),
						),
						array(
							'size'    => 'col-sm-6',
							'control' => array(
								'group_markers' => array(
									'label'       => __( 'Group Markers', 'facetwp' ),
									'description' => __( 'Enable Marker grouping when zoomed out.', 'facetwp' ),
									'type'        => 'toggle',
								),
							),
						),
					),
				),
			),
		),
	),
	'source'    => array(
		'label' => __( 'Data Sources', 'facetwp' ),
		'grid'  => array(
			'id'  => 'source_grid',
			'row' => array(
				array(
					'column' => array(
						array(
							'size'    => 'col-sm-6',
							'control' => array(
								'source_type'  => array(
									'label'       => __( 'Source Type', 'facetwp' ),
									'description' => __( 'Select the type of coordinates source.', 'facetwp' ),
									'value'       => 'single',
									'type'        => 'select',
									'choices'     => array(
										'single' => __( 'Single, comma separated', 'facetwp' ),
										'split'  => __( 'Separate latitude and longitude fields', 'facetwp' ),
									),
								),
								'single_order' => array(
									'label'       => __( 'Coordinates Order ', 'facetwp' ),
									'description' => __( 'Set the order of the comma separation', 'facetwp' ),
									'value'       => 'type',
									'type'        => 'select',
									'value'       => 'lat_lng',
									'choices'     => array(
										'lat_lng' => __( 'latitude, longitude', 'facetwp' ),
										'lng_lat' => __( 'longitude, latitude', 'facetwp' ),
									),
								),
							),
						),
						array(
							'size'    => 'col-sm-6',
							'control' => array(
								'location_field' => array(
									'label'       => __( 'Location Field', 'facetwp' ),
									'description' => __( 'Custom Field slug that contains the coordinates.', 'facetwp' ),
									'value'       => 'location',
									'type'        => 'template',
									'template'    => FWP_MAP_PATH . 'includes/location-selector.php',
									'style'       => array(
										'fselect' => FACETWP_URL . '/assets/js/fSelect/fSelect.css',
									),
									'script'      => array(
										'fselect' => FACETWP_URL . '/assets/js/fSelect/fSelect.js',
									),
								),
							),
						),
					),
				),
			),
		),
	),
	'map_style' => array(
		'label'   => __( 'Map', 'facetwp' ),
		'control' => array(
			'snazzy' => array(
				'label'    => __( 'Select A Snazzy Map', 'facetwp' ),
				'type'     => 'template',
				'template' => FWP_MAP_PATH . 'includes/snazzy.php',
				'script'   => array(
					'handlebars' => FWP_MAP_URL . 'assets/js/handlebars-latest.min.js',
					'snazzy'     => FWP_MAP_URL . 'assets/js/snazzy.min.js',
				),
			),
			'styles' => array(
				'label'       => __( 'Map Style Code', 'facetwp' ),
				'description' => __( 'Manually Add style code.', 'facetwp' ),
				'type'        => 'textarea',
			),
		),
	),
	'marker'    => array(
		'label'   => __( 'Marker', 'facetwp' ),
		'control' => array(
			'content' => array(
				'label'       => __( 'Marker Content', 'facetwp' ),
				'description' => __( 'Add contnet to display on the marker click.', 'facetwp' ),
				'type'        => 'textarea',
				'rows'        => 9,
				'value'       => '<div id="fwpm-infobox">' . "\r\n\t" . '<h1 class="fwpm-infobox-title"><?php the_title(); ?></h1>' . "\r\n\t" . '<div class="facetwp-infobox-content"><?php the_excerpt(); ?></div>' . "\r\n" . '</div>',
			),
		),
	),
);

return $settings;
