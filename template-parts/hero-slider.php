<?php
/**
 * "This Week" hero slider on the homepage.
 *
 * @package eventsinsider
 */

$ei_hero_args = array(
	'posts_per_page'      => 3,
	'ignore_sticky_posts' => true,
	'no_found_rows'       => true,
	'meta_key'            => '_thumbnail_id', // phpcs:ignore WordPress.DB.SlowDBQuery
);
$ei_sticky    = get_option( 'sticky_posts' );
if ( 'sticky' === get_theme_mod( 'ei_hero_source', 'latest' ) && $ei_sticky ) {
	$ei_hero_args['post__in'] = $ei_sticky;
}
$ei_hero = new WP_Query( $ei_hero_args );
if ( ! $ei_hero->have_posts() ) {
	return;
}
?>
<section class="hero" aria-roledescription="carousel" aria-label="<?php esc_attr_e( 'Featured this week', 'eventsinsider' ); ?>">
	<div class="hero__track">
		<?php
		$ei_i = 0;
		while ( $ei_hero->have_posts() ) :
			$ei_hero->the_post();
			?>
			<div class="hero__slide<?php echo 0 === $ei_i ? ' is-active' : ''; ?>" role="group" aria-roledescription="slide" <?php echo 0 === $ei_i ? '' : 'aria-hidden="true"'; ?>>
				<?php
				the_post_thumbnail(
					'ei-hero',
					array(
						'class'         => 'hero__img',
						'alt'           => '',
						'sizes'         => '100vw',
						'loading'       => 0 === $ei_i ? 'eager' : 'lazy',
						'fetchpriority' => 0 === $ei_i ? 'high' : 'auto',
					)
				);
				?>
				<div class="container hero__inner">
					<div class="hero__card">
						<p class="hero__label"><?php echo esc_html( ei_mod( 'hero_label' ) ); ?></p>
						<h2 class="hero__title"><a href="<?php the_permalink(); ?>"><?php echo wp_kses_post( ei_display_title() ); ?></a></h2>
						<?php ei_date_venue(); ?>
					</div>
				</div>
			</div>
			<?php
			++$ei_i;
		endwhile;
		wp_reset_postdata();
		?>
	</div>
	<?php if ( $ei_i > 1 ) : ?>
		<div class="hero__dots">
			<?php for ( $ei_d = 0; $ei_d < $ei_i; $ei_d++ ) : ?>
				<?php /* translators: %d: slide number */ ?>
				<button type="button" class="hero__dot<?php echo 0 === $ei_d ? ' is-active' : ''; ?>" aria-label="<?php echo esc_attr( sprintf( __( 'Show slide %d', 'eventsinsider' ), $ei_d + 1 ) ); ?>"></button>
			<?php endfor; ?>
		</div>
	<?php endif; ?>
</section>
