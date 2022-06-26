<?php
/************************************
 *** Custom Post Type Shortcodes
 *************************************/

/** Shortcode Mega Menu **/
function kft_mega_menu_shortcode( $atts, $content ) {

	extract( shortcode_atts( array(
		'title' => 'All Categories',
		'nav_menu' => '',
		'extra_class' => '',
	), $atts ) );

	$instance = array(
		'title' => $title,
		'nav_menu' => $nav_menu,
	);
	$classes = apply_filters( 'kc-el-class', $atts );
	$classes[] = 'kft-mega-menu-shortcode';
	$classes[] = $extra_class;

	ob_start();
	?>

	<div class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>">
		<?php the_widget('Mipro_WP_Nav_Menu_Widget', $instance); ?>
	</div>

	<?php
	return ob_get_clean();
}
add_shortcode('kft_mega_menu_wg', 'kft_mega_menu_shortcode');

/*** Shortcode Team memmber ***/
function kft_team_member_shortcode( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'image' => '',
		'style_img' => 'default',
		'name' => '',
		'title' => 'CEO / FOUNDER',
		'link' => '',
		'position' => 'meta',
		'icon_style' => 'colored',
		'facebook' => '',
		'twitter' => '',
		'google_plus' => '',
		'linkedin' => '',
		'dribbble' => '',
		'instagram' => '',
		'pinterest' => '',
		'rss' => '',
		'target' => '_blank',
	), $atts));

	if ( trim( $name ) == '' ) {
		return;
	}

	$link     = ( '||' === $link ) ? '' : $link;
	$link     = kc_parse_link( $link );
	$link_att = array();

	if ( strlen( $link['url'] ) > 0 ) {
		$a_target = strlen( $link['target'] ) > 0 ? $link['target'] : '_self';
		
		$link_att[] = 'href="' . esc_url( $link['url'] ) . '"';
		$link_att[] = 'target="' . esc_attr( $a_target ) . '"';
		$link_att[] = 'title="' . esc_attr( $link['title'] ) . '"';
	}

	$classes = apply_filters( 'kc-el-class', $atts );
	$classes[] = 'kft-team-member';
	$classes[] = $style_img;
	$classes[] = $icon_style;

	$social_content = '';

	if ( $facebook ) {
		$social_content .= '<li><a class="facebook" href="' . esc_url( $facebook ) . '" target="' . $target . '"><i class="fa fa-facebook"></i></a></li>';
	}
	if ( $twitter ) {
		$social_content .= '<li><a class="twitter" href="' . esc_url( $twitter ) . '" target="' . $target . '"><i class="fa fa-twitter"></i></a></li>';
	}
	if ( $google_plus ) {
		$social_content .= '<li><a class="google-plus" href="' . esc_url($google_plus) . '" target="' . $target . '"><i class="fa fa-google-plus"></i></a></li>';
	}
	if ( $linkedin ) {
		$social_content .= '<li><a class="linked" href="' . esc_url( $linkedin ) . '" target="' . $target . '"><i class="fa fa-linkedin"></i></a></li>';
	}
	if ( $rss ) {
		$social_content .= '<li><a class="rss" href="' . esc_url( $rss ) . '" target="' . $target . '"><i class="fa fa-rss"></i></a></li>';
	}
	if ( $dribbble ) {
		$social_content .= '<li><a class="dribbble" href="' . esc_url( $dribbble ) . '" target="' . $target . '"><i class="fa fa-dribbble"></i></a></li>';
	}
	if ( $pinterest ) {
		$social_content .= '<li><a class="pinterest" href="' . esc_url( $pinterest ) . '" target="' . $target . '"><i class="fa fa-pinterest-p"></i></a></li>';
	}
	if ( $instagram ) {
		$social_content .= '<li><a class="instagram" href="' . esc_url( $instagram ) . '" target="' . $target . '"><i class="fa fa-instagram"></i></a></li>';
	}

	ob_start();
	?>
	<div class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>">
		<div class="image">
			<div class="image-team">
				<?php echo wp_get_attachment_image( $image, 'full', 0, array( 'class' => 'img' ) ); ?>
				<?php if ( $position == 'thumbnail' ) : ?>
					<div class="overlay"></div>
				<?php endif; ?>
			</div>

			<?php if ( $position == 'thumbnail' ) : ?>
				<div class="on-thumbnail">
					<h3><a class="name" <?php echo implode( ' ', $link_att ); ?>><?php echo esc_html( $name ); ?></a></h3>
					<span class="job"><?php echo esc_html( $title ); ?></span>
					<div class="socials">
						<ul> <?php echo wp_kses_post( $social_content ); ?> </ul>
					</div>
				</div>
			<?php endif; ?>
		</div>

		<div class="content-member">
			<?php if ( $position == 'meta' ) : ?>
				<h3><a class="name" <?php echo implode( ' ', $link_att ); ?>><?php echo esc_html( $name ); ?></a></h3>
				<span class="job"><?php echo esc_html( $title ); ?></span>
				<div class="socials">
					<ul> <?php echo wp_kses_post( $social_content ); ?> </ul>
				</div>
			<?php endif; ?>

			<div class="excerpt"><?php echo do_shortcode( $content ); ?></div>
		</div>
	</div>

	<?php
	return ob_get_clean();
}
add_shortcode( 'kft_team_member', 'kft_team_member_shortcode' );

/*** Shortcode Mailchimp  ***/
if ( ! function_exists( 'kft_mailchimp_subscription_shortcode' ) ) {
	function kft_mailchimp_subscription_shortcode( $atts ) {
		extract( shortcode_atts( array( 
			'title' => 'Newsletter',
			'intro_text' => '',
			'header_text' =>'',
			'form' => '',
			'bg_image' => '',
			'text_style' => 'text-default',
			'style' => 'style-1',
		), $atts ) );

		$bg_img = wp_get_attachment_url( $bg_image );
		$bg_image = '';

		if ( ! class_exists( 'Mipro_Mailchimp_Subscription_Widget' ) ) {
			return;
		}

		$instance = compact( 'title','header_text', 'intro_text', 'bg_image', 'form', 'text_style' );

		$classes = apply_filters( 'kc-el-class', $atts );
		$classes[] = 'kft-mailchimp-shortcode';
		$classes[] = $style;

		ob_start();

		echo '<div class=" ' . esc_attr( implode( ' ', $classes ) ) . '" style="background-image:url(' . $bg_img . ')" >';

		the_widget( 'Mipro_Mailchimp_Subscription_Widget', $instance );

		echo '</div>';

		return ob_get_clean();
	}
}
add_shortcode( 'kft_mailchimp_subscription', 'kft_mailchimp_subscription_shortcode' );

/*** Shortcode Instagram ***/
function kft_instagram_shortcode( $atts ) {
	extract( shortcode_atts( array(
		'title' => 'Instagram',
		'username' => '',
		'number' => '9',
		'column' => '3',
		'size' => 'large',
		'target' => '_self',
		'cache_time' => '12',
	), $atts ) );

	if ( ! class_exists( 'Mipro_Instagram_Widget' ) ) {
		return;
	}

	$instance = array(
		'title' => $title,
		'username' => $username,
		'number' => $number,
		'column' => $column,
		'size' => $size,
		'target' => $target,
		'cache_time' => $cache_time,
	);

	$classes = apply_filters( 'kc-el-class', $atts );
	$classes[] = 'kft-instagram-shortcode';

	ob_start();

	echo '<div class=" ' . esc_attr( implode( ' ', $classes ) ) . '">';
	the_widget( 'Mipro_Instagram_Widget', $instance );
	echo '</div>';

	return ob_get_clean();
}
add_shortcode( 'kft_instagram', 'kft_instagram_shortcode' );

/*** Shortcode Feature Box ***/
function kft_feature_shortcode( $atts ) {
	extract( shortcode_atts( array( 
		'icon_style' => 'icon',
		'icon' => '',
		'icon_position' => 'center',
		'img_id' => '',
		'image_style' => 'default',
		'title' => '',
		'excerpt' => '',
		'link' => '',
		'extra_class' => '',
	), $atts ) );

	ob_start();

	$has_link = false;
	if ( ! empty( $link ) ) {

		$link     = ( '||' === $link ) ? '' : $link;
		$link     = kc_parse_link( $link );
		$link_att = array();

		if ( strlen( $link['url'] ) > 0 ) {
			$has_link = true;
			$a_target = strlen( $link['target'] ) > 0 ? $link['target'] : '_self';

			$links = esc_attr( $link['url'] );
			$target = esc_attr( $a_target );
			$link_title = esc_attr( $link['title'] );
		}
	}

	if ( empty( $icon ) ) {
		$icon = 'fa-leaf';
	}

	$classes = apply_filters( 'kc-el-class', $atts );
	$classes[] = 'kft-feature-box';
	$classes[] = $extra_class;
	$classes[] = $icon_style;
	if ( $icon_style == 'icon' ) {
		$classes[] = $icon_position;
	} else {
		$classes[] = $image_style;
	}
	?>
	<div class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>">

		<?php if ( $icon_style == 'icon' ) : ?>
			<a target="<?php echo $has_link ? esc_attr( $target ) : '_self'; ?>" class="feature_icon" href="<?php echo $has_link ? esc_url( $links ) : 'javascript: void(0)'; ?>" title ="<?php echo $has_link ? esc_attr( $link_title ) : ''; ?>">
				<i class="<?php echo esc_attr( $icon ); ?>"></i>
			</a>
		<?php endif; ?>

		<?php if ( $icon_style == 'image' ) : ?>
			<a target="<?php echo $has_link ? esc_attr( $target ) : '_self'; ?>" class="feature_image" href="<?php echo $has_link ? esc_url( $links ) : 'javascript: void(0)'; ?>" title ="<?php echo $has_link ? esc_attr( $link_title ) : ''; ?>">
				<?php echo wp_get_attachment_image( $img_id, 'full', 0 ); ?>

				<?php if ( $image_style == 'overlay' ) : ?>
					<div class="overlay"></div>
				<?php endif; ?>
			</a>
		<?php endif; ?>

		<div class="feature_content">
			<?php if ( ! empty( $title ) ) : ?>
				<h3 class="feature-title entry-title">
					<a target="<?php echo $has_link ? esc_attr( $target ) : '_self'; ?>" href="<?php echo $has_link ? esc_url( $links ) : 'javascript: void(0)'; ?>" title ="<?php echo $has_link ? esc_attr( $link_title ) : ''; ?>"><?php echo esc_html( $title ); ?></a>
				</h3>
			<?php endif; ?>

			<?php if ( ! empty( $excerpt ) ) : ?>
				<p class="feature_info">
					<?php echo esc_html( $excerpt ); ?>
				</p>
			<?php endif; ?>
		</div>
	</div>
	<?php
	return ob_get_clean();
}
add_shortcode( 'kft_feature', 'kft_feature_shortcode' );

