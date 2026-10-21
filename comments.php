<?php
/**
 * Comments of a post or page.
 *
 * @package DollyPortal
 */

defined( 'ABSPATH' ) || exit;

if ( post_password_required() ) {
	return;
}
?>
<section id="comments" class="dp-comments">
	<?php if ( have_comments() ) : ?>
		<h2 class="dp-comments__title">
			<?php
			$dolly_portal_count = get_comments_number();
			/* translators: %s: number of comments. */
			printf( esc_html( _n( '%s comment', '%s comments', $dolly_portal_count, 'dolly-portal' ) ), esc_html( number_format_i18n( $dolly_portal_count ) ) );
			?>
		</h2>
		<ol class="dp-comment-list">
			<?php
			wp_list_comments(
				array(
					'style'       => 'ol',
					'short_ping'  => true,
					'avatar_size' => 48,
				)
			);
			?>
		</ol>
		<?php the_comments_navigation(); ?>
		<?php if ( ! comments_open() ) : ?>
			<p class="dp-comments__closed"><?php esc_html_e( 'Comments are closed.', 'dolly-portal' ); ?></p>
		<?php endif; ?>
	<?php endif; ?>
	<?php comment_form(); ?>
</section>
