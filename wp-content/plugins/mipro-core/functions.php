<?php

/* Filter Product */
function mipro_filter_product_by_product_type( &$args = array(), $product_type = 'recent' ) {
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
			$args['meta_key'] = 'total_sales';
			$args['orderby']  = 'meta_value_num';
			$args['order']    = 'desc';
			break;
		case 'top_rated':
			$args['meta_key'] = '_wc_average_rating';
			$args['orderby']  = 'meta_value_num';
			$args['order']    = 'DESC';
			break;
		case 'mixed_order':
			$args['orderby'] = 'rand';
			break;
		default: /* Recent */
			$args['orderby'] = 'date';
			$args['order']   = 'desc';
			break;
	}
}


/*** Social Sharing */
if ( ! function_exists( 'mipro_template_social_sharing' ) ) {
	function mipro_template_social_sharing() {
		?>
		<ul class="social-sharing">

			<li class="facebook">
				<a href="https://www.facebook.com/sharer.php?u=<?php echo esc_url( get_permalink() ); ?>" target="_blank"><i class="fa fa-facebook"></i><?php esc_html_e( 'Facebook', 'mipro-core' ); ?></a>
			</li>

			<li class="twitter">
				<a href="https://twitter.com/home?status=<?php echo esc_url( get_permalink() ); ?>" target="_blank"><i class="fa fa-twitter"></i><?php esc_html_e( 'Twitter', 'mipro-core' ); ?></a>
			</li>

			<li class="pinterest">
				<?php $image_link = wp_get_attachment_url( get_post_thumbnail_id() ); ?>
				<a href="https://pinterest.com/pin/create/button/?url=<?php echo esc_url( get_permalink() ); ?>&amp;media=<?php echo esc_url( $image_link ); ?>" target="_blank"><i class="fa fa-pinterest"></i><?php esc_html_e( 'Pinterest', 'mipro-core' ); ?></a>
			</li>

			<li class="google-plus">
				<a href="https://plus.google.com/share?url=<?php echo esc_url( get_permalink() ); ?>" target="_blank"><i class="fa fa-google-plus"></i><?php esc_html_e( 'Google Plus', 'mipro-core' ); ?></a>
			</li>

			<li class="linkedin">
				<a href="http://linkedin.com/shareArticle?mini=true&amp;url=<?php echo esc_url( get_permalink() ); ?>&amp;title=<?php echo esc_attr( sanitize_title( get_the_title() ) ); ?>" target="_blank"><i class="fa fa-linkedin"></i><?php esc_html_e( 'Linkedin', 'mipro-core' ); ?></a>
			</li>

			<li class="reddit">
				<a href="http://www.reddit.com/submit?url=<?php echo esc_url( get_permalink() ); ?>&amp;title=<?php echo esc_attr( sanitize_title( get_the_title() ) ); ?>" target="_blank"><i class="fa fa-reddit"></i><?php esc_html_e( 'Reddit', 'mipro-core' ); ?></a>
			</li>

		</ul>
		<?php
	}
}/*** Social Sharing v2*/
if ( ! function_exists( 'mipro_template_social_sharing_blog' ) ) {
	function mipro_template_social_sharing_blog() {
		?>
		<ul class="social-sharing-blog">

			<li class="facebook kft-tooltip">
				<a href="https://www.facebook.com/sharer.php?u=<?php echo esc_url( get_permalink() ); ?>" target="_blank"><i class="icon-social-facebook"></i><?php esc_html_e( 'Facebook', 'mipro-core' ); ?></a>
			</li>

			<li class="twitter kft-tooltip">
				<a href="https://twitter.com/home?status=<?php echo esc_url( get_permalink() ); ?>" target="_blank"><i class="icon-social-twitter"></i><?php esc_html_e( 'Twitter', 'mipro-core' ); ?></a>
			</li>

			<li class="reddit kft-tooltip">
				<a href="http://www.reddit.com/submit?url=<?php echo esc_url( get_permalink() ); ?>&amp;title=<?php echo esc_attr( sanitize_title( get_the_title() ) ); ?>" target="_blank"><i class="icon-social-reddit"></i><?php esc_html_e( 'Reddit', 'mipro-core' ); ?></a>
			</li>

			<li class="linkedin kft-tooltip">
				<a href="http://linkedin.com/shareArticle?mini=true&amp;url=<?php echo esc_url( get_permalink() ); ?>&amp;title=<?php echo esc_attr( sanitize_title( get_the_title() ) ); ?>" target="_blank"><i class="icon-social-linkedin"></i><?php esc_html_e( 'Linkedin', 'mipro-core' ); ?></a>
			</li>


		</ul>
		<?php
	}
}

