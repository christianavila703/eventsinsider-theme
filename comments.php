<?php
/**
 * Comments.
 *
 * @package eventsinsider
 */

if ( post_password_required() ) {
	return;
}
?>
<section id="comments" class="content-card comments">
	<?php if ( have_comments() ) : ?>
		<h2 class="comments__title">
			<?php
			/* translators: %s: number of comments */
			echo esc_html( sprintf( _n( '%s Comment', '%s Comments', get_comments_number(), 'eventsinsider' ), number_format_i18n( get_comments_number() ) ) );
			?>
		</h2>
		<ol class="comment-list">
			<?php wp_list_comments( array( 'style' => 'ol', 'short_ping' => true, 'avatar_size' => 48 ) ); ?>
		</ol>
		<?php the_comments_navigation(); ?>
	<?php endif; ?>

	<?php comment_form( array( 'class_submit' => 'btn btn--brown' ) ); ?>
</section>
