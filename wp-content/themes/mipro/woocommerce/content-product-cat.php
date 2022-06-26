<?php
/**
 * The template for displaying product category thumbnails within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product_cat.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woothemes.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 4.7.0
 */

defined( 'ABSPATH' ) || exit;
?>

<div <?php wc_product_cat_class( 'product-category-shortcode', $category ); ?>>
	<a href="<?php echo esc_url( get_term_link( $category->slug, 'product_cat' ) ); ?>" class="category-image">
		<?php do_action( 'woocommerce_before_subcategory', $category ); ?>
		<?php
		/**
		 * woocommerce_before_subcategory_title hook
		 *
		 * @hooked woocommerce_subcategory_thumbnail - 10
		 */

		do_action( 'woocommerce_before_subcategory_title', $category );
		?>
	</a>
	<div class="category-content">
		<?php if ( ! isset( $show_title ) || ( isset( $show_title ) && $show_title ) ) : ?>
			<h3 class="product-title"><a href="<?php echo esc_url( get_term_link( $category->slug, 'product_cat' ) ); ?>"><?php echo esc_html( $category->name ); ?></a></h3>
		<?php endif; ?>

		<?php if ( ! isset( $show_description ) || ( isset( $show_description ) && $show_description ) ) : ?>
			<div class="category-description">
				<p class="description">
					<?php echo esc_html( $category->description ); ?>
				</p>
			</div>
		<?php endif; ?>

		<div class="category-count">
			<?php echo sprintf( _n( '%s product', '%s products', $category->count, 'mipro' ), $category->count ); ?>
		</div>
	</div>

	<?php
	/**
	 * woocommerce_after_subcategory_title hook
	 */
	do_action( 'woocommerce_after_subcategory_title', $category );
	?>

	<?php do_action( 'woocommerce_after_subcategory', $category ); ?>

</div>
