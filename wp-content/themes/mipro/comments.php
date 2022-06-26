<?php
if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-area">

	<?php if ( have_comments() ) : ?>
		<h2 class="comments-title">
			<?php comments_number( esc_html__( 'No Comments', 'mipro' ), esc_html__( 'One Comment', 'mipro' ), '% ' . esc_html__( 'Comments', 'mipro' ) ); ?>
		</h2>
		<ol class="comment-list">
			<?php wp_list_comments( array( 'callback' => 'mipro_comment' ) ); ?>
		</ol><!-- .comment-list -->

		<nav class="navigation comment-navigation" role="navigation">
			<h1 class="screen-reader-text section-heading"><?php echo esc_html_e( 'Comment navigation', 'mipro' ); ?></h1>
			<div class="nav-previous"><?php previous_comments_link( esc_html__( '&larr; Older Comments', 'mipro' ) ); ?></div>
			<div class="nav-next"><?php next_comments_link( esc_html__( 'Newer Comments &rarr;', 'mipro' ) ); ?></div>
		</nav><!-- .comment-navigation -->
	<?php endif; ?>

	<?php if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) : ?>
	<p class="no-comments"><?php echo esc_html_e( 'Comments are closed.', 'mipro' ); ?></p>
<?php endif; ?>

<?php
comment_form( array(
	'comment_notes_after' => '',
) );
?>

</div><!-- #comments -->
