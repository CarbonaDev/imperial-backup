<?php
/**
 * Merlin WP configuration file.
 *
 * @package   Merlin Config
 * @author    Joyce
 */

if ( ! class_exists( 'Merlin' ) ) {
	return;
}
/**
 * Set directory locations, text strings, and settings.
 */
$wizard      = new Merlin(
	$config  = array(
		'directory'            => 'inc/third-party/merlin', // Location / directory where Merlin WP is placed in your theme.
		'merlin_url'           => 'merlin', // The wp-admin page slug where Merlin WP loads.
		'parent_slug'          => 'themes.php', // The wp-admin parent page slug for the admin menu item.
		'capability'           => 'manage_options', // The capability required for this menu to be displayed to the user.
		'child_action_btn_url' => 'https://codex.wordpress.org/child_themes', // URL for the 'child-action-link'.
		'dev_mode'             => true, // Enable development mode for testing.
		'license_step'         => false, // EDD license activation step.
		'license_required'     => false, // Require the license activation step.
		'license_help_url'     => '', // URL for the 'license-tooltip'.
		'edd_remote_api_url'   => '', // EDD_Theme_Updater_Admin remote_api_url.
		'edd_item_name'        => '', // EDD_Theme_Updater_Admin item_name.
		'edd_theme_slug'       => '', // EDD_Theme_Updater_Admin item_slug.
		'ready_big_button_url' => home_url( '/' ), // Link for the big button on the ready step.
	),
	$strings = array(
		'admin-menu'               => esc_html__( 'Theme Setup Wizard', 'mipro' ),
		/* translators: 1: Title Tag 2: Theme Name 3: Closing Title Tag */
		'title%s%s%s%s'            => esc_html__( '%1$s%2$s Themes &lsaquo; Theme Setup: %3$s%4$s', 'mipro' ),
		'return-to-dashboard'      => esc_html__( 'Return to the dashboard', 'mipro' ),
		'ignore'                   => esc_html__( 'Disable this wizard', 'mipro' ),
		'btn-skip'                 => esc_html__( 'Skip', 'mipro' ),
		'btn-next'                 => esc_html__( 'Next', 'mipro' ),
		'btn-start'                => esc_html__( 'Start', 'mipro' ),
		'btn-no'                   => esc_html__( 'Cancel', 'mipro' ),
		'btn-plugins-install'      => esc_html__( 'Install', 'mipro' ),
		'btn-child-install'        => esc_html__( 'Install', 'mipro' ),
		'btn-content-install'      => esc_html__( 'Install', 'mipro' ),
		'btn-import'               => esc_html__( 'Import', 'mipro' ),
		'btn-license-activate'     => esc_html__( 'Activate', 'mipro' ),
		'btn-license-skip'         => esc_html__( 'Later', 'mipro' ),
		/* translators: Theme Name */
		'license-header%s'         => esc_html__( 'Activate %s', 'mipro' ),
		/* translators: Theme Name */
		'license-header-success%s' => esc_html__( '%s is Activated', 'mipro' ),
		/* translators: Theme Name */
		'license%s'                => esc_html__( 'Enter your license key to enable remote updates and theme support.', 'mipro' ),
		'license-label'            => esc_html__( 'License key', 'mipro' ),
		'license-success%s'        => esc_html__( 'The theme is already registered, so you can go to the next step!', 'mipro' ),
		'license-json-success%s'   => esc_html__( 'Your theme is activated! Remote updates and theme support are enabled.', 'mipro' ),
		'license-tooltip'          => esc_html__( 'Need help?', 'mipro' ),
		/* translators: Theme Name */
		'welcome-header%s'         => esc_html__( 'Welcome to %s', 'mipro' ),
		'welcome-header-success%s' => esc_html__( 'Hi. Welcome back', 'mipro' ),
		'welcome%s'                => esc_html__( 'This wizard will set up your theme, install plugins, and import content. It is optional & should take only a few minutes.', 'mipro' ),
		'welcome-success%s'        => esc_html__( 'You may have already run this theme setup wizard. If you would like to proceed anyway, click on the "Start" button below.', 'mipro' ),
		'child-header'             => esc_html__( 'Install Child Theme', 'mipro' ),
		'child-header-success'     => esc_html__( 'You\'re good to go!', 'mipro' ),
		'child'                    => esc_html__( 'Let\'s build & activate a child theme so you may easily make theme changes.', 'mipro' ),
		'child-success%s'          => esc_html__( 'Your child theme has already been installed and is now activated, if it wasn\'t already.', 'mipro' ),
		'child-action-link'        => esc_html__( 'Learn about child themes', 'mipro' ),
		'child-json-success%s'     => esc_html__( 'Awesome. Your child theme has already been installed and is now activated.', 'mipro' ),
		'child-json-already%s'     => esc_html__( 'Awesome. Your child theme has been created and is now activated.', 'mipro' ),
		'plugins-header'           => esc_html__( 'Install Plugins', 'mipro' ),
		'plugins-header-success'   => esc_html__( 'You\'re up to speed!', 'mipro' ),
		'plugins'                  => esc_html__( 'Let\'s install some essential WordPress plugins to get your site up to speed.', 'mipro' ),
		'plugins-success%s'        => esc_html__( 'The required WordPress plugins are all installed and up to date. Press "Next" to continue the setup wizard.', 'mipro' ),
		'plugins-action-link'      => esc_html__( 'Advanced', 'mipro' ),
		'import-header'            => esc_html__( 'Import Content', 'mipro' ),
		'import'                   => esc_html__( 'Let\'s import content to your website, to help you get familiar with the theme.', 'mipro' ),
		'import-action-link'       => esc_html__( 'Advanced', 'mipro' ),
		'ready-header'             => esc_html__( 'All done. Have fun!', 'mipro' ),
		/* translators: Theme Author */
		'ready%s'                  => esc_html__( 'Your theme has been all set up. Enjoy your new theme by %s.', 'mipro' ),
		'ready-action-link'        => esc_html__( 'Extras', 'mipro' ),
		'ready-big-button'         => esc_html__( 'View your website', 'mipro' ),
		'ready-link-1'             => sprintf( '<a href="%1$s">%2$s</a>', 'mailto:support@alura-studio.com', esc_html__( 'Contact Support', 'mipro' ) ),
		'ready-link-2'             => sprintf( '<a href="%1$s" target="_blank">%2$s</a>', 'https://themeforest.net/downloads/', esc_html__( 'Rating for Mipro', 'mipro' ) ),
		'ready-link-3'             => sprintf( '<a href="%1$s" target="_blank">%2$s</a>', 'https://themeforest.net/user/alurastudio/follow', esc_html__( 'Follow Alura Studio', 'mipro' ) ),
	)
);
