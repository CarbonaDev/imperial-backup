<?php
/**
 * Cart Page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce\Templates
 * @version 4.4.0
 */

defined( 'ABSPATH' ) || exit;

wc_print_notices();

do_action( 'woocommerce_before_cart' ); 
?>

<div class="woocommerce cart-content">
	<div class="woocommerce-cart-content-inner">
		<form class="woocommerce-cart-form" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post" onSubmit="setTimeout(function(){window.location.reload();},5000);"> 
			<?php do_action( 'woocommerce_before_cart_table' ); ?>
			
			<table class="shop_table cart woocommerce-cart-form__contents" cellspacing="0">
				<thead>
					<tr>
						<th class="product-remove">&nbsp;</th>
						<th colspan="2" class="product-name"><?php esc_html_e( 'Product', 'mipro' ); ?></th>
						<th class="product-price"><?php esc_html_e( 'Price', 'mipro' ); ?></th>
						<th class="product-quantity"><?php esc_html_e( 'Quantity', 'mipro' ); ?></th>
						<th class="product-subtotal"><?php esc_html_e( 'Subtotal', 'mipro' ); ?></th>
					</tr>
				</thead>
				<tbody>
					<?php do_action( 'woocommerce_before_cart_contents' ); ?>

					<?php
               $encomenda = false;
					foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
						$_product     = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
						$product_id   = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

						if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
							$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
							?>
							<tr class="woocommerce-cart-form__cart-item <?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">

								<td class="product-remove">
									<?php
									echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf(
										'<a href="%s" class="remove" aria-label="%s" data-product_id="%s" data-product_sku="%s" onClick="setTimeout(function(){window.location.reload();},5000);">&times;</a>',
										esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
										esc_html__( 'Remove this item', 'mipro' ),
										esc_attr( $product_id ),
										esc_attr( $_product->get_sku() )
									), $cart_item_key );
									?>
								</td>

								<td class="product-thumbnail">
									<?php
									$thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );

									if ( ! $product_permalink ) {
										echo wp_kses_post( $thumbnail );
									} else {
										printf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $thumbnail );
									}
									?>
								</td>

								<td class="product-name" data-title="<?php esc_attr_e( 'Product', 'mipro' ); ?>">
									<?php
									if ( ! $product_permalink ) {
										echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', esc_html( $_product->get_name() ), $cart_item, $cart_item_key ) . '&nbsp;' );
									} else {
										echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s</a>', esc_url( $product_permalink ), esc_html( $_product->get_name() ) ), $cart_item, $cart_item_key ) );
									}

									do_action( 'woocommerce_after_cart_item_name', $cart_item, $cart_item_key );

									// Meta data
									echo wc_get_formatted_cart_item_data( $cart_item );

               						// Backorder notification
									if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) ) {
										echo wp_kses_post( apply_filters( 'woocommerce_cart_item_backorder_notification', '<p class="backorder_notification">' . esc_html__( 'Available on backorder', 'mipro' ) . '</p>' ) );
                  $encomenda = true;
                   
									}
									?>
									<p class="mobile-cart-price">
										<span class="mobile-product-price__qty"><?php echo esc_html($cart_item['quantity']); ?> x </span>
										<?php
										echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
										?>
									</p>
								</td>

								<td class="product-price" data-title="<?php esc_attr_e( 'Price', 'mipro' ); ?>">
									<?php
									echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
									?>
								</td>

								<td class="product-quantity" data-title="<?php esc_attr_e( 'Quantity', 'mipro' ); ?>">
									<?php
									if ( $_product->is_sold_individually() ) {
										$product_quantity = sprintf( '1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key );
									} else {
										$product_quantity = woocommerce_quantity_input( array(
											'input_name'  => "cart[{$cart_item_key}][qty]",
											'input_value' => $cart_item['quantity'],
											'max_value'   => $_product->get_max_purchase_quantity(),
											'min_value'   => '0',
											'product_name' => $_product->get_name(),
										), $_product, false );
									}

									echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item );
									?>
								</td>

								<td class="product-subtotal" data-title="<?php esc_attr_e( 'Subtotal', 'mipro' ); ?>">
									<?php
									echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key );
									?>
								</td>

							</tr>
							<?php
						}
					}

					do_action( 'woocommerce_cart_contents' );
					?>
					<tr>
						<td colspan="6" class="actions">

							<?php if ( wc_coupons_enabled() ) { ?>
							<div class="coupon" style="float: right;">

								<label for="coupon_code"><?php esc_html_e( 'Coupon', 'mipro' ); ?>:</label> <input type="text" name="coupon_code" class="input-text" id="coupon_code" value="" placeholder="<?php esc_attr_e( 'Coupon code', 'mipro' ); ?>" /> <input type="submit" class="button" name="apply_coupon" value="<?php esc_attr_e( 'Apply Coupon', 'mipro' ); ?>" />

								<?php do_action( 'woocommerce_cart_coupon' ); ?>
							</div>
							<?php } ?>

							<input type="submit" class="button button-secondary" style="margin-right:10px;" name="update_cart" value="<?php esc_attr_e( 'Update Cart', 'mipro' ); ?>" />

							<?php do_action( 'woocommerce_cart_actions' ); ?>

							<?php wp_nonce_field( 'woocommerce-cart', 'woocommerce-cart-nonce' ); ?>
						</td>
					</tr>

					<?php do_action( 'woocommerce_after_cart_contents' ); ?>
				</tbody>
			</table>

			<?php do_action( 'woocommerce_after_cart_table' ); ?>
      <?php if($encomenda){ echo('<div style="border: 3px solid #e5e5e5; text-align:center;"> <div  style="background-color: #937C5C; text-align:center; font-weight:bold;"> <p class="backorder_notification" style="color:#fff !important; margin: 0px 3px;"> SOB ENCOMENDA </p> </div>
                                <p class="texto" style="background-color: #fff; color:#000 !important; margin-left:5%; margin-right:5%; "> 
                                Um ou mais produto(s), tem um prazo adicional para confec&ccedil;&atilde;o. Vamos confeccionar especialmente para voc&ecirc;!</p>
                                <p class="texto2" style="background-color: #fff; color:#000 !important; text-align:center;font-weight:bold;"> 20 a 30 dias &uacute;teis + prazo de entrega</p>
                      
                     </div>' ); }  ?>
		</form>
	</div>
  
	<?php do_action( 'woocommerce_before_cart_collaterals' ); ?>

	<div class="cart-collaterals">
		<?php do_action( 'woocommerce_cart_collaterals' ); ?>
	</div>
</div>

<?php do_action( 'woocommerce_after_cart' ); ?>
