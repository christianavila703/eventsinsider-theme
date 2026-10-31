<?php
/**
 * Small rendering helpers used across templates.
 *
 * @package eventsinsider
 */

defined( 'ABSPATH' ) || exit;

/**
 * Site logo: the Customizer logo if set, otherwise the bundled one.
 *
 * @param string $class Extra class for the link.
 */
function ei_logo( $class = '' ) {
	$name = get_bloginfo( 'name' );
	echo '<a class="logo ' . esc_attr( $class ) . '" href="' . esc_url( home_url( '/' ) ) . '" rel="home">';
	$logo_id = get_theme_mod( 'custom_logo' );
	if ( $logo_id ) {
		echo wp_get_attachment_image( $logo_id, 'medium', false, array( 'alt' => $name, 'class' => 'logo-img' ) );
	} else {
		echo '<img class="logo-img" src="' . esc_url( ei_img( 'logo.png' ) ) . '" width="420" height="212" alt="' . esc_attr( $name ) . '">';
	}
	echo '</a>';
}

/**
 * Five-star rating. Partial stars are drawn with a clipped overlay.
 *
 * @param float|null $rating 0–5, or null to print nothing.
 * @param string     $class  Extra class.
 */
function ei_stars( $rating, $class = '' ) {
	if ( null === $rating ) {
		return;
	}
	/* translators: %s: rating out of 5 */
	$label = sprintf( __( 'Rated %s out of 5', 'eventsinsider' ), number_format_i18n( $rating, floor( $rating ) == $rating ? 0 : 1 ) );
	echo '<div class="stars ' . esc_attr( $class ) . '" role="img" aria-label="' . esc_attr( $label ) . '">';
	for ( $i = 1; $i <= 5; $i++ ) {
		$fill = max( 0, min( 1, $rating - ( $i - 1 ) ) );
		echo '<span class="star" style="--fill:' . esc_attr( round( $fill * 100 ) ) . '%">' . ei_icon( 'star', 32 ) . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput
	}
	echo '</div>';
}

/**
 * Date + venue line (calendar and pin icons), as in the hero and article header.
 *
 * @param int  $post_id   Post ID.
 * @param bool $with_link Link the venue to Google Maps.
 */
function ei_date_venue( $post_id = 0, $with_link = false ) {
	$post_id = $post_id ?: get_the_ID();
	$venue   = ei_venue( $post_id );
	echo '<ul class="meta-line">';
	echo '<li>' . ei_icon( 'calendar' ) . '<span>' . esc_html( ei_display_date( $post_id ) ) . '</span></li>'; // phpcs:ignore WordPress.Security.EscapeOutput
	if ( $venue ) {
		$map = $with_link ? ei_venue_map_url( $post_id ) : '';
		echo '<li>' . ei_icon( 'map-pin' ); // phpcs:ignore WordPress.Security.EscapeOutput
		if ( $map ) {
			echo '<a href="' . esc_url( $map ) . '" target="_blank" rel="noopener">' . esc_html( $venue ) . '</a>';
		} else {
			echo '<span>' . esc_html( $venue ) . '</span>';
		}
		echo '</li>';
	}
	echo '</ul>';
}

/**
 * Pagination. Uses WP-PageNavi when active (it was used by the previous theme), core links otherwise.
 * Both are styled the same way by .pagination.
 *
 * @param WP_Query|null $query Custom query, or null for the main query.
 */
function ei_pagination( $query = null ) {
	global $wp_query;
	$q = $query ?: $wp_query;
	if ( $q->max_num_pages < 2 ) {
		return;
	}
	echo '<nav class="pagination" aria-label="' . esc_attr__( 'Articles pages', 'eventsinsider' ) . '">';
	if ( function_exists( 'wp_pagenavi' ) ) {
		wp_pagenavi(
			array(
				'query'   => $q,
				'options' => array(
					'prev_text'                    => __( 'Previous', 'eventsinsider' ),
					'next_text'                    => __( 'Next', 'eventsinsider' ),
					'first_text'                   => '',
					'last_text'                    => '',
					'dotleft_text'                 => '…',
					'dotright_text'                => '…',
					'num_pages'                    => 5,
					'always_show'                  => false,
					'num_larger_page_numbers'      => 0,
					'larger_page_numbers_multiple' => 10,
					'pages_text'                   => '',
					'current_text'                 => '%PAGE_NUMBER%',
					'page_text'                    => '%PAGE_NUMBER%',
					'style'                        => 1,
					'use_pagenavi_css'             => false,
				),
			)
		);
	} else {
		$current = max( 1, (int) get_query_var( 'paged' ), (int) get_query_var( 'page' ) );
		echo '<div class="wp-pagenavi">';
		echo paginate_links( // phpcs:ignore WordPress.Security.EscapeOutput
			array(
				'total'     => $q->max_num_pages,
				'current'   => $current,
				'mid_size'  => 2,
				'end_size'  => 1,
				'prev_text' => __( 'Previous', 'eventsinsider' ),
				'next_text' => __( 'Next', 'eventsinsider' ),
			)
		);
		echo '</div>';
	}
	echo '</nav>';
}

/**
 * Link to a page by slug if it exists.
 *
 * @param string $slug Page slug.
 * @return string URL or empty.
 */
