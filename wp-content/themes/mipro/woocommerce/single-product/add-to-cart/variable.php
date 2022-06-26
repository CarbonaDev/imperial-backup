<?php
/**
 * Variable product add to cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/add-to-cart/variable.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.5.5
 */
defined( 'ABSPATH' ) || exit;

global $product, $post;

$attribute_keys = array_keys( $attributes );

$show_swatches = mipro_get_opt('kft_prod_variation_swatches');
$select_class = '';
if ( $show_swatches ) {
	$select_class = 'hidden';
}

do_action( 'woocommerce_before_add_to_cart_form' ); ?>

<form class="variations_form cart" action="<?php echo esc_url( apply_filters( 'woocommerce_add_to_cart_form_action', $product->get_permalink() ) ); ?>" method="post" enctype='multipart/form-data' data-product_id="<?php echo absint( $product->get_id() ); ?>" data-product_variations="<?php echo htmlspecialchars( wp_json_encode( $available_variations ) ) ?>">
	<?php do_action( 'woocommerce_before_variations_form' ); ?>
	
	<?php if ( empty( $available_variations ) && false !== $available_variations ) : ?>
		<p class="stock out-of-stock"><?php esc_html_e( 'This product is currently out of stock and unavailable.', 'mipro' ); ?></p>
	<?php else : ?>
		<table class="variations" cellspacing="0">
			<tbody>
				<?php foreach ( $attributes as $attribute_name => $options ) : ?>

					<tr>
						<td class="label"><label for="<?php echo esc_attr( sanitize_title( $attribute_name ) ); ?>"><?php echo wc_attribute_label( $attribute_name ); ?></label></td>
						<td class="value">

							<?php if( $show_swatches && is_array( $options ) ): ?>
								<div class="kft-product-attribute">
									<?php 
									if ( isset( $_REQUEST[ 'attribute_' . sanitize_title( $attribute_name ) ] ) ) {
										$selected_value = $_REQUEST[ 'attribute_' . sanitize_title( $attribute_name ) ];
									} elseif ( isset( $selected_attributes[ sanitize_title( $attribute_name ) ] ) ) {
										$selected_value = $selected_attributes[ sanitize_title( $attribute_name ) ];
									} else {
										$selected_value = '';
									}

									// Get terms if this is a taxonomy - ordered
									if ( taxonomy_exists( $attribute_name ) ) {

										$has_color_swatches = false;
										$attribute_color = wc_sanitize_taxonomy_name( 'color' );
										if( $attribute_name == wc_attribute_taxonomy_name( $attribute_color ) ){
											$has_color_swatches = true;
										}
										$terms = wc_get_product_terms( $post->ID, $attribute_name, array( 'fields' => 'all' ) );

										foreach ( $terms as $term ) {
											if ( ! in_array( $term->slug, $options ) ) {
												continue;
											}

											if ( $has_color_swatches ) {
												$color = $image = '';
												$color = get_term_meta( $term->term_id, 'color_color', true );
												$image = get_term_meta( $term->term_id, 'color_image', true );	
											}

											$class = sanitize_title( $selected_value ) == sanitize_title( $term->slug ) ? 'selected' : '';
											$class .= ' variation-product__option';
											if( $has_color_swatches ){
												$class .= ' color';
											}

											echo '<div data-variation="' . esc_attr( $term->slug ) . '" class="' . $class . '">';

											if ( $has_color_swatches ) {
												if ( trim( $image ) != '' ) {
													echo '<a href="#"><img width="32" height="32" src="' . esc_url($image) . '" class="color-image-attr" alt="' . $term->name . '" title="' . $term->name . '"></a>';
												}
												else {
													echo '<a href="#" class="kft-tooltip" style="background-color:' . $color . '">' . apply_filters( 'woocommerce_variation_option_name', $term->name ) . '</a>';
												}
											}
											else {
												echo '<a href="#">' . apply_filters( 'woocommerce_variation_option_name', $term->name ) . '</a>';
											}

											echo '</div>';
										}

									} else {

										foreach ( $options as $option ) {
											$class = sanitize_title( $selected_value ) == sanitize_title( $option ) ? 'selected' : '';
											$class .= ' variation-product__option';
											echo '<div data-variation="' . esc_attr( $option ) . '" class="' . $class . '"><a href="#">' . esc_html( apply_filters( 'woocommerce_variation_option_name', $option ) ) . '</a></div>';
										}

									}
									?>
								</div>
							<?php endif;
							
							$selected = isset( $_REQUEST[ 'attribute_' . sanitize_title( $attribute_name ) ] ) ? wc_clean( $_REQUEST[ 'attribute_' . sanitize_title( $attribute_name ) ] ) : $product->get_variation_default_attribute( $attribute_name );
							wc_dropdown_variation_attribute_options( array( 'options' => $options, 'attribute' => $attribute_name, 'product' => $product, 'selected' => $selected, 'class' => $select_class ) );
							echo end( $attribute_keys ) === $attribute_name ? wp_kses_post( apply_filters( 'woocommerce_reset_variations_link', '<a class="reset_variations" href="#">' . esc_html__( 'Clear', 'mipro' ) . '</a>' ) ) : '';
							?>
						</td>
					</tr>

				<?php endforeach; ?>
			</tbody>
		</table>

		<?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>

		<div class="single_variation_wrap">
			<?php
				/**
				 * woocommerce_before_single_variation Hook
				 */
				do_action( 'woocommerce_before_single_variation' );

				/**
				 * woocommerce_single_variation hook. Used to output the cart button and placeholder for variation data.
				 * @since 2.4.0
				 * @hooked woocommerce_single_variation - 10 Empty div for variation data.
				 * @hooked woocommerce_single_variation_add_to_cart_button - 20 Qty and cart button.
				 */
				do_action( 'woocommerce_single_variation' );

				/**
				 * woocommerce_after_single_variation Hook
				 */
				do_action( 'woocommerce_after_single_variation' );
				?>
			</div>

			<?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>

		<?php endif; ?>

		<?php do_action( 'woocommerce_after_variations_form' ); ?>
	</form>

	<?php do_action( 'woocommerce_after_add_to_cart_form' ); ?>