/***  Shortcode Testimonial  ***/
function kft_testimonials_shortcode( $atts = array(), $content = '' ) {
	extract( shortcode_atts( array( 
		'title' => '',
		'layout' => 'slider',
		'style' => 'default',
		'margin' => '30',
		'columns' => '3',
		'autoplay' => 'no',
		'show_nav' => 'no',
		'show_dots' => 'no',
		'extra_class' => '',
		'desksmini' => '3',
		'tablet' => '2',
		'tabletmini' => '2',
		'mobile' => '1',
		'mobilesmini' => '1',
	), $atts ) );

	if ( ! is_numeric( $margin ) ) {
		$margin = 30;
	}

	$classes = apply_filters( 'kc-el-class', $atts );
	$classes[] = $extra_class;
	$classes[] = 'layout-' . $layout;
	$classes[] = 'columns-' . $columns;
	$classes[] = 'style-' . $style;

	$data_attr = array();
	if ( $layout == 'slider' ) {
		$data_attr[] = 'data-margin=' . esc_attr( $margin );
		$data_attr[] = 'data-nav=' . esc_attr( ( $show_nav == 'yes' ) ? 1 : 0 );
		$data_attr[] = 'data-dots=' . esc_attr( ( $show_dots == 'yes' ) ? 1 : 0 );
		$data_attr[] = 'data-autoplay=' . esc_attr( ( $autoplay == 'yes' ) ? 1 : 0 );
		$data_attr[] = 'data-desksmini=' . esc_attr( $desksmini ? $desksmini : 3 );
		$data_attr[] = 'data-tablet=' . esc_attr( $tablet ? $tablet : 2 );
		$data_attr[] = 'data-tabletmini=' . esc_attr( $tabletmini ? $tabletmini : 2 );
		$data_attr[] = 'data-mobile=' . esc_attr( $mobile ? $mobile : 1 );
		$data_attr[] = 'data-mobilesmini=' . esc_attr( $mobilesmini ? $mobilesmini : 1 );
		$data_attr[] = 'data-columns=' . esc_attr( $columns ? $columns : 3 );
		$data_attr[] = 'data-slider=1';
	}

	ob_start();
	?>
	<div class="kft-testimonials-shortcode <?php echo esc_attr( implode( ' ', $classes ) ); ?>" <?php echo esc_attr( implode( ' ', $data_attr ) ); ?>>
		<?php if ( ! empty( $title ) ) : ?>
			<div class="section-title">
				<h2 class="section-title-main"><?php echo esc_html( $title ); ?></h2>
			</div>
		<?php endif; ?>
		<div class="meta-slider">
			<div class="testimonial">
				<?php echo do_shortcode( $content ); ?>
			</div>
		</div>
	</div>
	<?php
	$output = ob_get_contents();
	ob_end_clean();

	return $output;
}
add_shortcode( 'kft_testimonials', 'kft_testimonials_shortcode' );

function kft_testimonial_shortcode( $atts, $content = '' ) {
	extract( shortcode_atts( array(
		'image' => '',
		'img_width' => '80',
		'image_position' => 'top',
		'name' => '',
		'company' => '',
		'extra_class' => '',
	), $atts) );

	$classes = apply_filters( 'kc-el-class', $atts );
	$classes[] = $extra_class;
	$classes[] = 'testimonial-item';
	$classes[] = 'testimonial-image-' . $image_position;

	ob_start();
	?>
	<div class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>">
		<div class="testimonial-wrapper">
			<div class="avatar" style="width: <?php echo $img_width . 'px' ?>">
				<?php echo wp_get_attachment_image( $image, 'thumbnail', 0, array( 'class' => 'img' ) ); ?>
			</div>
			<div class="content">
				<span class="excerpt">
					<?php echo do_shortcode( $content ); ?>
				</span>
				<div class="name">
					<?php echo esc_html( $name ); ?>
					<?php if ( $company ) : ?>
						<span class="company"><?php echo esc_html( $company ); ?></span>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
	<?php
	$output = ob_get_contents();
	ob_end_clean();

	return $output;
}
add_shortcode('kft_testimonial', 'kft_testimonial_shortcode');

/*** Shortcode Banner ***/
function kft_banners_slider_shortcode( $atts = array(), $content = '' ) {
	extract( shortcode_atts( array(
		'title' => '',
		'margin' => '30',
		'columns' => '3',
		'autoplay' => 'no',
		'show_nav' => 'no',
		'show_dots' => 'no',
		'extra_class' => '',
		'desksmini' => '3',
		'tablet' => '2',
		'tabletmini' => '2',
		'mobile' => '1',
		'mobilesmini' => '1',
	), $atts ) );

	if ( ! is_numeric( $margin ) ) {
		$margin = 30;
	}

	$classes = apply_filters( 'kc-el-class', $atts );
	$classes[] = $extra_class;

	$data_attr = array();
	$data_attr[] = 'data-margin=' . esc_attr( $margin );
	$data_attr[] = 'data-nav=' . esc_attr( ( $show_nav == 'yes' ) ? 1 : 0 );
	$data_attr[] = 'data-dots=' . esc_attr( ( $show_dots == 'yes' ) ? 1 : 0 );
	$data_attr[] = 'data-autoplay=' . esc_attr( ( $autoplay == 'yes' ) ? 1 : 0 );
	$data_attr[] = 'data-desksmini=' . esc_attr( $desksmini ? $desksmini : 3 );
	$data_attr[] = 'data-tablet=' . esc_attr( $tablet ? $tablet : 2 );
	$data_attr[] = 'data-tabletmini=' . esc_attr( $tabletmini ? $tabletmini : 2 );
	$data_attr[] = 'data-mobile=' . esc_attr( $mobile ? $mobile : 1 );
	$data_attr[] = 'data-mobilesmini=' . esc_attr( $mobilesmini ? $mobilesmini : 1 );
	$data_attr[] = 'data-columns=' . esc_attr( $columns ? $columns : 1 );
	$data_attr[] = 'data-slider=1';

	ob_start(); 
	?>
	<div class="kft-banners-slider <?php echo esc_attr( implode(' ', $classes) ); ?>" <?php echo esc_attr( implode(' ', $data_attr) ); ?>>
		<?php if ( $title != '' ) : ?>
			<div class="section-title">
				<h2 class="section-title-main"><?php echo esc_html( $title ); ?></h2>
			</div>
		<?php endif; ?>

		<div class="meta-slider">
			<div class="banners">
				<?php echo do_shortcode( $content ); ?>
			</div>
		</div>
	</div>
	<?php
	$output = ob_get_contents();
	ob_end_clean();

	return $output;
}
add_shortcode( 'kft_banners', 'kft_banners_slider_shortcode' );

function kft_banner_shortcode( $atts, $content = '' ) {
	extract( shortcode_atts( array(
		'title' => '',
		'bg_image' => '',
		'image_size' => 'full',
		'overlay' => '',
		'hover_effect' => 'none',
		'position_content' => 'center-center',
		'link' => '',
		'extra_class' => '',
	), $atts ) );

	if ( empty( $bg_image ) ) {
		return;
	}

	if ( $image_size == '' ) {
		$image_size = 'full';
	}

	$size_array = array( 'full', 'medium', 'large', 'thumbnail' );
	$image_data = wp_get_attachment_image_src( $bg_image, $image_size );
	$image_url = $image_data[0];

	if ( ! in_array( $image_size, $size_array ) && class_exists( 'kc_tools' ) ) {
		$image_url 	= kc_tools::createImageSize( $image_url, $image_size );
	}

	$classes = apply_filters( 'kc-el-class', $atts );
	$classes[] = $position_content;

	if ( $hover_effect != 'none' ) {
		$classes[] = 'has-hover';
		$classes[] = 'image-hover-' . $hover_effect;
	}
	$classes[] = $extra_class;

	$link_att = array();
	if ( function_exists( 'kc_parse_link' ) ) {
		$link     = ( '||' === $link ) ? '' : $link;
		$link     = kc_parse_link( $link );

		if ( strlen( $link['url'] ) > 0 ) {
			$a_target = strlen( $link['target'] ) > 0 ? $link['target'] : '_self';

			$link_att[] = 'href="' . esc_url( $link['url'] ) . '"';
			$link_att[] = 'target="' . esc_attr( $a_target ) . '"';
			$link_att[] = 'title="' . esc_attr( $link['title'] ) . '"';
		}
	}

	ob_start();
	?>
	<div class="kft-banner-shortcode <?php echo esc_attr( implode( ' ', $classes ) ); ?>">
		<div class="kft-banner-content">

			<div class="image">

				<?php if ( isset( $link['url'] ) && $link['url'] != '' ) : ?>
					<a <?php echo implode(' ', $link_att); ?> class="banner-link">
					<?php endif; ?>
					<img src="<?php echo esc_url( $image_url ); ?>" alt="">
					<?php if ( isset( $link['url'] ) && $link['url'] != '' ) : ?>
					</a>
				<?php endif; ?>

				<?php if ( $overlay ) : ?>
					<div class="overlay" style="background-color: <?php echo esc_attr( $overlay ); ?>"></div>
				<?php endif; ?>
			</div>
			
			<div class="content">
				<?php if ( $title != '' ) : ?>
					<div class="section-title">
						<h2 class="section-title-main"><?php echo esc_html( $title ); ?></h2>
					</div>
				<?php endif; ?>
				<?php
				$content = wpautop( preg_replace( '/<\/?p\>/', "\n", $content) . "\n" );
				echo do_shortcode( shortcode_unautop( $content ) );
				?>
				<?php if ( isset( $link['url'] ) && $link['url'] != '' && $link['title'] != '' ) : ?>
					<div class="link-title">
					<a <?php echo implode(' ', $link_att); ?> class="link-titlea button-readmore">
					<?php endif; ?>
					
					<?php if ( isset( $link['url'] ) && $link['url'] != '' && $link['title'] != '')  : ?>  
						<?php echo esc_attr( $link['title'] ); ?>
					</a>
				</div>
				<?php endif; ?>


			</div>
		</div>
	</div>
	<?php

	$output = ob_get_contents();
	ob_end_clean();
	return $output;
}
add_shortcode( 'kft_banner', 'kft_banner_shortcode' );

