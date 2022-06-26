<?php

if ( ! class_exists( 'Mipro_About_Me_Widget' ) ) {
	class Mipro_About_Me_Widget extends WP_Widget {

		function __construct() {
			$widget_ops = array( 'classname' => 'about-me-sidebar', 'description' => esc_html__( 'Add information block about author your sidebar.', 'mipro' ) );
			parent::__construct( 'kft_about_me_wg', esc_html__( 'Mipro - About Me', 'mipro' ), $widget_ops );
		}

		function widget( $args, $instance ) {
			extract( $args );

			$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? false : $instance['title'] );
			$caption = ( ! empty( $instance['caption'] ) ) ? $instance['caption'] : '';
			$bio       = ( ! empty( $instance['bio'] ) ) ? $instance['bio'] : '';
			$image     = ( ! empty( $instance['image'] ) ) ? $instance['image'] : '';
			$autograph = ( ! empty( $instance['autograph'] ) ) ? $instance['autograph'] : '';

			echo wp_kses_post( $args['before_widget'] );

			if ( ! empty( $title ) ) {
				echo wp_kses_post( $args['before_title'] . $title . $args['after_title'] );
			}
			?>

			<div class="about-me-wg">
				<?php if ( ! empty( $image ) ) : ?>
					<img src="<?php echo esc_url( $image ); ?>" alt="<?php echo esc_attr( $caption ); ?>" title="<?php echo esc_attr( $caption ); ?>">
				<?php endif; ?>

				<?php if ( ! empty( $caption ) ) : ?>
					<h3><?php echo esc_html( $caption ); ?></h3>
				<?php endif; ?>

				<?php if ( ! empty( $bio ) ) : ?>
					<p class="about-bio"><?php echo esc_html( $bio ); ?></p>
				<?php endif; ?>

				<?php if ( ! empty( $autograph ) ) : ?>
					<img src="<?php echo esc_url( $autograph ); ?>" alt="<?php echo esc_attr( $caption ); ?>" title="<?php echo esc_attr( $caption ); ?>">
				<?php endif; ?>
			</div>

			<?php
			echo wp_kses_post( $args['after_widget'] );
		}

		function update( $new_instance, $old_instance ) {
			$instance = $old_instance;
			$instance['title'] = $new_instance['title'];
			$instance['caption'] = $new_instance['caption'];
			$instance['bio'] = $new_instance['bio'];
			$instance['image'] = $new_instance['image'];
			$instance['autograph'] = $new_instance['autograph'];

			return $instance;
		}

		function form( $instance ) {
			$defaults = array(
				'title' => 'About me',
				'image' => '',
				'caption' => '',
				'bio' => '',
				'autograph' => '',
			);

			$instance = wp_parse_args( (array) $instance, $defaults );
			?>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id('title') ); ?>"><?php esc_html_e( 'Title:', 'mipro' ); ?></label>
				<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id('title') ); ?>" name="<?php echo esc_attr( $this->get_field_name('title') ); ?>" value="<?php echo sanitize_text_field( $instance['title'] ); ?>" />
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id('image') ); ?>"><?php esc_html_e( 'Image:', 'mipro' ); ?></label>
				<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id('image') ); ?>" name="<?php echo esc_attr( $this->get_field_name('image') ); ?>" value="<?php echo strip_tags( $instance['image'] ); ?>" />
				<input type="button" value="<?php esc_attr_e( 'Upload Image', 'mipro' ); ?>" class="button upload_image_button" />
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id('caption') ); ?>"><?php esc_html_e( 'Caption:', 'mipro' ); ?></label>
				<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id('caption') ); ?>" name="<?php echo esc_attr( $this->get_field_name('caption') ); ?>" value="<?php echo sanitize_text_field( $instance['caption'] ); ?>" />
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id('bio') ); ?>"><?php esc_html_e( 'Bio:', 'mipro' ); ?></label>
				<textarea rows="3" cols="10" class="widefat" id="<?php echo esc_attr( $this->get_field_id('bio') ); ?>" name="<?php echo esc_attr( $this->get_field_name('bio') ); ?>"><?php echo sanitize_text_field( $instance['bio'] ); ?></textarea>
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id('autograph') ); ?>"><?php esc_html_e( 'Autograph image:', 'mipro' ); ?></label>
				<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id('autograph') ); ?>" name="<?php echo esc_attr( $this->get_field_name('autograph') ); ?>" value="<?php echo strip_tags( $instance['autograph'] ); ?>" />
				<input type="button" value="<?php esc_attr_e( 'Upload Image', 'mipro' ); ?>" class="button upload_image_button" />
			</p>

			<?php
		}
	}
}