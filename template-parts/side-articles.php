<?php
/**
 * Sidebar: latest "Articles" list.
 *
 * @package eventsinsider
 */

$ei_latest = new WP_Query(
	array(
		'posts_per_page'      => 5,
		'ignore_sticky_posts' => true,
		'no_found_rows'       => true,
		'post__not_in'        => is_singular( 'post' ) ? array( get_the_ID() ) : array(),
	)
);
if ( ! $ei_latest->have_posts() ) {
	return;
}
?>
<section class="side-block">
	<h2 class="side-title"><?php esc_html_e( 'Articles', 'eventsinsider' ); ?></h2>
	<div class="side-card side-card--list">
		<ul class="side-list">
			<?php
			while ( $ei_latest->have_posts() ) :
				$ei_latest->the_post();
				?>
				<li class="side-list__item">
					<a class="side-list__title" href="<?php the_permalink(); ?>"><?php echo wp_kses_post( ei_display_title() ); ?></a>
					<ul class="meta-line meta-line--sm">
						<li><?php echo ei_icon( 'user', 20 ); // phpcs:ignore WordPress.Security.EscapeOutput ?><span><?php echo esc_html( sprintf( /* translators: %s: author */ __( 'By %s', 'eventsinsider' ), get_the_author() ) ); ?></span></li>
						<li><?php echo ei_icon( 'calendar', 20 ); // phpcs:ignore WordPress.Security.EscapeOutput ?><span><?php echo esc_html( get_the_date() ); ?></span></li>
					</ul>
				</li>
				<?php
			endwhile;
			wp_reset_postdata();
			?>
		</ul>
		<a class="link-blue" href="<?php echo esc_url( ei_posts_page_url() ); ?>"><?php esc_html_e( 'View More', 'eventsinsider' ); ?></a>
	</div>
</section>
