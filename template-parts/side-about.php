<?php
/**
 * Sidebar: "What is Events Insider?".
 *
 * @package eventsinsider
 */

$ei_img_id = absint( get_theme_mod( 'ei_about_box_image' ) );
?>
<section class="side-block">
	<h2 class="side-title"><?php echo esc_html( ei_mod( 'about_box_title' ) ); ?></h2>
	<div class="side-card">
		<div class="side-card__media">
			<?php
			if ( $ei_img_id ) {
				echo wp_get_attachment_image( $ei_img_id, 'ei-side', false, array( 'alt' => '' ) );
			} else {
				echo '<img src="' . esc_url( ei_img( 'about-card.jpg' ) ) . '" alt="" loading="lazy" width="640" height="426">';
			}
			?>
		</div>
		<h3 class="side-card__title side-card__title--lead"><?php echo esc_html( ei_mod( 'about_box_lead' ) ); ?></h3>
		<div class="side-card__text"><?php echo wp_kses_post( wpautop( esc_html( ei_mod( 'about_box_text' ) ) ) ); ?></div>
		<?php ei_social_icons( 'social side-card__social' ); ?>
	</div>
</section>
