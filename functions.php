<?php
/**
 * Genesis Royal Navy Golfing Society.
 *
 * This file adds functions to the Genesis Royal Navy Golfing Society Theme.
 *
 * @package Genesis Royal Navy Golfing Society
 * @author  BobbingWide
 * @license GPL-2.0-or-later
 * @link    https://www.studiopress.com/
 */

// Starts the engine.
require_once get_template_directory() . '/lib/init.php';

// Sets up the Theme.
require_once get_stylesheet_directory() . '/lib/theme-defaults.php';

add_action( 'after_setup_theme', 'genesis_rngs_localization_setup' );
/**
 * Sets localization (do not remove).
 *
 * @since 1.0.0
 */
function genesis_rngs_localization_setup() {

	load_child_theme_textdomain( genesis_get_theme_handle(), get_stylesheet_directory() . '/languages' );

}

// Adds helper functions.
require_once get_stylesheet_directory() . '/lib/helper-functions.php';

// Adds image upload and color select to Customizer.
require_once get_stylesheet_directory() . '/lib/customize.php';

// Includes Customizer CSS.
require_once get_stylesheet_directory() . '/lib/output.php';

// Adds WooCommerce support.
//require_once get_stylesheet_directory() . '/lib/woocommerce/woocommerce-setup.php';

// Adds the required WooCommerce styles and Customizer CSS.
//require_once get_stylesheet_directory() . '/lib/woocommerce/woocommerce-output.php';

// Adds the Genesis Connect WooCommerce notice.
//require_once get_stylesheet_directory() . '/lib/woocommerce/woocommerce-notice.php';

add_action( 'after_setup_theme', 'genesis_child_gutenberg_support' );
/**
 * Adds Gutenberg opt-in features and styling.
 *
 * @since 2.7.0
 */
function genesis_child_gutenberg_support() { // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedFunctionFound -- using same in all child themes to allow action to be unhooked.
	require_once get_stylesheet_directory() . '/lib/gutenberg/init.php';
}

// Registers the responsive menus.
if ( function_exists( 'genesis_register_responsive_menus' ) ) {
	genesis_register_responsive_menus( genesis_get_config( 'responsive-menus' ) );
}

add_action( 'wp_enqueue_scripts', 'genesis_rngs_enqueue_scripts_styles' );
/**
 * Enqueues scripts and styles.
 *
 * @since 1.0.0
 */
function genesis_rngs_enqueue_scripts_styles() {

	$appearance = genesis_get_config( 'appearance' );

	wp_enqueue_style(
		genesis_get_theme_handle() . '-fonts',
		$appearance['fonts-url'],
		array(),
		genesis_get_theme_version()
	);

	wp_enqueue_style( 'dashicons' );

	if ( genesis_is_amp() ) {
		wp_enqueue_style(
			genesis_get_theme_handle() . '-amp',
			get_stylesheet_directory_uri() . '/lib/amp/amp.css',
			array( genesis_get_theme_handle() ),
			genesis_get_theme_version()
		);
	}

}

add_action( 'after_setup_theme', 'genesis_rngs_theme_support', 9 );
add_action( 'after_setup_theme', 'genesis_rngs_oik_clone_support' );
/**
 * Add desired theme supports.
 *
 * See config file at `config/theme-supports.php`.
 *
 * @since 3.0.0
 */
function genesis_rngs_theme_support() {

	$theme_supports = genesis_get_config( 'theme-supports' );

	foreach ( $theme_supports as $feature => $args ) {
		add_theme_support( $feature, $args );
	}
}

function genesis_rngs_oik_clone_support() {
	$feature = 'clone';
	add_post_type_support( 'oik_testimonials', $feature );
	add_post_type_support( 'post', $feature );
	add_post_type_support( 'page', $feature );
	add_post_type_support( 'attachment', $feature );
}

add_filter( 'genesis_seo_title', 'genesis_rngs_header_title', 10, 3 );
/**
 * Removes the link from the hidden site title if a custom logo is in use.
 *
 * Without this filter, the site title is hidden with CSS when a custom logo
 * is in use, but the link it contains is still accessible by keyboard.
 *
 * @since 1.2.0
 *
 * @param string $title  The full title.
 * @param string $inside The content inside the title element.
 * @param string $wrap   The wrapping element name, such as h1.
 * @return string The site title with anchor removed if a custom logo is active.
 */
