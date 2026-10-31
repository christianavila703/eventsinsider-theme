<?php
/**
 * Contact page (slug "contact"). The page's own content (including any Contact Form 7 form) goes in the first card.
 *
 * Template Name: Contact
 *
 * @package eventsinsider
 */

get_header();

while ( have_posts() ) :
	the_post();
	?>
	<div class="page-body page-body--decor page-body--top">
		<div class="container">
			<h1 class="page-title"><?php esc_html_e( 'Get In Touch', 'eventsinsider' ); ?></h1>
			<div class="layout">
				<div class="layout__main contact">
					<div class="content-card entry-content">
						<?php the_content(); ?>
					</div>

					<section class="follow">
						<h2 class="section-title section-title--md"><?php esc_html_e( 'Follow Us', 'eventsinsider' ); ?></h2>
						<div class="follow__card">
							<img class="follow__img" src="<?php echo esc_url( ei_img( 'follow-us.jpg' ) ); ?>" alt="" loading="lazy">
							<div class="follow__body">
								<p><?php esc_html_e( 'Stay connected with us on social media for latest event update, travel stories and exciting updates.', 'eventsinsider' ); ?></p>
								<?php ei_social_icons(); ?>
							</div>
						</div>
					</section>

					<section class="nl-card-wrap">
						<h2 class="section-title section-title--md"><?php esc_html_e( 'Get Weekly Newsletter', 'eventsinsider' ); ?></h2>
						<div class="content-card nl-card">
							<p><?php esc_html_e( 'Have questions about events, partnerships, or submissions? We’d love to hear from you.', 'eventsinsider' ); ?></p>
							<?php ei_newsletter_form( 'card' ); ?>
						</div>
					</section>

					<?php get_template_part( 'template-parts/explore-articles' ); ?>
				</div>

				<?php get_sidebar( null, array( 'blocks' => array( 'about', 'instagram' ) ) ); ?>
			</div>
		</div>
	</div>
	<?php
endwhile;

get_footer();
