<?php
/**
 * Inline SVG icons (line style matching the design's "Linear" icon set).
 *
 * @package eventsinsider
 */

defined( 'ABSPATH' ) || exit;

/**
 * Return an inline SVG icon.
 *
 * @param string $name Icon name.
 * @param int    $size Pixel size.
 * @return string
 */
function ei_icon( $name, $size = 24 ) {
	$stroke = 'fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"';
	$paths  = array(
		'calendar'  => '<rect x="3" y="4.5" width="18" height="16.5" rx="3" ' . $stroke . '/><path d="M3 9.5h18M8 3v3M16 3v3" ' . $stroke . '/>',
		'map-pin'   => '<path d="M12 21s-7-6.2-7-11.5a7 7 0 0 1 14 0C19 14.8 12 21 12 21Z" ' . $stroke . '/><circle cx="12" cy="9.5" r="2.5" ' . $stroke . '/>',
		'user'      => '<circle cx="12" cy="8" r="3.5" ' . $stroke . '/><path d="M5 20c.8-3.6 3.6-5.5 7-5.5s6.2 1.9 7 5.5" ' . $stroke . '/>',
		'search'    => '<circle cx="11" cy="11" r="7" ' . $stroke . '/><path d="m20 20-3.5-3.5" ' . $stroke . '/>',
		'menu'      => '<path d="M4 7h16M4 12h16M4 17h16" ' . $stroke . '/>',
		'close'     => '<path d="M6 6l12 12M18 6 6 18" fill="none" stroke="currentColor" stroke-width="2.25" stroke-linecap="round"/>',
		'chevron-l' => '<path d="m14.5 6-6 6 6 6" ' . $stroke . '/>',
		'chevron-r' => '<path d="m9.5 6 6 6-6 6" ' . $stroke . '/>',
		'star'      => '<path d="M12 2.8l2.85 5.78 6.38.93-4.62 4.5 1.09 6.35L12 17.36l-5.7 3 1.09-6.35-4.62-4.5 6.38-.93Z" fill="currentColor"/>',
		'heart'     => '<path d="M12 20s-7.5-4.6-7.5-10A4.3 4.3 0 0 1 12 7.4 4.3 4.3 0 0 1 19.5 10c0 5.4-7.5 10-7.5 10Z" ' . $stroke . '/>',
		'comment'   => '<path d="M20 11.5a8 8 0 0 1-11.7 7.1L4 20l1.4-4.1A8 8 0 1 1 20 11.5Z" ' . $stroke . '/>',
		'send'      => '<path d="M21 3 10 14M21 3l-7 18-4-7-7-4 18-7Z" ' . $stroke . '/>',
		// Feature icons for the About page.
		'interactive' => '<rect x="3" y="3" width="8" height="8" rx="2" ' . $stroke . '/><rect x="13" y="13" width="8" height="8" rx="2" ' . $stroke . '/><path d="M15 3h4a2 2 0 0 1 2 2v4M9 21H5a2 2 0 0 1-2-2v-4" ' . $stroke . '/>',
		'immersive'   => '<path d="M4 20h16M7 20l3-9 4 4 3-7M12 4l1 2M17 6l2-1M7 6 5 5" ' . $stroke . '/>',
		'handpicked'  => '<circle cx="12" cy="12" r="8.5" ' . $stroke . '/><path d="m8.5 12.2 2.4 2.4 4.6-5" ' . $stroke . '/>',
		'travel'      => '<path d="M3 6.5 9 4l6 2.5L21 4v13.5L15 20l-6-2.5L3 20Z" ' . $stroke . '/><path d="M9 4v13.5M15 6.5V20" ' . $stroke . '/>',
		// Brand glyphs.
		'instagram' => '<rect x="3" y="3" width="18" height="18" rx="5" ' . $stroke . '/><circle cx="12" cy="12" r="4" ' . $stroke . '/><circle cx="17.3" cy="6.7" r="1" fill="currentColor"/>',
		'facebook'  => '<path d="M14 8.5V7c0-.8.5-1.2 1.2-1.2H17V2.6h-2.6C11.6 2.6 10.5 4.5 10.5 7v1.5H8V12h2.5v9.4H14V12h2.6l.4-3.5Z" fill="currentColor"/>',
		'twitter'   => '<path d="M17.8 3h3.1l-6.8 7.7L22 21h-6.2l-4.9-6.3L5.3 21H2.2l7.2-8.3L1.8 3h6.4l4.4 5.8L17.8 3Zm-1.1 16.2h1.7L7.4 4.7H5.6l11.1 14.5Z" fill="currentColor"/>',
		'youtube'   => '<path d="M21.6 7.2a2.5 2.5 0 0 0-1.8-1.8C18.2 5 12 5 12 5s-6.2 0-7.8.4A2.5 2.5 0 0 0 2.4 7.2 26 26 0 0 0 2 12a26 26 0 0 0 .4 4.8 2.5 2.5 0 0 0 1.8 1.8C5.8 19 12 19 12 19s6.2 0 7.8-.4a2.5 2.5 0 0 0 1.8-1.8A26 26 0 0 0 22 12a26 26 0 0 0-.4-4.8ZM10 15V9l5.2 3L10 15Z" fill="currentColor"/>',
		'tiktok'    => '<path d="M16.5 2h-3.3v13.2a2.9 2.9 0 1 1-2-2.8V9.1a6.2 6.2 0 1 0 5.3 6.1V8.5a7.8 7.8 0 0 0 4.5 1.4V6.6a4.5 4.5 0 0 1-4.5-4.6Z" fill="currentColor"/>',
	);
	if ( ! isset( $paths[ $name ] ) ) {
		return '';
	}
	return sprintf(
		'<svg class="icon icon-%1$s" width="%2$d" height="%2$d" viewBox="0 0 24 24" aria-hidden="true" focusable="false">%3$s</svg>',
		esc_attr( $name ),
		(int) $size,
		$paths[ $name ]
	);
}
