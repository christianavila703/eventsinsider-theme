<?php
/**
 * About page (slug "about-johnny-monsarrat"). Also selectable as a template for other pages.
 *
 * Template Name: About
 *
 * @package eventsinsider
 */

get_header();

$ei_features = array(
	array( 'interactive', __( 'Interactive Event Coverage', 'eventsinsider' ), __( 'We prioritize events that engage the senses and invite participation over passive viewing.', 'eventsinsider' ) ),
	array( 'immersive', __( 'Immersive Activities', 'eventsinsider' ), __( 'From escape rooms to glass-blowing workshops, we find the activities that challenge and inspire.', 'eventsinsider' ) ),
	array( 'handpicked', __( 'Hand-picked Experiences', 'eventsinsider' ), __( 'Every recommendation is vetted by our team of curators who live and breathe local culture.', 'eventsinsider' ) ),
	array( 'travel', __( 'Travel + Events', 'eventsinsider' ), __( 'We connect the destination with the event so your travel plans revolve around meaningful moments.', 'eventsinsider' ) ),
);

while ( have_posts() ) :
	the_post();
	?>
	<section class="page-hero" style="background-image:url('<?php echo esc_url( has_post_thumbnail() ? get_the_post_thumbnail_url( null, 'ei-hero' ) : ei_img( 'about-hero.jpg' ) ); ?>')">
		<div class="container">
			<div class="page-hero__card">
				<p class="page-hero__title"><?php esc_html_e( 'Discover Experiences That Stay With You', 'eventsinsider' ); ?></p>
				<p class="page-hero__text"><?php esc_html_e( 'We curate the extraordinary, from local hidden gems to global travel wonders. Our mission is to move beyond the passive and into the immersive.', 'eventsinsider' ); ?></p>
				<a class="btn btn--brown" href="#about-us"><?php esc_html_e( 'Read More', 'eventsinsider' ); ?></a>
			</div>
		</div>
	</section>

	<div class="page-body page-body--decor">
		<div class="container layout">
			<div class="layout__main about">
				<section id="about-us" class="about__intro">
					<h1 class="section-title"><?php esc_html_e( 'About Us', 'eventsinsider' ); ?></h1>
					<div class="entry-content entry-content--plain"><?php the_content(); ?></div>
				</section>

				<section class="split-card">
					<div class="split-card__body">
						<h2 class="split-card__title"><?php esc_html_e( 'Who We Are ?', 'eventsinsider' ); ?></h2>
						<p><?php esc_html_e( 'We believe the best experiences are active, not passive. Watching a show is one thing; being part of an interactive theater production is another. We champion events that bridge the gap between spectator and participant.', 'eventsinsider' ); ?></p>
						<p><?php esc_html_e( 'Our philosophy is rooted in the "Digital Curator" mindset filtering out the noise of mass-market tourism to bring you moments of genuine connection, artistic wonder, and sensory delight.', 'eventsinsider' ); ?></p>
					</div>
					<div class="split-card__media" style="background-image:url('<?php echo esc_url( ei_img( 'who-we-are.jpg' ) ); ?>')" aria-hidden="true"></div>
				</section>

				<section class="features">
					<h2 class="section-title section-title--md"><?php esc_html_e( 'Why We’re Different ?', 'eventsinsider' ); ?></h2>
					<div class="features__grid">
						<?php foreach ( $ei_features as $ei_feature ) : ?>
							<div class="feature">
								<span class="feature__icon"><?php echo ei_icon( $ei_feature[0], 24 ); // phpcs:ignore WordPress.Security.EscapeOutput ?></span>
								<div>
									<h3 class="feature__title"><?php echo esc_html( $ei_feature[1] ); ?></h3>
									<p class="feature__text"><?php echo esc_html( $ei_feature[2] ); ?></p>
								</div>
							</div>
						<?php endforeach; ?>
					</div>
				</section>

				<?php get_template_part( 'template-parts/explore-articles' ); ?>

				<figure class="quote">
					<blockquote><p><?php esc_html_e( '"We don’t just list events; we tell the story of the moments that make life worth exploring. Our curation is an invitation to step outside your routine and discover something truly remarkable."', 'eventsinsider' ); ?></p></blockquote>
					<figcaption><?php esc_html_e( 'Johnny Monsarrat', 'eventsinsider' ); ?></figcaption>
				</figure>

				<section class="cta" style="background-image:url('<?php echo esc_url( ei_img( 'cta-bg.jpg' ) ); ?>')">
					<h2 class="cta__title"><?php esc_html_e( 'Start Exploring Experiences', 'eventsinsider' ); ?></h2>
					<p class="cta__text"><?php esc_html_e( 'Discover hand-picked events, hidden gems, and unforgettable experiences happening near you.', 'eventsinsider' ); ?></p>
					<a class="btn btn--yellow" href="<?php echo esc_url( get_post_type_archive_link( 'events' ) ?: ei_posts_page_url() ); ?>"><?php esc_html_e( 'Explore Events', 'eventsinsider' ); ?></a>
				</section>
			</div>

			<?php get_sidebar( null, array( 'blocks' => array( 'handpicked', 'instagram' ) ) ); ?>
		</div>
	</div>
	<?php
endwhile;

get_footer();
