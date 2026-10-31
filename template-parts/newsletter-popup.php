<?php
/**
 * "Subscribe for Updates!" popup. Opened by main.js after a delay, once per visitor.
 *
 * @package eventsinsider
 */

if ( ! get_theme_mod( 'ei_popup_enabled', true ) ) {
	return;
}
?>
<div class="nl-popup" id="nl-popup" hidden>
	<div class="nl-popup__backdrop" data-popup-close></div>
	<div class="nl-popup__frame" role="dialog" aria-modal="true" aria-labelledby="nl-popup-title" style="background-image:url('<?php echo esc_url( ei_img( 'popup-bg.jpg' ) ); ?>')">
		<button class="nl-popup__close" type="button" data-popup-close>
			<span class="screen-reader-text"><?php esc_html_e( 'Close', 'eventsinsider' ); ?></span>
			<?php echo ei_icon( 'close', 36 ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
		</button>
		<div class="nl-popup__card">
			<h2 class="nl-popup__title" id="nl-popup-title"><?php echo esc_html( ei_mod( 'popup_title' ) ); ?></h2>
			<p class="nl-popup__text"><?php echo esc_html( ei_mod( 'popup_text' ) ); ?></p>
			<?php ei_newsletter_form( 'popup' ); ?>
		</div>
	</div>
</div>