function ei_page_url( $slug ) {
	$page = get_page_by_path( $slug );
	return $page ? get_permalink( $page ) : '';
}

/**
 * Items shown when no menu is assigned to a location. Mirrors the design's labels and points at
 * pages that already exist on the site.
 *
 * @param string $location Menu location.
 * @return array<int,array{0:string,1:string}> [label, url]
 */
function ei_fallback_items( $location ) {
	$events = get_post_type_archive_link( 'events' );
	$items  = array();
	switch ( $location ) {
		case 'custom-menu':
			$items = array(
				array( __( 'Events', 'eventsinsider' ), $events ?: home_url( '/' ) ),
				array( __( 'Reviews', 'eventsinsider' ), ei_page_url( 'articles' ) ?: ei_posts_page_url() ),
				array( __( 'Travel', 'eventsinsider' ), ei_page_url( 'travel' ) ?: home_url( '/?s=travel' ) ),
				array( __( 'Guides', 'eventsinsider' ), home_url( '/?s=guide' ) ),
			);
			break;
		case 'footer-1':
			$items = array(
				array( __( 'About', 'eventsinsider' ), ei_page_url( 'about-johnny-monsarrat' ) ),
				array( __( 'Contact', 'eventsinsider' ), ei_page_url( 'contact' ) ),
				array( __( 'Submit an Event', 'eventsinsider' ), ei_page_url( 'contact' ) ),
			);
			break;
		case 'footer-2':
			$items = ei_fallback_items( 'custom-menu' );
			array_shift( $items );
			break;
		case 'article-tabs':
			foreach ( array( 'Guide', 'Travel', 'Reviews', 'Festival', 'Theater', 'Interactive' ) as $term ) {
				$items[] = array( $term, home_url( '/?s=' . rawurlencode( strtolower( $term ) ) ) );
			}
			break;
	}
	return array_filter( $items, fn( $item ) => ! empty( $item[1] ) );
}

/**
 * Print a nav menu, or the design's fallback links when none is assigned.
 *
 * @param string $location Menu location.
 * @param string $class    UL class.
 */
function ei_menu( $location, $class ) {
	if ( has_nav_menu( $location ) ) {
		wp_nav_menu(
			array(
				'theme_location' => $location,
				'container'      => false,
				'menu_class'     => $class,
				'depth'          => 1,
				'fallback_cb'    => false,
			)
		);
		return;
	}
	$current = home_url( add_query_arg( array() ) );
	echo '<ul class="' . esc_attr( $class ) . '">';
	foreach ( ei_fallback_items( $location ) as $item ) {
		$active = untrailingslashit( $item[1] ) === untrailingslashit( $current ) ? ' current-menu-item' : '';
		echo '<li class="menu-item' . esc_attr( $active ) . '"><a href="' . esc_url( $item[1] ) . '">' . esc_html( $item[0] ) . '</a></li>';
	}
	echo '</ul>';
}

/**
 * Mailchimp signup form (same list the previous theme posted to).
 *
 * @param string $variant Class modifier: banner|popup|card.
 */
function ei_newsletter_form( $variant = 'banner' ) {
	$action   = ei_mod( 'mailchimp_action' );
	$honeypot = ei_mod( 'mailchimp_honeypot' );
	$id       = 'ei-email-' . $variant;
	?>
	<form class="nl-form nl-form--<?php echo esc_attr( $variant ); ?>" action="<?php echo esc_url( $action ); ?>" method="post" target="_blank" novalidate>
		<label class="screen-reader-text" for="<?php echo esc_attr( $id ); ?>"><?php esc_html_e( 'Email', 'eventsinsider' ); ?></label>
		<input class="input" type="email" name="EMAIL" id="<?php echo esc_attr( $id ); ?>" placeholder="<?php esc_attr_e( 'Email', 'eventsinsider' ); ?>" autocomplete="email" required>
		<?php if ( $honeypot ) : ?>
			<div class="nl-hp" aria-hidden="true"><input type="text" name="<?php echo esc_attr( $honeypot ); ?>" tabindex="-1" value=""></div>
		<?php endif; ?>
		<button class="btn btn--brown" type="submit" name="subscribe"><?php esc_html_e( 'Subscribe Now', 'eventsinsider' ); ?></button>
	</form>
	<?php
}

/**
 * Social icon links.
 *
 * @param string $class Wrapper class.
 */
function ei_social_icons( $class = 'social' ) {
	$links = ei_social_links();
	if ( ! $links ) {
		return;
	}
	echo '<ul class="' . esc_attr( $class ) . '">';
	foreach ( $links as $network => $url ) {
		$icon = 'instagram' === $network
			? '<img src="' . esc_url( ei_img( 'instagram-icon.png' ) ) . '" width="32" height="32" alt="">'
			: ei_icon( $network, 28 );
		echo '<li><a class="social-' . esc_attr( $network ) . '" href="' . esc_url( $url ) . '" target="_blank" rel="noopener"><span class="screen-reader-text">' . esc_html( ucfirst( $network ) ) . '</span>' . $icon . '</a></li>'; // phpcs:ignore WordPress.Security.EscapeOutput
	}
	echo '</ul>';
}

/**
 * Copyright line with {year} replaced.
 *
 * @return string
 */
function ei_copyright() {
	return str_replace( '{year}', wp_date( 'Y' ), ei_mod( 'copyright' ) );
}
