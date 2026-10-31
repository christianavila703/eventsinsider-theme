<?php
/**
 * Site header.
 *
 * @package eventsinsider
 */

?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="skip-link screen-reader-text" href="#main"><?php esc_html_e( 'Skip to content', 'eventsinsider' ); ?></a>

<header class="site-header">
	<div class="container site-header__inner">
		<?php ei_logo( 'site-header__logo' ); ?>

		<nav class="primary-nav" aria-label="<?php esc_attr_e( 'Main', 'eventsinsider' ); ?>">
			<?php ei_menu( 'custom-menu', 'primary-nav__list' ); ?>
		</nav>

		<button class="nav-toggle" type="button" aria-controls="mobile-nav" aria-expanded="false">
			<span class="screen-reader-text"><?php esc_html_e( 'Open menu', 'eventsinsider' ); ?></span>
			<?php echo ei_icon( 'menu', 28 ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
		</button>
	</div>
</header>

<div class="mobile-nav" id="mobile-nav" hidden>
	<div class="mobile-nav__top">
		<?php ei_logo( 'mobile-nav__logo' ); ?>
		<button class="nav-close" type="button">
			<span class="screen-reader-text"><?php esc_html_e( 'Close menu', 'eventsinsider' ); ?></span>
			<?php echo ei_icon( 'close', 28 ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
		</button>
	</div>
	<nav aria-label="<?php esc_attr_e( 'Mobile', 'eventsinsider' ); ?>">
		<?php ei_menu( 'custom-menu', 'mobile-nav__list' ); ?>
	</nav>
	<?php get_search_form(); ?>
</div>

<main id="main" class="site-main">
