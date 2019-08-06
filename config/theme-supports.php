<?php
/**
 * Genesis Royal Navy Golfing Society child theme.
 *
 * Theme supports.
 *
 * @package Genesis Royal Navy Golfing Society
 * @author  StudioPress
 * @license GPL-2.0-or-later
 * @link    https://my.studiopress.com/themes/genesis-rngs/
 */

return array(
	'custom-logo'                     => array(
		'height'      => 120,
		'width'       => 700,
		'flex-height' => true,
		'flex-width'  => true,
	),
	'html5'                           => array(
		'caption',
		'comment-form',
		'comment-list',
		'gallery',
		'search-form',
	),
	'genesis-accessibility'           => array(
		'drop-down-menu',
		'headings',
		'search-form',
		'skip-links',
	),
	'genesis-after-entry-widget-area' => '',
	'genesis-footer-widgets'          => 3,
	'genesis-menus'                   => array(
		'primary'   => __( 'Header Menu', 'genesis-rngs' ),
		'secondary' => __( 'Footer Menu', 'genesis-rngs' ),
	),
);
