<?php
/**
 * Right sidebar. Templates choose which design blocks appear via $args['blocks'].
 *
 * @package eventsinsider
 *
 * @var array $args { @type string[] $blocks handpicked|about|articles|instagram }
 */

$ei_blocks = $args['blocks'] ?? array( 'about', 'articles', 'instagram' );
?>
<aside class="sidebar" aria-label="<?php esc_attr_e( 'Sidebar', 'eventsinsider' ); ?>">
	<?php
	foreach ( $ei_blocks as $ei_block ) {
		get_template_part( 'template-parts/side', $ei_block );
	}
	?>
</aside>
