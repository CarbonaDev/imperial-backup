<nav class="main-navigation" aria-label="<?php esc_attr_e( 'Primary Menu', 'mipro' ); ?>">
	<?php wp_nav_menu( array( 'theme_location' => 'primary', 'walker' => new Mipro_Mega_Menu_Walker() ) ); ?>
</nav><!-- #site-navigation -->