/*** Shortcode Images Gallery ***/
if ( ! function_exists( 'kft_images_gallery_shortcode' ) ) {
	function kft_images_gallery_shortcode( $atts ) {
		extract( shortcode_atts( array(
			'images' => '',
			'image_size' => 'full',
			'layout' => 'grid',
			'columns' => '3',
			'margin' => '30',
			'nav' => 'no',
			'dots' => 'no',
			'autoplay' => 'no',
			'action' => '',
			'custom_links' => '',
			'desksmini' => '2',
			'tablet' => '2',
			'tabletmini' => '2',
			'mobile' => '1',
			'mobilesmini' => '1',
		), $atts ) );

		$target = '_self';
		if ( ! is_numeric( $margin ) ) {
			$margin = 30;
		}
		$columns = $columns ? $columns : 3;
		$images = str_replace( ' ', '', $images );
		if ( $images == '' ) {
			return;
		}
		$images = explode( ',', $images );

		if ( $image_size == '' ) {
			$image_size = 'full';
		}
		$size_array = array( 'full', 'medium', 'large', 'thumbnail' );

		$classes = apply_filters( 'kc-el-class', $atts );
		$classes[] = 'layout-' . $layout;
		if ( $layout != 'slider' ) {
			$classes[] = 'columns-' . $columns;
		}
		if ( $action == 'lightbox' ) {
			$classes[] = 'lightbox';
		}
		if ( $action == 'links' ) {
			$custom_links = ( '||' === $custom_links ) ? '' : $custom_links;
			$custom_links = kc_parse_link( $custom_links );
			$custom_link = esc_url( $custom_links['url'] );
			$a_target = strlen( $custom_links['target'] ) > 0 ? $custom_links['target'] : '_self';
			$target = esc_attr( $a_target );
		}

		$data_attr = array();
		if ( $layout == 'slider' ) {
			$data_attr[] = 'data-margin=' . esc_attr( $margin );
			$data_attr[] = 'data-nav=' . esc_attr( ( $nav == 'yes' ) ? 1 : 0 );
			$data_attr[] = 'data-dots=' . esc_attr( ( $dots == 'yes' ) ? 1 : 0 );
			$data_attr[] = 'data-autoplay=' . esc_attr( ( $autoplay == 'yes' ) ? 1 : 0 );
			$data_attr[] = 'data-desksmini=' . esc_attr( $desksmini ? $desksmini : 2 );
			$data_attr[] = 'data-tablet=' . esc_attr( $tablet ? $tablet : 2 );
			$data_attr[] = 'data-tabletmini=' . esc_attr( $tabletmini ? $tabletmini : 2 );
			$data_attr[] = 'data-mobile=' . esc_attr( $mobile ? $mobile : 1 );
			$data_attr[] = 'data-mobilesmini=' . esc_attr( $mobilesmini ? $mobilesmini : 1 );
			$data_attr[] = 'data-columns=' . esc_attr( $columns );
		}

		ob_start();
		?>
		<div class="kft-images-shortcode <?php echo esc_attr( implode( ' ', $classes ) ); ?>" <?php echo esc_attr( implode( ' ', $data_attr ) ); ?>>
			<div class="images-gallery">
				<?php
				if ( is_array ($images ) || is_object( $images ) ) :
					foreach ( $images as $index => $img_id ) :
						$attachment = get_post( $img_id );
						$title = trim( strip_tags( $attachment->post_title ) );

						if ( $action == 'lightbox' ) {
							$custom_link = wp_get_attachment_image_src( $img_id, 'large' );
							$custom_link = $custom_link[0];
						}

						$image_data = wp_get_attachment_image_src( $img_id, $image_size );
						$image_url = $image_data[0];
						?>

						<div class="images-gallery-item">
							<?php if ( $action != '' ) : ?>
								<a href="<?php echo esc_url( $custom_link ); ?>" target="<?php echo esc_attr( $target ); ?>" title="<?php echo esc_attr( $title ); ?>">
								<?php endif; ?>	

								<?php if ( in_array( $image_size, $size_array ) ) : ?>
									<?php echo wp_get_attachment_image( $img_id, $image_size ); ?>

									<?php elseif ( class_exists( 'kc_tools' ) ) : ?>	
										<?php $image_url = kc_tools::createImageSize( $image_url, $image_size ); ?>
										<img src="<?php echo esc_url( $image_url ); ?>" alt="">
									<?php endif; ?>

									<?php if ( $action != '' ) : ?>
									</a>
								<?php endif; ?>

							</div>
						<?php endforeach; ?>
					<?php endif; ?>
				</div>
			</div>

			<?php
			if ( function_exists( 'kc_js_callback' ) ) {
				kc_js_callback( 'MiproTheme.GalleryImagesShortcode' );
			}

			$output = ob_get_contents();
			ob_end_clean();
			return $output;
		}

		add_shortcode( 'kft_images_gallery', 'kft_images_gallery_shortcode' );
	}

	/*** Shortcode Brand ***/
	if ( ! function_exists( 'kft_brands_slider_shortcode' ) ) {
		function kft_brands_slider_shortcode( $atts, $content = null ) {
			extract( shortcode_atts( array(
				'title' => '',
				'categories' => '',
				'per_page' => 7,
				'rows' => 1,
				'columns' => 4,
				'active_link' => 'no',
				'nav' => 'yes',
				'autoplay' => 'no',
				'margin_image' => '30',
				'desksmini' => '4',
				'tablet' => '3',
				'tabletmini' => '2',
				'mobile' => '2',
				'mobilesmini' => '1',
			), $atts ) );

			if ( ! class_exists('Mipro_Brands') ) {
				return;
			}

			$rows = $rows ? $rows : 1;
			$columns = $columns ? $columns : 4;
			$desksmini = $desksmini ? $desksmini : 4;
			$tablet = $tablet ? $tablet : 3;
			$tabletmini = $tabletmini ? $tabletmini : 2;
			$mobile = $mobile ? $mobile : 2;
			$mobilesmini = $mobilesmini ? $mobilesmini : 1;

			if ( ! is_numeric( $margin_image ) ) {
				$margin_image = 30;
			}

			if ( ! is_numeric( $per_page ) ) {
				$per_page = 4;
			}

			$args = array(
				'post_type' => 'kft_brand',
				'post_status' => 'publish',
				'ignore_sticky_posts' => 1,
				'posts_per_page' => $per_page,
				'orderby' => 'date',
				'order' => 'asc',
			);

			$categories = str_replace( ' ', '', $categories );
			if ( strlen( $categories ) > 0 ) {
				$categories = explode( ',', $categories );
			}

			if ( is_array( $categories ) && count( $categories ) > 0 ) {
				$field_name = is_numeric( $categories[0] ) ? 'term_id' : 'slug';
				$args['tax_query'] = array(
					array(
						'taxonomy' => 'kft_brand_cat',
						'terms' => $categories,
						'field' => $field_name,
						'include_children' => false,
					),
				);
			}

			$brands = new WP_Query( $args );

			global $post;
			ob_start();
			if ( $brands->have_posts() ) {

				$data_attr = array();
				$data_attr[] = 'data-margin=' . esc_attr( $margin_image );
				$data_attr[] = 'data-nav=' . esc_attr( ( $nav == 'yes' ) ? 1 : 0 );
				$data_attr[] = 'data-dots= 0';
				$data_attr[] = 'data-autoplay=' . esc_attr( ( $autoplay == 'yes' ) ? 1 : 0 );
				$data_attr[] = 'data-desksmini=' . esc_attr( $desksmini );
				$data_attr[] = 'data-tablet=' . esc_attr( $tablet );
				$data_attr[] = 'data-tabletmini=' . esc_attr( $tabletmini );
				$data_attr[] = 'data-mobile=' . esc_attr( $mobile );
				$data_attr[] = 'data-mobilesmini=' . esc_attr( $mobilesmini );
				$data_attr[] = 'data-columns=' . esc_attr( $columns );
				$data_attr[] = 'data-slider= 1';

				$classes = apply_filters( 'kc-el-class', $atts );
				$classes[] = 'kft-brand-slider-shortcode';
				?>
				<div id="brand-<?php echo rand(1, 1000); ?>" class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>" <?php echo implode( ' ', $data_attr ); ?>>

					<?php if ( strlen( $title ) > 0 ) : ?>
						<div class="section-title">
							<h3 class="section-title-main">
								<span><?php echo esc_html( $title ); ?></span>
							</h3>
						</div>
					<?php endif; ?>

					<div class="meta-slider loading">
						<div class="brands owl-carousel">
							<?php
							$count = 0;
							while ( $brands->have_posts() ) {
								$brands->the_post();
								if ( $rows > 1 && $count % $rows == 0 ) {
									echo '<div class="brand">';
								} ?>

								<div class="item">
									<?php if ( $active_link == 'yes' ) :
										$brand_url = get_post_meta( $post->ID, 'kft_brand_url', true );
										$brand_target = get_post_meta( $post->ID, 'kft_brand_target', true );
										?>
										<a href="<?php echo esc_url( $brand_url ); ?>" target="<?php echo esc_attr( $brand_target ); ?>">
										<?php endif; ?>

										<?php if ( has_post_thumbnail() ) {
											the_post_thumbnail('kft_brand_thumb');
										} ?>

										<?php if ( $active_link == 'yes' ) : ?>
										</a>
									<?php endif; ?>
								</div>

								<?php
								if ( $rows > 1 && ($count % $rows == $rows - 1 || $count == $count_posts - 1) ) {
									echo '</div>';
								}
								$count++;
							}
							?>

						</div>
					</div>
				</div>

				<?php
				if ( function_exists( 'kc_js_callback' ) ) {
					kc_js_callback( 'MiproTheme.SliderShortcode' );
				}
			}
			wp_reset_postdata();
			return ob_get_clean();
		}
	}
	add_shortcode( 'kft_brands_slider', 'kft_brands_slider_shortcode' );

