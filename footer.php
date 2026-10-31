<?php
/**
 * Site footer.
 *
 * @package eventsinsider
 */

?>
</main>

<footer class="site-footer">
	<div class="container">
		<div class="site-footer__top">
			<?php ei_logo( 'site-footer__logo' ); ?>
			<nav class="footer-nav" aria-label="<?php esc_attr_e( 'Footer', 'eventsinsider' ); ?>">
				<?php ei_menu( 'footer-1', 'footer-nav__list' ); ?>
				<?php ei_menu( 'footer-2', 'footer-nav__list' ); ?>
			</nav>
			<?php ei_social_icons( 'social site-footer__social' ); ?>
		</div>
		<p class="site-footer__copy"><?php echo esc_html( ei_copyright() ); ?></p>
	</div>
</footer>

<?php get_template_part( 'template-parts/newsletter-popup' ); ?>

<?php wp_footer(); ?>
</body>
</html>
