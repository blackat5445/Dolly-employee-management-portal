<?php
/**
 * Dolly Portal theme.
 *
 * A clean one-column theme for a site dedicated to an employee portal. With the "Dolly Employee
 * Management" plugin active, the portal pages (sign-in, employee portal, workplace display) use the
 * templates in /dolly and the plugin's design, colors, logo and languages. Without the plugin the theme
 * works as a simple blog and pages theme.
 *
 * @package DollyPortal
 */

defined( 'ABSPATH' ) || exit;

define( 'DOLLY_PORTAL_VERSION', '1.4.0' );

/** Oldest version of the Dolly Employee Management plugin this theme is made for. */
define( 'DOLLY_PORTAL_PLUGIN_VERSION', '1.13.0' );

if ( ! isset( $content_width ) ) {
	$content_width = 720; // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited -- Core global for embeds and images.
}

/** Theme features. */
function dolly_portal_setup() {
	load_theme_textdomain( 'dolly-portal', get_template_directory() . '/languages' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'wp-block-styles' );
	add_theme_support( 'align-wide' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script', 'navigation-widgets' ) );
	add_theme_support( 'editor-styles' );
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 96,
			'width'       => 96,
			'flex-height' => true,
			'flex-width'  => true,
		)
	);
	add_editor_style( 'assets/css/editor.css' );
	register_nav_menus( array( 'primary' => __( 'Primary menu', 'dolly-portal' ) ) );
}
add_action( 'after_setup_theme', 'dolly_portal_setup' );

/**
 * Logo in the header of the standard pages: the custom logo (Appearance › Customize › Site Identity) or, by
 * default, the Dolly logo. Filter dolly_portal_default_logo: false to show only the site title.
 */
function dolly_portal_logo() {
	if ( has_custom_logo() ) {
		the_custom_logo();
		return;
	}
	if ( ! apply_filters( 'dolly_portal_default_logo', true ) ) {
		return;
	}
	printf(
		'<a class="dp-logo" href="%1$s" rel="home" aria-hidden="true" tabindex="-1"><img src="%2$s" alt="" width="32" height="26"></a>',
		esc_url( home_url( '/' ) ),
		esc_url( get_template_directory_uri() . '/assets/images/dolly-logo.svg' )
	);
}

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

/** Message recommending the latest version of the plugin (no links until it is published in the WordPress directory). */
function dolly_portal_plugin_message( $status ) {
	return 'outdated' === $status
		/* translators: %s: required plugin version. */
		? sprintf( __( 'this theme needs a newer version of the Dolly Employee Management plugin. Install the latest version (%s or later).', 'dolly-portal' ), DOLLY_PORTAL_PLUGIN_VERSION )
		: __( 'install and activate the latest version of the Dolly Employee Management plugin to turn this site into an employee portal (sign-in, employee portal and workplace display).', 'dolly-portal' );
}

/** Styles: the theme stylesheet; on pages that are not plugin views, also the plugin's design. */
function dolly_portal_scripts() {
	if ( dolly_portal_plugin_active() && ! Dolly_Frontend::current_view() ) {
		Dolly_Frontend::enqueue_styles();
	}
	wp_enqueue_style( 'dolly-portal', get_stylesheet_uri(), array(), DOLLY_PORTAL_VERSION );
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'dolly_portal_scripts' );

/** Body class used by the stylesheet. */
function dolly_portal_body_class( $classes ) {
	$classes[] = 'dolly-portal';
	return $classes;
}
add_filter( 'body_class', 'dolly_portal_body_class' );

/** Color of the browser bar on phones: the header color of the plugin's Appearance settings. */
function dolly_portal_theme_color() {
	return dolly_portal_plugin_active() ? Dolly_Frontend::theme_color() : '#2563EB';
}

/**
 * Admin notice recommending the plugin when it is missing or outdated. Dismissible: the dismissal is
 * remembered for each administrator until the state changes.
 */
function dolly_portal_admin_notice() {
	$status = dolly_portal_plugin_status();
	if ( ! $status || ! current_user_can( 'install_plugins' ) || get_user_meta( get_current_user_id(), 'dolly_portal_notice_dismissed', true ) === $status ) {
		return;
	}
	printf(
		'<div class="notice notice-info is-dismissible" data-dolly-portal-notice="%1$s" data-nonce="%2$s"><p><strong>%3$s</strong> %4$s</p></div>',
		esc_attr( $status ),
		esc_attr( wp_create_nonce( 'dolly_portal_notice' ) ),
		esc_html__( 'Dolly Portal:', 'dolly-portal' ),
		esc_html( dolly_portal_plugin_message( $status ) )
	);
}
add_action( 'admin_notices', 'dolly_portal_admin_notice' );

/** Script that remembers the dismissal (WordPress only hides the notice for the current page view). */
function dolly_portal_admin_scripts() {
	if ( dolly_portal_plugin_status() && current_user_can( 'install_plugins' ) ) {
		wp_enqueue_script( 'dolly-portal-notice', get_template_directory_uri() . '/assets/js/admin-notice.js', array(), DOLLY_PORTAL_VERSION, true );
	}
}
add_action( 'admin_enqueue_scripts', 'dolly_portal_admin_scripts' );

/** AJAX: dismiss the plugin notice for the current administrator. */
function dolly_portal_dismiss_notice() {
	check_ajax_referer( 'dolly_portal_notice' );
	if ( current_user_can( 'install_plugins' ) ) {
		$status = isset( $_POST['status'] ) ? sanitize_key( wp_unslash( $_POST['status'] ) ) : '';
		update_user_meta( get_current_user_id(), 'dolly_portal_notice_dismissed', $status );
	}
	wp_send_json_success();
}
add_action( 'wp_ajax_dolly_portal_dismiss_notice', 'dolly_portal_dismiss_notice' );

/**
 * Shared layout for the application views. Called by the templates in /dolly.
 */
function dolly_portal_app_layout() {
	get_template_part( 'template-parts/app-layout' );
}