/************************************
 *** Element Shortcodes
 *************************************/

/*** Shortcode Blog ***/
if ( ! function_exists( 'kft_blogs_shortcode' ) ) {
	function kft_blogs_shortcode( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'blog_title' => '',
			'columns' => '3',
			'categories' => '',
			'title' => 'yes',
			'limit' => 5,
			'orderby' => 'none',
			'order' => 'DESC',
			'thumbnail' => 'yes',
			'author' => 'no',
			'date' => 'no',
			'comment' => 'yes',
			'excerpt' => 'yes',
			'view' => 'no',
			'readmore' => 'yes',
			'excerpt_words' => 20,
			'layout' => 'grid',
			'nav' => 'yes',
			'dots' => 'no',
			'autoplay' => 'no',
			'margin' => 30,
			'load_more' => 'no',
			'load_more_text' => 'Show more',
			'style' => '',
			'desksmini' => '3',
			'tablet' => '2',
			'tabletmini' => '2',
			'mobile' => '1',
			'mobilesmini' => '1',
		), $atts ) );

		if ( ! is_numeric( $excerpt_words ) ) {
			$excerpt_words = 20;
		}
		$style_blog=array();
		$style_blog[] =$style; 
		$columns = $columns ? $columns : 3;
		$load_more = ( $load_more == 'yes' ) ? 1 : 0;

		$slider = $masonry = 0;
		if ( $layout == 'slider' ) {
			$slider = 1;
		}
		if ( $layout == 'masonry' ) {
			$masonry = 1;
		}

		$args = array(
			'post_type' => 'post',
			'post_status' => 'publish',
			'ignore_sticky_posts' => 1,
			'posts_per_page' => $limit,
			'orderby' => $orderby,
			'order' => $order,
		);

		$categories = str_replace( ' ', '', $categories );
		if ( strlen( $categories ) > 0 ) {
			$ar_categories = explode( ',', $categories );
			if ( is_array( $ar_categories ) && count( $ar_categories ) > 0 ) {
				$field_name = is_numeric( $ar_categories[0] ) ? 'term_id' : 'slug';
				$args['tax_query'] = array(
					array(
						'taxonomy' => 'category',
						'terms' => $ar_categories,
						'field' => $field_name,
						'include_children' => false,
					),
				);
			}
		}

		global $post;
		$posts = new WP_Query( $args );

		ob_start();
		if ( $posts->have_posts() ) {
			if ( $posts->post_count <= 1 ) {
				$slider = 0;
			}
			if ( $slider ) {
				$load_more = 0;
			}

			$atts = compact( 'slider', 'categories', 'limit', 'orderby', 'order', 'columns', 'title', 'thumbnail', 'author', 'date', 'comment', 'excerpt', 'readmore', 'view', 'excerpt_words', 'load_more' );

			$classes = apply_filters( 'kc-el-class', $atts );
			$data_attr = array();
			$classes[] = 'kft-blogs-shortcode';
			if ( $slider ) {
				$classes[] = 'slider';
				$data_attr[] = 'data-slider=' . esc_attr( $slider );
				$data_attr[] = 'data-columns=' . esc_attr( $columns );
				$data_attr[] = 'data-nav=' . esc_attr( ( $nav == 'yes' ) ? 1 : 0 );
				$data_attr[] = 'data-dots=' . esc_attr( ( $dots == 'yes' ) ? 1 : 0 );
				$data_attr[] = 'data-autoplay=' . esc_attr( ( $autoplay == 'yes' ) ? 1 : 0 );
				$data_attr[] = 'data-margin=' . esc_attr( $margin );
				$data_attr[] = 'data-desksmini=' . esc_attr( $desksmini ? $desksmini : 3 );
				$data_attr[] = 'data-tablet=' . esc_attr( $tablet ? $tablet : 2 );
				$data_attr[] = 'data-tabletmini=' . esc_attr( $tabletmini ? $tabletmini : 2 );
				$data_attr[] = 'data-mobile=' . esc_attr( $mobile ? $mobile : 1 );
				$data_attr[] = 'data-mobilesmini=' . esc_attr( $mobilesmini ? $mobilesmini : 1 );
			}
			if ( $masonry ) {
				$classes[] = 'masonry';
			}
			if ( ! $slider && $load_more ) {
				$classes[] = 'has-load-more';
				$data_attr[] = 'data-atts=' . htmlentities(json_encode($atts));
			}

			?>
			<div class="<?php echo esc_attr( implode(' ', $classes) ).' '.esc_attr( implode(' ', $style_blog)) ?>" <?php echo esc_attr( implode(' ', $data_attr) ); ?>>

				<?php if ( strlen( $blog_title ) > 0 ) : ?>
					<div class="section-title">
						<h3 class="section-title-main"><span><?php echo esc_html( $blog_title ); ?></span></h3>
					</div>
				<?php endif; ?>

				<div class="meta-slider <?php echo ($slider) ? esc_attr('loading') : ''; ?>">
					<div class="blogs">
						<?php kft_get_blog_items_content_shortcode( $atts, $posts );?>
					</div>

					<?php if ( $load_more ) : ?>
						<div class="load-more-wrapper">
							<a href="#" class="load-more button" data-paged="2"><?php echo esc_html( $load_more_text ) ?></a>
						</div>
					<?php endif; ?>

				</div>
			</div>

			<?php
		}
		wp_reset_postdata();
		return ob_get_clean();
	}
}
add_shortcode('kft_blogs', 'kft_blogs_shortcode');

add_action('wp_ajax_kft_blogs_load_items', 'kft_get_blog_items_content_shortcode');
add_action('wp_ajax_nopriv_kft_blogs_load_items', 'kft_get_blog_items_content_shortcode');
if ( ! function_exists('kft_get_blog_items_content_shortcode') ) {
	function kft_get_blog_items_content_shortcode( $atts, $posts = null ) {

		global $post;

		if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
			if ( ! isset( $_POST['atts'] ) ) {
				die();
			}
			$atts = $_POST['atts'];
			$paged = isset( $_POST['paged'] ) ? absint( $_POST['paged'] ) : 1;

			extract( $atts );

			$args = array(
				'post_type' => 'post',
				'post_status' => 'publish',
				'ignore_sticky_posts' => 1,
				'posts_per_page' => $limit,
				'orderby' => $orderby,
				'order' => $order,
				'paged' => $paged,
			);

			$categories = str_replace( ' ', '', $categories );
			if ( strlen( $categories ) > 0 ) {
				$categories = explode( ',', $categories );
			}

			if ( is_array( $categories ) && count( $categories ) > 0 ) {
				$field_name = is_numeric( $categories[0] ) ? 'term_id' : 'slug';
				$args['tax_query'] = array(
					array(
						'taxonomy' => 'category',
						'terms' => $categories,
						'field' => $field_name,
						'include_children' => false,
					),
				);
			}

			$posts = new WP_Query( $args );
			ob_start();
		}

		extract( $atts );

		if ( $posts->have_posts() ) {
			$item_class = '';
			if ( ! $slider ) {
				$item_class = 12 / (int) $columns;
				$item_class = 'col-sm-' . $item_class;
			}
			$key = -1;
			while ( $posts->have_posts() ) { 
				$posts->the_post();

				$post_format = get_post_format(); /* Video, Audio, Gallery, Quote */
				if ( $slider && $post_format == 'gallery' ) {
					/* Remove Slider in Slider */
					$post_format = false;
				}

				$key++;
				$item_extra_class = ($key % $columns == 0) ? 'first' : ( ( $key % $columns == $columns - 1 ) ? 'last' : '' );
				$post_class = array();
				$post_class[] = $item_class;
				$post_class[] = 'item post-item hentry';
				$post_class[] = $item_extra_class;
				$post_class[] = $post_format;
				?>
				<article id="post-<?php the_ID(); ?>" <?php post_class( $post_class ); ?>>
					<header class="entry-header">
						<?php if ( $thumbnail == 'yes' ) : ?>
							<?php mipro_post_thumb( array( 'size' => 'full', 'class' => '' ) ); ?>
						<?php endif; ?>
					</header>

					<?php if ( $post_format != 'quote' ) : ?>
						<div class="entry-content">
							<?php if ( $author == 'yes' ) : ?>
								<span class="vcard author"><?php esc_html_e( 'Posted by: ', 'mipro-core' ); ?>
								<?php echo get_avatar( get_the_author_meta( 'ID' ), 32 ); ?>
								<?php the_author_posts_link(); ?></span>
							<?php endif; ?>

							<?php if ( $date == 'yes' ) : ?>
								<div class="date-time">
									<?php echo get_the_time( get_option( 'date_format' ) ); ?>
								</div>
							<?php endif; ?>

							<?php if ( $title == 'yes' ) : ?>
								<h3 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
							<?php endif; ?>

							<?php if ( $comment == 'yes' ) : ?>
								<?php
								if ( get_comments_number() == 0 ) {
									$comments = esc_html__( 'No Comments', 'mipro-core' );
								} elseif ( get_comments_number() > 1 ) {
									$comments = sprintf( esc_html__( '%s Comments', 'mipro-core' ), get_comments_number() );
								} else {
									$comments = esc_html__( '1 Comment', 'mipro-core' );
								}
								echo '<a class="comment" href="' . get_comments_link() . '"> <i class="fa fa-comments"></i> ' . $comments . '</a>';
								?>
							<?php endif; ?>

							<?php if ( $view == 'yes' ) : ?>
								<span class="count-view"><?php esc_html_e( 'View: ', 'mipro-core' );?><?php echo mipro_get_post_views( get_the_ID() ); ?></span>
							<?php endif; ?>
							<div class="clear"></div>

							<?php if ( $excerpt == 'yes' && function_exists( 'mipro_the_excerpt_max_words' ) ) : ?>
								<div class="entry-info"><p><?php mipro_the_excerpt_max_words( $excerpt_words, true, '...', true ); ?></p></div>
							<?php endif; ?>

							<?php if ( $readmore == 'yes' ) : ?>
								<a href="<?php the_permalink(); ?>" class="button-readmore"><?php esc_html_e( 'Read More', 'mipro-core' ); ?></a>
							<?php endif; ?>
						</div>

					<?php else: /* Post format is quote */ ?>
						<div class="kft-blockquote">
							<blockquote class="blockquote-bg">
								<?php
								$quote_content = get_the_excerpt();
								if ( ! $quote_content ) {
									$quote_content = get_the_content();
								}
								echo do_shortcode( $quote_content );
								?>
							</blockquote>
							<div class="blockquote-meta">
								<?php if ( $author == 'yes' ) : ?>
									<span class="author"><i class="fa fa-user"></i><?php the_author_posts_link();?></span>
								<?php endif; ?>

								<?php if ( $date == 'yes' ) : ?>
									<span class="date-time">
										<?php echo get_the_time( get_option('date_format') ); ?>
									</span>
								<?php endif; ?>
							</div>
						</div>
					<?php endif; ?>
				</article>
				<?php
			}
		}

		wp_reset_postdata();

		if ( defined('DOING_AJAX') && DOING_AJAX ) {
			die( ob_get_clean() );
		}
	}
}

