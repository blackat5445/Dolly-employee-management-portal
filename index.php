<?php
/**
 * Fallback template. The portal has no public content: visitors are redirected by the plugin to the
 * sign-in page or to the area matching their role. This page is shown only when that redirect is
 * disabled (filter dolly_redirect_front_page) or the plugin is inactive.
 *
 * @package DollyPortal
 */

defined( 'ABSPATH' ) || exit;
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="theme-color" content="<?php echo esc_attr( dolly_portal_theme_color() ); ?>">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<?php if ( ! dolly_portal_plugin_active() ) : ?>
	<?php get_template_part( 'template-parts/plugin-missing' ); ?>
<?php else : ?>
	<?php Dolly_Frontend::skip_link(); ?>
	<div id="dolly-content">
		<?php if ( is_singular() && have_posts() ) : ?>
			<?php
			while ( have_posts() ) :
				the_post();
				?>
				<main class="dolly-app dolly-auth">
					<article class="dolly-card dolly-auth__card dp-content">
						<?php Dolly_Frontend::brand(); ?>
						<h1 class="dolly-auth__title"><?php the_title(); ?></h1>
						<?php the_content(); ?>
					</article>
				</main>
			<?php endwhile; ?>
		<?php else : ?>
			<?php Dolly_Frontend::render_welcome(); ?>
		<?php endif; ?>
	</div>
<?php endif; ?>
<?php wp_footer(); ?>
</body>
</html>
