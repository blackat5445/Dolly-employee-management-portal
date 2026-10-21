<?php
/**
 * Layout for the application views (sign-in, password recovery, employee portal, workplace display).
 * Content, styles, body classes and the skip link come from the Dolly Employee Management plugin.
 *
 * @package DollyPortal
 */

defined( 'ABSPATH' ) || exit;
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
	<meta name="theme-color" content="<?php echo esc_attr( dolly_portal_theme_color() ); ?>">
	<meta name="format-detection" content="telephone=no">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<?php
if ( dolly_portal_plugin_active() ) {
	Dolly_Frontend::skip_link();
	echo '<div id="dolly-content">';
	Dolly_Frontend::render_view();
	echo '</div>';
} else {
	get_template_part( 'template-parts/plugin-missing' );
}
?>
<?php wp_footer(); ?>
</body>
</html>