/* Google Map shortcode */
if ( ! function_exists('kft_google_map_shortcode') ) {
	function kft_google_map_shortcode( $atts, $content = '' ) {
		extract( shortcode_atts( array(
			'address' => '',
			'zoom' => 12,
			'icon' => '',
			'styles' => '',
			'show_content' => 'no',
			'content_position' => 'top_left',
		), $atts ) );

		wp_enqueue_script('gmap-api');
		$id = rand();
		if ( $icon ) {
			$url = wp_get_attachment_image_src( $icon );
			$icon = $url[0];
		}

		if ( ! is_numeric( $zoom ) ) {
			$zoom = 12;
		}

		$classes = apply_filters( 'kc-el-class', $atts );
		$classes[] = 'google-map-container';
		$classes[] = $content_position;

		ob_start();
		?>
		<div class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>">
			<div id ="google-map-<?php echo esc_attr( $id ); ?>" class="google-map-<?php echo esc_attr( $id ); ?> google-map-wrapper"></div>
			<?php if ( $show_content == 'yes' && $content != '' ) : ?>
				<div class="google-map-content">
					<?php echo do_shortcode( $content ); ?>
				</div>
			<?php endif; ?>
		</div>

		<?php
		wp_add_inline_script('mipro-global', 'jQuery(document).ready(function(){
			google.maps.event.addDomListener(window, "load", init);
			google.maps.event.addDomListener(window, "resize", init);

			function init() {

				var mapOptions = {
					zoom: ' . $zoom . ',
					center: new google.maps.LatLng(44.5403, -78.5463),
				};
				var mapElement = document.getElementById("google-map-' . esc_js( $id ) . '");
				var map = new google.maps.Map(mapElement, mapOptions);

				var styledMapType = new google.maps.StyledMapType(' . $styles . ');
				map.mapTypes.set("styled_map", styledMapType);
				map.setMapTypeId("styled_map");

				var geocoder = new google.maps.Geocoder();
				geocoder.geocode( {address: "' . $address . '"}, function(results, status) {
					if( status == google.maps.GeocoderStatus.OK ){
						var _ret_array =  new Array(results[0].geometry.location.lat(),results[0].geometry.location.lng());
						map.setCenter(results[0].geometry.location);
						var marker = new google.maps.Marker({
							position: results[0].geometry.location,
							animation: google.maps.Animation.DROP,
							map: map,
							title: "",
							icon:"' . $icon . '"
						});
					}
				});
			}
		});', 'after');

		$output = ob_get_contents();
		ob_end_clean();

		return $output;
	}
}
add_shortcode('kft_google_map', 'kft_google_map_shortcode');

/* Countdown shortcode */
if ( ! function_exists( 'kft_countdown_shortcode' ) ) {
	function kft_countdown_shortcode( $atts ) {
		extract( shortcode_atts( array(
			'date' => '2018/12/12',
		), $atts ) );
		
		$date = str_replace( '/', '-', $date );

		$classes = apply_filters( 'kc-el-class', $atts );
		$classes[] = 'kft-countdown';

		ob_start();

		if ( function_exists('kc_js_callback') ) {
			kc_js_callback( 'MiproTheme.CountdownTimer' );
		}
		?>

		<div class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>">
			<div class="countdown-timer" data-countdown="<?php echo esc_attr( $date ) ?>"></div>
		</div>

		<?php
		return ob_get_clean();
	}
}
add_shortcode( 'kft_countdown', 'kft_countdown_shortcode' );

/* Counter Up shortcode */
if ( ! function_exists( 'kft_counter_shortcode' ) ) {
	function kft_counter_shortcode( $atts ) {
		extract( shortcode_atts( array(
			'number' => 0,
			'meta' => '',
		), $atts) );

		$css_class = apply_filters( 'kc-el-class', $atts );
		$css_class[] = 'kft-counter';

		if ( ! is_numeric( $number ) ) {
			$number = 0;
		}

		ob_start();
		
		if ( function_exists('kc_js_callback') ) {
			kc_js_callback( 'MiproTheme.CounterUpShortcode' );
		}
		?>
		<div class="<?php echo esc_attr( implode( ' ', $css_class ) ); ?>">
			<span class="number">
				<?php echo esc_html( $number ); ?>
			</span>
			<?php if ( ! empty( $meta ) ) : ?>
				<h3 class="meta">
					<?php echo esc_html( $meta ); ?>
				</h3>
			<?php endif; ?>
		</div>
		<?php
		return ob_get_clean();
	}
}
add_shortcode( 'kft_counter', 'kft_counter_shortcode' );

/******  Woocommerce shortcodes  ******/

/*** Products Shortcode ***/
if ( ! function_exists('kft_products_shortcode') ) {
	function kft_products_shortcode( $atts, $content ) {

		extract( shortcode_atts( array(
			'title' => '',
			'product_layout' => 'grid',
			'style' => '',
			'product_type' => 'recent',
			'orderby' => '',
			'order' => '',
			'rows' => 1,
			'columns' => 4,
			'per_page' => 5,
			'product_cats' => '',
			'show_countdown' => 'no',
			'show_load_more' => 'no',
			'load_more_text' => 'Show more',
			'nav' => 'yes',
			'dots' => 'no',
			'autoplay' => 'no',
			'margin' => 30,
			'desksmini' => 4,
			'tablet' => 3,
			'tabletmini' => 2,
			'mobile' => 2,
			'mobilesmini' => 1,
			'show_cate' => 1,


		), $atts));

		if ( ! class_exists( 'WooCommerce' ) ) {
			return;
		}

		$show_countdown = ( $show_countdown == 'yes' ) ? 1 : 0;
		$show_load_more = ( $show_load_more == 'yes' ) ? 1 : 0;
		$nav = ( $nav == 'yes' ) ? 1 : 0;
		$dots = ( $dots == 'yes' ) ? 1 : 0;
		$autoplay = ( $autoplay == 'yes' ) ? 1 : 0;
		$columns = $columns ? $columns : 4;
		$rows = $rows ? $rows : 1;
		$desksmini = $desksmini ? $desksmini : 4;
		$tablet = $tablet ? $tablet : 3;
		$tabletmini = $tabletmini ? $tabletmini : 2;
		$mobile = $mobile ? $mobile : 2;
		$mobilesmini = $mobilesmini ? $mobilesmini : 1;

		if ( ! is_numeric( $per_page ) ) {
			$per_page = 5;
		}
		if ( ! is_numeric( $margin ) ) {
			$margin = 30;
		}

		$is_slider = $is_masonry = 0;
		if ( $product_layout == 'slider' ) {
			$is_slider = 1;
		}
		if ( $product_layout == 'masonry' ) {
			$is_masonry = 1;
		}

		if ( $show_countdown ) {
			add_action('kft_after_shop_loop_item', 'kft_template_loop_time_deals', 65);
		}
		if ( function_exists( 'mipro_remove_woocommerce_hook' ) ) {
			mipro_remove_woocommerce_hook();
		}

		$args = array(
			'post_type' => 'product',
			'post_status' => 'publish',
			'ignore_sticky_posts' => 1,
			'posts_per_page' => $per_page,
			'orderby' => 'date',
			'order' => 'desc',
			'meta_query' => WC()->query->get_meta_query(),
			'tax_query' => WC()->query->get_tax_query(),
		);

		if ( ! empty( $order ) || ! empty( $orderby ) ) {
			if ( ! empty( $order ) ) {
				$args['order'] = $order;
			}
			if ( ! empty( $orderby ) ) {
				$args['orderby'] = $orderby;
			}
		} else {
			mipro_filter_product_by_product_type( $args, $product_type );
		}

		$product_cats = str_replace(' ', '', $product_cats);
		if ( strlen( $product_cats ) > 0 ) {
			$product_cats = explode(',', $product_cats);
		}
		if ( is_array( $product_cats ) && count( $product_cats ) > 0 ) {
			$field_name = is_numeric( $product_cats[0] ) ? 'term_id' : 'slug';
			$args['tax_query'] = array(
				array(
					'taxonomy' => 'product_cat',
					'terms' => $product_cats,
					'field' => $field_name,
					'include_children' => false,
				),
			);
		}

		ob_start();
		global $woocommerce_loop;
		if ( (int) $columns <= 0 ) {
			$columns = 4;
		}
		$old_woocommerce_loop_columns = isset($woocommerce_loop['columns']);
		$woocommerce_loop['columns'] = $columns;

		$products = new WP_Query( $args );

		$classes = apply_filters( 'kc-el-class', $atts );
		$classes[] = 'kft-product-shortcode';
		$classes[] = 'is-' . $product_layout;
		$classes[] = 'product-style-shortcode';
		$classes[] = 'is-' . $style;
		if ($style == 'shade') {
			$classes[] = 'is-overlay';
		}

		$atts = compact( 'product_type', 'rows', 'columns', 'is_slider', 'is_masonry', 'product_cats', 'show_countdown', 'per_page', 'orderby', 'order', 'show_load_more', 'nav', 'dots', 'autoplay', 'margin','show_cate', 'desksmini', 'tablet', 'tabletmini', 'mobile', 'mobilesmini' );

		if ( $products->have_posts() ) : ?>
			<div class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>" data-atts="<?php echo htmlentities( json_encode( $atts ) ); ?>">
				<div class="section-title">
					<?php if ( strlen( $title ) > 0 ) : ?>
						<h3 class="section-title-main"><span><?php echo esc_html( $title ); ?></span></h3>
					<?php endif; ?>
				</div>

				<div class="meta-slider <?php echo ($is_slider) ? 'loading' : ''; ?>">

					<?php woocommerce_product_loop_start(); ?>

					<?php kft_products_items_content_shortcode( $atts, $products ); ?>

					<?php woocommerce_product_loop_end(); ?>

					<?php if ( $show_load_more && ! $is_slider ) : ?>
						<div class="load-more-wrapper">
							<a href="#" class="load-more button" data-paged="2"><?php echo esc_html( $load_more_text ) ?></a>
						</div>
					<?php endif; ?>

				</div>

			</div>
			<?php
		endif;

		remove_action( 'kft_after_shop_loop_item', 'kft_template_loop_time_deals', 65 );
		wp_reset_postdata();

		$woocommerce_loop['columns'] = $old_woocommerce_loop_columns;
		return '<div class="woocommerce columns-' . $columns . '">' . ob_get_clean() . '</div>';
	}
}
add_shortcode('kft_products', 'kft_products_shortcode');

