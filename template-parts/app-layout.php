<?php
/**
 * Layout for the application views (login, password recovery, employee portal, workplace display).
 * The content itself is rendered by the Dolly Employee Management plugin.
 *
 * @package DollyPortal
 */

defined( 'ABSPATH' ) || exit;

$dolly_view = dolly_portal_plugin_active() ? MEM_Frontend::current_view() : '';
$dolly_skip = in_array( $dolly_view, array( 'portale' ), true ) ? '#mem-main' : '#mp-content';
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
	<meta name="theme-color" content="#002F4D">
	<meta name="format-detection" content="telephone=no">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="mp-skip-link" href="<?php echo esc_attr( $dolly_skip ); ?>">Vai al contenuto</a>
<div id="mp-content">
	<?php
	if ( dolly_portal_plugin_active() ) {
		MEM_Frontend::render_view();
	} else {
		get_template_part( 'template-parts/plugin-missing' );
	}
	?>
</div>
<?php wp_footer(); ?>
</body>
</html>
