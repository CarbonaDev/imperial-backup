<?php
/**
 * Pagination - Show numbered pagination for catalog pages.
 *
 * @author      WooThemes
 * @package     WooCommerce/Templates
 * @version     3.3.1
 */

defined( 'ABSPATH' ) || exit;

global $wp_query;

$total = isset( $total ) ? $total : wc_get_loop_prop( 'total_pages' );
$current = isset( $current ) ? $current : wc_get_loop_prop( 'current_page' );
$base = isset( $base ) ? $base : esc_url_raw( str_replace( 999999999, '%#%', remove_query_arg( 'add-to-cart', get_pagenum_link( 999999999, false ) ) ) );
$format = isset( $format ) ? $format : '';

if ( $total <= 1 ) {
	return;
}
$woo_pagination = mipro_get_opt('kft_shop_pagination');
?>

<?php if ( $woo_pagination == 'loadmore' || $woo_pagination == 'infinit' ) : ?>
	<?php if ( get_next_posts_link() ) : ?>
		<button class="mipro-products-load-more hidden">
			<span class="load-more"><?php esc_html_e( 'Load more', 'mipro' ); ?></span>
		</button> 
		<span class="page-load-status">
			<p class="infinite-scroll-request spinner"><?php esc_html_e( 'Loading...', 'mipro' ); ?></p>
			<p class="infinite-scroll-last"><?php esc_html_e( 'End of Load Products', 'mipro' ); ?></p>
			<p class="infinite-scroll-error"><?php esc_html_e( 'Load Product Error', 'mipro' ); ?></p>
		</span>
	<?php endif; ?>
<?php endif; ?>

<nav class="woocommerce-pagination">
	<?php
	echo paginate_links( apply_filters('woocommerce_pagination_args', array( 
		'base' => $base,
		'format' => $format,
		'add_args' => false,
		'current' => max(1, $current),
		'total' => $total,
		'prev_text' => '',
		'next_text' => '',
		'type' => 'list',
		'end_size' => 3,
		'mid_size' => 3,
	) ) );
	?>
</nav>