add_action('wp_ajax_kft_products_load_items', 'kft_products_items_content_shortcode');
add_action('wp_ajax_nopriv_kft_products_load_items', 'kft_products_items_content_shortcode');
if ( ! function_exists( 'kft_products_items_content_shortcode' ) ) { 
	function kft_products_items_content_shortcode( $atts, $products = null ) { 

		if ( defined('DOING_AJAX') && DOING_AJAX ) {
			if ( ! isset( $_POST['atts'] ) ) {
				die();
			}
			$atts = $_POST['atts'];
			$paged = isset( $_POST['paged'] ) ? absint( $_POST['paged'] ) : 1;

			extract($atts);

			if ( $show_countdown ) {
				add_action('kft_after_shop_loop_item', 'kft_template_loop_time_deals', 65);
			}
			if ( function_exists('mipro_remove_woocommerce_hook') ) {
				mipro_remove_woocommerce_hook();
			}

			$args = array(
				'post_type' => 'product',
				'post_status' => 'publish',
				'ignore_sticky_posts' => 1,
				'posts_per_page' => $per_page,
				'orderby' => 'date',
				'order' => 'desc',
				'meta_query' => WC()->query->get_meta_query(),
				'tax_query' => WC()->query->get_tax_query(),
				'paged' => $paged,
			);
			if ( ! empty( $order ) || ! empty( $orderby ) ) {
				if ( ! empty( $order ) ) {
					$args['order'] = $order;
				}
				if ( ! empty( $orderby ) ) {
					$args['order'] = $orderby;
				}
			} else {
				mipro_filter_product_by_product_type( $args, $product_type );
			}

			$product_cats = str_replace( ' ', '', $product_cats );
			if ( is_string ( $product_cats ) && strlen( $product_cats ) > 0 ) {
				$product_cats = explode( ',', $product_cats );
			}
			if ( is_array( $product_cats ) && count( $product_cats ) > 0 ) {
				$field_name = is_numeric( $product_cats[0] ) ? 'term_id' : 'slug';
				$args['tax_query'] = array(
					array(
						'taxonomy' => 'product_cat',
						'terms' => $product_cats,
						'field' => $field_name,
						'include_children' => false,
					),
				);
			}

			ob_start();
			global $woocommerce_loop;
			if ( (int) $columns <= 0 ) {
				$columns = 4;
			}
			$old_woocommerce_loop_columns = $woocommerce_loop['columns'];
			$woocommerce_loop['columns'] = $columns;

			$products = new WP_Query($args);
		}

		extract( $atts );

		$count = 0;
		while ( $products->have_posts() ) {
			$products->the_post();

			if ( $rows > 1 && $count % $rows == 0 ) {
				echo '<div class="product-group">';
			}

			wc_get_template_part( 'content', 'product' );

			if ( $rows > 1 && ( $count % $rows == $rows - 1 || $count == $products->post_count - 1) ) {
				echo '</div>';
			}
			$count++;
		}

		remove_action( 'kft_after_shop_loop_item', 'kft_template_loop_time_deals', 65 );
		wp_reset_postdata();

		if ( defined('DOING_AJAX') && DOING_AJAX ) {
			die( ob_get_clean() );
		}

	}
}

/*** Products Widget ***/
if ( ! function_exists('kft_products_widget_shortcode') ) {
	function kft_products_widget_shortcode( $atts, $content ) {

		if ( ! class_exists('Mipro_Products_Widget') ) {
			return;
		}

		extract( shortcode_atts( array(
			'product_type' => 'recent',
			'rows' => 3,
			'per_page' => 6,
			'product_cats' => '',
			'title' => '',
			'show_image' => 1,
			'thumbnail_size' => 'shop_thumbnail',
			'show_title' => 1,
			'show_price' => 1,
			'show_rating' => 1,
			'show_categories' => 0,
			'is_slider' => 0,
			'show_nav' => 1,
			'auto_play' => 1,
		), $atts) );

		if ( trim( $product_cats ) != '' ) {
			$product_cats = array_map( 'trim', explode(',', $product_cats) );
		}

		if ( ! is_numeric( $rows ) ) {
			$rows = 3;
		}

		if ( ! is_numeric( $per_page ) ) {
			$per_page = 6;
		}

		$instance = array(
			'title' => $title,
			'product_type' => $product_type,
			'product_cats' => $product_cats,
			'row' => $rows,
			'limit' => $per_page,
			'show_thumbnail' => ($show_image == 'yes') ? 1 : 0,
			'thumbnail_size' => $thumbnail_size,
			'show_categories' => ($show_categories == 'yes') ? 1 : 0,
			'show_product_title' => ($show_title == 'yes') ? 1 : 0,
			'show_price' => ($show_price == 'yes') ? 1 : 0,
			'show_rating' => ($show_rating == 'yes') ? 1 : 0,
			'is_slider' => ($is_slider == 'yes') ? 1 : 0,
			'show_nav' => ($show_nav == 'yes') ? 1 : 0,
			'auto_play' => ($auto_play == 'yes') ? 1 : 0,
		);

		ob_start();
		$classes = apply_filters( 'kc-el-class', $atts );
		$classes[] = 'products-widget-shortcode';
		?>

		<div class="<?php echo esc_attr( implode(' ', $classes) ); ?>">
			<?php the_widget('Mipro_Products_Widget', $instance); ?>
		</div>

		<?php
		if ( function_exists( 'kc_js_callback' ) ) {
			kc_js_callback( 'MiproTheme.ProductWgSlider' );
		}
		return ob_get_clean();
	}
}
add_shortcode( 'kft_products_widget', 'kft_products_widget_shortcode' );

/* Product Category Shortcode */
if ( ! function_exists('kft_product_categories_shortcode') ) {
	function kft_product_categories_shortcode( $atts, $content ) {
		extract( shortcode_atts( array(
			'title' => '',
			'layout' => 'grid',
			'per_page' => '5',
			'columns' => '4',
			'rows' => '1',
			'ids' => '',
			'hide_empty' => 'no',
			'show_title' => 'yes',
			'show_description' => 'no',
			'show_nav' => 'yes',
			'dots' => 'no',
			'auto_play' => 'no',
			'margin' => '30',
			'desksmini' => '4',
			'tablet' => '3',
			'tabletmini' => '2',
			'mobile' => '2',
			'mobilesmini' => '1',
		), $atts) );

		if ( ! class_exists('WooCommerce') ) {
			return;
		}

		$hide_empty = ($hide_empty == 'yes') ? true : false;
		$show_title = ($show_title == 'yes') ? true : false;
		$show_description = ($show_description == 'yes') ? true : false;
		$show_nav = ($show_nav == 'yes') ? 1 : 0;
		$dots = ($dots == 'yes') ? 1 : 0;
		$auto_play = ($auto_play == 'yes') ? 1 : 0;
		$rows = $rows ? $rows : '1';
		$columns = $columns ? $columns : '4';
		$margin = $margin ? $margin : '30';
		$desksmini = $desksmini ? $desksmini : '4';
		$tablet = $tablet ? $tablet : '3';
		$tabletmini = $tabletmini ? $tabletmini : '2';
		$mobile = $mobile ? $mobile : '2';
		$mobilesmini = $mobilesmini ? $mobilesmini : '1';

		if ( ! is_numeric( $per_page ) ) {
			$per_page = 5;
		}

		add_filter('subcategory_archive_thumbnail_size', 'kft_product_cat_thumbnail_size_filter', 10);

		$args = array(
			'orderby' => 'name',
			'order' => 'ASC',
			'hide_empty' => $hide_empty,
			'include' => array_map('trim', explode(',', $ids)),
			'pad_counts' => true,
			'parent' => '',
			'number' => $per_page,
		);
		$product_categories = get_terms('product_cat', $args);

		global $woocommerce_loop;
		$old_woocommerce_loop_columns = $woocommerce_loop['columns'];
		$woocommerce_loop['columns'] = $columns;

		ob_start();

		$classes = apply_filters('kc-el-class', $atts);
		$classes[] = 'woocommerce';
		$classes[] = 'kft-product-categories-shortcode';
		$classes[] = 'layout-' . $layout;
		if ( $layout != 'slider' ) {
			$classes[] = 'columns-' . $columns;
		}

		if ( count($product_categories) > 0 ) {
			$data_attr = array();
			$data_attr[] = 'data-nav=' . $show_nav;
			$data_attr[] = 'data-dots=' . $dots;
			$data_attr[] = 'data-autoplay=' . $auto_play;
			$data_attr[] = 'data-margin=' . $margin;
			$data_attr[] = 'data-columns=' . $columns;
			$data_attr[] = 'data-desksmini=' . $desksmini;
			$data_attr[] = 'data-tablet=' . $tablet;
			$data_attr[] = 'data-tabletmini=' . $tabletmini;
			$data_attr[] = 'data-mobile=' . $mobile;
			$data_attr[] = 'data-mobilesmini=' . $mobilesmini;
			$data_attr[] = 'data-slider= 1';
			?>

			<div class="<?php echo esc_attr(implode(' ', $classes)) ?>" <?php echo implode(' ', $data_attr); ?>>
				<div class="section-title">
					<?php if ( strlen($title) > 0 ) : ?>
						<h3 class="section-title-main-title"><span><?php echo esc_html( $title ); ?></span></h3>
					<?php endif; ?>
				</div>
				<div class="meta-slider <?php echo esc_attr( ($layout == 'slider') ? 'loading' : '' ) ?>">
					<?php
					woocommerce_product_loop_start();

					$count_all = count($product_categories);
					$count = 0;
					foreach ( $product_categories as $category ) {
						if ( $rows > 1 && $count % $rows == 0 ) {
							echo '<div class="product-cat-group">';
						}

						wc_get_template('content-product-cat.php', array(
							'category' => $category,
							'show_title' => $show_title,
							'show_description' => $show_description,
						));

						if ( $rows > 1 && ($count % $rows == $rows - 1 || $count == $count_all - 1) ) {
							echo '</div>';
						}
						$count++;
					}

					woocommerce_product_loop_end();
					woocommerce_reset_loop();
					?>
				</div>
			</div>
			<?php
		}

		remove_filter('subcategory_archive_thumbnail_size', 'kft_product_cat_thumbnail_size_filter', 10);
		$woocommerce_loop['columns'] = $old_woocommerce_loop_columns;

		$output = ob_get_clean();
		return $output;
	}
}
add_shortcode('kft_product_categories', 'kft_product_categories_shortcode');

