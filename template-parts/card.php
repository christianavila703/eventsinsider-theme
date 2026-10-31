<?php
/**
 * Article card used in the grids.
 *
 * @package eventsinsider
 */

$ei_rating = ei_rating();
?>
<article <?php post_class( 'card' ); ?>>
	<a class="card__media" href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true">
		<?php if ( has_post_thumbnail() ) : ?>
			<?php the_post_thumbnail( 'ei-card', array( 'alt' => '', 'sizes' => '(max-width: 640px) 100vw, (max-width: 1200px) 50vw, 384px' ) ); ?>
		<?php else : ?>
			<img src="<?php echo esc_url( ei_img( 'hero-fallback.jpg' ) ); ?>" alt="" loading="lazy">
		<?php endif; ?>
	</a>
	<div class="card__body">
		<h3 class="card__title"><a href="<?php the_permalink(); ?>"><?php echo wp_kses_post( ei_display_title() ); ?></a></h3>
		<?php ei_stars( $ei_rating, 'card__stars' ); ?>
	</div>
</article>
