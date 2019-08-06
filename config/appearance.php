<?php
/**
 * Genesis Solent Roofing and Building appearance settings.
 *
 * @package Genesis Solent Roofing and Building
 * @author  StudioPress
 * @license GPL-2.0-or-later
 * @link    https://www.studiopress.com/
 */

$genesis_srab_default_colors = array(
	'link'   => '#5f5d89',
	'accent' => '#0073e5',
);

$genesis_srab_link_color = get_theme_mod(
	'genesis_srab_link_color',
	$genesis_srab_default_colors['link']
);

$genesis_srab_accent_color = get_theme_mod(
	'genesis_srab_accent_color',
	$genesis_srab_default_colors['accent']
);

$genesis_srab_link_color_contrast   = genesis_srab_color_contrast( $genesis_srab_link_color );
$genesis_srab_link_color_brightness = genesis_srab_color_brightness( $genesis_srab_link_color, 35 );

return array(
	'fonts-url'            => 'https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,400i,600,700&display=swap',
	'content-width'        => 1200,
	'button-bg'            => $genesis_srab_link_color,
	'button-color'         => $genesis_srab_link_color_contrast,
	'button-outline-hover' => $genesis_srab_link_color_brightness,
	'link-color'           => $genesis_srab_link_color,
	'default-colors'       => $genesis_srab_default_colors,
	'editor-color-palette' => array(
		array(
			'name'  => __( 'Custom color', 'genesis-srab' ), // Called “Link Color” in the Customizer options. Renamed because “Link Color” implies it can only be used for links.
			'slug'  => 'theme-primary',
			'color' => $genesis_srab_link_color,
		),
		array(
			'name'  => __( 'Accent color', 'genesis-srab' ),
			'slug'  => 'theme-secondary',
			'color' => $genesis_srab_accent_color,
		),
	),
	'editor-font-sizes'    => array(
		array(
			'name' => __( 'Small', 'genesis-srab' ),
			'size' => 12,
			'slug' => 'small',
		),
		array(
			'name' => __( 'Normal', 'genesis-srab' ),
			'size' => 18,
			'slug' => 'normal',
		),
		array(
			'name' => __( 'Large', 'genesis-srab' ),
			'size' => 20,
			'slug' => 'large',
		),
		array(
			'name' => __( 'Larger', 'genesis-srab' ),
			'size' => 24,
			'slug' => 'larger',
		),
	),
);
