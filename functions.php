<?php
/**
 * Dolly Portal theme.
 *
 * The theme only provides layout and presentation. Accounts, attendance, requests and all other
 * features live in the "Dolly Employee Management" plugin, so they survive a theme change.
 *
 * @package DollyPortal
 */

defined( 'ABSPATH' ) || exit;

define( 'DOLLY_PORTAL_VERSION', '1.0.0' );

add_action(
	'after_setup_theme',
	function () {
		add_theme_support( 'title-tag' );
		add_theme_support( 'html5', array( 'style', 'script', 'navigation-widgets' ) );
		load_theme_textdomain( 'dolly-portal', get_template_directory() . '/languages' );
	}
);

/** True when the application plugin is active. */
function dolly_portal_plugin_active() {
	return class_exists( 'MEM_Frontend' );
}

add_action(
	'wp_enqueue_scripts',
	function () {
		wp_enqueue_style( 'dolly-portal', get_stylesheet_uri(), array(), DOLLY_PORTAL_VERSION );
	}
);

/** The portal is private: keep it out of search engines. */
add_filter(
	'wp_robots',
	function ( $robots ) {
		$robots['noindex']  = true;
		$robots['nofollow'] = true;
		return $robots;
	}
);

add_filter(
	'body_class',
	function ( $classes ) {
		$classes[] = 'dolly-portal';
		if ( dolly_portal_plugin_active() && MEM_Frontend::current_view() ) {
			$classes[] = 'mem-body';
			$classes[] = 'mem-view-' . sanitize_html_class( MEM_Frontend::current_view() );
		}
		return $classes;
	}
);

/**
 * Brand the WordPress password-reset screens (wp-login.php?action=rp) reached from the recovery email.
 * Navy/gold palette, text wordmark or the logo configured in the plugin settings.
 */
add_action(
	'login_enqueue_scripts',
	function () {
		$logo = dolly_portal_plugin_active() ? MEM_Settings::logo_url() : '';
		wp_enqueue_style( 'dolly-portal-login', get_template_directory_uri() . '/assets/login.css', array(), DOLLY_PORTAL_VERSION );
		if ( $logo ) {
			wp_add_inline_style( 'dolly-portal-login', 'body.login h1 a{background-image:url(' . esc_url( $logo ) . ');background-size:contain;width:220px;height:64px;text-indent:-9999px;}' );
		}
	}
);
add_filter( 'login_headerurl', function () { return home_url( '/accesso/' ); } );
add_filter( 'login_headertext', function () { return 'Dolly'; } );

/** After resetting the password, send people back to the portal login instead of wp-login.php. */
add_action(
	'after_password_reset',
	function ( $user ) {
		if ( dolly_portal_plugin_active() && MEM_Auth::is_portal_user( $user ) ) {
			add_filter( 'login_url', function () { return home_url( '/accesso/' ); } );
		}
	}
);

/** Admin notice when the application plugin is missing. */
add_action(
	'admin_notices',
	function () {
		if ( ! dolly_portal_plugin_active() && current_user_can( 'activate_plugins' ) ) {
			echo '<div class="notice notice-warning"><p><strong>Dolly Portal:</strong> attiva il plugin <em>Dolly Employee Management</em> per usare il portale dipendenti.</p></div>';
		}
	}
);

/**
 * Shared layout for the application views. Called by the templates in /dolly.
 */
function dolly_portal_app_layout() {
	get_template_part( 'template-parts/app-layout' );
}
