<?php
/**
 * Homepage: hero slider, article grid with sidebar, newsletter banner.
 *
 * @package eventsinsider
 */

get_header();

$ei_paged = max( 1, (int) get_query_var( 'paged' ), (int) get_query_var( 'page' ) );
$ei_grid  = new WP_Query(
	array(
		'post_type'      => 'post',
		'posts_per_page' => ei_grid_per_page(),
		'paged'          => $ei_paged,
	)
);
?>
<h1 class="screen-reader-text"><?php bloginfo( 'name' ); ?></h1>

<?php
if ( 1 === $ei_paged ) {
	get_template_part( 'template-parts/hero-slider' );
}
?>

<div class="page-body page-body--decor">
	<div class="container layout">
		<div class="layout__main">
			<?php get_template_part( 'template-parts/article-toolbar', null, array( 'title' => __( 'Article', 'eventsinsider' ), 'tag' => 'h2' ) ); ?>

			<?php
			if ( 1 === $ei_paged && 'page' === get_option( 'show_on_front' ) ) :
				while ( have_posts() ) :
					the_post();
					if ( '' !== trim( get_the_content() ) ) :
						?>
						<div class="content-card entry-content entry-content--intro"><?php the_content(); ?></div>
						<?php
					endif;
				endwhile;
			endif;
			?>

			<?php if ( $ei_grid->have_posts() ) : ?>
				<div class="card-grid" id="articles">
					<?php
					while ( $ei_grid->have_posts() ) :
						$ei_grid->the_post();
						get_template_part( 'template-parts/card' );
					endwhile;
					?>
				</div>
				<?php ei_pagination( $ei_grid ); ?>
				<?php wp_reset_postdata(); ?>
			<?php endif; ?>
		</div>

		<?php get_sidebar( null, array( 'blocks' => array( 'handpicked', 'instagram' ) ) ); ?>
	</div>

	<?php get_template_part( 'template-parts/newsletter-banner' ); ?>
</div>

<?php
get_footer();
