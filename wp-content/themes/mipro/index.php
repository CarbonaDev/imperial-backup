<?php
/**
 * The theme's index.php file.
 *
 */

get_header();

$content_class = mipro_get_content_layout( mipro_get_opt('kft_blog_layout') );
if ( ! is_active_sidebar( mipro_get_opt('kft_blog_left_sidebar') ) || ! is_active_sidebar( mipro_get_opt('kft_blog_right_sidebar') ) ) {
	$content_class['main_class'] = 'col-sm-12 col-xs-12';
}
?>

<div class="container">
	<?php if ( mipro_get_opt('kft_breadcrumbs') ) {
		mipro_breadcrumbs(); 
	} ?>
	<div class="row">

		<?php if ( $content_class['left_sidebar'] && is_active_sidebar( mipro_get_opt('kft_blog_left_sidebar') ) ) : ?>
			<aside id="left-sidebar" class="<?php echo esc_attr( $content_class['left_sidebar_class'] ); ?>">
				<?php dynamic_sidebar( mipro_get_opt('kft_blog_left_sidebar') ); ?>
			</aside>
		<?php endif; ?>

		<section id="content" class="site-content <?php echo esc_attr( $content_class['main_class'] ); ?>">
			<?php 
			if ( have_posts() ) : 
				while ( have_posts() ) : 
					the_post();
					get_template_part( 'template-parts/post/content', get_post_format() );
				endwhile;
				mipro_pagination();
			else :
				echo '<div class="alert alert-error">' . esc_html__( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'mipro' ) . '</div>';
				get_search_form();
			endif; 
			?>
		</section><!-- #content -->

		<?php if ( $content_class['right_sidebar'] && is_active_sidebar( mipro_get_opt('kft_blog_right_sidebar') ) ) : ?>
			<aside id="right-sidebar" class="<?php echo esc_attr( $content_class['right_sidebar_class'] ); ?>">
				<?php dynamic_sidebar( mipro_get_opt('kft_blog_right_sidebar') ); ?>
			</aside>
		<?php endif; ?>

	</div><!-- .row -->
</div><!-- .container -->

<?php 
get_footer();
