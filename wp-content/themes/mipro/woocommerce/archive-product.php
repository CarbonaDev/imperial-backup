<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive.
 *
 * Override this template by copying it to yourtheme/woocommerce/archive-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.4.0
 */

defined( 'ABSPATH' ) || exit;

get_header();

$content_class = mipro_get_content_layout(mipro_get_opt('kft_prod_cat_layout'));

?>
<div class="container">
	<div class="shop-bread-cate">
	<?php if ( mipro_get_opt('kft_breadcrumbs') ) {
		mipro_breadcrumbs(); 
	} ?>
	<?php echo  mipro_products_cate_shop(); ?>
	</div>
	<div class="row">
		
		<?php if( $content_class['left_sidebar'] && is_active_sidebar(mipro_get_opt('kft_prod_cat_left_sidebar')) ): ?>
			<aside id="left-sidebar" class="shop-sidebar <?php echo esc_attr($content_class['left_sidebar_class']); ?>">
				<div class="close-sidebar"><span><?php echo esc_html_e('Close','mipro'); ?></span></div>
				<?php dynamic_sidebar( mipro_get_opt('kft_prod_cat_left_sidebar') ); ?>
			</aside>
		<?php endif; ?>	

		<?php
		/**
		 * woocommerce_before_main_content hook
		 *
		 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
		 * @hooked woocommerce_breadcrumb - 20
		 */
		do_action( 'woocommerce_before_main_content' );
		?>
		
		<section id="content" class="site-content shop-content <?php echo esc_attr($content_class['main_class']); ?>">	

			<?php do_action( 'woocommerce_archive_description' ); ?>

			<?php if ( woocommerce_product_loop() ) : ?>

				<div class="archive-loop-header">
					<div class="title-bread-left">
					<?php

					 woocommerce_page_title();

					 ?>
					</div>
					 <?php 
				/**
				 * woocommerce_before_shop_loop hook
				 *
				 * @hooked woocommerce_result_count - 20
				 * @hooked woocommerce_catalog_ordering - 30
				 */
				remove_action('woocommerce_before_shop_loop','woocommerce_result_count',20);
				do_action( 'woocommerce_before_shop_loop' );
				
				?>
			</div>
			
			<div class="mipro-active-filters">
				<?php the_widget( 'WC_Widget_Layered_Nav_Filters', array(), array() ); ?>
			</div>
			<?php 
			global $woocommerce_loop;
			if( absint(mipro_get_opt('kft_prod_cat_columns')) > 0 ){
				$woocommerce_loop['columns'] = absint(mipro_get_opt('kft_prod_cat_columns'));
			}
			?>
			<div class="woocommerce columns-<?php echo esc_attr($woocommerce_loop['columns']); ?>">
				<?php
				woocommerce_product_loop_start();

				$woocommerce_loop['loop'] = 0;
				if ( wc_get_loop_prop( 'total' ) ) {
					while ( have_posts() ) {
						the_post(); 
						
						wc_get_template_part( 'content', 'product' ); 
						
					} 
				}

				woocommerce_product_loop_end();
				?>
			</div>
			<div class="archive-loop-footer">
				<?php
				/**
				 * woocommerce_after_shop_loop hook
				 *
				 * @hooked woocommerce_pagination - 10
				 */
				do_action( 'woocommerce_after_shop_loop' );
				?>
			</div>
			
		<?php else : ?>

			<?php wc_get_template( 'loop/no-products-found.php' ); ?>

		<?php endif; ?>

		<?php
		/**
		 * woocommerce_after_main_content hook
		 *
		 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
		 */
		do_action( 'woocommerce_after_main_content' );
		?>
	</section>

	<?php if( $content_class['right_sidebar'] && is_active_sidebar(mipro_get_opt('kft_prod_cat_right_sidebar')) ): ?>
		<aside id="right-sidebar" class="shop-sidebar <?php echo esc_attr($content_class['right_sidebar_class']); ?>">
			<div class="close-sidebar"><span><?php echo esc_html_e('Close','mipro'); ?></span></div>
			<?php dynamic_sidebar( mipro_get_opt('kft_prod_cat_right_sidebar') ); ?>
		</aside>
	<?php endif; ?>
</div>
</div>

<?php get_footer( 'shop' ); ?>