function genesis_rngs_header_title( $title, $inside, $wrap ) {

	if ( has_custom_logo() ) {
		$inside = get_bloginfo( 'name' );
	}

	return sprintf( '<%1$s class="site-title">%2$s</%1$s>', $wrap, $inside );

}

// Adds image sizes.
add_image_size( 'sidebar-featured', 75, 75, true );

// Removes header right widget area.
unregister_sidebar( 'header-right' );

// Removes secondary sidebar.
unregister_sidebar( 'sidebar-alt' );

// Removes site layouts.
genesis_unregister_layout( 'content-sidebar-sidebar' );
genesis_unregister_layout( 'sidebar-content-sidebar' );
genesis_unregister_layout( 'sidebar-sidebar-content' );

add_filter( 'genesis_customizer_theme_settings_config', 'genesis_rngs_remove_customizer_settings' );
/**
 * Removes output of header and front page breadcrumb settings in the Customizer.
 *
 * @since 2.6.0
 *
 * @param array $config Original Customizer items.
 * @return array Filtered Customizer items.
 */
function genesis_rngs_remove_customizer_settings( $config ) {

	unset( $config['genesis']['sections']['genesis_header'] );
	unset( $config['genesis']['sections']['genesis_breadcrumbs']['controls']['breadcrumb_front_page'] );
	return $config;

}

// Displays custom logo.
add_action( 'genesis_site_title', 'the_custom_logo', 0 );

// Repositions primary navigation menu.
remove_action( 'genesis_after_header', 'genesis_do_nav' );
add_action( 'genesis_header', 'genesis_do_nav', 12 );

// Repositions the secondary navigation menu.
remove_action( 'genesis_after_header', 'genesis_do_subnav' );
add_action( 'genesis_footer', 'genesis_do_subnav', 10 );

add_filter( 'wp_nav_menu_args', 'genesis_rngs_secondary_menu_args' );
/**
 * Reduces secondary navigation menu to one level depth.
 *
 * @since 2.2.3
 *
 * @param array $args Original menu options.
 * @return array Menu options with depth set to 1.
 */
function genesis_rngs_secondary_menu_args( $args ) {

	if ( 'secondary' !== $args['theme_location'] ) {
		return $args;
	}

	$args['depth'] = 1;
	return $args;

}

add_filter( 'genesis_author_box_gravatar_size', 'genesis_rngs_author_box_gravatar' );
/**
 * Modifies size of the Gravatar in the author box.
 *
 * @since 2.2.3
 *
 * @param int $size Original icon size.
 * @return int Modified icon size.
 */
function genesis_rngs_author_box_gravatar( $size ) {

	return 90;

}

add_filter( 'genesis_comment_list_args', 'genesis_rngs_comments_gravatar' );
/**
 * Modifies size of the Gravatar in the entry comments.
 *
 * @since 2.2.3
 *
 * @param array $args Gravatar settings.
 * @return array Gravatar settings with modified size.
 */
function genesis_rngs_comments_gravatar( $args ) {

	$args['avatar_size'] = 60;
	return $args;

}

add_filter( 'genesis_pre_get_option_footer_text', "genesis_rngs_footer_creds_text" );

/**
 * Display footer credits for the genesis-hm theme
 */
function genesis_rngs_footer_creds_text( $text ) {
	do_action( "oik_add_shortcodes" );
	$text = "[bw_wpadmin]";
	$text .= '<br />';
	$text .= "[bw_copyright]";
	//$text .= '<hr />';
	//$text .= 'Website designed and developed by [bw_link text="Herb Miller" herbmiller.me] of';
	//$text .= ' <a href="//www.bobbingwide.com" title="Bobbing Wide - web design, web development">[bw]</a>';
	//$text .= '<br />';
	//$text .= '[bw_power]';
	return( $text );
}

// Logic copied/cobbled from rngs0721c

// (C) Copyright Bobbing Wide 2014

