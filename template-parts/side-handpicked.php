<?php
/**
 * Sidebar: "Hand-Picked Events".
 *
 * @package eventsinsider
 */

$ei_pick = ei_handpicked_post();
if ( ! $ei_pick ) {
	return;
}
?>
<section class="side-block">
	<h2 class="side-title"><?php esc_html_e( 'Hand-Picked Events', 'eventsinsider' ); ?></h2>
	<div class="side-card">
		<a class="side-card__media" href="<?php echo esc_url( get_permalink( $ei_pick ) ); ?>" tabindex="-1" aria-hidden="true">
			<?php
			if ( has_post_thumbnail( $ei_pick ) ) {
				echo get_the_post_thumbnail( $ei_pick, 'ei-side', array( 'alt' => '', 'sizes' => '(max-width: 960px) 100vw, 301px' ) );
			} else {
				echo '<img src="' . esc_url( ei_img( 'about-card.jpg' ) ) . '" alt="" loading="lazy">';
			}
			?>
		</a>
		<h3 class="side-card__title"><a href="<?php echo esc_url( get_permalink( $ei_pick ) ); ?>"><?php echo wp_kses_post( ei_display_title( $ei_pick ) ); ?></a></h3>
		<div class="side-card__text">
			<p><?php echo esc_html( wp_trim_words( get_the_excerpt( $ei_pick ), 70 ) ); ?></p>
		</div>
		<?php ei_social_icons( 'social side-card__social' ); ?>
	</div>
</section>
