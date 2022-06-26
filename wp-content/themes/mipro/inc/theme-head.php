<?php
/**
 * Theme <head></head>
 * (c) Joyce
 */

class Mipro_Head {

	public function __construct() {

		add_action( 'wp_head', array( $this, 'mipro_insert_og_meta' ), 5 );
		add_filter( 'language_attributes', array( $this, 'add_opengraph_doctype' ) );

		add_filter( 'document_title_separator', array( $this, 'document_title_separator' ) );
		add_action( 'wp_head', array( $this, 'add_favicon' ), 2 );
		add_action( 'wp_head', array( $this, 'custom_fonts_font_faces' ) );

		if ( ! function_exists( '_wp_render_title_tag' ) ) {
			add_filter( 'wp_title', array( $this, 'render_title' ), 10, 2 );
		}

	}

	/* Adding the Open Graph in the Language Attributes */
	public function add_opengraph_doctype($output ) {
		if ( mipro_get_opt('kft_status_opengraph') ) {
			return $output . ' prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb#"';
		}
		return $output;
	}

	/* Renders the title. */
	public function render_title() {
		wp_title( '' );
	}

	/* Favicon */
	public function add_favicon() {
		if ( function_exists('wp_site_icon') && function_exists('has_site_icon') && has_site_icon() ) {
			return;
		}

		$favicon = get_parent_theme_file_uri( '/assets/images/favicon.ico' );
		$favicon_url = mipro_get_opt('kft_favicon');
		if ( isset($favicon_url['url'] ) && $favicon_url['url'] != '' ) {
			$favicon = esc_url($favicon_url['url']);
		}
		$touch_icon = '';
		$favicon_retina = mipro_get_opt('kft_favicon_retina');
		if ( isset($favicon_retina['url'] ) && $favicon_retina['url'] != '' ) {
			$touch_icon = $favicon_retina['url'];
		}
		?>
		<link rel="shortcut icon" href="<?php echo esc_url( $favicon ); ?>" />
		<link rel="apple-touch-icon-precomposed" sizes="152x152" href="<?php echo esc_url($touch_icon); ?>">
		<?php
	}

		/**
		* Extra OpenGraph tags
		*/
		public function mipro_insert_og_meta() {
			if ( ! mipro_get_opt('kft_status_opengraph') ) {
				return;
			}
			if ( ! is_singular() ) {
				return;
			}

			global $post;

			$image = '';
			if ( ! has_post_thumbnail( $post->ID ) ) {
				$logo_img = mipro_get_opt('kft_logo');
				if ( $logo_img ) {
					$image = $logo_img['url'];
				}
			} else {
				$thumbnail_src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
				$image = esc_attr( $thumbnail_src[0] );
			}

			if ( is_array( $image ) ) {
				$image = ( isset( $image['url'] ) && '' != $image['url'] ) ? $image['url'] : '';
			}
			$content = $post->post_content;
			$content = wp_strip_all_tags($content);
			$content = strip_shortcodes($content);
			$content = mipro_string_limit_words($content, 55, '');
			?>

			<meta property="og:title" content="<?php echo esc_attr( strip_tags( str_replace( array( '"', "'" ), array( '&quot;', '&#39;' ), $post->post_title ) ) ); ?>"/>
			<meta property="og:type" content="article"/>
			<meta property="og:url" content="<?php echo esc_url_raw( get_permalink() ); ?>"/>
			<meta property="og:site_name" content="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>"/>
			<meta property="og:description" content="<?php echo esc_attr( $content ); ?>"/>

			<?php if ( '' != $image ) : ?>
				<?php if ( is_array( $image ) ) : ?> 
					<?php if ( isset( $image['url'] ) ) : ?>
						<meta property="og:image" content="<?php echo esc_url_raw( $image['url'] ); ?>"/>
					<?php endif; ?> <?php else : ?>
					<meta property="og:image" content="<?php echo esc_url_raw( $image ); ?>"/>
				<?php endif; ?>
			<?php endif; ?>
			<?php
		}

