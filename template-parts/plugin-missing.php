<?php
/**
 * Shown when the application plugin is not active.
 *
 * @package DollyPortal
 */

defined( 'ABSPATH' ) || exit;
?>
<main class="mp-page">
	<div class="mp-page__card">
		<p class="mp-wordmark">Dolly</p>
		<h1>Portale dipendenti non disponibile</h1>
		<p>Il portale è in manutenzione. Riprova più tardi o contatta l'amministratore.</p>
		<?php if ( current_user_can( 'activate_plugins' ) ) : ?>
			<p><a class="mp-button" href="<?php echo esc_url( admin_url( 'plugins.php' ) ); ?>">Attiva il plugin Dolly Employee Management</a></p>
		<?php endif; ?>
	</div>
</main>
