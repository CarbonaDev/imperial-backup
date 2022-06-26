<?php 
/**
 * Mega Menu
 * (c) Joyce
 */

/* Mega Menu */
if ( ! class_exists('Mipro_Mega_Menu') ) {
	class Mipro_Mega_Menu {
		function __construct() {
			add_filter( 'wp_edit_nav_menu_walker', array( $this, 'show_custom_fields' ) );
			add_action( 'wp_update_nav_menu_item', array( $this, 'save_custom_fields' ), 10, 3 );
			add_filter( 'wp_setup_nav_menu_item', array( $this, 'add_custom_fields' ) );
		}
		
		function show_custom_fields() {
			return 'Mipro_Custom_Mega_Menu';
		}
		
		function save_custom_fields( $menu_id, $menu_item_db_id, $args ) {
			$fields = array( 'design', 'width', 'height', 'icon', 'label-color', 'label-text', 'block', 'columns', 'bg-image', 'bg-repeat', 'bg-position' );
			for ( $i = 0; $i < count( $fields ); $i++ ) {
				$key = 'menu-item-' . $fields[ $i ];
				if ( isset( $_REQUEST[ $key ] ) && isset( $_REQUEST[ $key ][ $menu_item_db_id ] ) && ! empty( $_REQUEST[ $key ] ) && is_array( $_REQUEST[ $key ] ) ) {
					$custom_value = $_REQUEST[ $key ][ $menu_item_db_id ];
					update_post_meta( $menu_item_db_id, '_menu_item_' . $fields[ $i ], $custom_value );
				}
			}
		}
		
		function add_custom_fields( $menu_item ) {
			$menu_item->design = get_post_meta( $menu_item->ID, '_menu_item_design', true );
			$menu_item->width = get_post_meta( $menu_item->ID, '_menu_item_width', true );
			$menu_item->height = get_post_meta( $menu_item->ID, '_menu_item_height', true );
			$menu_item->icon = get_post_meta( $menu_item->ID, '_menu_item_icon', true );
			$menu_item->label_color = get_post_meta( $menu_item->ID, '_menu_item_label-color', true );
			$menu_item->label_text = get_post_meta( $menu_item->ID, '_menu_item_label-text', true );
			$menu_item->block = get_post_meta( $menu_item->ID, '_menu_item_block', true );
			$menu_item->columns = get_post_meta( $menu_item->ID, '_menu_item_columns', true );
			$menu_item->bg_image = get_post_meta( $menu_item->ID, '_menu_item_bg-image', true );
			$menu_item->bg_repeat = get_post_meta( $menu_item->ID, '_menu_item_bg-repeat', true );
			$menu_item->bg_position = get_post_meta( $menu_item->ID, '_menu_item_bg-position', true );

			return $menu_item;
		}
	}
}
global $mipro_mega_menu;
$mipro_mega_menu = new Mipro_Mega_Menu();

