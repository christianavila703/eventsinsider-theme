<?php
/**
 * Not found.
 *
 * @package eventsinsider
 */

get_header();
?>
<div class="page-body page-body--decor page-body--top">
	<div class="container layout">
		<div class="layout__main">
			<h1 class="page-title"><?php esc_html_e( 'Page Not Found', 'eventsinsider' ); ?></h1>
			<div class="content-card entry-content">
				<p><?php esc_html_e( 'Sorry, we couldn’t find that page. Try searching for an event, venue or review:', 'eventsinsider' ); ?></p>
				<?php get_search_form(); ?>
				<p><a class="btn btn--brown" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Back to Home', 'eventsinsider' ); ?></a></p>
			</div>
		</div>
		<?php get_sidebar(); ?>
	</div>
</div>
<?php
get_footer();
