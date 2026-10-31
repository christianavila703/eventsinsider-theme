<?php
/**
 * Default page.
 *
 * @package eventsinsider
 */

get_header();

while ( have_posts() ) :
	the_post();
	?>
	<div class="page-body page-body--decor page-body--top">
		<div class="container">
			<h1 class="page-title"><?php the_title(); ?></h1>
			<div class="layout">
				<div class="layout__main">
					<?php if ( has_post_thumbnail() ) : ?>
						<figure class="page-thumb"><?php the_post_thumbnail( 'large' ); ?></figure>
					<?php endif; ?>
					<div class="content-card entry-content">
						<?php
						the_content();
						wp_link_pages( array( 'before' => '<nav class="page-links">', 'after' => '</nav>' ) );
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
		</div>
	</div>
	<?php
endwhile;

get_footer();
