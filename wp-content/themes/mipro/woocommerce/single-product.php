<?php
/**
 * The Template for displaying all single products.
 *
 * Override this template by copying it to yourtheme/woocommerce/single-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

defined( 'ABSPATH' ) || exit;

get_header(); 
$content_class = mipro_get_content_layout( mipro_get_opt('kft_prod_layout') );


?>
<div class="container">
	<?php mipro_breadcrumbs(); ?>
	<div class="row product-single-wrapper">

		<?php if ( $content_class['left_sidebar'] && is_active_sidebar( mipro_get_opt('kft_prod_left_sidebar') ) ) : ?>
			<aside id="left-sidebar" class="<?php echo esc_attr( $content_class['left_sidebar_class'] ); ?>">
				<?php dynamic_sidebar( mipro_get_opt('kft_prod_left_sidebar') ); ?>
			</aside>
		<?php endif; ?>	
		
		<section id="content" class="site-content product-image-summary <?php echo esc_attr( $content_class['main_class'] ); ?>">
			<?php
		/**
		 * woocommerce_before_main_content hook
		 *
		 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
		 * @hooked woocommerce_breadcrumb - 20
		 */
		do_action( 'woocommerce_before_main_content' );
		?> 

		<?php while ( have_posts() ) : the_post(); ?>

			<?php wc_get_template_part( 'content', 'single-product' ); ?>

		<?php endwhile; // end of the loop. ?>
		<?php
		/**
		 * woocommerce_after_main_content hook
		 *
		 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
		 */
		do_action( 'woocommerce_after_main_content' );
		?>
	</section>

	<?php if ( $content_class['right_sidebar'] && is_active_sidebar( mipro_get_opt('kft_prod_right_sidebar') ) ) : ?>
		<aside id="right-sidebar" class="<?php echo esc_attr($content_class['right_sidebar_class']); ?>">
			<?php dynamic_sidebar( mipro_get_opt('kft_prod_right_sidebar') ); ?>
		</aside>
	<?php endif; ?>
	
	<?php if ( mipro_get_opt('kft_show_prod_navigation') ) {
		mipro_template_single_navigation();
	} ?>
	
</div>
</div>
<?php get_footer( 'shop' ); ?>