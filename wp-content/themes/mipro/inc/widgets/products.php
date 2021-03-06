<?php

if( !class_exists('Mipro_Products_Widget') ){
	class Mipro_Products_Widget extends WP_Widget {

		function __construct() {
			$widget_ops = array( 'classname' => 'kft-items-widget', 'description' => esc_html__( 'Display products on your sidebar','mipro' ) );
			parent::__construct( 'kft_products', esc_html__( 'Mipro - Products','mipro' ), $widget_ops );
		}

		function widget( $args, $instance ) {
			
			if ( ! mipro_is_woocommerce_activated() ) {
				return;
			}
			
			extract( $args );
			$title 				= apply_filters( 'widget_title', $instance['title'] );
			$limit 				= ( $instance['limit'] != 0 ) ? absint( $instance['limit'] ) : 8;
			$product_type 		= $instance['product_type'];
			$product_cats 		= $instance['product_cats'];
			$row 				= ( $instance['row'] != 0 ) ? absint( $instance['row'] ) : 4;
			$show_thumbnail 	= ! empty( $instance['show_thumbnail'] ) ? $instance['show_thumbnail'] : '';
			$thumbnail_size 	= $instance['thumbnail_size'];
			$show_categories 	= ! empty( $instance['show_categories'] ) ? $instance['show_categories'] : '';
			$show_product_title = ! empty( $instance['show_product_title'] ) ? $instance['show_product_title'] : '';
			$show_price 		= ! empty( $instance['show_price'] ) ? $instance['show_price'] : '';
			$show_rating 		= ! empty( $instance['show_rating'] ) ? $instance['show_rating'] : '';
			$is_slider 			= ! empty( $instance['is_slider'] ) ? $instance['is_slider'] : '';
			$show_nav 			= ! empty( $instance['show_nav'] ) ? $instance['show_nav'] : '';
			$auto_play 			= ! empty( $instance['auto_play'] ) ? $instance['auto_play'] : '';
			
			if ( $limit == $row ) {
				$is_slider = false;
			}
			
			$args = array(
				'post_type'				=> 'product',
				'post_status' 			=> 'publish',
				'ignore_sticky_posts'	=> 1,
				'posts_per_page' 		=> $limit,
				'orderby' 				=> 'date',
				'order' 				=> 'desc',
				'meta_query' 			=> WC()->query->get_meta_query(),
				'tax_query'           	=> WC()->query->get_tax_query(),
			);
			
			switch ( $product_type ) {
				case 'sale':
				$args['post__in'] = array_merge( array( 0 ), wc_get_product_ids_on_sale() );
				break;
				case 'featured':
				$args['tax_query'][] = array(
					'taxonomy' => 'product_visibility',
					'field'    => 'name',
					'terms'    => 'featured',
					'operator' => 'IN',
				);
				break;
				case 'best_selling':
				$args['meta_key'] 	= 'total_sales';
				$args['orderby'] 	= 'meta_value_num';
				$args['order'] 	= 'desc';
				break;
				case 'top_rated':		
				$args['meta_key'] = '_wc_average_rating';
				$args['orderby'] = 'meta_value_num';
				$args['order'] = 'DESC';
				break;
				case 'mixed_order':
				$args['orderby'] 	= 'rand';
				break;
				default:
				$args['orderby'] 	= 'date';
				$args['order'] 		= 'desc';
				break;
			}

			if ( is_array( $product_cats ) && count( $product_cats ) > 0 ) {
				$field_name = is_numeric( $product_cats[0] ) ? 'term_id' : 'slug';
				$args['tax_query'] = array(
					array(
						'taxonomy' 	=> 'product_cat',
						'terms' 	=> $product_cats,
						'field' 	=> $field_name,
					)
				);
			}
			global $post, $product;

			echo wp_kses_post( $before_widget );
			
			if ( $title ) {
				echo wp_kses_post( $before_title . $title . $after_title );
			}
			
			$products = new WP_Query( $args );
			if ( $products->have_posts() ) {
				$count = 0;
				$num_posts = $products->post_count;
				if ( $num_posts <= $row ) {
					$is_slider = false;
				}
				if ( ! $is_slider ) {
					$row = $num_posts;
				}
				
				$extra_class = '';
				$extra_class .= ( $is_slider ) ? ' slider loading' : '';
				
				?>
				
				<div class="kft-product-items-widget <?php echo esc_attr( $extra_class ); ?>" data-nav="<?php echo esc_attr( $show_nav ); ?>" data-auto_play="<?php echo esc_attr( $auto_play ); ?>">
					<?php while ( $products->have_posts() ): $products->the_post(); $product = wc_get_product( $post->ID ); ?>
						<?php if ( $count % $row == 0 ) : ?>

							<ul class="product-list-widget">
							<?php endif; ?>
							<li>
								<a class="product-widget-image" href="<?php echo esc_url( get_permalink( $product->get_id() ) ); ?>" title="<?php echo esc_attr( $product->get_title() ); ?>">
									<?php  
									if ( $show_thumbnail ) {
										echo wp_kses_post( $product->get_image( $thumbnail_size ) );	
									}
									?>
								</a>
								
								<div class="product-meta-widget item-information">
									<?php 
									if ( isset($show_categories) && $show_categories ) {
										add_action('woocommerce_after_shop_loop_item', 'mipro_template_product_categories', 25);
									} else {
										remove_action('woocommerce_after_shop_loop_item', 'mipro_template_product_categories', 25);
									}
									if ( isset($show_rating) && $show_rating ) {
										add_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_rating', 21);
									} else {
										remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_rating', 21);
									}
									if ( isset($show_product_title) && $show_product_title ) {
										add_action('woocommerce_after_shop_loop_item', 'mipro_template_product_title', 20);
									} else {
										remove_action('woocommerce_after_shop_loop_item', 'mipro_template_product_title', 20);
									}
									if ( isset($show_price) && $show_price ) {
										add_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_price', 50);
									} else {
										remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_price', 50);
									}
									do_action( 'woocommerce_after_shop_loop_item' ); 
									?>
								</div>
							</li>
							<?php if ( $count % $row == $row - 1 || $count == $num_posts - 1 ) : ?>	
							</ul>
						<?php endif; ?>

						<?php $count++; endwhile; ?>
					</div>
					<?php
				}
				echo wp_kses_post( $after_widget );
				
				wp_reset_postdata();
			}

			function update( $new_instance, $old_instance ) {
				$instance = $old_instance;		
				$instance['title'] = isset( $new_instance['title'] ) ? strip_tags( $new_instance['title'] ) : '';
				$instance['product_type'] = isset( $new_instance['product_type'] ) ? $new_instance['product_type'] : '';
				$instance['thumbnail_size'] = isset( $new_instance['thumbnail_size'] ) ? $new_instance['thumbnail_size'] : '';
				$instance['product_cats'] = isset( $new_instance['product_cats'] ) ? $new_instance['product_cats'] : '';		
				$instance['row'] = isset( $new_instance['row'] ) ? absint( $new_instance['row'] ) : '';		
				$instance['limit'] = isset( $new_instance['limit'] ) ? absint( $new_instance['limit'] ) : '';		
				$instance['show_thumbnail'] = isset( $new_instance['show_thumbnail'] ) ? $new_instance['show_thumbnail'] : '';		
				$instance['show_categories'] = isset( $new_instance['show_categories'] ) ? $new_instance['show_categories'] : '';		
				$instance['show_product_title'] = isset( $new_instance['show_product_title'] ) ? $new_instance['show_product_title'] :'';		
				$instance['show_price'] = isset( $new_instance['show_price'] ) ? $new_instance['show_price'] : '';		
				$instance['show_rating'] = isset( $new_instance['show_rating'] ) ? $new_instance['show_rating'] : '';		
				$instance['is_slider'] = isset( $new_instance['is_slider'] ) ? $new_instance['is_slider'] : '';		
				$instance['show_nav'] = isset( $new_instance['show_nav'] ) ? $new_instance['show_nav'] : '';		
				$instance['auto_play'] = isset( $new_instance['auto_play'] ) ? $new_instance['auto_play'] : '';	

				if ( $instance['row'] > $instance['limit'] ) {
					$instance['row'] = $instance['limit'];
				}

				return $instance;
			}

			function form( $instance ) {

				$defaults = array(
					'title'					=> 'Recent Products',
					'product_type'			=> 'recent',
					'thumbnail_size'		=> 'shop_thumbnail',
					'product_cats'			=> array(),
					'row'					=> '4',
					'limit'					=> '8',
					'show_thumbnail' 		=> 1,
					'show_categories' 		=> 1,
					'show_product_title' 	=> 1,
					'show_price' 			=> 1,
					'show_rating' 			=> 1,
					'is_slider'				=> 0,
					'show_nav' 				=> 1,
					'auto_play' 			=> 1,
				);

				$instance = wp_parse_args( (array) $instance, $defaults );	
				$categories = $this->get_list_categories(0);

				if ( ! is_array($instance['product_cats']) ) {
					$instance['product_cats'] = array();
				}

				?>
				<p>
					<label for="<?php echo esc_attr( $this->get_field_id('title') ); ?>"><?php esc_html_e( 'Enter your title', 'mipro' ); ?> </label>
					<input class="widefat" id="<?php echo esc_attr( $this->get_field_id('title') ); ?>" name="<?php echo esc_attr( $this->get_field_name('title') ); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>" />
				</p>

				<p>
					<label for="<?php echo esc_attr( $this->get_field_id('product_type') ); ?>"><?php esc_html_e( 'Product type', 'mipro' ); ?> </label>
					<select class="widefat" id="<?php echo esc_attr( $this->get_field_id('product_type') ); ?>" name="<?php echo esc_attr( $this->get_field_name('product_type') ); ?>">
						<option value="recent" <?php selected( $instance['product_type'], 'recent' ); ?>><?php esc_html_e( 'Recent', 'mipro' ); ?></option>
						<option value="sale" <?php selected( $instance['product_type'], 'sale' ); ?>><?php esc_html_e( 'Sale', 'mipro' ); ?></option>
						<option value="featured" <?php selected( $instance['product_type'], 'featured' ); ?>><?php esc_html_e( 'Featured', 'mipro' ); ?></option>
						<option value="best_selling" <?php selected( $instance['product_type'], 'best_selling' ); ?>><?php esc_html_e( 'Best selling', 'mipro' ); ?></option>
						<option value="top_rated" <?php selected( $instance['product_type'], 'top_rated' ); ?>><?php esc_html_e( 'Top rated', 'mipro' ); ?></option>
						<option value="mixed_order" <?php selected( $instance['product_type'], 'mixed_order' ); ?>><?php esc_html_e( 'Mixed order', 'mipro' ); ?></option>
					</select>
				</p>

				<p>
					<label><?php esc_html_e( 'Select categories', 'mipro' ); ?></label>
					<div class="categorydiv">
						<div class="tabs-panel">
							<ul class="categorychecklist">
								<?php foreach ( $categories as $cat ) : ?>
									<li>
										<label>
											<input type="checkbox" name="<?php echo esc_attr( $this->get_field_name('product_cats') ); ?>[<?php echo esc_attr( $cat->term_id ); ?>]" value="<?php echo esc_attr( $cat->term_id ); ?>" <?php echo ( in_array( $cat->term_id, $instance['product_cats'] ) ) ? 'checked' : ''; ?> />
											<?php echo esc_html( $cat->name ); ?>
										</label>
										<?php $this->get_list_sub_categories( $cat->term_id, $instance ); ?>
									</li>
								<?php endforeach; ?>
							</ul>
						</div>
					</div>
				</p>

				<p>
					<label for="<?php echo esc_attr( $this->get_field_id('row') ); ?>"><?php esc_html_e( 'Number of rows - in carousel slider', 'mipro' ); ?> </label>
					<input class="widefat" id="<?php echo esc_attr( $this->get_field_id('row') ); ?>" name="<?php echo esc_attr( $this->get_field_name('row') ); ?>" type="number" min="0" value="<?php echo esc_attr( $instance['row'] ); ?>" />
				</p>

				<p>
					<label for="<?php echo esc_attr( $this->get_field_id('limit') ); ?>"><?php esc_html_e( 'Number of posts to show', 'mipro' ); ?> </label>
					<input class="widefat" id="<?php echo esc_attr( $this->get_field_id('limit') ); ?>" name="<?php echo esc_attr( $this->get_field_name('limit') ); ?>" type="number" min="0" value="<?php echo esc_attr( $instance['limit'] ); ?>" />
				</p>

				<p>
					<input type="checkbox" id="<?php echo esc_attr( $this->get_field_id('show_thumbnail') ); ?>" name="<?php echo esc_attr( $this->get_field_name('show_thumbnail') ); ?>" value="1" <?php echo esc_attr( ( $instance['show_thumbnail'] ) ? 'checked' : '' ); ?> />
					<label for="<?php echo esc_attr( $this->get_field_id('show_thumbnail') ); ?>"><?php esc_html_e( 'Show thumbnail', 'mipro' ); ?></label>
				</p>

				<p>
					<label for="<?php echo esc_attr( $this->get_field_id('thumbnail_size') ); ?>"><?php esc_html_e( 'Thumbnail size', 'mipro' ); ?> </label>
					<select class="widefat" id="<?php echo esc_attr( $this->get_field_id('thumbnail_size') ); ?>" name="<?php echo esc_attr( $this->get_field_name('thumbnail_size') ); ?>">
						<option value="shop_thumbnail" <?php selected( $instance['thumbnail_size'], 'shop_thumbnail' ); ?>><?php esc_html_e( 'Thumbnail Image', 'mipro' ); ?></option>
						<option value="shop_catalog" <?php selected( $instance['thumbnail_size'], 'shop_catalog' ); ?>><?php esc_html_e( 'Catalog Image', 'mipro' ); ?></option>
						<option value="shop_single" <?php selected( $instance['thumbnail_size'], 'shop_single' ); ?>><?php esc_html_e( 'Single Image', 'mipro' ); ?></option>
					</select>
				</p>

				<p>
					<input type="checkbox" id="<?php echo esc_attr( $this->get_field_id('show_categories') ); ?>" name="<?php echo esc_attr( $this->get_field_name('show_categories') ); ?>" value="1" <?php echo esc_attr( ( $instance['show_categories'] ) ? 'checked' : '' ); ?> />
					<label for="<?php echo esc_attr( $this->get_field_id('show_categories') ); ?>"><?php esc_html_e( 'Show categories', 'mipro' ); ?></label>
				</p>

				<p>
					<input type="checkbox" id="<?php echo esc_attr( $this->get_field_id('show_product_title') ); ?>" name="<?php echo esc_attr( $this->get_field_name('show_product_title') ); ?>" value="1" <?php echo esc_attr( ( $instance['show_product_title'] ) ? 'checked' : '' ); ?> />
					<label for="<?php echo esc_attr( $this->get_field_id('show_product_title') ); ?>"><?php esc_html_e( 'Show product title', 'mipro' ); ?></label>
				</p>

				<p>
					<input type="checkbox" id="<?php echo esc_attr( $this->get_field_id('show_price') ); ?>" name="<?php echo esc_attr( $this->get_field_name('show_price') ); ?>" value="1" <?php echo esc_attr( ( $instance['show_price'] ) ? 'checked' : '' ); ?> />
					<label for="<?php echo esc_attr( $this->get_field_id('show_price') ); ?>"><?php esc_html_e( 'Show price', 'mipro' ); ?></label>
				</p>

				<p>
					<input type="checkbox" id="<?php echo esc_attr( $this->get_field_id('show_rating') ); ?>" name="<?php echo esc_attr( $this->get_field_name('show_rating') ); ?>" value="1" <?php echo esc_attr( ( $instance['show_rating'] ) ? 'checked' : '' ); ?> />
					<label for="<?php echo esc_attr( $this->get_field_id('show_rating') ); ?>"><?php esc_html_e( 'Show rating', 'mipro' ); ?></label>
				</p>

				<hr/>

				<p>
					<input type="checkbox" id="<?php echo esc_attr( $this->get_field_id('is_slider') ); ?>" name="<?php echo esc_attr( $this->get_field_name('is_slider') ); ?>" value="1" <?php echo esc_attr( ( $instance['is_slider'] ) ? 'checked' : '' ); ?> />
					<label for="<?php echo esc_attr( $this->get_field_id('is_slider') ); ?>"><?php esc_html_e( 'Show in a carousel slider', 'mipro' ); ?></label>
				</p>

				<p>
					<input type="checkbox" id="<?php echo esc_attr( $this->get_field_id('show_nav') ); ?>" name="<?php echo esc_attr( $this->get_field_name('show_nav') ); ?>" value="1" <?php echo esc_attr( ( $instance['show_nav'] ) ? 'checked' : '' ); ?> />
					<label for="<?php echo esc_attr( $this->get_field_id('show_nav') ); ?>"><?php esc_html_e( 'Show navigation button', 'mipro' ); ?></label>
				</p>

				<p>
					<input type="checkbox" id="<?php echo esc_attr( $this->get_field_id('auto_play') ); ?>" name="<?php echo esc_attr( $this->get_field_name('auto_play') ); ?>" value="1" <?php echo esc_attr( ( $instance['auto_play'] ) ? 'checked' : '' ); ?> />
					<label for="<?php echo esc_attr( $this->get_field_id('auto_play') ); ?>"><?php esc_html_e( 'Auto play', 'mipro' ); ?></label>
				</p>

				<?php 
			}

			function get_list_categories( $cat_parent_id ) {
				if ( ! mipro_is_woocommerce_activated() ) {
					return array();
				}
				$args = array(
					'taxonomy' 			=> 'product_cat',
					'hierarchical'		=> 1,
					'parent'			=> $cat_parent_id,
					'title_li'			=> '',
					'child_of'			=> 0,
				);
				$cats = get_categories( $args );

				return $cats;
			}

			function get_list_sub_categories( $cat_parent_id, $instance ) {
				$sub_categories = $this->get_list_categories( $cat_parent_id ); 
				if ( count( $sub_categories ) > 0): ?>
					<ul class="children">
						<?php foreach ( $sub_categories as $sub_cat ) : ?>
							<li>
								<label>
									<input type="checkbox" name="<?php echo esc_attr( $this->get_field_name('product_cats') ); ?>[<?php echo esc_attr( $sub_cat->term_id ); ?>]" value="<?php echo esc_attr( $sub_cat->term_id ); ?>" <?php echo ( in_array( $sub_cat->term_id, $instance['product_cats'] ) ) ? 'checked' : ''; ?> />
									<?php echo esc_html( $sub_cat->name ); ?>
								</label>
								<?php $this->get_list_sub_categories( $sub_cat->term_id, $instance ); ?>
							</li>
						<?php endforeach; ?>
					</ul>
					<?php 
				endif;
			}
		}
	}

