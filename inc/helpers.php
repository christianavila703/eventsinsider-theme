<?php
/**
 * Data helpers: ratings, venue fields, theme images.
 *
 * @package eventsinsider
 */

defined( 'ABSPATH' ) || exit;

/**
 * Cache-busting version for a theme file.
 *
 * @param string $rel Path relative to the theme root.
 * @return string
 */
function ei_asset_version( $rel ) {
	$file = EI_DIR . '/' . $rel;
	return file_exists( $file ) ? EI_VERSION . '.' . filemtime( $file ) : EI_VERSION;
}

/**
 * URL of an image bundled with the theme.
 *
 * @param string $name File name inside assets/img.
 * @return string
 */
function ei_img( $name ) {
	return EI_URI . '/assets/img/' . $name;
}

/**
 * Cards per page for article grids.
 *
 * @return int
 */
function ei_grid_per_page() {
	return absint( get_theme_mod( 'ei_grid_per_page', 6 ) ) ?: 6;
}

/**
 * Rating pattern used in existing titles, e.g. "(4.5 stars)", "(5 stars PLUS)", "(3 Stars)".
 */
const EI_RATING_PATTERN = '/\s*\(\s*(\d(?:\.\d)?)\s*stars?(\s*plus)?\s*\)\s*$/i';

/**
 * Star rating for a post, read from its title. Returns null when the title has no rating.
 *
 * @param int|WP_Post|null $post Post.
 * @return float|null
 */
function ei_rating( $post = null ) {
	$title = get_the_title( $post );
	if ( preg_match( EI_RATING_PATTERN, html_entity_decode( $title ), $m ) ) {
		return min( 5, (float) $m[1] );
	}
	return null;
}

/**
 * Title without the trailing "(N stars)" note, since the stars are drawn separately.
 *
 * @param int|WP_Post|null $post Post.
 * @return string Escaped-safe title HTML (as returned by get_the_title).
 */
function ei_display_title( $post = null ) {
	$title   = get_the_title( $post );
	$cleaned = preg_replace( EI_RATING_PATTERN, '', $title );
	return '' !== trim( (string) $cleaned ) ? $cleaned : $title;
}

/**
 * Read a custom field. Uses ACF when active (it formats values), plain post meta otherwise.
 *
 * @param string $key     Field name.
 * @param int    $post_id Post ID.
 * @return mixed
 */
function ei_field( $key, $post_id = 0 ) {
	$post_id = $post_id ?: get_the_ID();
	if ( function_exists( 'get_field' ) ) {
		return get_field( $key, $post_id );
	}
	return get_post_meta( $post_id, $key, true );
}

/**
 * Venue line, e.g. "Mystic Seaport, Mystic". Built from the ACF fields the old theme used.
 *
 * @param int $post_id Post ID.
 * @return string Plain text.
 */
function ei_venue( $post_id = 0 ) {
	$parts = array();
	$name  = trim( wp_strip_all_tags( (string) ei_field( 'venue_name', $post_id ) ) );
	$city  = trim( wp_strip_all_tags( (string) ei_field( 'event_city', $post_id ) ) );
	if ( $name ) {
		$parts[] = $name;
	}
	if ( $city && false === stripos( $name, $city ) ) {
		$parts[] = $city;
	}
	if ( ! $parts ) {
		$map = ei_field( 'venue_address', $post_id );
		if ( is_array( $map ) && ! empty( $map['address'] ) ) {
			$parts[] = implode( ',', array_slice( explode( ',', $map['address'] ), 0, 2 ) );
		}
	}
	return implode( ', ', $parts );
}

/**
 * Google Maps link for the venue, if the post has coordinates or an address.
 *
 * @param int $post_id Post ID.
 * @return string URL or empty string.
 */
function ei_venue_map_url( $post_id = 0 ) {
	$map = ei_field( 'venue_address', $post_id );
	if ( is_array( $map ) && ! empty( $map['lat'] ) && ! empty( $map['lng'] ) ) {
		return 'https://www.google.com/maps/search/?api=1&query=' . rawurlencode( $map['lat'] . ',' . $map['lng'] );
	}
	if ( is_array( $map ) && ! empty( $map['address'] ) ) {
		return 'https://www.google.com/maps/search/?api=1&query=' . rawurlencode( $map['address'] );
	}
	return '';
}

/**
 * Display date: the event start date for "events" posts, the publish date otherwise.
 *
 * @param int $post_id Post ID.
 * @return string
 */
function ei_display_date( $post_id = 0 ) {
	$post_id = $post_id ?: get_the_ID();
	$start   = ei_field( 'start_date', $post_id );
	if ( $start ) {
		$ts = is_numeric( $start ) && strlen( (string) $start ) === 8 ? strtotime( $start ) : strtotime( (string) $start );
		if ( $ts ) {
			return date_i18n( get_option( 'date_format' ), $ts );
		}
	}
	return get_the_date( '', $post_id );
}

/**
 * The post shown in the "Hand-Picked Events" box: the Customizer choice, else the newest sticky post, else the newest post with an image.
 *
 * @return WP_Post|null
 */
function ei_handpicked_post() {
	$id = absint( get_theme_mod( 'ei_handpicked_post', 0 ) );
	if ( $id && 'publish' === get_post_status( $id ) ) {
		return get_post( $id );
	}
	$sticky = get_option( 'sticky_posts' );
	$args   = array(
		'posts_per_page'      => 1,
		'ignore_sticky_posts' => true,
		'no_found_rows'       => true,
	);
	if ( $sticky ) {
		$args['post__in'] = $sticky;
	} else {
		$args['meta_key'] = '_thumbnail_id'; // phpcs:ignore WordPress.DB.SlowDBQuery
	}
	$posts = get_posts( $args );
	return $posts ? $posts[0] : null;
}

/**
 * Configured social profiles, in display order.
 *
 * @return array<string,string> network => URL
 */
function ei_social_links() {
	$links = array();
	foreach ( array( 'instagram', 'facebook', 'twitter', 'youtube', 'tiktok' ) as $network ) {
		$url = get_theme_mod( 'ei_social_' . $network, ei_social_default( $network ) );
		if ( $url ) {
			$links[ $network ] = $url;
		}
	}
	return $links;
}

/**
 * Defaults taken from the previous theme's header links.
 *
 * @param string $network Network key.
 * @return string
 */
function ei_social_default( $network ) {
	$defaults = array(
		'facebook'  => 'https://www.facebook.com/groups/102947671077/',
		'twitter'   => 'https://twitter.com/oddbostonevents',
	);
	return $defaults[ $network ] ?? '';
}

/**
 * Link for "View all" / "More" buttons: the posts page if set, else the site home.
 *
 * @return string
 */
function ei_posts_page_url() {
	$page_for_posts = (int) get_option( 'page_for_posts' );
	return $page_for_posts ? get_permalink( $page_for_posts ) : home_url( '/' );
}