if ( ! function_exists('kft_product_cat_thumbnail_size_filter') ) {
	function kft_product_cat_thumbnail_size_filter($size) {
		return 'kft_product_cat_thumb';
	}
}

/* Product Deals */
if ( ! function_exists( 'kft_products_deals_shortcode' ) ) {
	function kft_products_deals_shortcode( $atts, $content ) {

		extract( shortcode_atts( array(
			'title' => '',
			'product_layout' => 'grid',
			'style' => 'default',
			'product_type' => 'recent',
			'orderby' => '',
			'order' => '',
			'rows' => 1,
			'columns' => 4,
			'per_page' => 5,
			'product_cats' => '',
			'show_countdown' => 'no',
			'show_gallery' => 'no',
			'show_description' => 'no',
			'nav' => 'yes',
			'dots' => 'no',
			'autoplay' => 'no',
			'margin' => 30,
			'desksmini' => 4,
			'tablet' => 3,
			'tabletmini' => 2,
			'mobile' => 2,
			'mobilesmini' => 1,

		), $atts ) );

		if ( ! class_exists( 'WooCommerce' ) ) {
			return;
		}

		$show_countdown = ( $show_countdown == 'yes' ) ? 1 : 0;
		$show_gallery = ( $show_gallery == 'yes' ) ? 1 : 0;
		$show_description = ( $show_description == 'yes' ) ? 1 : 0;
		$nav = ( $nav == 'yes' ) ? 1 : 0;
		$dots = ( $dots == 'yes' ) ? 1 : 0;
		$autoplay = ( $autoplay == 'yes' ) ? 1 : 0;

		$is_slider = $is_masonry = 0;
		if ( $product_layout == 'slider' ) {
			$is_slider = 1;
		}
		if ( $product_layout == 'masonry' ) {
			$is_masonry = 1;
		}

		if ( $show_countdown ) {
			add_action('woocommerce_after_shop_loop_item', 'kft_template_loop_time_deals', 110);
		}

		if ( $show_gallery ) {
			add_action('woocommerce_after_shop_loop_item', 'kft_template_loop_thumb_list', 1000);
		}
		if ( $show_description ) {
			add_action('woocommerce_after_shop_loop_item', 'mipro_template_product_short_description', 65);
		}

		$args = array(
			'post_type' => array('product', 'product_variation'),
			'post_status' => 'publish',
			'ignore_sticky_posts' => 1,
			'posts_per_page' => -1,
			'orderby' => 'date',
			'order' => 'desc',
			'meta_query' => array(
				array(
					'key' => '_sale_price_dates_to',
					'value' => current_time('timestamp', true),
					'compare' => '>',
					'type' => 'numeric',
				),
				array(
					'key' => '_sale_price_dates_from',
					'value' => current_time('timestamp', true),
					'compare' => '<',
					'type' => 'numeric',
				),
			),
			'tax_query' => array(),
		);

		mipro_filter_product_by_product_type( $args, $product_type );

		$array_product_cats = array();

		$product_cats = str_replace(' ', '', $product_cats);
		if ( strlen( $product_cats ) > 0 ) {
			$array_product_cats = explode(',', $product_cats);
		}

		ob_start();
		global $woocommerce_loop, $post, $product;
		if ( (int) $columns <= 0 ) {
			$columns = 5;
		}
		$old_woocommerce_loop_columns = $woocommerce_loop['columns'];
		$woocommerce_loop['columns'] = $columns;

		$product_ids_on_sale = array();

		$products = new WP_Query( $args );

		if ( $products->have_posts() ) {
			while ( $products->have_posts() ) {
				$products->the_post();
				if ( $post->post_type == 'product' ) {
					$_product = wc_get_product( $post->ID );
					if ( is_object( $_product ) && $_product->is_visible() ) {
						if ( ! empty( $array_product_cats ) ) {
							$field_name = is_numeric( $array_product_cats[0] ) ? 'ids' : 'slug';
							$post_terms = wp_get_post_terms( $post->ID, 'product_cat', array( 'fields' => $field_name ) );

							if ( is_array( $post_terms ) ) {
								$array_intersect = array_intersect( $post_terms, $array_product_cats );

								if ( ! empty( $array_intersect ) ) {
									$product_ids_on_sale[] = $post->ID;
								}
							}

						} else {
							$product_ids_on_sale[] = $post->ID;
						}
					}
				} else {
					$post_parent_id = $post->post_parent;
					$parent_product = wc_get_product( $post_parent_id );

					if ( is_object( $parent_product ) && $parent_product->is_visible() ) {

						if ( ! empty( $array_product_cats ) ) {
							$field_name = is_numeric( $array_product_cats[0] ) ? 'ids' : 'slug';
							$post_terms = wp_get_post_terms( $post_parent_id, 'product_cat', array( 'fields' => $field_name ) );

							if ( is_array( $post_terms ) ) {
								$array_intersect = array_intersect( $post_terms, $array_product_cats );
								if ( ! empty( $array_intersect ) ) {
									$product_ids_on_sale[] = $post_parent_id;
								}
							}

						} else {
							$product_ids_on_sale[] = $post_parent_id;
						}
					}
				}

				$product_ids_on_sale = array_unique( $product_ids_on_sale );
				if ( count( $product_ids_on_sale ) == $per_page ) {
					break;
				}
			}
		}

		if ( count( $product_ids_on_sale ) == 0 ) {
			$product_ids_on_sale = array(0);
		}

		$args = array(
			'post_type' => 'product',
			'post_status' => 'publish',
			'ignore_sticky_posts' => 1,
			'posts_per_page' => $per_page,
			'orderby' => 'date',
			'order' => 'desc',
			'post__in' => $product_ids_on_sale,
			'meta_query' => WC()->query->get_meta_query(),
			'tax_query' => WC()->query->get_tax_query(),
		);

		mipro_filter_product_by_product_type( $args, $product_type );

		$products = new WP_Query( $args );

		$classes = apply_filters('kc-el-class', $atts);
		$classes[] = 'kft-products-deals-shortcode kft-product-shortcode';
		$classes[] = 'is-' . $product_layout;
		$classes[] = 'product-style-shortcode';
		$classes[] = 'is-' . $style;
		if ($style == 'shade') {
			$classes[] = 'is-overlay';

		}

		$atts = compact( 'title', 'rows', 'columns', 'is_slider', 'is_masonry', 'product_cats', 'show_countdown', 'per_page', 'orderby', 'order', 'custom_order', 'nav', 'dots', 'autoplay', 'margin', 'desksmini', 'tablet', 'tabletmini', 'mobile', 'mobilemini' );

		if ( $products->have_posts() ) : ?>
			<div class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>" data-atts="<?php echo htmlentities( json_encode( $atts ) ); ?>">
				<div class="section-title">
					<?php if ( strlen( $title ) > 0 ) : ?>
						<h3 class="section-title-main"><span><?php echo esc_html( $title ); ?></span></h3>
					<?php endif; ?>
				</div>
				<div class="meta-slider">
					<?php woocommerce_product_loop_start(); ?>

					<?php while ( $products->have_posts() ) : $products->the_post(); ?>
						<?php wc_get_template_part( 'content', 'product' ); ?>
					<?php endwhile; ?>

					<?php woocommerce_product_loop_end(); ?>
				</div>

			</div>
			<?php
		endif;

        //Remove Product Deal action
		remove_action( 'woocommerce_after_shop_loop_item', 'kft_template_loop_thumb_list', 1000 );
		remove_action( 'woocommerce_after_shop_loop_item', 'mipro_template_product_short_description', 65 );
		remove_action( 'woocommerce_after_shop_loop_item', 'kft_template_loop_time_deals', 110 );
		remove_action( 'woocommerce_after_shop_loop_item', 'kft_template_loop_thumb_list', 1000 );
		wp_reset_postdata();

		$woocommerce_loop['columns'] = $old_woocommerce_loop_columns;
		return '<div class="woocommerce columns-' . $columns . '">' . ob_get_clean() . '</div>';
	}
}
add_shortcode( 'kft_products_deals', 'kft_products_deals_shortcode' );