/* Custom Fields Menu Item */
if ( ! class_exists('Mipro_Custom_Mega_Menu') ) {
	class Mipro_Custom_Mega_Menu extends Walker_Nav_Menu {

		function __construct() {

		}
		
		function start_lvl(&$output, $depth = 0, $args = array()){}
		
		function end_lvl(&$output, $depth = 0, $args = array()){}

		function start_el(&$output, $item, $depth = 0, $args = array(), $current_object_id = 0) {
			global $_wp_nav_menu_max_depth;
			$_wp_nav_menu_max_depth = $depth > $_wp_nav_menu_max_depth ? $depth : $_wp_nav_menu_max_depth;
			
			ob_start();
			
			$item_id = esc_attr( $item->ID );
			$removed_args = array(
				'action'
				,'customlink-tab'
				,'edit-menu-item'
				,'menu-item'
				,'page-tab'
				,'_wpnonce'
			);

			$original_title = '';
			if ( 'taxonomy' == $item->type ) {
				$original_title = get_term_field( 'name', $item->object_id, $item->object, 'raw' );
				if ( is_wp_error( $original_title ) )
					$original_title = false;
			} elseif ( 'post_type' == $item->type ) {
				$original_object = get_post( $item->object_id );
				$original_title = get_the_title( $original_object->ID );
			}

			$classes = array(
				'menu-item menu-item-depth-' . $depth,
				'menu-item-' . esc_attr( $item->object ),
				'menu-item-edit-' . ( ( isset( $_GET['edit-menu-item'] ) && $item_id == $_GET['edit-menu-item'] ) ? 'active' : 'inactive'),
			);

			$title = $item->title;

			if ( ! empty( $item->_invalid ) ) {
				$classes[] = 'menu-item-invalid';
				/* translators: %s: title of menu item which is invalid */
				$title = sprintf( esc_html__( '%s (Invalid)','mipro' ), $item->title );
			} elseif ( isset( $item->post_status ) && 'draft' == $item->post_status ) {
				$classes[] = 'pending';
				/* translators: %s: title of menu item in draft status */
				$title = sprintf( esc_html__('%s (Pending)','mipro'), $item->title );
			}

			$title = empty( $item->label ) ? $title : $item->label;

			?>
			<li id="menu-item-<?php echo esc_attr($item_id); ?>" class="<?php echo implode(' ', $classes ); ?>">
				<dl class="menu-item-bar">
					<dt class="menu-item-handle">
						<span class="item-title"><?php echo esc_html( $title ); ?></span>
						<span class="item-controls">
							<span class="item-type"><?php echo esc_html( $item->type_label ); ?></span>
							<span class="item-order hide-if-js">
								<a href="<?php
								echo wp_nonce_url(
									esc_url(
										add_query_arg(
											array(
												'action' => 'move-up-menu-item',
												'menu-item' => $item_id,
											),
											remove_query_arg($removed_args, admin_url( 'nav-menus.php' ) )
										)
									),
									'move-menu_item'
								);
								?>" class="item-move-up"><abbr title="<?php esc_attr_e('Move up','mipro'); ?>">&#8593;</abbr></a>
								|
								<a href="<?php
								echo wp_nonce_url(
									esc_url(
										add_query_arg(
											array(
												'action' => 'move-down-menu-item',
												'menu-item' => $item_id,
											),
											remove_query_arg($removed_args, admin_url( 'nav-menus.php' ) )
										)
									),
									'move-menu_item'
								);
								?>" class="item-move-down"><abbr title="<?php esc_attr_e('Move down','mipro'); ?>">&#8595;</abbr></a>
							</span>
							<a class="item-edit" id="edit-<?php echo esc_attr($item_id); ?>" title="<?php esc_attr_e('Edit Menu Item','mipro'); ?>" href="<?php
							echo ( isset( $_GET['edit-menu-item'] ) && $item_id == $_GET['edit-menu-item'] ) ? admin_url( 'nav-menus.php' ) : esc_url( add_query_arg( 'edit-menu-item', $item_id, remove_query_arg( $removed_args, admin_url( 'nav-menus.php#menu-item-settings-' . $item_id ) ) ) );
							?>"><?php esc_html_e( 'Edit Menu Item','mipro' ); ?></a>
						</span>
					</dt>
				</dl>
				<div class="menu-item-settings wp-clearfix" id="menu-item-settings-<?php echo esc_attr($item_id); ?>">
					<?php if( 'custom' == $item->type ) : ?>
						<p class="field-url description description-wide">
							<label for="edit-menu-item-url-<?php echo esc_attr($item_id); ?>">
								<?php esc_html_e( 'URL','mipro' ); ?><br />
								<input type="text" id="edit-menu-item-url-<?php echo esc_attr($item_id); ?>" class="widefat code edit-menu-item-url" name="menu-item-url[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr( $item->url ); ?>" />
							</label>
						</p>
					<?php endif; ?>
					<p class="description description-thin">
						<label for="edit-menu-item-title-<?php echo esc_attr($item_id); ?>">
							<?php esc_html_e( 'Navigation Label','mipro' ); ?><br />
							<input type="text" id="edit-menu-item-title-<?php echo esc_attr($item_id); ?>" class="widefat edit-menu-item-title" name="menu-item-title[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr( $item->title ); ?>" />
						</label>
					</p>
					<p class="description description-thin">
						<label for="edit-menu-item-attr-title-<?php echo esc_attr($item_id); ?>">
							<?php esc_html_e( 'Title Attribute','mipro' ); ?><br />
							<input type="text" id="edit-menu-item-attr-title-<?php echo esc_attr($item_id); ?>" class="widefat edit-menu-item-attr-title" name="menu-item-attr-title[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr( $item->post_excerpt ); ?>" />
						</label>
					</p>
					<p class="field-link-target description">
						<label for="edit-menu-item-target-<?php echo esc_attr($item_id); ?>">
							<input type="checkbox" id="edit-menu-item-target-<?php echo esc_attr($item_id); ?>" value="_blank" name="menu-item-target[<?php echo esc_attr($item_id); ?>]"<?php checked( $item->target, '_blank' ); ?> />
							<?php esc_html_e( 'Open link in a new window/tab','mipro' ); ?>
						</label>
					</p>
					<p class="field-css-classes description description-thin">
						<label for="edit-menu-item-classes-<?php echo esc_attr($item_id); ?>">
							<?php esc_html_e( 'CSS Classes (optional)','mipro' ); ?><br />
							<input type="text" id="edit-menu-item-classes-<?php echo esc_attr($item_id); ?>" class="widefat code edit-menu-item-classes" name="menu-item-classes[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr( implode(' ', $item->classes ) ); ?>" />
						</label>
					</p>
					<p class="field-xfn description description-thin">
						<label for="edit-menu-item-xfn-<?php echo esc_attr($item_id); ?>">
							<?php esc_html_e( 'Link Relationship (XFN)','mipro' ); ?><br />
							<input type="text" id="edit-menu-item-xfn-<?php echo esc_attr($item_id); ?>" class="widefat code edit-menu-item-xfn" name="menu-item-xfn[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr( $item->xfn ); ?>" />
						</label>
					</p>
					<p class="field-description description description-wide">
						<label for="edit-menu-item-description-<?php echo esc_attr($item_id); ?>">
							<?php esc_html_e( 'Description','mipro' ); ?><br />
							<textarea id="edit-menu-item-description-<?php echo esc_attr($item_id); ?>" class="widefat edit-menu-item-description" rows="3" cols="20" name="menu-item-description[<?php echo esc_attr($item_id); ?>]"><?php echo esc_html( $item->description ); // textarea_escaped ?></textarea>
							<span class="description"><?php esc_html_e('The description will be displayed in the menu if the current theme supports it.','mipro'); ?></span>
						</label>
					</p> 
					<?php
					/*
					 * This is the added fields
					 */
					do_action( 'wp_nav_menu_item_custom_fields', $item_id, $item, $depth, $args ); 
					/* Compatible with the Nav Menu Roles plugin */
					?>  
					<h4><?php esc_html_e('Mega Menu Options', 'mipro') ?></h4>
					<p class="description description-wide kft-design">
						<label for="edit-menu-item-design-<?php echo esc_attr( $item_id ); ?>">
							<?php $design = $item->design; ?>
							<?php esc_html_e('Design', 'mipro'); ?><br>
							<select id="edit-menu-item-design-<?php echo esc_attr( $item_id ); ?>" data-field="kft-design" class="widefat" name="menu-item-design[<?php echo esc_attr( $item_id ); ?>]">
								<option value="default" <?php selected( $design, 'default', true); ?>><?php esc_html_e('Default', 'mipro'); ?></option>
								<option value="full-width" <?php selected( $design, 'full-width', true); ?>><?php esc_html_e('Full width', 'mipro'); ?></option>
								<option value="sized" <?php selected( $design, 'sized', true); ?>><?php esc_html_e('Set sizes', 'mipro'); ?></option>
							</select>
						</label>
					</p>
					<p class="description description-thin kft-width" style="display:none;">
						<label for="edit-menu-item-width-<?php echo esc_attr( $item_id ); ?>">
							<?php esc_html_e('Dropdown Width', 'mipro'); ?><br>
							<input type="number" id="edit-menu-item-width-<?php echo esc_attr( $item_id ); ?>" class="widefat" name="menu-item-width[<?php echo esc_attr( $item_id ); ?>]" value="<?php echo esc_attr( $item->width ); ?>">
						</label>
					</p>
					<p class="description description-thin kft-height" style="display:none;">
						<label for="edit-menu-item-height-<?php echo esc_attr( $item_id ); ?>">				
							<?php esc_html_e('Dropdown Height', 'mipro'); ?><br>
							<input type="number" id="edit-menu-item-height-<?php echo esc_attr( $item_id ); ?>" class="widefat" name="menu-item-height[<?php echo esc_attr( $item_id ); ?>]" value="<?php echo esc_attr( $item->height); ?>">
						</label>
					</p>
					<p class="description description-wide kft-columns" style="display:none;">
						<label for="edit-menu-item-columns-<?php echo esc_attr( $item_id ); ?>">
							<?php $columns = $item->columns; ?>	
							<?php esc_html_e('Columns', 'mipro'); ?><br>
							<select id="edit-menu-item-columns-<?php echo esc_attr( $item_id ); ?>" class="widefat" name="menu-item-columns[<?php echo esc_attr( $item_id ); ?>]">
								<option value="1" <?php selected( $columns, '1', true); ?>><?php esc_html_e('1', 'mipro'); ?></option>
								<option value="2" <?php selected( $columns, '2', true); ?>><?php esc_html_e('2', 'mipro'); ?></option>
								<option value="3" <?php selected( $columns, '3', true); ?>><?php esc_html_e('3', 'mipro'); ?></option>
								<option value="4" <?php selected( $columns, '4', true); ?>><?php esc_html_e('4', 'mipro'); ?></option>
								<option value="5" <?php selected( $columns, '5', true); ?>><?php esc_html_e('5', 'mipro'); ?></option>
							</select>
						</label>
					</p>
					<p class="description description-wide kft-block" style="display:none;">
						<label for="edit-menu-item-block-<?php echo esc_attr( $item_id ); ?>">
							<?php esc_html_e('HTML Static Block', 'mipro'); ?><br>
							<?php wp_editor( stripslashes(wp_specialchars_decode( $item->block )), 'edit-menu-item-block-'.$item_id, array('textarea_name'=>'menu-item-block['.$item_id.']') ); ?>
						</label>
					</p>
					<p class="description description-wide kft-icon">
						<label for="edit-menu-item-height-<?php echo esc_attr( $item_id ); ?>">
							<?php esc_html_e('Icon name (from FontAwesome set)', 'mipro'); ?><br>
							<input type="text" id="edit-menu-item-icon-<?php echo esc_attr( $item_id ); ?>" class="widefat" name="menu-item-icon[<?php echo esc_attr( $item_id ); ?>]" value="<?php echo esc_attr( $item->icon ); ?>" placeholder="<?php echo esc_attr_e('Ex: fa-star', 'mipro'); ?>">
						</label>
					</p>
					<p class="description description-thin kft-label-text">
						<label for="edit-menu-item-label-text-<?php echo esc_attr( $item_id ); ?>">
							<?php esc_html_e('Badge text', 'mipro'); ?><br>
							<input type="text" id="edit-menu-item-label-text-<?php echo esc_attr( $item_id ); ?>" class="widefat" name="menu-item-label-text[<?php echo esc_attr( $item_id ); ?>]" value="<?php echo esc_attr( $item->label_text ); ?>">
						</label>
					</p>
					<p class="description description-thin kft-label-color">
						<label for="edit-menu-item-label-color-<?php echo esc_attr( $item_id ); ?>">
							<?php $label_color = $item->label_color; ?>
							<?php esc_html_e('Badge background color', 'mipro'); ?><br>
							<select id="edit-menu-item-label-color-<?php echo esc_attr( $item_id ); ?>" class="widefat" name="menu-item-label-color[<?php echo esc_attr( $item_id ); ?>]">
								<option value=""></option>
								<option value="red" <?php selected( $label_color, 'red', true); ?>><?php esc_html_e('Red', 'mipro'); ?></option>
								<option value="green" <?php selected( $label_color, 'green', true); ?>><?php esc_html_e('Green', 'mipro'); ?></option>
								<option value="blue" <?php selected( $label_color, 'blue', true); ?>><?php esc_html_e('Blue', 'mipro'); ?></option>
								<option value="orange" <?php selected( $label_color, 'orange', true); ?>><?php esc_html_e('Orange', 'mipro'); ?></option>
								<option value="grey" <?php selected( $label_color, 'grey', true); ?>><?php esc_html_e('Grey', 'mipro'); ?></option>
								<option value="black" <?php selected( $label_color, 'black', true); ?>><?php esc_html_e('Black', 'mipro'); ?></option>
								<option value="white" <?php selected( $label_color, 'white', true); ?>><?php esc_html_e('White', 'mipro'); ?></option>
							</select>
						</label>
					</p>
					<p class="description description-wide kft-bg-image">
						<label>
							<?php 
							$bg_image = wp_get_attachment_url( $item->bg_image );
							esc_html_e( 'Background Image', 'mipro' ); 
							?>
							<br />
							<a id="<?php echo esc_attr($item_id); ?>" class="kft_mega_menu_upload_image" href="javascript:void(0)" style="display:<?php echo !empty($bg_image) ? 'none' : 'inline'; ?>;"><?php echo esc_html_e('Select Image', 'mipro'); ?></a>
							<span class="preview-thumbnail-wrapper">
								<?php if( !empty($bg_image) ): ?>
									<img src="<?php echo esc_url($bg_image); ?>" width="32" height="32" id="background-menu-item-<?php echo esc_attr($item_id); ?>" title="menu-item-<?php echo esc_attr($item_id); ?>-background" alt="menu-item-<?php echo esc_attr($item_id); ?>-background">
								<?php endif; ?>
							</span>
							<a id="<?php echo esc_attr($item_id); ?>" class="kft_mega_menu_remove_image" href="javascript:void(0)" style="display:<?php echo !empty($bg_image) ? 'inline' : 'none'; ?>;"><?php echo esc_html_e('Remove Image', 'mipro'); ?></a>
							<input type="hidden" id="edit-menu-item-bg-image-<?php echo esc_attr($item_id); ?>" class="widefat thumbnail-id-hidden" name="menu-item-bg-image[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr( $item->bg_image ); ?>" />
						</label>	
					</p>

					<p class="description description-thin kft-bg-repeat">
						<label for="edit-menu-item-bg-repeat-<?php echo esc_attr( $item_id ); ?>">
							<?php $bg_repeat = $item->bg_repeat; ?>
							<?php esc_html_e('Background Repeat', 'mipro'); ?><br>
							<select id="edit-menu-item-bg-repeat-<?php echo esc_attr( $item_id ); ?>" class="widefat" name="menu-item-bg-repeat[<?php echo esc_attr( $item_id ); ?>]">
								<option value="no-repeat" <?php selected( $bg_repeat, 'no-repeat', true); ?>><?php esc_html_e('No Repeat', 'mipro'); ?></option>
								<option value="repeat" <?php selected( $bg_repeat, 'repeat', true); ?>><?php esc_html_e('Repeat', 'mipro'); ?></option>
								<option value="repeat-x" <?php selected( $bg_repeat, 'repeat-x', true); ?>><?php esc_html_e('Repeat X', 'mipro'); ?></option>
								<option value="repeat-y" <?php selected( $bg_repeat, 'repeat-y', true); ?>><?php esc_html_e('Repeat Y', 'mipro'); ?></option>
							</select>
						</label>
					</p>
					<p class="description description-thin kft-bg-position">
						<label for="edit-menu-item-bg-position-<?php echo esc_attr( $item_id ); ?>">
							<?php $bg_position = $item->bg_position; ?>
							<?php esc_html_e('Background Position', 'mipro'); ?><br>
							<select id="edit-menu-item-bg-position-<?php echo esc_attr( $item_id ); ?>" class="widefat" name="menu-item-bg-position[<?php echo esc_attr( $item_id ); ?>]">
								<option value="left top" <?php selected( $bg_position, 'left top', true); ?>><?php esc_html_e('Left Top', 'mipro'); ?></option>
								<option value="left bottom" <?php selected( $bg_position, 'left bottom', true); ?>><?php esc_html_e('Left Bottom', 'mipro'); ?></option>
								<option value="left center" <?php selected( $bg_position, 'left center', true); ?>><?php esc_html_e('Left Center', 'mipro'); ?></option>
								<option value="right bottom" <?php selected( $bg_position, 'right bottom', true); ?>><?php esc_html_e('Right Bottom', 'mipro'); ?></option>
								<option value="right top" <?php selected( $bg_position, 'right top', true); ?>><?php esc_html_e('Right Top', 'mipro'); ?></option>
								<option value="right center" <?php selected( $bg_position, 'right center', true); ?>><?php esc_html_e('Right Center', 'mipro'); ?></option>
								<option value="center top" <?php selected( $bg_position, 'center top', true); ?>><?php esc_html_e('Center Top', 'mipro'); ?></option>
								<option value="center bottom" <?php selected( $bg_position, 'center bottom', true); ?>><?php esc_html_e('Center Bottom', 'mipro'); ?></option>
								<option value="center center" <?php selected( $bg_position, 'center center', true); ?>><?php esc_html_e('Center Center', 'mipro'); ?></option>
							</select>
						</label>
					</p>
					<?php
					/*
					 * end the added fields
					 */
					?>
					<div class="menu-item-actions description-wide submitbox">
						<?php if( 'custom' != $item->type && $original_title !== false ) : ?>
							<p class="link-to-original">
								<?php printf( esc_html__('Original: %s','mipro'), '<a href="' . esc_attr( $item->url ) . '">' . esc_html( $original_title ) . '</a>' ); ?>
							</p>
						<?php endif; ?>
						<a class="item-delete submitdelete deletion" id="delete-<?php echo esc_attr($item_id); ?>" href="<?php
						echo wp_nonce_url(
							esc_url(
								add_query_arg(
									array(
										'action' => 'delete-menu-item',
										'menu-item' => $item_id,
									),
									remove_query_arg($removed_args, admin_url( 'nav-menus.php' ) )
								)
							),
							'delete-menu_item_' . $item_id
						); ?>"><?php esc_html_e('Remove','mipro'); ?></a> <span class="meta-sep"> | </span> <a class="item-cancel submitcancel" id="cancel-<?php echo esc_attr($item_id); ?>" href="<?php echo esc_url( add_query_arg( array('edit-menu-item' => $item_id, 'cancel' => time()), remove_query_arg( $removed_args, admin_url( 'nav-menus.php' ) ) ) );
						?>#menu-item-settings-<?php echo esc_attr($item_id); ?>"><?php esc_html_e('Cancel','mipro'); ?></a>
					</div>

					<input class="menu-item-data-db-id" type="hidden" name="menu-item-db-id[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr($item_id); ?>" />
					<input class="menu-item-data-object-id" type="hidden" name="menu-item-object-id[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr( $item->object_id ); ?>" />
					<input class="menu-item-data-object" type="hidden" name="menu-item-object[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr( $item->object ); ?>" />
					<input class="menu-item-data-parent-id" type="hidden" name="menu-item-parent-id[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr( $item->menu_item_parent ); ?>" />
					<input class="menu-item-data-position" type="hidden" name="menu-item-position[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr( $item->menu_order ); ?>" />
					<input class="menu-item-data-type" type="hidden" name="menu-item-type[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr( $item->type ); ?>" />
				</div><!-- .menu-item-settings-->
				<ul class="menu-item-transport"></ul>
				<?php
				$output .= ob_get_clean();
			}
		}
	}