/*** Social Network */
if ( ! function_exists( 'mipro_template_social_network' ) ) {
	function mipro_template_social_network() {
		if ( ! function_exists( 'mipro_get_opt' ) ) {
			return;
		}

		$socials = apply_filters(
			'mipro_core_social_network_buttons',
			array(
				'facebook'  => array(
					'link'  => ! empty( mipro_get_opt( 'facebook_link' ) ) ? mipro_get_opt( 'facebook_link' ) : '',
					'icon'  => 'fa fa-facebook',
					'label' => esc_html__( 'Facebook', 'mipro-core' ),
				),
				'twitter'   => array(
					'link'  => ! empty( mipro_get_opt( 'twitter_link' ) ) ? mipro_get_opt( 'twitter_link' ) : '',
					'icon'  => 'fa fa-twitter',
					'label' => esc_html__( 'Twitter', 'mipro-core' ),
				),
				'instagram' => array(
					'link'  => ! empty( mipro_get_opt( 'instagram_link' ) ) ? mipro_get_opt( 'instagram_link' ) : '',
					'icon'  => 'fa fa-instagram',
					'label' => esc_html__( 'Instagram', 'mipro-core' ),
				),
				'pinterest' => array(
					'link'  => ! empty( mipro_get_opt( 'pinterest_link' ) ) ? mipro_get_opt( 'pinterest_link' ) : '',
					'icon'  => 'fa fa-pinterest',
					'label' => esc_html__( 'Pinterest', 'mipro-core' ),
				),
				'reddit'    => array(
					'link'  => ! empty( mipro_get_opt( 'reddit_link' ) ) ? mipro_get_opt( 'reddit_link' ) : '',
					'icon'  => 'fa fa-reddit',
					'label' => esc_html__( 'Reddit', 'mipro-core' ),
				),
				'youtube'   => array(
					'link'  => ! empty( mipro_get_opt( 'youtube_link' ) ) ? mipro_get_opt( 'youtube_link' ) : '',
					'icon'  => 'fa fa-youtube',
					'label' => esc_html__( 'Youtube', 'mipro-core' ),
				),
				'linkedin'  => array(
					'link'  => ! empty( mipro_get_opt( 'linkedin_link' ) ) ? mipro_get_opt( 'linkedin_link' ) : '',
					'icon'  => 'fa fa-linkedin',
					'label' => esc_html__( 'Linkedin', 'mipro-core' ),
				),
			)
		);

		if ( ! empty( $socials ) ) {
			echo '<ul class="social-sharing">';
			foreach ( $socials as $key => $social ) {
				if ( ! empty( $social['link'] ) ) {
					echo '<li class="' . esc_attr( $key ) . '">';
					echo '<a href="' . esc_url( $social['link'] ) . '" target="_blank">';
					echo '<i class="' . esc_attr( $social['icon'] ) . '"></i>';
					echo esc_html( $social['label'] );
					echo '</a>';
					echo '</li>';
				}
			}
			echo '</ul>';
		}
	}
}

// Remove Calc Image on Single Product
add_action( 'wp', 'mipro_remove_calc_images' );
function mipro_remove_calc_images() {
	if ( is_singular( 'product' ) ) {
		add_filter( 'wp_calculate_image_sizes', '__return_false', 9999 );
		add_filter( 'wp_calculate_image_srcset', '__return_false', 9999 );
		remove_filter( 'the_content', 'wp_make_content_images_responsive' );
	}
}

