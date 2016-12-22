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
					'label'       => __( 'Map', 'facetwp' ),
					'description' => __( 'Snazzy Maps Integration.', 'facetwp' ),
					'icon'        => 'dashicons-location-alt',
					'control'     => array(
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
							'label'       => __( 'Map Style Code', 'facetwp' ),
							'description' => __( 'Manually Add style code.', 'facetwp' ),
							'type'        => 'textarea',
						),
					),
				),
				'marker' => array(
					'label'   => __( 'Marker', 'facetwp' ),
					'icon'    => 'dashicons-location',
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
