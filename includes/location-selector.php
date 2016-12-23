<?php
/**
 * FWP_MAP location selector
 *
 * @package   facetwp_map
 * @author    David Cramer
 * @license   GPL-2.0+
 * @copyright 2016 David Cramer
 */
$sources = FWP()->helper->get_data_sources();
$value   = $this->get_value();
if ( empty( $value ) || ! is_array( $value ) ) {
	$value = array(
		'single'    => 'location',
		'latitude'  => '',
		'longitude' => '',
	);
}
// define the fields the fields
$fields = array(
	'single'    => array(
		'label'       => __( 'Coordinates source', 'facetwp' ),
		'description' => __( 'Select source of the comma separated coordinates', 'facetwp' ),
	),
	'lat'  => array(
		'label'       => __( 'Latitude source', 'facetwp' ),
		'description' => __( 'Select source of the latitude coordinate', 'facetwp' ),
	),
	'lng' => array(
		'label'       => __( 'Longitude source', 'facetwp' ),
		'description' => __( 'Select source of the longitude coordinate', 'facetwp' ),
	),
);

foreach ( $fields as $field => $conf ) {
	?>
	<div class="facetwp_map-control facetwp_map-control-select fwpm-src facetwp_map-<?php echo $field; ?>-source">
		<label for="fwp_map-location_field_<?php echo $field; ?>">
		<span
			class="facetwp_map-control-label"><?php echo esc_html( $conf['label'] ); ?></span>
		</label>
		<div class="facetwp_map-control-input">
			<select name="<?php echo $this->name(); ?>[<?php echo $field; ?>]" id="fwp_map-location_field_<?php echo $field; ?>"
			        class="fselect select-field"
			        style="width:100%;">
				<?php

				foreach ( $sources as $source => $option ) {
					if ( in_array( $source, array( 'posts', 'taxonomies' ) ) ) {
						continue;
					}
					echo '<optgroup label="' . esc_attr( $option['label'] ) . '">';
					foreach ( $option['choices'] as $choice => $label ) {
						$sel = ( $choice == $value[ $field ] ) ? 'selected="selected"' : '';
						echo '<option value="' . esc_attr( $choice ) . '" ' . $sel . '>' . esc_html( $label ) . '</option>';
					}
					echo '</optgroup>';
				}
				?>
			</select>
		</div>
		<span
			class="facetwp_map-control-description"><?php echo esc_html( $conf['description'] ); ?></span>
	</div>
	<?php
}
?>
