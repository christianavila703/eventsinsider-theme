<?php
/**
 * The "events" post type and "event_type" taxonomy.
 *
 * The previous theme (monsarrat) registered these itself, so they are kept here with the same
 * slugs and rewrite settings; otherwise existing event content would 404 after switching themes.
 *
 * @package eventsinsider
 */

defined( 'ABSPATH' ) || exit;

/**
 * Register the post type and taxonomy unless a plugin already does.
 */
function ei_register_content_types() {
	if ( ! post_type_exists( 'events' ) ) {
		register_post_type(
			'events',
			array(
				'labels'        => array(
					'name'               => __( 'Events', 'eventsinsider' ),
					'singular_name'      => __( 'Event', 'eventsinsider' ),
					'add_new'            => __( 'Add new', 'eventsinsider' ),
					'add_new_item'       => __( 'Add new Event', 'eventsinsider' ),
					'edit_item'          => __( 'Edit Event', 'eventsinsider' ),
					'new_item'           => __( 'New Event', 'eventsinsider' ),
					'view_item'          => __( 'View Event', 'eventsinsider' ),
					'search_items'       => __( 'Search Event', 'eventsinsider' ),
					'not_found'          => __( 'Not Found', 'eventsinsider' ),
					'not_found_in_trash' => __( 'Not Found in trash', 'eventsinsider' ),
					'menu_name'          => __( 'Events', 'eventsinsider' ),
				),
				'public'        => true,
				'menu_position' => 7,
				'menu_icon'     => 'dashicons-calendar-alt',
				'hierarchical'  => false,
				'supports'      => array( 'title', 'editor', 'thumbnail', 'excerpt', 'author' ),
				'taxonomies'    => array( 'post_tag' ),
				'has_archive'   => true,
				'rewrite'       => true,
				'query_var'     => true,
				'show_in_rest'  => true,
			)
		);
	}

	if ( ! taxonomy_exists( 'event_type' ) ) {
		register_taxonomy(
			'event_type',
			'events',
			array(
				'label'             => __( 'Event Type', 'eventsinsider' ),
				'hierarchical'      => true,
				'sort'              => true,
				'show_in_nav_menus' => true,
				'show_ui'           => true,
				'show_tagcloud'     => false,
				'show_in_rest'      => true,
			)
		);
	}
}
add_action( 'init', 'ei_register_content_types' );

/**
 * Flush rewrite rules once after the theme is activated so event URLs resolve.
 */
function ei_flush_rewrites_on_switch() {
	ei_register_content_types();
	flush_rewrite_rules();
}
add_action( 'after_switch_theme', 'ei_flush_rewrites_on_switch' );
