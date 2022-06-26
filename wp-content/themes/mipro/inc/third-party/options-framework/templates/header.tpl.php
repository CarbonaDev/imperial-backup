<?php
	/**
	 * The template for the panel header area.
	 *
	 */

    $tip_title  = esc_html__( 'Developer Mode Enabled', 'mipro' );

    if ( $this->parent->dev_mode_forced ) {
        $is_debug       = false;
        $is_localhost   = false;

        $debug_bit = '';
        if ( Redux_Helpers::isWpDebug() ) {
            $is_debug = true;
            $debug_bit = esc_html__( 'WP_DEBUG is enabled', 'mipro' );
        }

        $localhost_bit = '';
        if ( Redux_Helpers::isLocalHost() ) {
            $is_localhost = true;
            $localhost_bit = esc_html__( 'you are working in a localhost environment', 'mipro' );
        }

        $conjunction_bit = '';
        if ( $is_localhost && $is_debug ) {
            $conjunction_bit = ' ' . esc_html__( 'and', 'mipro' ) . ' ';
        }

        $tip_msg    = esc_html__( 'Redux has enabled developer mode because', 'mipro' ) . ' ' . $debug_bit . $conjunction_bit . $localhost_bit . '.';
    } else {
        $tip_msg    = esc_html__( 'If you are not a developer, your theme/plugin author shipped with developer mode enabled. Contact them directly to fix it.', 'mipro' );
    }

    ?>

    <div id="redux-header">
     <?php if ( ! empty( $this->parent->args['display_name'] ) ) : ?>
         <div class="display_header">

           <?php if ( isset( $this->parent->args['dev_mode'] ) && $this->parent->args['dev_mode'] == true ) : ?>
               <div class="redux-dev-mode-notice-container redux-dev-qtip" qtip-title="<?php echo esc_attr( $tip_title ); ?>" qtip-content="<?php echo esc_attr( $tip_msg ); ?>">
                <span class="redux-dev-mode-notice"><?php esc_html_e( 'Developer Mode Enabled', 'mipro' ); ?></span>
            </div>
        <?php endif; ?>

        <h2><?php echo esc_attr( $this->parent->args['display_name'] ); ?></h2>
        
        <?php if ( ! empty( $this->parent->args['display_version'] ) ) : ?>
           <span class="redux-theme-version"> <?php echo esc_attr( $this->parent->args['display_version'] ); ?></span>
       <?php endif; ?>
   </div>
   
<?php endif; ?>
<div class="clear"></div>
</div>