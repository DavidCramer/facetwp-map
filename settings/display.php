<?php

/**
 * FWP_Map Display Settings
 *
 * @package   facetwp_map
 * @author    David Cramer
 * @license   GPL-2.0+
 * @link
 * @copyright 2016 David Cramer
 */

$settings = array(
	'label'       => __( 'Display', 'facetwp' ),
	'description' => __( 'Display Setup for FacetWP Map', 'facetwp' ),
	'panel'       => array(
		'style' => array(
			'section' => array(
				'map'    => array(
					'label'   => __( 'Map', 'facetwp' ),
					'icon'    => 'dashicons-location-alt',
					'control' => array(
						'map_style' => array(
							'label'       => __( 'Map Style', 'facetwp' ),
							'description' => __( 'Select the map style.', 'facetwp' ),
							'type'        => 'select',
							'choices'     => array(
								'preset' => __( 'Preset', 'facetwp' ),
								'manual' => __( 'Custom', 'facetwp' ),
							),
						),
					),
				),
				'marker' => array(
					'label'   => __( 'Marker', 'facetwp' ),
					'icon'    => 'dashicons-location',
					'control' => array(
						'marker_style' => array(
							'label'       => __( 'Marker Style', 'facetwp' ),
							'description' => __( 'Select the marker style.', 'facetwp' ),
							'type'        => 'select',
							'choices'     => array(
								'preset' => __( 'Preset', 'facetwp' ),
								'manual' => __( 'Custom', 'facetwp' ),
							),
						),
					),
				),
				'info'   => array(
					'label'   => __( 'Info Panel', 'facetwp' ),
					'icon'    => 'dashicons-admin-comments',
					'control' => array(
						'info_style' => array(
							'label'       => __( 'Info Style', 'facetwp' ),
							'description' => __( 'Select the info popout style.', 'facetwp' ),
							'type'        => 'select',
							'choices'     => array(
								'preset' => __( 'Preset', 'facetwp' ),
								'manual' => __( 'Custom', 'facetwp' ),
							),
						),
					),
				),
			),
		),
	),
);
return $settings;