if ( ! function_exists( 'kft_template_loop_thumb_list' ) ) {
	function kft_template_loop_thumb_list() {
		global $product;

		$prod_galleries = $product->get_gallery_image_ids();
		$num_product_gallery = ( (int) mipro_get_opt('kft_product_gallery_number') > 0 ) ? (int) mipro_get_opt('kft_product_gallery_number') : 3;

		if ( $num_product_gallery > count( $prod_galleries ) ) {
			$num_product_gallery = count( $prod_galleries );
		}

		if ( ! is_array( $prod_galleries ) || ( is_array( $prod_galleries ) && count( $prod_galleries ) == 0 ) ) {
			$has_list_image = false;
		}

		if ( wp_is_mobile() ) {
			$has_list_image = false;
		}

		$image_size = apply_filters( 'kft_loop_product_thumbnail', 'shop_catalog' );

		$image_thumb_size = apply_filters( 'single_product_small_thumbnail_size', 'shop_thumbnail' );

		$dimensions = wc_get_image_size( $image_size );

		$dimensions_thumb = wc_get_image_size( $image_thumb_size );

		$front_img_src_thumb = '';

		if ( has_post_thumbnail( $product->get_id() ) ) {
			$post_thumbnail_id = get_post_thumbnail_id( $product->get_id() );
			$image_obj = wp_get_attachment_image_src( $post_thumbnail_id, $image_size, 0 );
			$image_obj_thumb = wp_get_attachment_image_src( $post_thumbnail_id, $image_thumb_size, 0 );

			if ( isset( $image_obj_thumb[0] ) ) {
				$front_img_src_thumb = $image_obj_thumb[0];
			}

			if ( isset( $image_obj[0] ) ) {
				$front_img_src = $image_obj[0];
			}

			$alt = trim( strip_tags( get_post_meta($post_thumbnail_id, '_wp_attachment_image_alt', true ) ) );

		} elseif ( wc_placeholder_img_src() ) {
			$front_img_src_thumb = wc_placeholder_img_src();
		}

		echo '<div class="product-gallery-images"><ul>';

		for ( (int) $i = 0; $i < $num_product_gallery; $i++ ) {
			$list_img_src = '';
			$alt = '';
			$image_obj = wp_get_attachment_image_src( $prod_galleries[$i], $image_thumb_size, 0 );
			$image_obj_hover = wp_get_attachment_image_src( $prod_galleries[$i], $image_size, 0 );

			if ( isset( $image_obj[0] ) ) {
				$list_img_src = $image_obj[0];
				$list_img_src_hover = $image_obj_hover[0];
				$alt = trim( strip_tags( get_post_meta( $prod_galleries[$i], '_wp_attachment_image_alt', true ) ) );
			} elseif ( wc_placeholder_img_src() ) {
				$list_img_src = wc_placeholder_img_src();
			}

			echo '<li><img src="' . esc_url( $list_img_src ) . '" data-hover="' . esc_url( $list_img_src_hover ) . '" class="kft_thumb_list_hover" alt="' . esc_attr( $alt ) . '" width="' . $dimensions_thumb['width'] . '" height="' . $dimensions_thumb['height'] . '" /></li>';
		}

		echo '</ul></div>';
	}
}

if ( ! function_exists( 'kft_template_loop_time_deals' ) ) {
	function kft_template_loop_time_deals() {
		global $product;
		$sale_date = '';
		$curent_date = strtotime( date( 'Y-m-d H:i:s' ) );
		$timezone = 'GMT';

		if ( $product->get_type() == 'variable' ) {
			$children = $product->get_children();
			if ( is_array( $children ) && count( $children ) > 0 ) {
				foreach ( $children as $children_id ) {
					$sale_date = get_post_meta( $children_id, '_sale_price_dates_to', true );
					$sale_date_start = get_post_meta( $children_id, '_sale_price_dates_from', true );
					if ( $sale_date != '' ) {
						break;
					}
				}
			}
		} 
		else {
			$sale_date = get_post_meta( $product->get_id(), '_sale_price_dates_to', true );
			$sale_date_start = get_post_meta( $product->get_id(), '_sale_price_dates_from', true );
		}

		if ( $sale_date_start == '' || $sale_date == ''  || $sale_date < $curent_date || $curent_date < $sale_date_start ) {
			return;
		}
		?>

		<div class="countdown-timer" data-countdown="<?php echo esc_attr( date( 'Y-m-d H:i:s', $sale_date ) ); ?>"></div>

		<?php
	}
}

/* Video Button Shortcode */
if ( ! function_exists( 'kft_video_button_shortcode' ) ) {
	function kft_video_button_shortcode( $atts ) {
		extract( shortcode_atts( array(
			'video_url' => '',
			'icon' => '',
			'image' => '',
			'image_size' => 'full',
			'extra_class' => '',
		), $atts ) );

		if ( empty( $video_url ) ) {
			return;
		}

		$classes = apply_filters( 'kc-el-class', $atts );
		$classes[] = $extra_class;

		if ( $image_size == '' ) {
			$image_size = 'full';
		}

		$size_array = array( 'full', 'medium', 'large', 'thumbnail' );

		ob_start();
		?>
		<div class="kft-video-button <?php echo esc_attr( implode( ' ',$classes ) ); ?>">
			<a href="<?php echo esc_url( $video_url ); ?>" class="kft-video-lightbox">
				<div class="video-icon">
					<i class="<?php echo esc_attr( $icon ); ?>"></i>
				</div>
				<?php if ( ! empty( $image ) ) : ?>
					<div class="video-image">
						<?php
						if ( in_array( $image_size, $size_array )) {
							echo wp_get_attachment_image( $image, $image_size );
						}
						elseif ( class_exists('kc_tools') ) {
							$image_data = wp_get_attachment_image_src( $image, $image_size );
							$create_size = $image_data[0];
							$image_url 	= kc_tools::createImageSize( $create_size, $image_size );
							echo '<img src="'.esc_url($image_url).'" alt="">';
						}
						?>
					</div>
				<?php endif; ?>
			</a>
		</div>
		<?php
		return ob_get_clean();
	}
}
add_shortcode('kft_video_button', 'kft_video_button_shortcode');

/* Shortcode SoundCloud */
if ( ! function_exists('kft_soundcloud_shortocde')) {
	function kft_soundcloud_shortocde( $atts, $content ) {
		extract( shortcode_atts( array(
			'params' => "color=ff5500&auto_play=false&hide_related=false&show_comments=true&show_user=true&show_reposts=false",
			'url' => '',
			'width' => '100%',
			'height' => '166',
			'iframe' => 1,
		), $atts ) );

		$atts = compact( 'params', 'url', 'width', 'height', 'iframe' );

		if ( $iframe ) {
			return kft_soundcloud_iframe_widget( $atts );
		} else {
			return kft_soundcloud_flash_widget( $atts );
		}
	}
}
add_shortcode('kft_soundcloud', 'kft_soundcloud_shortocde');

function kft_soundcloud_iframe_widget( $options ) {
	$url = 'https://w.soundcloud.com/player/?url=' . $options['url'] . '&' . $options['params'];
	$unique_class = 'kft-soundcloud-' . rand();
	$style = '.' . $unique_class . ' iframe{width: ' . $options['width'] . '; height:' . $options['height'] . 'px;}';
	$style = '<style>' . $style . '</style>';
	return '<div class="kft-soundcloud ' . $unique_class . '">' . $style . '<iframe src="' . esc_url($url) . '"></iframe></div>';
}

function kft_soundcloud_flash_widget( $options ) {
	$url = 'https://player.soundcloud.com/player.swf?url=' . $options['url'] . '&' . $options['params'];

	return preg_replace('/\s\s+/', '', sprintf('<div class="kft-soundcloud"><object width="%s" height="%s">
		<param name="movie" value="%s"></param>
		<param name="allowscriptaccess" value="always"></param>
		<embed width="%s" height="%s" src="%s" allowscriptaccess="always" type="application/x-shockwave-flash"></embed>
		</object></div>', $options['width'], $options['height'], esc_url($url), $options['width'], $options['height'], esc_url($url)));
}

/* Shortcode Video - Support Youtube and Vimeo video */
if ( ! function_exists( 'kft_video_shortcode' ) ) {
	function kft_video_shortcode( $atts ) {
		extract( shortcode_atts( array(
			'src' => '',
			'size' => 'auto-size',
			'height' => '450',
			'width' => '800',
			'class' => '',
		), $atts ) );

		if ( empty( $src ) ) {
			return;
		}
		$extra_class = array();
		$extra_class[] = $size;
		$extra_class[] = $class;

		$src = kft_parse_video_link( $src );
		ob_start();
		?>
		<div class="kft-video <?php echo esc_attr( implode( ' ',$extra_class ) ); ?>">
			<iframe width="<?php echo esc_attr( $width ); ?>" height="<?php echo esc_attr( $height ); ?>" src="<?php echo esc_url( $src ); ?>" allowfullscreen></iframe>
		</div>
		<?php
		return ob_get_clean();
	}
}
add_shortcode('kft_video', 'kft_video_shortcode');

if ( ! function_exists('kft_parse_video_link') ) {
	function kft_parse_video_link( $video_url ) {
		if ( strstr( $video_url, 'youtube.com' ) || strstr( $video_url, 'youtu.be' ) ) {
			preg_match('%(?:youtube\.com/(?:user/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $video_url, $match);
			
			if ( count( $match ) >= 2 ) {
				return '//www.youtube.com/embed/' . $match[1];
			}

		} elseif ( strstr( $video_url, 'vimeo.com' ) ) {
			preg_match( '~^http://(?:www\.)?vimeo\.com/(?:clip:)?(\d+)~', $video_url, $match );

			if ( count( $match ) >= 2 ) {
				return '//player.vimeo.com/video/' . $match[1];
			} else {
				$video_id = explode( '/', $video_url );

				if ( is_array( $video_id ) && ! empty( $video_id ) ) {
					$video_id = $video_id[count($video_id) - 1];
					return '//player.vimeo.com/video/' . $video_id;
				}
			}
		}
		return $video_url;
	}
}
?>