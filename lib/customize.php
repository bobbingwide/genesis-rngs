<?php
/**
 * Genesis Royal Navy Golfing Society.
 *
 * This file adds the Customizer additions to the Genesis Royal Navy Golfing Society Theme.
 *
 * @package Genesis Royal Navy Golfing Society
 * @author  StudioPress
 * @license GPL-2.0-or-later
 * @link    https://www.studiopress.com/
 */

add_action( 'customize_register', 'genesis_rngs_customizer_register' );
/**
 * Registers settings and controls with the Customizer.
 *
 * @since 2.2.3
 *
 * @param WP_Customize_Manager $wp_customize Customizer object.
 */
function genesis_rngs_customizer_register( $wp_customize ) {

	$appearance = genesis_get_config( 'appearance' );

	$wp_customize->add_setting(
		'genesis_rngs_link_color',
		array(
			'default'           => $appearance['default-colors']['link'],
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'genesis_rngs_link_color',
			array(
				'description' => __( 'Change the color of post info links and button blocks, the hover color of linked titles and menu items, and more.', 'genesis-rngs' ),
				'label'       => __( 'Link Color', 'genesis-rngs' ),
				'section'     => 'colors',
				'settings'    => 'genesis_rngs_link_color',
			)
		)
	);

	$wp_customize->add_setting(
		'genesis_rngs_accent_color',
		array(
			'default'           => $appearance['default-colors']['accent'],
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'genesis_rngs_accent_color',
			array(
				'description' => __( 'Change the default hover color for button links, menu buttons, and submit buttons. The button block uses the Link Color.', 'genesis-rngs' ),
				'label'       => __( 'Accent Color', 'genesis-rngs' ),
				'section'     => 'colors',
				'settings'    => 'genesis_rngs_accent_color',
			)
		)
	);

	$wp_customize->add_setting(
		'genesis_rngs_logo_width',
		array(
			'default'           => 350,
			'sanitize_callback' => 'absint',
		)
	);

	// Add a control for the logo size.
	$wp_customize->add_control(
		'genesis_rngs_logo_width',
		array(
			'label'       => __( 'Logo Width', 'genesis-rngs' ),
			'description' => __( 'The maximum width of the logo in pixels.', 'genesis-rngs' ),
			'priority'    => 9,
			'section'     => 'title_tagline',
			'settings'    => 'genesis_rngs_logo_width',
			'type'        => 'number',
			'input_attrs' => array(
				'min' => 100,
			),

		)
	);

}
