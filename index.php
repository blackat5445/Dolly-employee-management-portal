<?php
/**
 * Posts, pages, archives, search results and 404. The portal views (sign-in, employee portal, workplace
 * display) use the templates in /dolly instead.
 *
 * With the plugin active the front page is redirected to the portal; when that redirect is disabled
 * (filter dolly_redirect_front_page) and the front page shows the latest posts, it shows a welcome card
 * with links to both sign-in pages.
 *
 * @package DollyPortal
 */

defined( 'ABSPATH' ) || exit;

get_header();

if ( dolly_portal_plugin_active() && is_front_page() && is_home() ) {
	Dolly_Frontend::render_welcome();
	get_footer();
	return;
}
?>
<div class="dp-wrap">
	<?php if ( is_home() && ! is_front_page() ) : ?>
		<header class="dp-page-header"><h1 class="dp-page-title"><?php single_post_title(); ?></h1></header>
	<?php elseif ( is_archive() ) : ?>
		<header class="dp-page-header">
			<?php the_archive_title( '<h1 class="dp-page-title">', '</h1>' ); ?>
			<?php the_archive_description( '<div class="dp-archive-description">', '</div>' ); ?>
		</header>
	<?php elseif ( is_search() ) : ?>
		<header class="dp-page-header">
			<h1 class="dp-page-title">
				<?php
				/* translators: %s: search terms. */
				printf( esc_html__( 'Search results for: %s', 'dolly-portal' ), '<span>' . esc_html( get_search_query() ) . '</span>' );
				?>
			</h1>
		</header>
	<?php endif; ?>

	<?php if ( have_posts() ) : ?>
		<?php
		while ( have_posts() ) :
			the_post();
			?>
			<article id="post-<?php the_ID(); ?>" <?php post_class( 'dp-entry' ); ?>>
				<header class="dp-entry__header">
					<?php
					if ( is_singular() ) {
						the_title( '<h1 class="dp-entry__title">', '</h1>' );
					} else {
						the_title( '<h2 class="dp-entry__title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
					}
					?>
					<?php if ( 'post' === get_post_type() ) : ?>
						<p class="dp-entry__meta">
							<time datetime="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
							<span class="dp-entry__author">
								<?php
								/* translators: %s: author name. */
								printf( esc_html__( 'by %s', 'dolly-portal' ), esc_html( get_the_author() ) );
								?>
							</span>
							<?php if ( is_sticky() && ! is_singular() ) : ?>
								<span class="dp-entry__sticky"><?php esc_html_e( 'Featured', 'dolly-portal' ); ?></span>
							<?php endif; ?>
						</p>
					<?php endif; ?>
				</header>

				<?php if ( has_post_thumbnail() && ! post_password_required() ) : ?>
					<figure class="dp-entry__thumbnail"><?php the_post_thumbnail( 'large' ); ?></figure>
				<?php endif; ?>

				<div class="dp-entry__content">
					<?php
					if ( is_singular() ) {
						the_content();
						wp_link_pages(
							array(
								'before' => '<nav class="dp-page-links" aria-label="' . esc_attr__( 'Page', 'dolly-portal' ) . '">' . esc_html__( 'Pages:', 'dolly-portal' ),
								'after'  => '</nav>',
							)
						);
					} else {
						the_excerpt();
					}
					?>
				</div>

				<?php if ( is_singular( 'post' ) ) : ?>
					<footer class="dp-entry__footer">
						<?php if ( has_category() ) : ?>
							<p><?php esc_html_e( 'Categories:', 'dolly-portal' ); ?> <?php the_category( ', ' ); ?></p>
						<?php endif; ?>
						<?php the_tags( '<p>' . esc_html__( 'Tags:', 'dolly-portal' ) . ' ', ', ', '</p>' ); ?>
					</footer>
				<?php endif; ?>
			</article>

			<?php
			if ( is_singular( 'post' ) ) {
				the_post_navigation(
					array(
						'prev_text' => '<span class="dp-nav-label">' . esc_html__( 'Previous', 'dolly-portal' ) . '</span> %title',
						'next_text' => '<span class="dp-nav-label">' . esc_html__( 'Next', 'dolly-portal' ) . '</span> %title',
					)
				);
			}
			if ( is_singular() && ( comments_open() || get_comments_number() ) ) {
				comments_template();
			}
		endwhile;

		the_posts_pagination();
		?>
	<?php else : ?>
		<section class="dp-entry dp-empty">
			<h1 class="dp-entry__title"><?php is_404() ? esc_html_e( 'Page not found', 'dolly-portal' ) : esc_html_e( 'Nothing found', 'dolly-portal' ); ?></h1>
			<p><?php is_search() ? esc_html_e( 'No results match your search. Try different words.', 'dolly-portal' ) : esc_html_e( 'The page you are looking for is not available. Try a search.', 'dolly-portal' ); ?></p>
			<?php get_search_form(); ?>
		</section>
	<?php endif; ?>
</div>
<?php
get_footer();
