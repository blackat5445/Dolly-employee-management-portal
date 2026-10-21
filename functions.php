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

define( 'DOLLY_PORTAL_VERSION', '1.2.0' );

/** Oldest version of the Dolly Employee Management plugin this theme is made for. */
define( 'DOLLY_PORTAL_PLUGIN_VERSION', '1.12.0' );

add_action(
	'after_setup_theme',
	function () {
		add_theme_support( 'title-tag' );
		add_theme_support( 'html5', array( 'style', 'script', 'navigation-widgets' ) );
		// Only for the few texts shown when the plugin is missing; everything else is translated by the plugin.
		load_theme_textdomain( 'dolly-portal', get_template_directory() . '/languages' );
	}
);

/** True when the application plugin is active (and recent enough to render the portal). */
function dolly_portal_plugin_active() {
	return class_exists( 'Dolly_Frontend' ) && method_exists( 'Dolly_Frontend', 'render_view' );
}

/**
 * State of the application plugin: '' when the plugin is active and up to date, 'missing' when it is not
 * installed or not active, 'outdated' when it is older than DOLLY_PORTAL_PLUGIN_VERSION.
 */
function dolly_portal_plugin_status() {
	if ( ! dolly_portal_plugin_active() ) {
		return 'missing';
	}
	return defined( 'DOLLY_VERSION' ) && version_compare( DOLLY_VERSION, DOLLY_PORTAL_PLUGIN_VERSION, '<' ) ? 'outdated' : '';
}

/** Message asking to install the latest version of the plugin (no links until it is published in the WordPress directory). */
function dolly_portal_plugin_message( $status ) {
	return 'outdated' === $status
		/* translators: %s: required plugin version. */
		? sprintf( __( 'this theme needs a newer version of the Dolly Employee Management plugin. Install the latest version (%s or later).', 'dolly-portal' ), DOLLY_PORTAL_PLUGIN_VERSION )
		: __( 'install and activate the latest version of the Dolly Employee Management plugin. The theme is only the layout of the portal: sign-in, employee portal and workplace display come from the plugin.', 'dolly-portal' );
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

/** Admin notice when the application plugin is missing or outdated. */
add_action(
	'admin_notices',
	function () {
		$status = dolly_portal_plugin_status();
		if ( $status && current_user_can( 'install_plugins' ) ) {
			printf(
				'<div class="notice notice-warning"><p><strong>%1$s</strong> %2$s</p></div>',
				esc_html__( 'Dolly Portal:', 'dolly-portal' ),
				esc_html( dolly_portal_plugin_message( $status ) )
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
