<?php
global $mipro_page_options;
get_header(); 
$content_class = mipro_get_content_layout( $mipro_page_options['kft_page_layout'] );
?>

<?php if ( $mipro_page_options['kft_page_slider'] && $mipro_page_options['kft_page_slider_position'] == 'before_main_content' ) : ?>	
	<div class="revo-slider">
		<div class="kft-rev-slider">
			<?php mipro_show_page_slider(); ?>
		</div>
	</div>
<?php endif; ?>

<div class="container">	
	<?php if ( mipro_get_opt('kft_breadcrumbs') ) {
		mipro_breadcrumbs(); 
	} ?>
	<div class="row">
		<?php if ( $content_class['left_sidebar'] && is_active_sidebar( $mipro_page_options['kft_left_sidebar'] ) ) : ?>
			<aside id="left-sidebar" class="<?php echo esc_attr( $content_class['left_sidebar_class'] ); ?>">
				<?php dynamic_sidebar( $mipro_page_options['kft_left_sidebar'] ); ?>
			</aside>
		<?php endif; ?>
		
		<section id="content" class="site-content <?php echo esc_attr( $content_class['main_class'] ); ?>">
			<?php while ( have_posts() ) : the_post(); ?>
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<?php the_content(); ?>
					<?php wp_link_pages(); ?>
				</article>

				<?php	
				/* If comments are open or we have at least one comment, load up the comment template. */
				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;
			endwhile;
			?>
		</section><!-- #content -->

		<?php if ( $content_class['right_sidebar'] && is_active_sidebar( $mipro_page_options['kft_right_sidebar'] ) ) : ?>
			<aside id="right-sidebar" class="<?php echo esc_attr( $content_class['right_sidebar_class'] ); ?>">
				<?php dynamic_sidebar( $mipro_page_options['kft_right_sidebar'] ); ?>
			</aside>
		<?php endif; ?>
	</div> <!-- .row -->
</div><!-- .container -->

<?php 
get_footer();
