<?php
/**
 * Dolly Portal theme.
 *
 * The theme is only the base layout of a portal site. Everything else lives in the "Dolly Employee
 * Management" plugin: content, styles, colors, logo and brand (Gestione Dipendenti › Aspetto), languages,
 * the branded WordPress sign-in screens, redirects and search-engine rules. The plugin works the same with
 * any theme, so nothing is lost if you switch.
 *
 * @package DollyPortal
 */

defined( 'ABSPATH' ) || exit;

define( 'DOLLY_PORTAL_VERSION', '1.1.0' );

add_action(
	'after_setup_theme',
	function () {
		add_theme_support( 'title-tag' );
		add_theme_support( 'html5', array( 'style', 'script', 'navigation-widgets' ) );
		// Only for the few texts shown when the plugin is missing; everything else is translated by the plugin.
		load_theme_textdomain( 'dolly-portal', get_template_directory() . '/languages' );
	}
);

/** True when the application plugin is active. */
function dolly_portal_plugin_active() {
	return class_exists( 'Dolly_Frontend' );
}

add_action(
	'wp_enqueue_scripts',
	function () {
		// Theme pages that are not plugin views (front page, pages) use the plugin's design and Appearance settings.
		if ( dolly_portal_plugin_active() && ! Dolly_Frontend::current_view() ) {
			Dolly_Frontend::enqueue_styles();
		}
		wp_enqueue_style( 'dolly-portal', get_stylesheet_uri(), array(), DOLLY_PORTAL_VERSION );
	}
);

/** A portal site is private: no page is indexed (the plugin already marks its own views). */
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
		return $classes;
	}
);

/** Color of the browser bar on phones: the header color of the plugin's Appearance settings. */
function dolly_portal_theme_color() {
	return dolly_portal_plugin_active() ? Dolly_Frontend::theme_color() : '#2563EB';
}

/** Admin notice when the application plugin is missing. */
add_action(
	'admin_notices',
	function () {
		if ( ! dolly_portal_plugin_active() && current_user_can( 'activate_plugins' ) ) {
			printf(
				'<div class="notice notice-warning"><p><strong>%1$s</strong> %2$s</p></div>',
				esc_html__( 'Dolly Portal:', 'dolly-portal' ),
				esc_html__( 'activate the Dolly Employee Management plugin to use the employee portal.', 'dolly-portal' )
			);
		}
	}
);

/**
 * Shared layout for the application views. Called by the templates in /dolly.
 */
function dolly_portal_app_layout() {
	get_template_part( 'template-parts/app-layout' );
}
