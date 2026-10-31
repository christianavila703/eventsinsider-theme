<?php
/**
 * Customizer options (Appearance → Customize → Events Insider).
 *
 * @package eventsinsider
 */

defined( 'ABSPATH' ) || exit;

/**
 * Default values for text options, shared by the Customizer and templates.
 *
 * @param string $key Option key without the ei_ prefix.
 * @return string
 */
function ei_default( $key ) {
	$defaults = array(
		'mailchimp_action'  => 'https://eventsinsider.us13.list-manage.com/subscribe/post?u=ae886c676b711b1fa76fecb7f&id=262690cc74',
		'mailchimp_honeypot'=> 'b_ae886c676b711b1fa76fecb7f_262690cc74',
		'hero_label'        => __( 'This Week:', 'eventsinsider' ),
		'newsletter_title'  => __( 'Be the First to Know', 'eventsinsider' ),
		'newsletter_text'   => __( 'Discover the hottest events, travel ideas, and insider picks before everyone else.', 'eventsinsider' ),
		'popup_title'       => __( 'Subscribe for Updates!', 'eventsinsider' ),
		'popup_text'        => __( 'Get feature alerts and inside access to our test community!', 'eventsinsider' ),
		'about_box_title'   => __( 'What is Events Insider?', 'eventsinsider' ),
		'about_box_lead'    => __( 'Events INSIDER is dedicated to interactive events, which let you live life to the fullest.', 'eventsinsider' ),
		'about_box_text'    => __( "With 50,000 followers on email and social media, Events INSIDER is the most popular all-digital news source on the arts and travel in New England. We were incubated in the Boston Globe headquarters as a Boston Globe contractor until 2015 and are now independent.\n\nEvents INSIDER has more of that than anyone else in New England by a factor of 3 or more, and we also write on travel experiences around the world.", 'eventsinsider' ),
		'instagram_caption' => __( 'The Dreamland Wax Museum', 'eventsinsider' ),
		'copyright'         => __( '© {year} Eventsinsider All Rights Reserved.', 'eventsinsider' ),
	);
	return $defaults[ $key ] ?? '';
}

/**
 * Theme mod with the shared default.
 *
 * @param string $key Option key without the ei_ prefix.
 * @return string
 */
function ei_mod( $key ) {
	return (string) get_theme_mod( 'ei_' . $key, ei_default( $key ) );
}

/**
 * Register Customizer panel, sections and controls.
 *
 * @param WP_Customize_Manager $wp_customize Manager.
 */
