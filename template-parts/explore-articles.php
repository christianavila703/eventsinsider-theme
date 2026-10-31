<?php
/**
 * "Explore Articles" — three topic cards (About and Contact pages).
 *
 * @package eventsinsider
 */

$ei_topics = array(
	array( __( 'Guide', 'eventsinsider' ), 'explore-guide.jpg', home_url( '/?s=guide' ) ),
	array( __( 'Travel', 'eventsinsider' ), 'explore-travel.jpg', ei_page_url( 'travel' ) ?: home_url( '/?s=travel' ) ),
	array( __( 'Reviews', 'eventsinsider' ), 'explore-reviews.jpg', ei_page_url( 'articles' ) ?: ei_posts_page_url() ),
);
?>
<section class="explore">
	<div class="explore__head">
		<h2 class="section-title section-title--md"><?php esc_html_e( 'Explore Articles', 'eventsinsider' ); ?></h2>
		<a class="link-blue" href="<?php echo esc_url( ei_posts_page_url() ); ?>"><?php esc_html_e( 'View All Categories', 'eventsinsider' ); ?></a>
	</div>
	<div class="explore__grid">
		<?php foreach ( $ei_topics as $ei_topic ) : ?>
			<a class="topic-card" href="<?php echo esc_url( $ei_topic[2] ); ?>">
				<img class="topic-card__img" src="<?php echo esc_url( ei_img( $ei_topic[1] ) ); ?>" alt="" loading="lazy">
				<span class="topic-card__body">
					<span class="topic-card__title"><?php echo esc_html( $ei_topic[0] ); ?></span>
					<span class="topic-card__text"><?php esc_html_e( 'From hidden gems to major attractions, we bring you the most exciting events.', 'eventsinsider' ); ?></span>
				</span>
			</a>
		<?php endforeach; ?>
	</div>
</section>
