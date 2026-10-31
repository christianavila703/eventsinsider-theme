<?php
/**
 * Search form.
 *
 * @package eventsinsider
 */

$ei_search_id = wp_unique_id( 'search-' );
?>
<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label class="screen-reader-text" for="<?php echo esc_attr( $ei_search_id ); ?>"><?php esc_html_e( 'Search for:', 'eventsinsider' ); ?></label>
	<input type="search" id="<?php echo esc_attr( $ei_search_id ); ?>" class="search-form__input" placeholder="<?php esc_attr_e( 'Search..', 'eventsinsider' ); ?>" value="<?php echo esc_attr( get_search_query() ); ?>" name="s">
	<button type="submit" class="search-form__btn">
		<span class="screen-reader-text"><?php esc_html_e( 'Search', 'eventsinsider' ); ?></span>
		<?php echo ei_icon( 'search', 21 ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
	</button>
</form>