/**
 * Let WordPress know that this theme is supported from bobbingwide.
 * Also the parent theme.
 */
function rngs0414c_oik_admin_menu() {
	oik_register_theme_server( __FILE__ );
	oik_register_theme_server( "rngs0414/rngs0414.php" );
}

/**
 * Function to invoke when rngs0414c/functions.php is loaded
 */
function rngs0414c_functions_loaded() {
	//add_action( "oik_admin_menu", "rngs0414c_oik_admin_menu" );

	add_filter( 'wpmem_forgot_link' , 'rngs_wpmem_forgot_link' );
	add_filter( 'wpmem_inc_login_inputs', 'rngs_wpmem_inc_login_inputs' );
	add_filter( 'wpmem_login_failed_args', 'rngs_wpmem_login_failed_args' );
	add_filter( 'wpmem_sb_login_args', 'rngs_wpmem_sb_login_args' );
	add_filter( 'login_form_defaults', 'rngs_login_form_defaults' );
	add_action( 'login_form', 'rngs_username_or_email_login' );

	remove_filter( 'authenticate', 'wp_authenticate_username_password', 20, 3 );
	add_filter( 'authenticate', 'rngs_email_login_authenticate', 20, 3 );
	add_filter( "oik_table_titles_fixture", "rngs_table_titles_fixture" );
	add_action( "password_reset", "rngs_password_reset", 10, 2 );
	remove_filter( 'the_content', 'wptexturize' );


}

/**
 * Implement "password_reset" for RNGS
 *
 * After a password reset has been performed we want the Log in link to redirect the user to the home url.
 * When we see this action being run we know that we should be filtering "login_url" to add the redirect the home page.
 * We don't filter "login_url" any other time.
 *
 * @param WP_User $user - the user object
 * @param string $new_pass - the new password
 *
 */
function rngs_password_reset( $user, $new_pass ) {
	//bw_trace2();
	add_filter( "login_url", "rngs_login_url", 10, 2 );
}

/**
 * Redirect the user to the home page after logging in
 *
 * @TODO - make this an option field that controls where the logged in user goes
 * @TODO - dependent upon role?
 *
 * @param string $login_url - the original login_url which is not expected to include "redirect_to" or "reauth"
 * @param string $redirect - expected to be null/blank
 */
function rngs_login_url( $login_url, $redirect ) {
	//bw_trace2();
	$home_redirect = home_url();
	$login_url = add_query_arg('redirect_to', urlencode( $home_redirect ), $login_url);
	return( $login_url );
}

/**
 * Implement "wpmem_forgot_link" for RNGS
 *
 * Since we're allowing login by email address we need to override the WP-Members password reset logic and
 * use WordPress logic instead.
 *
 * @param string $link - the default link for WP-Members password reset
 * @return string - the link for WordPress lost password
 *
 */
function rngs_wpmem_forgot_link( $link ) {
	return( site_url( "wp-login.php?action=lostpassword" ) );
}

/**
 * Implement "wpmem_inc_login_inputs" filter for RNGS
 *
 * Since we're using email-login we're allowing users to login with their email address as well as their username.
 * In actual fact we expect them to be the same but that's a different issue.
 * Here we need to alter the label on the WP-Members generated login form.
 *

$default_inputs = array(
array(
'name'   => __( 'Username', 'wp-members' ),
'type'   => 'text',
'tag'    => 'log',
'class'  => 'username',
'div'    => 'div_text'
),
array(
'name'   => __( 'Password', 'wp-members' ),
'type'   => 'password',
'tag'    => 'pwd',
'class'  => 'password',
'div'    => 'div_text'
)
);
 *
 */
function rngs_wpmem_inc_login_inputs( $inputs ) {
	$inputs[0]['name'] = __( "Username or email", "email-login" );
	return( $inputs );
}


/**
 * Implement "wpmem_login_failed_args" filter for RNGS
 *
 * Since we're using email-login we're allowing users to login with their email address as well as their username.
 * Here we need to alter the WP-Members generated failure message
 *
 */
function rngs_wpmem_login_failed_args( $args ) {
	$args['message'] = __( "You entered an invalid username or email or password", "oik-email-login" ) ;
	return( $args );
}

