<?php
/**
 * Full-width "Be the First to Know" newsletter banner.
 *
 * @package eventsinsider
 */

?>
<section class="nl-banner-wrap container">
	<div class="nl-banner">
		<div class="nl-banner__content">
			<h2 class="nl-banner__title"><?php echo esc_html( ei_mod( 'newsletter_title' ) ); ?></h2>
			<p class="nl-banner__text"><?php echo esc_html( ei_mod( 'newsletter_text' ) ); ?></p>
			<?php ei_newsletter_form( 'banner' ); ?>
		</div>
		<div class="nl-banner__media" style="background-image:url('<?php echo esc_url( ei_img( 'newsletter.jpg' ) ); ?>')" aria-hidden="true"></div>
	</div>
</section>
