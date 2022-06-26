<?php
add_action('widgets_init', 'mipro_instagram_load_widgets');

function mipro_instagram_load_widgets()
{
	register_widget('Mipro_Instagram_Widget');
}

if(!class_exists('Mipro_Instagram_Widget')){
	class Mipro_Instagram_Widget extends WP_Widget {

		function __construct(){
			$widget_ops = array('classname' => 'kft-instagram-widget', 'description' => esc_html__('Display your photos from Instagram', 'mipro-core'));
			parent::__construct('kft_instagram', esc_html__('Mipro - Instagram', 'mipro-core'), $widget_ops);
		}

		function widget( $args, $instance ) {
			
			extract($args);
			$title = apply_filters('widget_title', $instance['title']);
			if( strlen(trim($instance['username'])) == 0 ){
				return;
			}
			
			$username 		= $instance['username'];
			$number 		= absint($instance['number']);
			$column 		= absint($instance['column']);
			$size 			= $instance['size'];
			$target 		= $instance['target'];
			$cache_time 	= absint($instance['cache_time']);
			
			if( $cache_time == 0 ){
				$cache_time = 12;
			}
			
			echo wp_kses_post($before_widget);
			if( $title ){
				echo wp_kses_post($before_title . $title . $after_title); 
			}
			unset($instance['title']);
				
			$instagram = mipro_get_instagram_feed( $number );

			ob_start();
			?>

			<div class="kft-instagram columns-<?php echo esc_attr($column); ?>">
				<?php if ( ! is_wp_error( $instagram ) ) {
					foreach ( $instagram as $index => $item ) { ?>
						<div class="item">
							<a href="<?php echo esc_url( $item['link'] ) ?>" target="<?php echo esc_attr( $target ) ?>" rel="noopener">
								<img src="<?php echo esc_url( $item['image_url'] ) ?>" alt="<?php echo esc_attr( $item['caption'] ) ?>" title="<?php echo esc_attr( $item['caption'] ) ?>" />
							</a>
						</div>
					<?php } 
				} else {
					echo wp_kses_post( $instagram->get_error_message() );
				} ?>
			</div>

			<?php
			$output = ob_get_clean();
			echo $output;
			
			echo wp_kses_post($after_widget);
		}

		function update( $new_instance, $old_instance ) {
			$instance = $old_instance;	
			$instance['title'] 				=  strip_tags($new_instance['title']);
			$instance['username'] 			=  $new_instance['username'];
			$instance['number'] 			=  $new_instance['number'];
			$instance['column'] 			=  $new_instance['column'];
			$instance['size'] 				=  $new_instance['size'];									
			$instance['target'] 			=  $new_instance['target'];									
			$instance['cache_time'] 		=  $new_instance['cache_time'];									
			return $instance;
		}

		function form( $instance ) {
			$array_default = array(
				'title'			=> 'Instagram'
				,'username' 	=> ''
				,'number' 		=> 9
				,'column' 		=> 3
				,'size' 		=> 'large'
				,'target' 		=> '_self'
				,'cache_time'	=> 12
			);
			
			$instance = wp_parse_args( (array) $instance, $array_default );
			if ( ! mipro_get_opt( 'instagram_access_token' ) ) {
				echo '<p>You need set for Access Token on <a href="' . esc_url( admin_url( 'admin.php?page=_options' ) ) . '">Theme Options</a></p>';
			}
			?>
			<p>
				<label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Enter your title', 'mipro-core'); ?> </label>
				<input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($instance['title']); ?>" />
			</p>
			<p>
				<label for="<?php echo esc_attr($this->get_field_id('username')); ?>"><?php esc_html_e('Username', 'mipro-core'); ?> </label>
				<input class="widefat" id="<?php echo esc_attr($this->get_field_id('username')); ?>" name="<?php echo esc_attr($this->get_field_name('username')); ?>" type="text" value="<?php echo esc_attr($instance['username']); ?>" />
			</p>
			<p>
				<label for="<?php echo esc_attr($this->get_field_id('number')); ?>"><?php esc_html_e('Number of photos', 'mipro-core'); ?> </label>
				<input class="widefat" type="number" id="<?php echo esc_attr($this->get_field_id('number')); ?>" name="<?php echo esc_attr($this->get_field_name('number')); ?>" value="<?php echo esc_attr($instance['number']); ?>" />
			</p>
			<p>
				<label for="<?php echo esc_attr($this->get_field_id('column')); ?>"><?php esc_html_e('Column', 'mipro-core'); ?> </label>
				<select class="widefat" id="<?php echo esc_attr($this->get_field_id('column')); ?>" name="<?php echo esc_attr($this->get_field_name('column')); ?>" >
					<?php for( $i = 1; $i <= 4; $i++ ): ?>
						<option value="<?php echo esc_attr($i); ?>" <?php selected($instance['column'], $i); ?> ><?php echo esc_attr($i); ?></option>
					<?php endfor; ?>
				</select>
			</p>
			<p>
				<label for="<?php echo esc_attr($this->get_field_id('size')); ?>"><?php esc_html_e('Size', 'mipro-core'); ?> </label>
				<select class="widefat" id="<?php echo esc_attr($this->get_field_id('size')); ?>" name="<?php echo esc_attr($this->get_field_name('size')); ?>" >
					<option value="thumbnail" <?php selected($instance['size'], 'thumbnail'); ?> ><?php esc_html_e('Thumbnail', 'mipro-core') ?></option>
					<option value="small" <?php selected($instance['size'], 'small'); ?> ><?php esc_html_e('Small', 'mipro-core') ?></option>
					<option value="large" <?php selected($instance['size'], 'large'); ?> ><?php esc_html_e('Large', 'mipro-core') ?></option>
					<option value="original" <?php selected($instance['size'], 'original'); ?> ><?php esc_html_e('Original', 'mipro-core') ?></option>
				</select>
			</p>
			<p>
				<label for="<?php echo esc_attr($this->get_field_id('target')); ?>"><?php esc_html_e('Target', 'mipro-core'); ?> </label>
				<select class="widefat" id="<?php echo esc_attr($this->get_field_id('target')); ?>" name="<?php echo esc_attr($this->get_field_name('target')); ?>" >
					<option value="_self" <?php selected($instance['target'], '_self'); ?> ><?php esc_html_e('Current window', 'mipro-core') ?></option>
					<option value="_blank" <?php selected($instance['target'], '_blank'); ?> ><?php esc_html_e('New window', 'mipro-core') ?></option>
				</select>
			</p>
			<p>
				<label for="<?php echo esc_attr($this->get_field_id('cache_time')); ?>"><?php esc_html_e('Cache time (hours)', 'mipro-core'); ?> </label>
				<input class="widefat" type="number" min="1" id="<?php echo esc_attr($this->get_field_id('cache_time')); ?>" name="<?php echo esc_attr($this->get_field_name('cache_time')); ?>" value="<?php echo esc_attr($instance['cache_time']); ?>" />
			</p>
			
			<?php 
		}
	}
}

