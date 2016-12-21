<?php

/**
 * FWP_Map General Settings
 *
 * @package   facetwp_map
 * @author    David Cramer
 * @license   GPL-2.0+
 * @link
 * @copyright 2016 David Cramer
 */

$settings = array(
	'label'       => __( 'General', 'facetwp' ),
	'description' => __( 'General Setup for FacetWP Map', 'facetwp' ),
	'control'     => array(
		'api_key'        => array(
			'label'       => __( 'API Key', 'facetwp' ),
			'description' => __( 'Google Maps API Key.', 'facetwp' ),
			'type'        => 'test',
			'value'       => defined( 'GMAPS_API_KEY' ) ? GMAPS_API_KEY : '',
		),
		'group_markers'  => array(
			'label'       => __( 'Group Markers', 'facetwp' ),
			'description' => __( 'Enable Marker grouping when zoomed out.', 'facetwp' ),
			'type'        => 'toggle',
		),
		'location_field' => array(
			'label'       => __( 'Location Field', 'facetwp' ),
			'description' => __( 'Custom Field slug that contains the location.', 'facetwp' ),
			'value'       => 'location',
			'type'        => 'text',
		),
		'result_count'   => array(
			'label'       => __( 'Result Count', 'facetwp' ),
			'description' => __( 'Set how many results are displayed on the map.', 'facetwp' ),
			'type'        => 'select',
			'choices'     => array(
				'all'  => __( 'Display All results. No pagination', 'facetwp' ),
				'page' => __( 'Adapt to templates pagination and results count.', 'facetwp' ),
			),
		),
	),
);

return $settings;
