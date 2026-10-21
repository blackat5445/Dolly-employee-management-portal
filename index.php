<?php
/**
 * Fallback template. The portal has no public content: visitors are redirected by the plugin
 * to the login page or to the area matching their role. This page is shown only when that
 * redirect is disabled or the plugin is inactive.
 *
 * @package DollyPortal
 */

defined( 'ABSPATH' ) || exit;
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="theme-color" content="#002F4D">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="mp-skip-link" href="#mp-content">Vai al contenuto</a>
<?php if ( ! dolly_portal_plugin_active() ) : ?>
	<div id="mp-content"><?php get_template_part( 'template-parts/plugin-missing' ); ?></div>
<?php else : ?>
	<main class="mp-page" id="mp-content">
		<div class="mp-page__card">
			<p class="mp-wordmark">Dolly</p>
			<?php if ( have_posts() && ( is_singular() ) ) : ?>
				<?php
				while ( have_posts() ) :
					the_post();
					?>
					<h1><?php the_title(); ?></h1>
					<?php the_content(); ?>
				<?php endwhile; ?>
			<?php else : ?>
				<h1>Portale dipendenti</h1>
				<p>Accedi per timbrare, consultare le presenze e inviare richieste.</p>
			<?php endif; ?>
			<p>
				<a class="mp-button" href="<?php echo esc_url( home_url( '/accesso/' ) ); ?>">Accesso dipendenti</a>
				<a href="<?php echo esc_url( home_url( '/accesso-sede/' ) ); ?>" style="margin-left:16px">Accesso sede</a>
			</p>
		</div>
	</main>
<?php endif; ?>
<?php wp_footer(); ?>
</body>
</html>
