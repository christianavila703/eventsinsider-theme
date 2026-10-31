<?php
/**
 * Posts page, archives and search results: article grid with sidebar.
 *
 * @package eventsinsider
 */

get_header();

if ( is_home() ) {
	$ei_page_for_posts = (int) get_option( 'page_for_posts' );
	$ei_title          = $ei_page_for_posts ? get_the_title( $ei_page_for_posts ) : __( 'Articles', 'eventsinsider' );
} elseif ( is_search() ) {
	/* translators: %s: search terms */
	$ei_title = sprintf( __( 'Search: %s', 'eventsinsider' ), get_search_query() );
} elseif ( is_post_type_archive( 'events' ) ) {
	$ei_title = __( 'Events', 'eventsinsider' );
} else {
	$ei_title = wp_strip_all_tags( get_the_archive_title() );
}
?>

<div class="page-body page-body--decor page-body--top">
	<div class="container layout">
		<div class="layout__main">
			<?php get_template_part( 'template-parts/article-toolbar', null, array( 'title' => $ei_title ) ); ?>

			<?php
			$ei_intro = '';
			if ( is_home() && ! is_paged() && ! empty( $ei_page_for_posts ) ) {
				$ei_intro = apply_filters( 'the_content', get_post_field( 'post_content', $ei_page_for_posts ) );
			} elseif ( is_archive() && ! is_paged() ) {
				$ei_intro = get_the_archive_description();
			}
			if ( trim( wp_strip_all_tags( $ei_intro ) ) ) {
				echo '<div class="content-card entry-content entry-content--intro">' . wp_kses_post( $ei_intro ) . '</div>';
			}
			?>

			<?php if ( have_posts() ) : ?>
				<div class="card-grid">
					<?php
					while ( have_posts() ) :
						the_post();
						get_template_part( 'template-parts/card' );
					endwhile;
					?>
				</div>
				<?php ei_pagination(); ?>
			<?php else : ?>
				<div class="content-card entry-content">
					<p><?php is_search() ? esc_html_e( 'Nothing matched your search. Try different words.', 'eventsinsider' ) : esc_html_e( 'No articles found.', 'eventsinsider' ); ?></p>
				</div>
			<?php endif; ?>
		</div>

		<?php get_sidebar( null, array( 'blocks' => array( 'handpicked', 'instagram' ) ) ); ?>
	</div>

	<?php get_template_part( 'template-parts/newsletter-banner' ); ?>
</div>

<?php
get_footer();
