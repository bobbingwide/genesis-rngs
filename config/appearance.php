<?php
/**
 * Genesis Royal Navy Golfing Society appearance settings.
 *
 * @package Genesis Royal Navy Golfing Society
 * @author  StudioPress
 * @license GPL-2.0-or-later
 * @link    https://www.studiopress.com/
 */

$genesis_rngs_default_colors = array(
	'link'   => '#76b93c',
	'accent' => '#adc85b',
);

$genesis_rngs_link_color = get_theme_mod(
	'genesis_rngs_link_color',
	$genesis_rngs_default_colors['link']
);

$genesis_rngs_accent_color = get_theme_mod(
	'genesis_rngs_accent_color',
	$genesis_rngs_default_colors['accent']
);

$genesis_rngs_link_color_contrast   = genesis_rngs_color_contrast( $genesis_rngs_link_color );
$genesis_rngs_link_color_brightness = genesis_rngs_color_brightness( $genesis_rngs_link_color, 35 );

return array(
	'fonts-url'            => 'https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,400i,600,700&display=swap',
	'content-width'        => 1200,
	'button-bg'            => $genesis_rngs_link_color,
	'button-color'         => $genesis_rngs_link_color_contrast,
	'button-outline-hover' => $genesis_rngs_link_color_brightness,
	'link-color'           => $genesis_rngs_link_color,
	'default-colors'       => $genesis_rngs_default_colors,
	'editor-color-palette' => array(
		array(
			'name'  => __( 'Custom color', 'genesis-rngs' ), // Called “Link Color” in the Customizer options. Renamed because “Link Color” implies it can only be used for links.
			'slug'  => 'theme-primary',
			'color' => $genesis_rngs_link_color,
		),
		array(
			'name'  => __( 'Accent color', 'genesis-rngs' ),
			'slug'  => 'theme-secondary',
			'color' => $genesis_rngs_accent_color,
		),
	),
	'editor-font-sizes'    => array(
		array(
			'name' => __( 'Small', 'genesis-rngs' ),
			'size' => 12,
			'slug' => 'small',
		),
		array(
			'name' => __( 'Normal', 'genesis-rngs' ),
			'size' => 18,
			'slug' => 'normal',
		),
		array(
			'name' => __( 'Large', 'genesis-rngs' ),
			'size' => 20,
			'slug' => 'large',
		),
		array(
			'name' => __( 'Larger', 'genesis-rngs' ),
			'size' => 24,
			'slug' => 'larger',
		),
	),
);