		/* Set the document title separator. */
		public function document_title_separator() {
			return '-';
		}

		/* Add custom fonts */
		public function custom_fonts_font_faces() {
			$custom_fonts = mipro_get_opt('custom_fonts');
			if ( isset( $custom_fonts['name'] ) && is_array( $custom_fonts['name'] ) && ! empty( $custom_fonts['name'][0] ) ) {

				echo '<style>';
				
				foreach ( $custom_fonts['name'] as $key => $label ) {

					$process = false;
					foreach ( array( 'woff', 'woff2', 'ttf', 'svg', 'eot' ) as $filetype ) {
						if ( ! $process && isset( $custom_fonts[ $filetype ] ) && isset( $custom_fonts[ $filetype ][ $key ] ) ) {
							$process = true;
						}
					}
					// If we don't have any files to process then skip this item.
					if ( ! $process ) {
						continue;
					}

					$firstfile = true;
					echo '@font-face{';
					echo 'font-family:';
					// If font-name has a space, then it must be wrapped in double-quotes.
					if ( false !== strpos( $label, ' ' ) ) {
						echo '"' . sanitize_text_field( $label ) . '";';
					} else {
						echo sanitize_text_field( $label ) . ';';
					}
					// Start adding sources.
					echo 'src:';
					// Add .eot file.
					if ( isset( $custom_fonts['eot'] ) && isset( $custom_fonts['eot'][ $key ] ) && $custom_fonts['eot'][ $key ]['url'] ) {
						echo 'url("' . str_replace( array( 'http://', 'https://' ), '//', $custom_fonts['eot'][ $key ]['url'] ) . '?#iefix") format("embedded-opentype")';
						$firstfile = false;
					}
					// Add .woff file.
					if ( isset( $custom_fonts['woff'] ) && isset( $custom_fonts['woff'][ $key ] ) && $custom_fonts['woff'][ $key ]['url'] ) {
						echo esc_attr( ( $firstfile ) ? '' : ',' );
						echo 'url("' . str_replace( array( 'http://', 'https://' ), '//', $custom_fonts['woff'][ $key ]['url'] ) . '") format("woff")';
						$firstfile = false;
					}
					// Add .woff2 file.
					if ( isset( $custom_fonts['woff2'] ) && isset( $custom_fonts['woff2'][ $key ]['url'] ) && $custom_fonts['woff2'][ $key ]['url'] ) {
						echo esc_attr( ( $firstfile ) ? '' : ',' );
						echo 'url("' . str_replace( array( 'http://', 'https://' ), '//', $custom_fonts['woff2'][ $key ]['url'] ) . '") format("woff2")';
						$firstfile = false;
					}
					// Add .ttf file.
					if ( isset( $custom_fonts['ttf'] ) && isset( $custom_fonts['ttf'][ $key ] ) && $custom_fonts['ttf'][ $key ]['url'] ) {
						echo esc_attr( ( $firstfile ) ? '' : ',' );
						echo 'url("' . str_replace( array( 'http://', 'https://' ), '//', $custom_fonts['ttf'][ $key ]['url'] ) . '") format("truetype")';
						$firstfile = false;
					}
					// Add .svg file.
					if ( isset( $custom_fonts['svg'] ) && isset( $custom_fonts['svg'][ $key ] ) && $custom_fonts['svg'][ $key ]['url'] ) {
						echo esc_attr( ( $firstfile ) ? '' : ',' );
						echo 'url("' . str_replace( array( 'http://', 'https://' ), '//', $custom_fonts['svg'][ $key ]['url'] ) . '") format("svg")';
						$firstfile = false;
					}
					if ( isset( $custom_fonts['font_weight'] ) && $custom_fonts['font_weight'][ $key ] ) {
						echo ';font-weight: ' . sanitize_text_field( $custom_fonts['font_weight'][ $key ] );
					}
					else {
						echo ';font-weight: normal';
					}
					echo ';font-style: normal;';
					echo '}';
				}

				echo '</style>';
			}
		}
	}

	new Mipro_Head();