function ei_customize_register( $wp_customize ) {
	$wp_customize->add_panel( 'ei_panel', array( 'title' => __( 'Events Insider', 'eventsinsider' ), 'priority' => 30 ) );

	$text = function ( $section, $key, $label, $type = 'text', $sanitize = 'sanitize_text_field' ) use ( $wp_customize ) {
		$wp_customize->add_setting( 'ei_' . $key, array( 'default' => ei_default( $key ), 'sanitize_callback' => $sanitize ) );
		$wp_customize->add_control( 'ei_' . $key, array( 'label' => $label, 'section' => $section, 'type' => $type ) );
	};

	// Homepage.
	$wp_customize->add_section( 'ei_home', array( 'title' => __( 'Homepage & articles', 'eventsinsider' ), 'panel' => 'ei_panel' ) );
	$text( 'ei_home', 'hero_label', __( 'Hero slider label', 'eventsinsider' ) );
	$wp_customize->add_setting( 'ei_hero_source', array( 'default' => 'latest', 'sanitize_callback' => 'sanitize_key' ) );
	$wp_customize->add_control(
		'ei_hero_source',
		array(
			'label'   => __( 'Hero slider shows', 'eventsinsider' ),
			'section' => 'ei_home',
			'type'    => 'radio',
			'choices' => array(
				'latest' => __( 'Latest 3 posts with a featured image', 'eventsinsider' ),
				'sticky' => __( 'Sticky posts (falls back to latest)', 'eventsinsider' ),
			),
		)
	);
	$wp_customize->add_setting( 'ei_grid_per_page', array( 'default' => 6, 'sanitize_callback' => 'absint' ) );
	$wp_customize->add_control( 'ei_grid_per_page', array( 'label' => __( 'Article cards per page', 'eventsinsider' ), 'section' => 'ei_home', 'type' => 'number', 'input_attrs' => array( 'min' => 2, 'max' => 24, 'step' => 2 ) ) );

	$recent  = get_posts( array( 'numberposts' => 60, 'no_found_rows' => true, 'suppress_filters' => false ) );
	$choices = array( 0 => __( '— Automatic (newest sticky post) —', 'eventsinsider' ) );
	foreach ( $recent as $p ) {
		$choices[ $p->ID ] = wp_trim_words( get_the_title( $p ), 12 );
	}
	$wp_customize->add_setting( 'ei_handpicked_post', array( 'default' => 0, 'sanitize_callback' => 'absint' ) );
	$wp_customize->add_control( 'ei_handpicked_post', array( 'label' => __( '"Hand-Picked Events" post', 'eventsinsider' ), 'section' => 'ei_home', 'type' => 'select', 'choices' => $choices ) );

	// Newsletter.
	$wp_customize->add_section( 'ei_newsletter', array( 'title' => __( 'Newsletter & popup', 'eventsinsider' ), 'panel' => 'ei_panel' ) );
	$text( 'ei_newsletter', 'mailchimp_action', __( 'Mailchimp form action URL', 'eventsinsider' ), 'url', 'esc_url_raw' );
	$text( 'ei_newsletter', 'mailchimp_honeypot', __( 'Mailchimp anti-spam field name (b_…)', 'eventsinsider' ) );
	$text( 'ei_newsletter', 'newsletter_title', __( 'Banner heading', 'eventsinsider' ) );
	$text( 'ei_newsletter', 'newsletter_text', __( 'Banner text', 'eventsinsider' ), 'textarea', 'sanitize_textarea_field' );
	$wp_customize->add_setting( 'ei_popup_enabled', array( 'default' => true, 'sanitize_callback' => 'wp_validate_boolean' ) );
	$wp_customize->add_control( 'ei_popup_enabled', array( 'label' => __( 'Show subscribe popup', 'eventsinsider' ), 'section' => 'ei_newsletter', 'type' => 'checkbox' ) );
	$wp_customize->add_setting( 'ei_popup_delay', array( 'default' => 12, 'sanitize_callback' => 'absint' ) );
	$wp_customize->add_control( 'ei_popup_delay', array( 'label' => __( 'Popup delay (seconds)', 'eventsinsider' ), 'section' => 'ei_newsletter', 'type' => 'number' ) );
	$wp_customize->add_setting( 'ei_popup_days', array( 'default' => 14, 'sanitize_callback' => 'absint' ) );
	$wp_customize->add_control( 'ei_popup_days', array( 'label' => __( 'Hide popup for this many days after it is closed', 'eventsinsider' ), 'section' => 'ei_newsletter', 'type' => 'number' ) );
	$text( 'ei_newsletter', 'popup_title', __( 'Popup heading', 'eventsinsider' ) );
	$text( 'ei_newsletter', 'popup_text', __( 'Popup text', 'eventsinsider' ), 'textarea', 'sanitize_textarea_field' );

	// Sidebar.
	$wp_customize->add_section( 'ei_sidebar', array( 'title' => __( 'Sidebar', 'eventsinsider' ), 'panel' => 'ei_panel' ) );
	$text( 'ei_sidebar', 'about_box_title', __( '"What is Events Insider?" heading', 'eventsinsider' ) );
	$text( 'ei_sidebar', 'about_box_lead', __( 'Box lead sentence', 'eventsinsider' ), 'textarea', 'sanitize_textarea_field' );
	$text( 'ei_sidebar', 'about_box_text', __( 'Box text', 'eventsinsider' ), 'textarea', 'sanitize_textarea_field' );
	$wp_customize->add_setting( 'ei_about_box_image', array( 'default' => '', 'sanitize_callback' => 'absint' ) );
	$wp_customize->add_control( new WP_Customize_Media_Control( $wp_customize, 'ei_about_box_image', array( 'label' => __( 'Box image', 'eventsinsider' ), 'section' => 'ei_sidebar', 'mime_type' => 'image' ) ) );
	$wp_customize->add_setting( 'ei_instagram_image', array( 'default' => '', 'sanitize_callback' => 'absint' ) );
	$wp_customize->add_control( new WP_Customize_Media_Control( $wp_customize, 'ei_instagram_image', array( 'label' => __( '"On Instagram" image', 'eventsinsider' ), 'section' => 'ei_sidebar', 'mime_type' => 'image' ) ) );
	$text( 'ei_sidebar', 'instagram_caption', __( '"On Instagram" caption', 'eventsinsider' ) );
	$wp_customize->add_setting( 'ei_instagram_shortcode', array( 'default' => '', 'sanitize_callback' => 'wp_kses_post' ) );
	$wp_customize->add_control( 'ei_instagram_shortcode', array( 'label' => __( 'Instagram feed shortcode (optional)', 'eventsinsider' ), 'description' => __( 'e.g. [instagram-feed] from an Instagram feed plugin. Replaces the static card.', 'eventsinsider' ), 'section' => 'ei_sidebar', 'type' => 'text' ) );

	// Social.
	$wp_customize->add_section( 'ei_social', array( 'title' => __( 'Social links', 'eventsinsider' ), 'panel' => 'ei_panel' ) );
	foreach ( array( 'instagram' => 'Instagram', 'facebook' => 'Facebook', 'twitter' => 'X / Twitter', 'youtube' => 'YouTube', 'tiktok' => 'TikTok' ) as $key => $label ) {
		$wp_customize->add_setting( 'ei_social_' . $key, array( 'default' => ei_social_default( $key ), 'sanitize_callback' => 'esc_url_raw' ) );
		$wp_customize->add_control( 'ei_social_' . $key, array( 'label' => $label, 'section' => 'ei_social', 'type' => 'url' ) );
	}

	// Footer.
	$wp_customize->add_section( 'ei_footer', array( 'title' => __( 'Footer', 'eventsinsider' ), 'panel' => 'ei_panel' ) );
	$text( 'ei_footer', 'copyright', __( 'Copyright line ({year} = current year)', 'eventsinsider' ) );
}
add_action( 'customize_register', 'ei_customize_register' );