// **********************************************************************// 
// Mega Menu Walker
// **********************************************************************// 

	if ( ! class_exists( 'Mipro_Mega_Menu_Walker' )) {
		class Mipro_Mega_Menu_Walker extends Walker_Nav_Menu {

			function start_lvl( &$output, $depth = 0, $args = array() ) {
				$indent = str_repeat("\t", $depth);

				if( $depth == 0) {
					$output .= "\n$indent<div class=\"sub-menu-dropdown\">\n";

				}
				if( $depth < 1 ) {
					$sub_menu_class = "sub-menu";
				} else {
					$sub_menu_class = "sub-sub-menu";
				}

				$output .= "\n$indent<ul class=\"$sub_menu_class\">\n";
			}

			function end_lvl( &$output, $depth = 0, $args = array() ) {
				$indent = str_repeat("\t", $depth);
				$output .= "$indent</ul>\n";
				if( $depth == 0) {
					$output .= "$indent</div>\n";
				}
			}

			function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
				$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

				$classes = empty( $item->classes ) ? array() : (array) $item->classes;
				$classes[] = 'menu-item-' . $item->ID;
				$classes[] = 'item-level-' . $depth;

				$design = $width = $height = $icon = $label = $label_out = $background_image = '';
				$design  = get_post_meta( $item->ID, '_menu_item_design',  true );
				$width   = get_post_meta( $item->ID, '_menu_item_width',   true );
				$height  = get_post_meta( $item->ID, '_menu_item_height',  true );
				$icon    = get_post_meta( $item->ID, '_menu_item_icon',    true );
				$label_color   = get_post_meta( $item->ID, '_menu_item_label-color',   true );
				$label_text = get_post_meta( $item->ID, '_menu_item_label-text',   true );
				$bg_image  = get_post_meta( $item->ID, '_menu_item_bg-image',  true );
				$bg_repeat  = get_post_meta( $item->ID, '_menu_item_bg-repeat',  true );
				$bg_position  = get_post_meta( $item->ID, '_menu_item_bg-position',  true );
				$columns   = get_post_meta( $item->ID, '_menu_item_columns',  true );
				$block   = get_post_meta( $item->ID, '_menu_item_block',   true );
				$block = stripslashes(wp_specialchars_decode( $block ));

				if( empty($design) ) {
					$design = 'default';
				} 

				if( $depth == 0 && $args->menu_class != 'site-mobile-menu' ) {
					$classes[] = 'menu-item-' . $design;
					$classes[] = 'menu-' . ( (  in_array( $design, array( 'sized', 'full-width' ) ) ) ? 'mega-dropdown' : 'simple-dropdown' );
					if( $design == 'sized' || $design == 'full-width' ){
						$columns = (empty($columns)) ? 'full' : $columns;
						$classes[] = 'item-columns-' . $columns;
					}
					if( has_post_thumbnail( $item->ID ) ) {
						$classes[] = 'item-has-bg';
					}
				}

				if( !empty( $label_color ) ) {
					$classes[] = 'item-has-label';
					$label_out = '<span class="menu-label label-' . $label_color . '">' . esc_attr( $label_text ) . '</span>';
				}

				if( !empty( $bg_image ) ) {
					$classes[] = 'has-bg-images';
				}

				if( ! empty( $block ) ) {
					$classes[] = 'menu-item-has-children';
				}

				$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth ) );
				$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

				$id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args, $depth );
				$id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

				$output .= $indent . '<li' . $id . $class_names .'>';

				$atts = array();
				$atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
				$atts['target'] = ! empty( $item->target )     ? $item->target     : '';
				$atts['rel']    = ! empty( $item->xfn )        ? $item->xfn        : '';
				$atts['href']   = ! empty( $item->url )        ? $item->url        : '';

				$atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );
				$atts['class'] = 'nav-link';

				$attributes = '';
				foreach ( $atts as $attr => $value ) {
					if ( ! empty( $value ) ) {
						$value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
						$attributes .= ' ' . $attr . '="' . $value . '"';
					}
				}

				$icon_url = '';

				$item_output = $args->before;
				$item_output .= '<a'. $attributes .'>';
				if($icon != '') {
					$item_output .= '<i class="fa ' . $icon . '"></i>';
				}
				if( ! empty( $icon_url ) ) {
					$item_output .= '<img src="'  . esc_url( $icon_url ) . '" alt="' . esc_attr( $item->title ) . '" class="category-icon" />';
				}
				/** This filter is documented in wp-includes/post-template.php */
				$item_output .= '<span>' . $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after . '</span>';
				$item_output .= $label_out;
				$item_output .= '</a>';
				$item_output .= $args->after;

				$styles = '';

				if( $depth == 0 && $args->menu_class != 'site-mobile-menu' ) {
					if( $bg_image != '' ){
						$background_image = wp_get_attachment_url( $bg_image );
						if( $background_image ){
							$styles .= '.menu-item-' . $item->ID . ' > .sub-menu-dropdown .sub-menu {';
							$styles .= 'background-image: url(' . $background_image .'); ';
							$styles .= 'background-repeat: ' . $bg_repeat .'; ';
							$styles .= 'background-position: ' . $bg_position .'; ';					
							$styles .= '}';
						}
					}

					if( ! empty( $block ) && !in_array("menu-item-has-children", $item->classes) ) {
						$item_output .= "\n$indent<div class=\"sub-menu-dropdown\">\n";
						$item_output .= "\n$indent<div class=\"container\">\n";
						$item_output .=  do_shortcode( $block );
						$item_output .= "\n$indent</div>\n";
						$item_output .= "\n$indent</div>\n";

					}
				}

				if( $design == 'sized' && !empty($height) && !empty($width) && $args->menu_class != 'site-mobile-menu' ) {
					$styles .= '.menu-item-' . $item->ID . ' > .sub-menu-dropdown {';
					$styles .= 'min-height: ' . $height .'px; ';
					$styles .= 'width: ' . $width .'px; ';
					$styles .= '}';
				}

				if( $styles != '' && $args->menu_class != 'site-mobile-menu' ) {
					$item_output .= '<sty'.'le>';
					$item_output .= $styles;
					$item_output .= '</sty'.'le>';
				}

				$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
			}
		}
	}
	?>