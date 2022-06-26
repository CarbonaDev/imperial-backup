<?php
/**
 * Single Product tabs
 *
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.8.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Filter tabs and allow third parties to add their own
 *
 * Each tab is an array containing title, callback and priority.
 * @see woocommerce_default_product_tabs()
 */

$tabs = apply_filters( 'woocommerce_product_tabs', array() );
?>

<?php if ( ! empty( $tabs ) ) : ?>
	<?php if ( shortcode_exists( 'kc_accordion' ) && mipro_get_opt('kft_prod_style_tabs') == 'accordion' ) : ?>

		<div class="woocommerce-tabs accordion-product-tabs wc-tabs-wrapper">
			<?php
			$kc_accordion = '[kc_accordion]';

			foreach ( $tabs as $key => $tab ) :
				$kc_accordion .= '[kc_accordion_tab tab_id="mipro-acc-' . rand() . '" title="' . apply_filters( 'woocommerce_product_' . $key . '_tab_title', $tab['title'], $key ) . '"]';
				ob_start();
				call_user_func( $tab['callback'], $key, $tab );
				$kc_accordion .= ob_get_clean();
				$kc_accordion .= '[/kc_accordion_tab]';
			endforeach;
			
			$kc_accordion .= '[/kc_accordion]';

			echo do_shortcode( $kc_accordion );
			?>
		</div>

	<?php elseif ( mipro_get_opt('kft_prod_style_tabs') == 'vertical' ) : ?>

		<div class="woocommerce-tabs vertical-product-tabs wc-tabs-wrapper">
			<ul class="product-tabs tabs wc-tabs col-sm-3 col-xs-12">
				<?php foreach ( $tabs as $key => $tab ) : ?>
					<li class="<?php echo esc_attr( $key ); ?>_tab">
						<a href="#tab-<?php echo esc_attr( $key ); ?>"><?php echo apply_filters( 'woocommerce_product_' . $key . '_tab_title',  esc_html( $tab['title'] ), $key ) ?></a>
					</li>
				<?php endforeach; ?>
			</ul>

			<div class="tab-panels col-sm-9 col-xs-12">
				<?php foreach ( $tabs as $key => $tab ) : ?>
					<div class="panel entry-content wc-tab" id="tab-<?php echo esc_attr( $key ); ?>">
						<?php call_user_func( $tab['callback'], $key, $tab ) ?>
					</div>
				<?php endforeach; ?>
			</div>
		</div>

	<?php else : ?>

		<div class="woocommerce-tabs wc-tabs-wrapper">
			<ul class="tabs wc-tabs">
				<?php foreach ( $tabs as $key => $tab ) : ?>
					<li class="<?php echo esc_attr( $key ); ?>_tab">
						<a href="#tab-<?php echo esc_attr( $key ); ?>"><?php echo apply_filters( 'woocommerce_product_' . $key . '_tab_title',  esc_html( $tab['title'] ), $key ) ?></a>
					</li>
				<?php endforeach; ?>
			</ul>

			<?php foreach ( $tabs as $key => $tab ) : ?>
				<div class="panel entry-content wc-tab" id="tab-<?php echo esc_attr( $key ); ?>">
					<?php call_user_func( $tab['callback'], $key, $tab ) ?>
				</div>
			<?php endforeach; ?>
		</div>

	<?php endif; ?>
<?php endif; ?>
