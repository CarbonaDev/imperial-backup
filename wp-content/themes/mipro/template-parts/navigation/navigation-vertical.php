<div class="kft-vertical-navigation">
	<div class="vertical-menu-heading">
		<i class="icon-menu"></i>
		<?php esc_html_e( 'Shop by category', 'mipro' ); ?>                            
	</div>

	<div class="vertical-menu vertical-menu-dropdown">
		<?php wp_nav_menu( array( 
			'theme_location' => 'vertical',
			'menu_id'        => 'vertical-menu',
			'walker' => new Mipro_Mega_Menu_Walker(), 
		) ); ?>
	</div>
</div>
