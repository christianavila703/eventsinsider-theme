<?php
/**
 * Section heading with the filter tabs and search box, above article grids.
 *
 * @package eventsinsider
 *
 * @var array $args { @type string $title Heading text. @type string $tag Heading tag. }
 */

$ei_title = $args['title'] ?? __( 'Article', 'eventsinsider' );
$ei_tag   = $args['tag'] ?? 'h1';
?>
<div class="article-toolbar">
	<<?php echo tag_escape( $ei_tag ); ?> class="section-title"><?php echo esc_html( $ei_title ); ?></<?php echo tag_escape( $ei_tag ); ?>>
	<div class="article-toolbar__row">
		<nav class="tabs" aria-label="<?php esc_attr_e( 'Article topics', 'eventsinsider' ); ?>">
			<?php ei_menu( 'article-tabs', 'tabs__list' ); ?>
			<a class="tabs__more" href="<?php echo esc_url( ei_posts_page_url() ); ?>"><?php esc_html_e( 'More', 'eventsinsider' ); ?></a>
		</nav>
		<?php get_search_form(); ?>
	</div>
</div>
