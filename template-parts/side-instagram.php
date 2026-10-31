<?php
/**
 * Sidebar: "On Instagram". A feed plugin shortcode set in the Customizer replaces the static card.
 *
 * @package eventsinsider
 */

$ei_ig_url  = get_theme_mod( 'ei_social_instagram', ei_social_default( 'instagram' ) );
$ei_ig_img  = absint( get_theme_mod( 'ei_instagram_image' ) );
$ei_ig_feed = trim( (string) get_theme_mod( 'ei_instagram_shortcode', '' ) );
?>
<section class="side-block">
	<h2 class="side-title"><?php esc_html_e( 'On Instagram', 'eventsinsider' ); ?></h2>
	<?php if ( $ei_ig_feed ) : ?>
		<div class="ig-feed"><?php echo do_shortcode( wp_kses_post( $ei_ig_feed ) ); ?></div>
	<?php else : ?>
		<?php echo $ei_ig_url ? '<a class="ig-card" href="' . esc_url( $ei_ig_url ) . '" target="_blank" rel="noopener">' : '<div class="ig-card">'; // phpcs:ignore WordPress.Security.EscapeOutput ?>
			<?php
			if ( $ei_ig_img ) {
				echo wp_get_attachment_image( $ei_ig_img, 'large', false, array( 'class' => 'ig-card__img', 'alt' => '' ) );
			} else {
				echo '<img class="ig-card__img" src="' . esc_url( ei_img( 'instagram-sample.jpg' ) ) . '" alt="" loading="lazy">';
			}
			?>
			<span class="ig-card__top"><?php echo ei_icon( 'instagram', 24 ); // phpcs:ignore WordPress.Security.EscapeOutput ?> Instagram</span>
			<span class="ig-card__bottom"><?php echo esc_html( ei_mod( 'instagram_caption' ) ); ?></span>
		<?php echo $ei_ig_url ? '</a>' : '</div>'; ?>
	<?php endif; ?>
</section>
