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
		<?php if ( current_user_can( 'activate_plugins' ) ) : ?>
			<p><a class="dp-button" href="<?php echo esc_url( admin_url( 'plugins.php' ) ); ?>"><?php esc_html_e( 'Activate the Dolly Employee Management plugin', 'dolly-portal' ); ?></a></p>
		<?php endif; ?>
	</div>
</main>
