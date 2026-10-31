<?php
/**
 * Single article / event.
 *
 * @package eventsinsider
 */

get_header();

while ( have_posts() ) :
	the_post();
	$ei_rating = ei_rating();
	?>
	<div class="page-body page-body--decor page-body--top">
		<article <?php post_class( 'container single' ); ?>>
			<h1 class="page-title"><?php echo wp_kses_post( ei_display_title() ); ?></h1>

			<?php if ( has_post_thumbnail() ) : ?>
				<figure class="single__hero">
					<?php the_post_thumbnail( 'full', array( 'sizes' => '(max-width: 1240px) 100vw, 1200px', 'fetchpriority' => 'high', 'loading' => 'eager' ) ); ?>
				</figure>
			<?php endif; ?>

			<div class="layout">
				<div class="layout__main">
					<div class="content-card single__card">
						<header class="single__meta">
							<div class="single__meta-info">
								<p class="single__author"><?php echo esc_html( sprintf( /* translators: %s: author */ __( 'By %s', 'eventsinsider' ), get_the_author() ) ); ?></p>
								<?php ei_date_venue( 0, true ); ?>
							</div>
							<?php ei_stars( $ei_rating, 'single__stars' ); ?>
						</header>

						<div class="entry-content">
							<?php
							the_content();
							wp_link_pages( array( 'before' => '<nav class="page-links">', 'after' => '</nav>' ) );
							?>
						</div>

						<?php
						$ei_tags = get_the_tag_list( '<ul class="tag-list"><li>', '</li><li>', '</li></ul>' );
						if ( $ei_tags && ! is_wp_error( $ei_tags ) ) {
							echo wp_kses_post( $ei_tags );
						}
						?>
					</div>

					<?php
					if ( comments_open() || get_comments_number() ) {
						comments_template();
					}
					?>
				</div>

				<?php get_sidebar(); ?>
			</div>
		</article>
	</div>
	<?php
endwhile;

get_footer();