// Remove Redux Demo Link
function mipro_removeDemoModeLink() {
	if ( class_exists( 'ReduxFrameworkPlugin' ) ) {
		remove_filter( 'plugin_row_meta', array( ReduxFrameworkPlugin::get_instance(), 'plugin_metalinks' ), null, 2 );
	}
	if ( class_exists( 'ReduxFrameworkPlugin' ) ) {
		remove_action( 'admin_notices', array( ReduxFrameworkPlugin::get_instance(), 'admin_notices' ) );
	}
}
add_action( 'init', 'mipro_removeDemoModeLink' );

// Enable Custom Post type on KingComposer
add_action( 'init', 'mipro_enable_post_type', 99 );
function mipro_enable_post_type() {
	if ( class_exists( 'KingComposer' ) ) {
		global $kc;
		$kc->add_content_type( 'kft_footer' );
	}

}

// Remove the custom options provided by the default twentyeleven theme.
add_action( 'after_setup_theme', 'mipro_remove_custom_options', 100 );
function mipro_remove_custom_options() {
	remove_theme_support( 'custom-background' );
	remove_theme_support( 'custom-header' );
}

// Lazy Load Images
function mipro_add_lazy_load_attrs() {
	if ( function_exists( 'mipro_lazy_loading' ) ) {
		add_filter( 'wp_get_attachment_image_attributes', 'mipro_lazy_loading', 10, 3 );
	}
}

function mipro_remove_lazy_load_attrs() {
	if ( function_exists( 'mipro_lazy_loading' ) ) {
		remove_filter( 'wp_get_attachment_image_attributes', 'mipro_lazy_loading', 10 );
	}
}

function mipro_get_instagram_feed( $number = 6 ) {
	$user_id      = mipro_get_opt( 'instagram_user_id' );
	$access_token = mipro_get_opt( 'instagram_access_token' );

	if ( empty( $access_token ) || empty( $user_id ) ) {
		return new WP_Error( 'site_down', esc_html__( 'You need config for User ID and Access Token in Theme Options > Instagram.', 'mipro-core' ) );
	}

	$transient = 'mipro-instagram-photo-' . $access_token . '-' . $number;
	$instagram = get_transient( $transient );

	if ( false === $instagram ) {
		$response = wp_remote_get( 'https://graph.facebook.com/' . $user_id . '/media?access_token=' . $access_token . '&fields=timestamp,caption,media_type,media_url,thumbnail_url,like_count,comments_count,permalink&limit=' . $number . '' );

		if ( is_wp_error( $response ) ) {
			return new WP_Error( 'site_down', esc_html__( 'Unable to communicate with Instagram.', 'mipro-core' ) );
		}

		$body = json_decode( $response['body'] );

		if ( is_object( $body ) ) {
			if ( isset( $body->error->message ) ) {
				return new WP_Error( 'site_down', $body->error->message );
			}
			if ( isset( $body->data ) ) {
				if ( ! is_array( $body->data ) || count( $body->data ) <= 0 ) {
					return new WP_Error( 'site_down', esc_html__( 'There are no images in your account.', 'mipro-core' ) );
				}
			}
		} else {
			return new WP_Error( 'site_down', esc_html__( 'Error decoding the instagram json.', 'mipro-core' ) );
		}

		$instagram = array();
		if ( $body->data ) {
			foreach ( $body->data as $item ) {
				$caption = esc_html__( 'Instagram Image', 'mipro-core' );

				if ( isset( $item->caption ) ) {
					$caption = $item->caption;
				}

				if ( 'VIDEO' === $item->media_type ) {
					$image_url = $item->thumbnail_url;
				} else {
					$image_url = $item->media_url;
				}

				$instagram[] = array(
					'link'      => preg_replace( '/^https:/i', '', $item->permalink ),
					'image_url' => preg_replace( '/^https:/i', '', $image_url ),
					'likes'     => isset( $item->like_count ) ? $item->like_count : '0',
					'comments'  => isset( $item->comments_count ) ? $item->comments_count : '0',
					'caption'   => $caption,
				);
			}
		}

		$instagram = base64_encode( maybe_serialize( $instagram ) );

		if ( $instagram ) {
			set_transient( $transient, $instagram, HOUR_IN_SECONDS * 6 );
		}
	}

	$instagram = maybe_unserialize( base64_decode( $instagram ) );

	return $instagram;
}
