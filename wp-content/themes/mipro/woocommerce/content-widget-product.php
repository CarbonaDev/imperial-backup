<?php
/**
 * The template for displaying product widget entries
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-widget-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @see 	http://docs.woothemes.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.5.5
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product;

if ( ! is_a( $product, 'WC_Product' ) ) {
	return;
}
?>

<li>
	<a class="kft-widget-image" href="<?php echo esc_url( get_permalink( $product->get_id() ) ); ?>" title="<?php echo esc_attr( $product->get_title() ); ?>">
		<?php echo wp_kses( $product->get_image(), array( 'img' => array('class' => true, 'width' => true, 'height' => true, 'src' => true, 'alt' => true) ) ); ?>
	</a>
	<div class="kft-meta-widget">
		<?php mipro_template_product_categories(); ?>
		<a href="<?php echo esc_url( get_permalink( $product->get_id() ) ); ?>" title="<?php echo esc_attr( $product->get_title() ); ?>">
			<?php echo esc_html( $product->get_title() ); ?>
		</a>
		<span class="price"><?php echo wp_kses_post( $product->get_price_html() ); ?></span>
		<?php if ( ! empty( $show_rating ) ) :
			echo wp_kses_post( wc_get_rating_html( $product->get_average_rating() ) );
		endif; ?>
	</div>
</li>