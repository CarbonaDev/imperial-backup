<?php 
global $post;

$args = mipro_get_related_posts_args( $post->ID );

$query = new WP_Query( $args );

if ( $query->have_posts() ) {
	$is_slider = true;
	if ( isset($query->post_count) && $query->post_count <= 1 ) {
		$is_slider = false;
	}
	?>

	<div class="related-posts related <?php echo esc_attr( ( $is_slider ) ? 'loading' : '' ); ?>">
		<h2><span><?php esc_html_e( 'Related Posts', 'mipro' ); ?></span></h2>
		<div class="meta-slider">
			<div class="blogs">
				<?php 
				while ( $query->have_posts() ) : 
					$query->the_post();

					$post_format = get_post_format();
					if ( $is_slider && $post_format == 'gallery' ) { 
						$post_format = false;
					}

					$post_class = 'post-item hentry ';
					?>

					<article id="post-<?php the_ID(); ?>" <?php post_class( $post_class ) ?>>
						<header class="entry-header">
							<?php mipro_post_thumb( array( 'size' => 'large', 'class' => 'post-image' ) ); ?>
						</header>

						<div class="entry-content">
							<header class="entry-header">
								<!-- Date Time -->
								<?php if ( mipro_get_opt('kft_blog_date') ) : ?>
									<div class="date-time date-time-meta">
										<?php echo get_the_time( get_option( 'date_format' ) ); ?>
									</div>
								<?php endif; ?>
								<h3 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
								
							</header>	

							<div class="entry-info"><p><?php mipro_the_excerpt_max_words( 18, true, '', true ); ?></p></div>

							<a href="<?php the_permalink(); ?>" class="button-readmore"><?php esc_html_e( 'Continue Reading', 'mipro' ) ?></a>
						</div>
					</article>
					
				<?php endwhile; ?>
			</div>
		</div>
	</div>

	<?php 
	wp_reset_postdata(); 
}
?>