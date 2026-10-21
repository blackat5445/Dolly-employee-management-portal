<?php
/**
 * Header of the standard pages (posts, pages, archives). The portal views use template-parts/app-layout.php.
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
<a class="skip-link screen-reader-text" href="#dp-main"><?php esc_html_e( 'Skip to content', 'dolly-portal' ); ?></a>
<header class="dp-header">
	<div class="dp-wrap dp-header__inner">
		<div class="dp-branding">
			<?php if ( is_front_page() && is_home() ) : ?>
				<h1 class="dp-site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
			<?php else : ?>
				<p class="dp-site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
			<?php endif; ?>
			<?php if ( get_bloginfo( 'description' ) ) : ?>
				<p class="dp-site-description"><?php bloginfo( 'description' ); ?></p>
			<?php endif; ?>
		</div>
		<?php if ( has_nav_menu( 'primary' ) ) : ?>
			<nav class="dp-nav" aria-label="<?php esc_attr_e( 'Primary menu', 'dolly-portal' ); ?>">
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'primary',
						'container'      => false,
						'depth'          => 2,
					)
				);
				?>
			</nav>
		<?php endif; ?>
	</div>
</header>
<main id="dp-main" class="dp-main" tabindex="-1">
