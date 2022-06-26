<?php
add_action('cmb2_admin_init', 'mipro_base_metaboxes');

if ( !function_exists('mipro_base_metaboxes')) {
	function mipro_base_metaboxes() {
		$prefix = 'kft_';

		$cmb = new_cmb2_box(array(
			'id' => 'page_options',
			'title' => esc_html__('Page options', 'mipro'),
			'object_types' => array('page'),
			'context' => 'normal',
			'priority' => 'high',
			'show_names' => true,
			'tabs' => array(
				'layout' => array(
					'label' => esc_html__('Layout', 'mipro'),
					'icon' => 'dashicons-align-left',
				),
				'top_bar' => array(
					'label' => esc_html__('Top Bar', 'mipro'),
					'icon' => 'dashicons-arrow-up-alt',
				),
				'header' => array(
					'label' => esc_html__('Header', 'mipro'),
					'icon' => 'dashicons-editor-kitchensink',
				),
				'breadcrumb' => array(
					'label' => esc_html__('Breadcrumb', 'mipro'),
					'icon' => 'dashicons-editor-insertmore',
				),
				'slider' => array(
					'label' => esc_html__('Slider', 'mipro'),
					'icon' => 'dashicons-editor-contract',
				),
				'footer' => array(
					'label' => esc_html__('Footer', 'mipro'),
					'icon' => 'dashicons-arrow-down-alt',
				),
				'css'    => array(
					'label' => esc_html__( 'Custom CSS', 'mipro' ),
					'icon'  => 'dashicons-admin-customizer',
				),
			),
			'tab_style' => 'default',
		));

		$cmb->add_field(array(
			'id' => $prefix . 'layout',
			'name' => esc_html__('Layout', 'mipro'),
			'desc' => '',
			'type' => 'radio_inline',
			'default' => 'default',
			'options' => array(
				'default' => esc_html__('Default', 'mipro'),
				'full-width' => esc_html__('Full width', 'mipro'),
				'boxed' => esc_html__('Boxed', 'mipro'),
				'wide' => esc_html__('Wide (1600 px)', 'mipro'),
			),
			'tab' => 'layout',
			'render_row_cb' => array('CMB2_Tabs', 'tabs_render_row_cb'),
		));

		$cmb->add_field(array(
			'id' => $prefix . 'page_layout',
			'name' => esc_html__('Page Layout', 'mipro'),
			'desc' => '',
			'type' => 'radio_inline',
			'options' => array(
				'full-width' => esc_html__('Fullwidth', 'mipro'),
				'left-sidebar' => esc_html__('Left Sidebar', 'mipro'),
				'right-sidebar' => esc_html__('Right Sidebar', 'mipro'),
				'left-right-sidebar' => esc_html__('Left & Right Sidebar', 'mipro'),
			),
			'default' => 'full-width',
			'tab' => 'layout',
			'render_row_cb' => array('CMB2_Tabs', 'tabs_render_row_cb'),
		));

		$cmb->add_field(array(
			'id' => $prefix . 'left_sidebar',
			'name' => esc_html__('Left Sidebar', 'mipro'),
			'desc' => '',
			'type' => 'select',
			'options' => mipro_get_sidebars(),
			'tab' => 'layout',
			'render_row_cb' => array('CMB2_Tabs', 'tabs_render_row_cb'),
		));

		$cmb->add_field(array(
			'id' => $prefix . 'right_sidebar',
			'name' => esc_html__('Right Sidebar', 'mipro'),
			'desc' => '',
			'type' => 'select',
			'options' => mipro_get_sidebars(),
			'tab' => 'layout',
			'render_row_cb' => array('CMB2_Tabs', 'tabs_render_row_cb'),
		));

		$cmb->add_field(array(
			'id' => $prefix . 'header_top_bar',
			'name' => esc_html__('Hide Top bar', 'mipro'),
			'desc' => esc_html__('Choose to hide top bar.', 'mipro'),
			'type' => 'checkbox',
			'tab' => 'top_bar',
			'render_row_cb' => array('CMB2_Tabs', 'tabs_render_row_cb'),
		));

		$cmb->add_field(array(
			'id' => $prefix . 'header_top_bar_color',
			'name' => esc_html__('Top bar Text Color', 'mipro'),
			'desc' => esc_html__('Set text color for top bar.', 'mipro'),
			'type' => 'colorpicker',
			'tab' => 'top_bar',
			'render_row_cb' => array('CMB2_Tabs', 'tabs_render_row_cb'),
		));

		$cmb->add_field(array(
			'id' => $prefix . 'header_top_bar_bg',
			'name' => esc_html__('Top bar Background', 'mipro'),
			'desc' => esc_html__('Set background color for top bar.', 'mipro'),
			'type' => 'colorpicker',
			'tab' => 'top_bar',
			'render_row_cb' => array('CMB2_Tabs', 'tabs_render_row_cb'),
		));

		$cmb->add_field(array(
			'id' => $prefix . 'header_layout',
			'name' => esc_html__('Header Layout', 'mipro'),
			'desc' => '',
			'type' => 'radio',
			'options' => array(
				'default' => esc_html__('Default', 'mipro'),
				'layout1' => esc_html__('Header Layout 1', 'mipro'),
				'layout2' => esc_html__('Header Layout 2', 'mipro'),
				'layout3' => esc_html__('Header Layout 3', 'mipro'),
				'layout4' => esc_html__('Header Layout 4', 'mipro'),
				'layout5' => esc_html__('Header Layout 5', 'mipro'),
				'layout6' => esc_html__('Header Layout 6', 'mipro'),
				'layout7' => esc_html__('Header Layout 7', 'mipro'),
				'layout8' => esc_html__('Header Layout 8', 'mipro'),
				'layout9' => esc_html__('Header Layout 9', 'mipro'),
				'layout10' => esc_html__('Header Layout 10', 'mipro'),
			),
			'default' => 'default',
			'tab' => 'header',
			'render_row_cb' => array('CMB2_Tabs', 'tabs_render_row_cb'),
		));

		$cmb->add_field(array(
			'id' => $prefix . 'logo',
			'name' => esc_html__('Logo', 'mipro'),
			'desc' => '',
			'type' => 'file',
			'tab' => 'header',
			'render_row_cb' => array('CMB2_Tabs', 'tabs_render_row_cb'),
		));

		$cmb->add_field(array(
			'id' => $prefix . 'header_overlap',
			'name' => esc_html__('Header above the content', 'mipro'),
			'desc' => esc_html__('Overlap page content with this header (header is transparent).', 'mipro'),
			'type' => 'checkbox',
			'tab' => 'header',
			'render_row_cb' => array('CMB2_Tabs', 'tabs_render_row_cb'),
		));

		$cmb->add_field(array(
			'id' => $prefix . 'header_text_color',
			'name' => esc_html__('Header Text Color', 'mipro'),
			'desc' => '',
			'type' => 'radio_inline',
			'options' => array(
				'default' => esc_html__('Default', 'mipro'),
				'dark' => esc_html__('Dark', 'mipro'),
				'light' => esc_html__('Light', 'mipro'),
			),
			'default' => 'default',
			'tab' => 'header',
			'render_row_cb' => array('CMB2_Tabs', 'tabs_render_row_cb'),
		));

		$menus = array('0' => esc_html__('Default', 'mipro'));
		$nav_terms = get_terms('nav_menu', array('hide_empty' => true));
		if (is_array($nav_terms)) {
			foreach ($nav_terms as $term) {
				$menus[$term->term_id] = $term->name;
			}
		}

		$cmb->add_field(array(
			'id' => $prefix . 'menu_id',
			'name' => esc_html__('Primary Menu', 'mipro'),
			'desc' => '',
			'type' => 'select',
			'options' => $menus,
			'tab' => 'header',
			'render_row_cb' => array('CMB2_Tabs', 'tabs_render_row_cb'),
		));

		$cmb->add_field(array(
			'id' => $prefix . 'page_title',
			'name' => esc_html__('Hide page title', 'mipro'),
			'desc' => esc_html__('Yes, please', 'mipro'),
			'type' => 'checkbox',
			'tab' => 'breadcrumb',
			'render_row_cb' => array('CMB2_Tabs', 'tabs_render_row_cb'),
		));

		$cmb->add_field(array(
			'id' => $prefix . 'breadcrumbs',
			'name' => esc_html__('Hide breadcrumb', 'mipro'),
			'desc' => esc_html__('Yes, please', 'mipro'),
			'type' => 'checkbox',
			'tab' => 'breadcrumb',
			'render_row_cb' => array('CMB2_Tabs', 'tabs_render_row_cb'),
		));

		$cmb->add_field(array(
			'id' => $prefix . 'breadcrumb_layout',
			'name' => esc_html__('Breadcrumb Layout', 'mipro'),
			'desc' => '',
			'type' => 'select',
			'options' => array(
				'default' => esc_html__('Default', 'mipro'),
				'layout1' => esc_html__('Breadcrumb Layout 1', 'mipro'),
				'layout2' => esc_html__('Breadcrumb Layout 2', 'mipro'),
			),
			'tab' => 'breadcrumb',
			'render_row_cb' => array('CMB2_Tabs', 'tabs_render_row_cb'),
		));

		$cmb->add_field(array(
			'id' => $prefix . 'bg_breadcrumbs',
			'name' => esc_html__('Breadcrumb Background Image', 'mipro'),
			'desc' => '',
			'type' => 'file',
			'tab' => 'breadcrumb',
			'render_row_cb' => array('CMB2_Tabs', 'tabs_render_row_cb'),
		));

		$revolution_exists = class_exists('RevSliderSlider');

		$page_sliders = array();
		$page_sliders[0] = esc_html__('No Slider', 'mipro');
		if ($revolution_exists) {
			$page_sliders['revslider'] = esc_html__('Revolution Slider', 'mipro');
		}

		$cmb->add_field(array(
			'id' => $prefix . 'page_slider',
			'name' => esc_html__('Page Slider', 'mipro'),
			'desc' => '',
			'type' => 'radio_inline',
			'options' => $page_sliders,
			'default' => 0,
			'tab' => 'slider',
			'render_row_cb' => array('CMB2_Tabs', 'tabs_render_row_cb'),
		));

		$cmb->add_field(array(
			'id' => $prefix . 'page_slider_position',
			'name' => esc_html__('Page Slider Position', 'mipro'),
			'desc' => '',
			'type' => 'select',
			'options' => array(
				'before_header' => esc_html__('Before Header', 'mipro'),
				'before_main_content' => esc_html__('Before Main Content', 'mipro'),
			),
			'default' => 'before_main_content',
			'tab' => 'slider',
			'render_row_cb' => array('CMB2_Tabs', 'tabs_render_row_cb'),
		));

		if ($revolution_exists) {
			$revsliders = array();
			$revsliders[0] = esc_html__('Select a slider', 'mipro');
			if (function_exists('rev_slider_shortcode')) {
				$slider_object = new RevSliderSlider();
				$sliders_array = $slider_object->getArrSliders();
				if ($sliders_array) {
					foreach ($sliders_array as $slider) {
						$revsliders[$slider->getAlias()] = $slider->getTitle();
					}
				}
			}

			$cmb->add_field(array(
				'id' => $prefix . 'rev_slider',
				'name' => esc_html__('Select Revolution Slider', 'mipro'),
				'desc' => '',
				'type' => 'select',
				'options' => $revsliders,
				'tab' => 'slider',
				'render_row_cb' => array('CMB2_Tabs', 'tabs_render_row_cb'),
			));
		}

		if (!class_exists('AluraStudio_Demo')) {
			$footer_blocks = array('0' => '');

			$args = array(
				'post_type' => 'kft_footer',
				'post_status' => 'publish',
				'posts_per_page' => -1,
			);

			$posts = new WP_Query($args);

			if (!empty($posts->posts) && is_array($posts->posts)) {
				foreach ($posts->posts as $p) {
					$footer_blocks[$p->ID] = $p->post_title;
				}
			}

			$cmb->add_field(array(
				'id' => $prefix . 'footer_top',
				'name' => esc_html__('Footer Top', 'mipro'),
				'desc' => '',
				'type' => 'select',
				'options' => $footer_blocks,
				'tab' => 'footer',
				'render_row_cb' => array('CMB2_Tabs', 'tabs_render_row_cb'),
			));

			$cmb->add_field(array(
				'id' => $prefix . 'footer_middle',
				'name' => esc_html__('Footer Middle', 'mipro'),
				'desc' => '',
				'type' => 'select',
				'options' => $footer_blocks,
				'tab' => 'footer',
				'render_row_cb' => array('CMB2_Tabs', 'tabs_render_row_cb'),
			));

			$cmb->add_field(array(
				'id' => $prefix . 'footer_bottom',
				'name' => esc_html__('Footer Bottom', 'mipro'),
				'desc' => '',
				'type' => 'select',
				'options' => $footer_blocks,
				'tab' => 'footer',
				'render_row_cb' => array('CMB2_Tabs', 'tabs_render_row_cb'),
			));

		}

		$cmb->add_field(
			array(
				'id'            => $prefix . 'page_custom_css',
				'name'          => esc_html__( 'Custom CSS', 'mipro' ),
				'type'          => 'textarea_code',
				'tab'           => 'css',
				'options'       => array( 'disable_codemirror' => true ),
				'render_row_cb' => array( 'CMB2_Tabs', 'tabs_render_row_cb' ),
			)
		);

		$cmb = new_cmb2_box(array(
			'id' => 'post_options',
			'title' => esc_html__('Post options', 'mipro'),
			'object_types' => array('post'),
			'context' => 'normal',
			'priority' => 'high',
			'show_names' => true,
			'tabs' => array(
				'format' => array(
					'label' => esc_html__('Data Format', 'mipro'),
					'icon' => 'dashicons-format-gallery',
				),
				'layout' => array(
					'label' => esc_html__('Layout', 'mipro'),
					'icon' => 'dashicons-align-left',
				),
				'breadcrumb' => array(
					'label' => esc_html__('Breadcrumb', 'mipro'),
					'icon' => 'dashicons-editor-insertmore',
				),
				'data_setting' => array(
					'label' => esc_html__('Data Setting', 'mipro'),
					'icon' => 'dashicons-format-aside',
				),
			),
			'tab_style' => 'default',
		));

		$cmb->add_field(array(
			'id' => $prefix . 'blog_details_layout',
			'name' => esc_html__('Post Layout', 'mipro'),
			'desc' => '',
			'type' => 'radio_inline',
			'options' => array(
				'' => esc_html__('Default', 'mipro'),
				'full-width' => esc_html__('Fullwidth', 'mipro'),
				'left-sidebar' => esc_html__('Left Sidebar', 'mipro'),
				'right-sidebar' => esc_html__('Right Sidebar', 'mipro'),
				'left-right-sidebar' => esc_html__('Left & Right Sidebar', 'mipro'),
			),
			'tab' => 'layout',
			'render_row_cb' => array('CMB2_Tabs', 'tabs_render_row_cb'),
		));

		$cmb->add_field(array(
			'id' => $prefix . 'blog_details_left_sidebar',
			'name' => esc_html__('Left Sidebar', 'mipro'),
			'desc' => '',
			'type' => 'select',
			'options' => mipro_get_sidebars(),
			'tab' => 'layout',
			'render_row_cb' => array('CMB2_Tabs', 'tabs_render_row_cb'),
		));

		$cmb->add_field(array(
			'id' => $prefix . 'blog_details_right_sidebar',
			'name' => esc_html__('Right Sidebar', 'mipro'),
			'desc' => '',
			'type' => 'select',
			'options' => mipro_get_sidebars(),
			'tab' => 'layout',
			'render_row_cb' => array('CMB2_Tabs', 'tabs_render_row_cb'),
		));

		$cmb->add_field(array(
			'id' => $prefix . 'bg_breadcrumbs',
			'name' => esc_html__('Breadcrumb Background Image', 'mipro'),
			'desc' => '',
			'type' => 'file',
			'desc' => esc_html__('Enter Breadcrumb Background Image URL', 'mipro'),
			'allow' => array('url', 'attachment'),
			'tab' => 'breadcrumb',
			'render_row_cb' => array('CMB2_Tabs', 'tabs_render_row_cb'),
		));

		$cmb->add_field(array(
			'id' => $prefix . 'blog_details_sharing',
			'name' => esc_html__('Hide Social Share Box', 'mipro'),
			'desc' => esc_html__('Choose to hide the post social share box.', 'mipro'),
			'type' => 'checkbox',
			'tab' => 'data_setting',
			'render_row_cb' => array('CMB2_Tabs', 'tabs_render_row_cb'),
		));

		$cmb->add_field(array(
			'id' => $prefix . 'blog_details_related_posts',
			'name' => esc_html__('Hide Related Post', 'mipro'),
			'desc' => esc_html__('Choose to hide related posts on this post.', 'mipro'),
			'type' => 'checkbox',
			'tab' => 'data_setting',
			'render_row_cb' => array('CMB2_Tabs', 'tabs_render_row_cb'),
		));

		$cmb->add_field(array(
			'id' => $prefix . 'blog_details_comment_form',
			'name' => esc_html__('Hide Comment Form', 'mipro'),
			'desc' => esc_html__('Choose to hide the post comment area.', 'mipro'),
			'type' => 'checkbox',
			'tab' => 'data_setting',
			'render_row_cb' => array('CMB2_Tabs', 'tabs_render_row_cb'),
		));

		$cmb->add_field(array(
			'id' => $prefix . 'audio_url',
			'name' => esc_html__('Audio URL:', 'mipro'),
			'desc' => esc_html__('Enter MP3, OGG, WAV file URL or SoundCloud URL (use for audio post format).', 'mipro'),
			'type' => 'oembed',
			'tab' => 'format',
			'render_row_cb' => array('CMB2_Tabs', 'tabs_render_row_cb'),
		));

		$cmb->add_field(array(
			'id' => $prefix . 'video_url',
			'name' => esc_html__('Video URL:', 'mipro'),
			'desc' => esc_html__('Enter Youtube or Vimeo video URL (use for video post format).', 'mipro'),
			'type' => 'oembed',
			'tab' => 'format',
			'render_row_cb' => array('CMB2_Tabs', 'tabs_render_row_cb'),
		));

		$cmb = new_cmb2_box(array(
			'id' => 'post_gallery',
			'title' => esc_html__('Post Gallery', 'mipro'),
			'object_types' => array('post'),
			'context' => 'side',
			'priority' => 'low',
			'show_names' => true,
		));

		$cmb->add_field(array(
			'id' => $prefix . 'gallery',
			'name' => '',
			'desc' => esc_html__('Add list gallery for Gallery format.', 'mipro'),
			'type' => 'file_list',
		));

		$cmb = new_cmb2_box(array(
			'id' => 'brand_options',
			'title' => esc_html__('Brand Options', 'mipro'),
			'object_types' => array('kft_brand'),
			'context' => 'normal',
			'priority' => 'high',
			'show_names' => true,
		));

		$cmb->add_field(array(
			'id' => $prefix . 'brand_url',
			'name' => esc_html__('Brand URL', 'mipro'),
			'desc' => '',
			'type' => 'text',
		));

		$cmb->add_field(array(
			'id' => $prefix . 'brand_target',
			'name' => esc_html__('Target', 'mipro'),
			'desc' => '',
			'type' => 'select',
			'options' => array(
				'_self' => esc_html__('Self', 'mipro'),
				'_blank' => esc_html__('New Window Tab', 'mipro'),
			),
		));

		$cmb = new_cmb2_box(array(
			'id' => 'product_options',
			'title' => esc_html__('Product Options', 'mipro'),
			'object_types' => array('product'),
			'context' => 'normal',
			'priority' => 'high',
			'show_names' => true,
			'tabs' => array(
				'layout' => array(
					'label' => esc_html__('Layout', 'mipro'),
					'icon' => 'dashicons-align-left',
				),
				'breadcrumb' => array(
					'label' => esc_html__('Breadcrumb', 'mipro'),
					'icon' => 'dashicons-editor-insertmore',
				),
				'size_chart' => array(
					'label' => esc_html__('Size Chart', 'mipro'),
					'icon' => 'dashicons-chart-bar',
				),
				'custom_tab' => array(
					'label' => esc_html__('Custom Tab', 'mipro'),
					'icon' => 'dashicons-editor-ul',
				),
				'video' => array(
					'label' => esc_html__('Video', 'mipro'),
					'icon' => 'dashicons-video-alt3',
				),
				'data_setting' => array(
					'label' => esc_html__('Data Setting', 'mipro'),
					'icon' => 'dashicons-format-aside',
				),
			),
			'tab_style' => 'default',
		));

		$cmb->add_field(array(
			'id' => $prefix . 'prod_layout',
			'name' => esc_html__('Product Layout', 'mipro'),
			'desc' => '',
			'type' => 'radio_inline',
			'options' => array(
				'' => esc_html__('Default', 'mipro'),
				'full-width' => esc_html__('Fullwidth', 'mipro'),
				'left-sidebar' => esc_html__('Left Sidebar', 'mipro'),
				'right-sidebar' => esc_html__('Right Sidebar', 'mipro'),
				'left-right-sidebar' => esc_html__('Left & Right Sidebar', 'mipro'),
			),
			'tab' => 'layout',
			'render_row_cb' => array('CMB2_Tabs', 'tabs_render_row_cb'),
		));

		$cmb->add_field(array(
			'id' => $prefix . 'prod_left_sidebar',
			'name' => esc_html__('Left Sidebar', 'mipro'),
			'desc' => '',
			'type' => 'select',
			'options' => mipro_get_sidebars(),
			'tab' => 'layout',
			'render_row_cb' => array('CMB2_Tabs', 'tabs_render_row_cb'),
		));

		$cmb->add_field(array(
			'id' => $prefix . 'prod_right_sidebar',
			'name' => esc_html__('Right Sidebar', 'mipro'),
			'desc' => '',
			'type' => 'select',
			'options' => mipro_get_sidebars(),
			'tab' => 'layout',
			'render_row_cb' => array('CMB2_Tabs', 'tabs_render_row_cb'),
		));

		$cmb->add_field(array(
			'id' => $prefix . 'bg_breadcrumbs',
			'name' => esc_html__('Breadcrumb Background Image', 'mipro'),
			'desc' => '',
			'type' => 'file',
			'tab' => 'breadcrumb',
			'render_row_cb' => array('CMB2_Tabs', 'tabs_render_row_cb'),
		));

		$cmb->add_field(array(
			'id' => $prefix . 'prod_related',
			'name' => esc_html__('Hide Related Product', 'mipro'),
			'desc' => esc_html__('Choose to hide related product on this product.', 'mipro'),
			'type' => 'checkbox',
			'default' => 0,
			'tab' => 'data_setting',
			'render_row_cb' => array('CMB2_Tabs', 'tabs_render_row_cb'),
		));

		$cmb->add_field(array(
			'id' => $prefix . 'prod_thumbnails_style',
			'name' => esc_html__('Product Thumbnail Style', 'mipro'),
			'desc' => '',
			'type' => 'radio_inline',
			'options' => array(
				'' => esc_html__('Default', 'mipro'),
				'vertical' => esc_html__('Vertical', 'mipro'),
				'horizontal' => esc_html__('Horizontal', 'mipro'),
			),
			'tab' => 'data_setting',
			'render_row_cb' => array('CMB2_Tabs', 'tabs_render_row_cb'),
		));

		$cmb->add_field(array(
			'id' => $prefix . 'show_size_chart',
			'name' => esc_html__('Show Size Chart', 'mipro'),
			'desc' => esc_html__('Show Size Chart', 'mipro'),
			'type' => 'checkbox',
			'tab' => 'size_chart',
			'render_row_cb' => array('CMB2_Tabs', 'tabs_render_row_cb'),
		));

		$cmb->add_field(array(
			'id' => $prefix . 'prod_size_chart',
			'name' => esc_html__('Size Chart Image', 'mipro'),
			'desc' => esc_html__('You can upload size chart image for product', 'mipro'),
			'type' => 'file',
			'query_args' => array(
				'type' => array(
					'image/jpeg',
					'image/png',
				),
			),
			'tab' => 'size_chart',
			'render_row_cb' => array('CMB2_Tabs', 'tabs_render_row_cb'),
		));

		$cmb->add_field(array(
			'id' => $prefix . 'prod_custom_tab',
			'name' => esc_html__('Custom Tab', 'mipro'),
			'desc' => esc_html__('Show Custom Tab', 'mipro'),
			'type' => 'checkbox',
			'tab' => 'custom_tab',
			'render_row_cb' => array('CMB2_Tabs', 'tabs_render_row_cb'),
		));

		$group_field_id = $cmb->add_field(array(
			'id' => $prefix . 'prod_custom_tabs',
			'type' => 'group',
			'tab' => 'custom_tab',
			'render_row_cb' => array('CMB2_Tabs', 'tabs_render_group_row_cb'),
			'options' => array(
				'group_title' => esc_html__('Tab {#}', 'mipro'),
				'add_button' => esc_html__('Add Another Tab', 'mipro'),
				'remove_button' => esc_html__('Remove Tab', 'mipro'),
				'sortable' => false,
			),
		));

		$cmb->add_group_field($group_field_id, array(
			'id' => 'tab_title',
			'name' => esc_html__('Tab Title', 'mipro'),
			'desc' => '',
			'type' => 'text',
		));

		$cmb->add_group_field($group_field_id, array(
			'id' => 'tab_content',
			'name' => esc_html__('Tab Content', 'mipro'),
			'desc' => '',
			'type' => 'wysiwyg',
		));

		$cmb->add_field(array(
			'id' => $prefix . 'prod_video_url',
			'name' => esc_html__('Video URL', 'mipro'),
			'desc' => esc_html__('Enter Youtube or Vimeo video URL', 'mipro'),
			'type' => 'text',
			'tab' => 'video',
			'render_row_cb' => array('CMB2_Tabs', 'tabs_render_row_cb'),
		));

		$cmb = new_cmb2_box(array(
			'id' => 'product_video_360',
			'title' => esc_html__('Product video 360', 'mipro'),
			'object_types' => array('product'),
			'context' => 'side',
			'priority' => 'low',
			'show_names' => true,
		));

		$cmb->add_field(array(
			'id' => $prefix . 'product_360',
			'name' => '',
			'desc' => esc_html__('Add Product Gallery Image for Video 360', 'mipro'),
			'type' => 'file_list',
		));
	}
}

