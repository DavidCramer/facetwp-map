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
									'label'       => __( 'Google Maps API Key', 'facetwp' ),
									'description' => '<div style="text-align:right"><a href="https://developers.google.com/maps/documentation/javascript/get-api-key#get-an-api-key" target="_blank">Get an API key &raquo;</a></div>',
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
									'type'        => 'select',
									'value'       => 'page',
									'choices'     => array(
										'all'  => __( 'Show all results', 'facetwp' ),
										'page' => __( 'Show paginated results', 'facetwp' ),
									),
								),
							),
						),
						array(
							'size'    => 'col-sm-6',
							'control' => array(
								'group_markers' => array(
									'label'       => __( 'Group Markers?', 'facetwp' ),
									'description' => __( 'Enable marker clustering', 'facetwp' ),
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
		'label' => __( 'Data', 'facetwp' ),
		'grid'  => array(
			'id'  => 'source_grid',
			'row' => array(
				array(
					'column' => array(
						array(
							'size'    => 'col-sm-6',
							'control' => array(
								'source_type'  => array(
									'label'       => __( 'Source Field(s)', 'facetwp' ),
									'value'       => 'single',
									'type'        => 'select',
									'choices'     => array(
										'single' => __( 'Single, comma separated', 'facetwp' ),
										'split'  => __( 'Separate latitude and longitude fields', 'facetwp' ),
									),
								),
								'single_order' => array(
									'label'       => __( 'Coordinates Order ', 'facetwp' ),
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
									'description' => __( 'Custom field containing the coordinates', 'facetwp' ),
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
				'label'    => __( 'Select a Snazzy Map', 'facetwp' ),
				'type'     => 'template',
				'template' => FWP_MAP_PATH . 'includes/snazzy.php',
				'script'   => array(
					'handlebars' => FWP_MAP_URL . 'assets/js/handlebars-latest.min.js',
					'snazzy'     => FWP_MAP_URL . 'assets/js/snazzy.min.js',
				),
			),
			'styles' => array(
				'label'       => __( 'Map Style Code', 'facetwp' ),
				'description' => __( 'Manually add style code', 'facetwp' ),
				'type'        => 'textarea',
			),
		),
	),
	'marker'    => array(
		'label'   => __( 'Marker', 'facetwp' ),
		'control' => array(
			'content' => array(
				'label'       => __( 'Marker Content', 'facetwp' ),
				'type'        => 'textarea',
				'rows'        => 9,
				'value'       => '<div id="fwpm-infobox">' . "\r\n\t" . '<h1 class="fwpm-infobox-title"><?php the_title(); ?></h1>' . "\r\n\t" . '<div class="fwpm-infobox-content"><?php the_excerpt(); ?></div>' . "\r\n" . '</div>',
			),
		),
	),
);

return $settings;
