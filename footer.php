<?php
/**
 * Footer of the standard pages.
 *
 * @package DollyPortal
 */

defined( 'ABSPATH' ) || exit;
?>
</main>
<footer class="dp-footer">
	<div class="dp-wrap">
		<p>
			<?php
			/* translators: 1: year, 2: site name. */
			echo esc_html( sprintf( __( '© %1$s %2$s', 'dolly-portal' ), wp_date( 'Y' ), get_bloginfo( 'name' ) ) );
			?>
		</p>
	</div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
