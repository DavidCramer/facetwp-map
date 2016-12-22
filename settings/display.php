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
						'snazzy' => array(
							'label'    => __( 'Select A Snazzy Map', 'facetwp' ),
							'type'     => 'template',
							'template' => FWP_MAP_PATH . 'includes/snazzy.php',
							'script'   => array(
								'handlebars' => FWP_MAP_URL . 'assets/js/handlebars-latest.min.js',
								'snazzy'     => FWP_MAP_URL . 'assets/js/snazzy.js',
							),
						),
						'styles' => array(
							'label'       => __( 'Map Style', 'facetwp' ),
							'description' => __( 'Manually Add style code.', 'facetwp' ),
							'type'        => 'textarea',
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
