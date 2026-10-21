/**
 * Dolly Portal: remembers the dismissal of the plugin notice (WordPress only hides it for this page view).
 */
document.addEventListener(
	'click',
	function (e) {
		var btn = e.target.closest && e.target.closest( '[data-dolly-portal-notice] .notice-dismiss' );
		if ( ! btn || ! window.ajaxurl) {
			return;
		}
		var notice = btn.closest( '[data-dolly-portal-notice]' );
		var data   = new FormData();
		data.append( 'action', 'dolly_portal_dismiss_notice' );
		data.append( 'status', notice.getAttribute( 'data-dolly-portal-notice' ) );
		data.append( '_ajax_nonce', notice.getAttribute( 'data-nonce' ) );
		fetch( window.ajaxurl, { method: 'POST', body: data, credentials: 'same-origin' } );
	}
);
