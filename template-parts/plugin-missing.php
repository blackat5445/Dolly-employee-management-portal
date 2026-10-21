<?php
/**
 * Shown when the application plugin is not active. The plugin's styles are not available here,
 * so this page uses the theme's own fallback styles (style.css).
 *
 * @package DollyPortal
 */

defined( 'ABSPATH' ) || exit;
?>
<a class="dp-skip-link" href="#dp-content"><?php esc_html_e( 'Skip to content', 'dolly-portal' ); ?></a>
<main class="dp-page" id="dp-content">
	<div class="dp-card">
		<h1><?php esc_html_e( 'Employee portal unavailable', 'dolly-portal' ); ?></h1>
		<p><?php esc_html_e( 'The portal is under maintenance. Try again later or contact your administrator.', 'dolly-portal' ); ?></p>
		<?php if ( current_user_can( 'install_plugins' ) ) : ?>
			<p class="dp-admin-note"><strong><?php esc_html_e( 'Administrator:', 'dolly-portal' ); ?></strong> <?php echo esc_html( dolly_portal_plugin_message( 'missing' ) ); ?></p>
		<?php endif; ?>
	</div>
</main>
