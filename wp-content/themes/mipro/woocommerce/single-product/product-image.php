<?php
/**
 * Single Product Image
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-image.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.5.1
 */

defined( 'ABSPATH' ) || exit;

global $post, $product;

$vertical_thumbnail = mipro_get_opt('kft_prod_thumbnails_style') == 'vertical';

$classes = array();
$classes[] = 'loading'; 
if ( mipro_get_opt('kft_product_zoom') ) {
	$classes[] = 'has-product-zoom'; 
}
if ( mipro_get_opt('kft_product_lightbox') ) {
	$classes[] = 'has-product-lightbox'; 
}

$post_thumbnail_id = $product->get_image_id();
$full_size_image   = wp_get_attachment_image_src( $post_thumbnail_id, 'full' );
?>

<div class="product-gallery <?php echo esc_attr( $vertical_thumbnail ? 'vertical-gallery' : 'default-gallery' ); ?>">

	<?php if ( $vertical_thumbnail ) :
		wc_get_template( 'woocommerce/single-product/product-gallery-thumbnails.php' ); 
	endif; ?>

	<div class=" <?php echo esc_attr( $vertical_thumbnail ? 'col-xs-10' : 'col-md-12' ); ?>">
		<div class="product-images-wrapper">
			
			<?php
			do_action( 'kft_before_product_image' );
			echo '<div class="images ' . esc_attr( implode( ' ', $classes ) ) . '">';

			if ( $product->get_image_id() ) {
				$attributes = array(
					'title'                   => get_post_field( 'post_excerpt', $post_thumbnail_id ),
					'data-index' 			  => 0,
					'data-src'                => $full_size_image[0],
					'data-large_image'        => $full_size_image[0],
					'data-large_image_width'  => $full_size_image[1],
					'data-large_image_height' => $full_size_image[2],
				);

				$html  = '<div data-thumb="' . get_the_post_thumbnail_url( $post->ID, 'woocommerce_thumbnail' ) . '" class="woocommerce-product-gallery__image first"><a href="' . esc_url( $full_size_image[0] ) . '">';
				$html .= get_the_post_thumbnail( $post->ID, 'woocommerce_single', $attributes );
				$html .= '</a></div>';
			} else {
				$html  = '<div class="woocommerce-product-gallery__image--placeholder">';
				$html .= sprintf( '<img src="%s" alt="%s" class="wp-post-image" />', esc_url( wc_placeholder_img_src() ), esc_html__( 'Awaiting product image', 'mipro' ) );
				$html .= '</div>';
			}

			echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', $html, $post_thumbnail_id );

			do_action( 'woocommerce_product_thumbnails' );

			echo '</div>';
			?>

		</div>
	</div>

	<?php if ( ! $vertical_thumbnail ) : 
		wc_get_template( 'woocommerce/single-product/product-gallery-thumbnails.php' ); 
	endif; ?>

</div>