add_filter('cmb2_admin_init', 'mipro_categories_metaboxes');

if (!function_exists('mipro_categories_metaboxes')) {
	function mipro_categories_metaboxes() {

		$cmb_term = new_cmb2_box(array(
			'id' => 'product_cat_options',
			'title' => esc_html__('Category Metabox', 'mipro'),
			'object_types' => array('term'),
			'taxonomies' => array('product_cat'),
		));

		$cmb_term->add_field(array(
			'id' => 'bg_breadcrumbs_id',
			'name' => esc_html__('Breadcrumbs Background Image', 'mipro'),
			'desc' => esc_html__('Upload an image or enter an URL.', 'mipro'),
			'type' => 'file',
			'allow' => array('url', 'attachment'),
		));

		$cmb_term->add_field(array(
			'id' => 'layout',
			'name' => esc_html__('Category Layout', 'mipro'),
			'desc' => '',
			'type' => 'select',
			'options' => array(
				'' => esc_html__('Default', 'mipro'),
				'full-width' => esc_html__('Fullwidth', 'mipro'),
				'left-sidebar' => esc_html__('Left Sidebar', 'mipro'),
				'right-sidebar' => esc_html__('Right Sidebar', 'mipro'),
				'left-right-sidebar' => esc_html__('Left & Right Sidebar', 'mipro'),
			),
		));

		$cmb_term->add_field(array(
			'id' => 'left_sidebar',
			'name' => esc_html__('Left Sidebar', 'mipro'),
			'desc' => '',
			'type' => 'select',
			'options' => mipro_get_sidebars(),
		));

		$cmb_term->add_field(array(
			'id' => 'right_sidebar',
			'name' => esc_html__('Right Sidebar', 'mipro'),
			'desc' => '',
			'type' => 'select',
			'options' => mipro_get_sidebars(),
		));

	}
}

add_filter('cmb2_admin_init', 'mipro_color_metaboxes');

if (!function_exists('mipro_color_metaboxes')) {
	function mipro_color_metaboxes() {

		$cmb_term = new_cmb2_box(array(
			'id' => 'product_color_attr',
			'title' => esc_html__('Color Metabox', 'mipro'),
			'object_types' => array('term'),
			'taxonomies' => array('pa_color'),
		));

		$cmb_term->add_field(array(
			'id' => 'color_color',
			'name' => esc_html__('Color', 'mipro'),
			'desc' => '',
			'type' => 'colorpicker',
		));

		$cmb_term->add_field(array(
			'id' => 'color_image',
			'name' => esc_html__('Thumbnail Image', 'mipro'),
			'desc' => '',
			'type' => 'file',
		));

	}
}

?>