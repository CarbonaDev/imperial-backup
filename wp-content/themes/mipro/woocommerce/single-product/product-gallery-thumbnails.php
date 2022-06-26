<?php
global $post, $product, $woocommerce;

$attachment_ids = $product->get_gallery_image_ids();
$vertical_thumbnail = mipro_get_opt('kft_prod_thumbnails_style') == 'vertical';
if ( $attachment_ids ) {
  ?>

  <div class="thumbnails <?php echo esc_attr( $vertical_thumbnail ? 'vertical-thumbnail col-xs-2' : 'col-md-12' ); ?>">
    <div class="product-thumbnails loading">

      <?php if ( has_post_thumbnail() ) : ?>
        <div class="thumbnail-image first"><a><?php echo get_the_post_thumbnail( $post->ID, apply_filters( 'single_product_small_thumbnail_size', 'woocommerce_single' ) ) ?></a></div>
      <?php endif; ?>

      <?php foreach ( $attachment_ids as $attachment_id ) {
        $classes = array( '' );
        $image_title  = esc_attr( get_the_title( $attachment_id ) );
        $image_caption  = esc_attr( get_post_field( 'post_excerpt', $attachment_id ) );
        $image_class = esc_attr( implode( ' ', $classes ) );
        $image       = wp_get_attachment_image( $attachment_id, apply_filters( 'single_product_small_thumbnail_size', 'woocommerce_single' ), 0, $attr = array(
          'title' => $image_title,
          'alt' => $image_title
        ) );

        echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', sprintf( '<div class="thumbnail-image"><a class="%s" title="%s" >%s</a></div>', $image_class, $image_caption, $image ), $attachment_id, $post->ID, $image_class );
      }
      ?>
      
    </div><!-- .product-thumbnails -->
  </div>
<?php }  ?>
