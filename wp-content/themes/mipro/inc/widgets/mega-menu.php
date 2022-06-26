<?php

if( ! class_exists( 'Mipro_WP_Nav_Menu_Widget' ) ) {
	class Mipro_WP_Nav_Menu_Widget extends WP_Widget {

		function __construct() {
			$widget_ops = array( 'classname' => 'mega-menu-sidebar', 'description' => esc_html__('Add a custom mega menu to your sidebar.', 'mipro') );
			parent::__construct( 'kft_mega_menu_wg', esc_html__( 'Mipro - Mega Menu Sidebar', 'mipro' ), $widget_ops );
		}

		function widget( $args, $instance ) {

			$nav_menu = ! empty( $instance['nav_menu'] ) ? wp_get_nav_menu_object( $instance['nav_menu'] ) : false;
			$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );

			if ( ! $nav_menu ) {
				return;
			} 

			echo wp_kses_post( $args['before_widget'] );

			if ( ! empty($title) ) {
				echo wp_kses_post( $args['before_title'] . $title . $args['after_title'] );
			}

			echo '<div class="mega-menu-wg vertical-menu vertical-menu-dropdown">';
			wp_nav_menu( array( 
				'menu' => $nav_menu,
				'menu_id'        => 'vertical-menu',
				'walker' => new Mipro_Mega_Menu_Walker(),
			) );
			echo '</div>';

			echo wp_kses_post( $args['after_widget'] );
		}

		function update( $new_instance, $old_instance ) {
			$instance = array();
			if ( ! empty( $new_instance['title'] ) ) {
				$instance['title'] = strip_tags( stripslashes($new_instance['title']) );
			}
			if ( ! empty( $new_instance['nav_menu'] ) ) {
				$instance['nav_menu'] = (int) $new_instance['nav_menu'];
			}
			return $instance;
		}

		function form( $instance ) {
			$defaults = array(
				'title' 				=> 'All Categories',
				'nav_menu'				=> '',
			);

			$instance = wp_parse_args( (array) $instance, $defaults );	

			// Get menus
			$menus = wp_get_nav_menus();
			?>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id('title') ); ?>"><?php esc_html_e( 'Title:', 'mipro' ); ?></label>
				<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id('title') ); ?>" name="<?php echo esc_attr( $this->get_field_name('title') ); ?>" value="<?php echo sanitize_text_field( $instance['title'] ); ?>" />
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id('nav_menu') ); ?>"><?php esc_html_e( 'Select Menu:', 'mipro' ); ?></label>
				<select id="<?php echo esc_attr( $this->get_field_id('nav_menu') ); ?>" name="<?php echo esc_attr( $this->get_field_name('nav_menu') ); ?>">
					<option value="0"><?php esc_html_e( '&mdash; Select &mdash;', 'mipro' ); ?></option>
					<?php
					foreach ( $menus as $menu ) {
						echo '<option value="' . $menu->term_id . '"'
						. selected( $instance['nav_menu'], $menu->term_id, false )
						. '>'. esc_html( $menu->name ) . '</option>';
					}
					?>
				</select>
			</p>
			<?php
		}
	}
}