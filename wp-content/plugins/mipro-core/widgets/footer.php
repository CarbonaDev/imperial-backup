<?php
add_action('widgets_init', 'kft_footer_load_widgets');

function kft_footer_load_widgets() {
    register_widget('Mipro_Footer_Widget');
}

if (!class_exists('Mipro_Footer_Widget')) {
    class Mipro_Footer_Widget extends WP_Widget {

        function __construct() {
            $widgetOps = array('classname' => 'kft-footer', 'description' => esc_html__('Insert your footer block', 'mipro-core'));
            parent::__construct('kft_footer', esc_html__('Mipro - Footer', 'mipro-core'), $widgetOps);
        }

        function widget($args, $instance) {
            extract($args);
            $block_id = isset($instance['block_id']) ? absint($instance['block_id']) : '';
            if (!$block_id) {
                return;
            }

            global $post;

            $args = array(
                'post_type' => 'kft_footer'
                , 'posts_per_page' => 1
                , 'include' => $block_id,
            );
            $posts = get_posts($args);

            if (is_array($posts)) {
                echo $before_widget;
                foreach ($posts as $post) {
                    if (function_exists('kc_do_shortcode')) {    
                        $raw_content = kc_raw_content( $post->ID );
                        echo kc_do_shortcode( $raw_content );
                    } else {
                        echo do_shortcode ($post->post_content);
                    }

                }
                echo $after_widget;
            }
            wp_reset_postdata();
        }

        function update($new_instance, $old_instance) {
            $instance = $old_instance;
            $instance['block_id'] = $new_instance['block_id'];
            return $instance;
        }

        function form($instance) {

            $defaults = array(
                'block_id' => '',
            );

            $instance = wp_parse_args((array) $instance, $defaults);
            $footer_blocks = $this->get_footer_blocks();
            ?>
            <p>
                <label for="<?php echo $this->get_field_id('block_id'); ?>"><?php esc_html_e('Mipro Footer', 'mipro-core');?> </label>
                <select name="<?php echo $this->get_field_name('block_id'); ?>" id="<?php echo $this->get_field_id('block_id'); ?>" class="widefat">
                   <option value=""></option>
                   <?php foreach ($footer_blocks as $block): ?>
                       <option value="<?php echo $block->ID; ?>" <?php selected($block->ID, $instance['block_id'])?>><?php echo esc_html($block->post_title); ?></option>
                   <?php endforeach;?>
               </select>
           </p>
           <?php
       }

       function get_footer_blocks() {
        $args = array(
            'post_type' => 'kft_footer'
            , 'post_status' => 'publish'
            , 'posts_per_page' => -1,
        );
        $posts = new WP_Query($args);
        if (isset($posts->posts)) {
            return $posts->posts;
        }
        return array();
    }
}
}