/**
 * Implement "wpmem_sb_login_args" filter for RNGS
 *
 * Since we're using email-login we're allowing users to login with their email address as well as their username.
 * Here we need to alter the WP-Members generated failure message; 'error_msg' on the Sidebar widget.
 *
 */
function rngs_wpmem_sb_login_args( $args ) {
	//$args['message'] = __( "You entered an invalid username or email or password", "oik-email-login" ) ;
	$args['error_msg'] = __( 'Login Failed!<br />You entered an invalid username or email or password.', 'oik-email-login' );
	return( $args );

}


/**
 * Override the values for the Login form
 *
 * Note: This does not override the values on any Artisteer generated Login form
 * We have to change the theme to handle this.
 */
function rngs_login_form_defaults( $defaults ) {
	//bw_trace2();
	$defaults['label_username'] = __( "Username or email", "email-login" );
	//$defaults['label_remember'] = "mem me";
	return( $defaults );
}


/**
 * Modify the string on the login page to prompt for username or email address
 *
 * I don't think it matters if we're on the login page or not... the action won't get called when we're not.
 *
 */
function rngs_username_or_email_login() {
	//if ( 'wp-login.php' != basename( $_SERVER['SCRIPT_NAME'] ) )
	//	return;

	?><script type="text/javascript">
        // Form Label
        if ( document.getElementById('loginform') )
            document.getElementById('loginform').childNodes[1].childNodes[1].childNodes[0].nodeValue = '<?php echo esc_js( __( 'Username or Email', 'email-login' ) ); ?>';

        // Error Messages
        if ( document.getElementById('login_error') )
            document.getElementById('login_error').innerHTML = document.getElementById('login_error').innerHTML.replace( '<?php echo esc_js( __( 'username' ) ); ?>', '<?php echo esc_js( __( 'Username or Email' , 'email-login' ) ); ?>' );
	</script><?php
}


/**
 * If an email address is entered in the username box, then look up the matching username and authenticate as per normal, using that.
 *
 * @param string $user
 * @param string $username
 * @param string $password
 * @return Results of autheticating via wp_authenticate_username_password(), using the username found when looking up via email.
 */
function rngs_email_login_authenticate( $user, $username, $password ) {
	if ( is_a( $user, 'WP_User' ) )
		return $user;

	if ( !empty( $username ) ) {
		$username = str_replace( '&', '&amp;', stripslashes( $username ) );
		$user = get_user_by( 'email', $username );
		if ( isset( $user, $user->user_login, $user->user_status ) && 0 == (int) $user->user_status )
			$username = $user->user_login;
	}

	return wp_authenticate_username_password( null, $username, $password );
}

/**
 * Theme the match manager's name
 *
 * Note: $user->display_name is often the same as First name space Last name but it doesn't have to be.
 *
 * @param string $key
 * @param string $value
 * @param array $field
 *
 */
function bw_theme_field_userref__match_manager( $key, $value, $field  ) {
	$id = bw_array_get( $value, 0, $value );
	if ( $id ) {
		$user = bw_get_user( $id );
		if ( $user ) {
			// bw_trace2( $user, "user" );
			$first_name = get_the_author_meta( "first_name", $id );
			$last_name  = get_the_author_meta( "last_name", $id );
			$email      = "$first_name $last_name";
			if ( is_user_logged_in() ) {
				oik_require( "shortcodes/oik-email.php" );
				$email_link = _bw_mailto_link( $user->user_email, array( "subject" => "y" ) );
				alink( null, $email_link, $email, esc_attr( $email ) );
			} else {
				e( $email );
			}
		} else {
		    e( "");
        }
	}
}

/**
 * Change the titles for "Title" and "Fixture format"
 *
 * Set them to "Fixture" and "Format" respectively
 *
 * @param array $titles - associative arrays of fields and their titles
 * @return array - the titles you want to use
 */
function rngs_table_titles_fixture( $titles ) {
	$titles['title'] = "Fixture";
	$titles['fixture_format'] = "Format";
	return( $titles );
}

rngs0414c_functions_loaded();

