<?php 
global $post, $wp_query;
$post_format = get_post_format();
$post_class = 'post-item hentry';
$show_blog_thumbnail = mipro_get_opt('kft_blog_details_thumbnail');
mipro_set_post_views( get_the_ID() );
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( $post_class ) ?>>
	<?php if ( $post_format != 'quote' ) : ?>
		<header class="entry-header">
				<!-- Category -->
			<?php $categories_list = get_the_category_list(' '); ?>
			<?php if ( $categories_list && mipro_get_opt('kft_blog_details_categories') ) : ?>
				<div class="cats-link">
					<span class="cat-links"><?php echo trim( $categories_list ); ?></span>
				</div>
			<?php endif; ?> 

			<h3 class="entry-title">
				<span class="post-title"><?php the_title(); ?></span>
			</h3>
		
			<?php if ( $show_blog_thumbnail ) : ?>
				<?php if ( $post_format == 'gallery' || $post_format === false || $post_format == 'standard' ) : ?>
					<div class="blog-image <?php echo esc_attr( $post_format ); ?> <?php echo esc_attr( ( $post_format == 'gallery' ) ? ( 'loading owl-carousel' ) : '' ); ?>">

						<?php 
						if ( $post_format == 'gallery' ) {
							$gallery = get_post_meta( $post->ID, 'kft_gallery', true );

							foreach( (array)$gallery as $gallery_id => $gallery_url ) {
								echo wp_get_attachment_image( $gallery_id, 'full', 0, array( 'class' => 'single-post-image' ) );
							}
						}

						if ( $post_format === false || $post_format == 'standard' ) {
							if ( has_post_thumbnail() ) {
								the_post_thumbnail( 'full', array( 'class' => 'single-post-image' ) );
							}
						}
						?>

					</div>
				<?php endif; ?>

				<?php
				if ( $post_format == 'video' ) {
					$video_url = get_post_meta( $post->ID, 'kft_video_url', true );
					if ( ! empty( $video_url ) ) {
						echo do_shortcode('[kft_video src="'.esc_url($video_url).'"]');
					}
				}

				if ( $post_format == 'audio' ) {
					$audio_url = get_post_meta( $post->ID, 'kft_audio_url', true );
					if ( ! empty( $audio_url ) ) {
						$file_format = substr( $audio_url, -3, 3 );
						if ( in_array( $file_format, array('mp3', 'ogg', 'wav') ) ) {
							echo do_shortcode( '[audio ' . $file_format . '="' . esc_url( $audio_url ) . '"]' );
						} else {
							echo do_shortcode( '[kft_soundcloud url="' . esc_url($audio_url) . '" width="100%" height="166"]' );
						}
					}
				}
				?>
			<?php endif; ?>
		</header><!-- .entry-header -->

		<div class="entry-content">
		

			<div class="info-category">
				<!-- Post by -->
							
					<span class="vcard author"><?php esc_html_e('By ', 'mipro'); ?>
					<?php echo get_avatar( get_the_author_meta( 'ID' ), 32 ); ?>
					<?php the_author_posts_link(); ?></span>
				

				<!-- Date Time -->
				<?php if ( mipro_get_opt('kft_blog_details_date') ) : ?>					
					<div class="date-time date-time-meta">
						<?php echo get_the_time(get_option('date_format')); ?>
					</div>
				<?php endif; ?>

				
				<div class="comment-count">
					<a href="#comments">
						<!-- Comment -->
						
							<?php 
							if ( get_comments_number() == 0 ) {
								$comments = esc_html__( 'No Comments', 'mipro' );
							} elseif ( get_comments_number() > 1 ) {
								$comments = sprintf( esc_html__( '%s Comments', 'mipro' ), get_comments_number() );
							} else {
								$comments = esc_html__( '1 Comment', 'mipro' );
							}
							echo '<a class="comment" href="' . esc_url( get_comments_link() ) . '"><i class="fa fa-comments"></i> ' . $comments . '</a>';
							?>
						
					</a>
				</div>
				
			</div><!-- .info-category -->
			<div class="clear"></div>

			<!-- Content -->
			<?php if ( mipro_get_opt('kft_blog_details_content') ) : ?>
				<div class="entry-summary">
					<div class="full-content"><?php the_content(); ?></div>
					<?php wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'mipro' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) ); ?>
				</div><!-- .entry-summary -->
			<?php endif; ?>

			<div class="footer-single-post">
				<!-- Tags -->
				<?php   
				$tags_list = get_the_tag_list('', ', '); 
				if ( $tags_list && mipro_get_opt('kft_blog_details_tags') ) : ?>
					<span class="tags-link"> 
						<span><?php esc_html_e( 'Tags: ','mipro' ); ?></span>
						<span class="tag-links">
							<?php echo trim( $tags_list ); ?>
						</span>
					</span>
				<?php endif; ?> 

				<!-- Social Sharing -->
				<?php if ( mipro_get_opt('kft_blog_details_sharing') && function_exists('mipro_template_social_sharing' ) ) : ?>
				<?php mipro_template_social_sharing(); ?>
			<?php endif; ?>
		</div>
	</div><!-- .entry-content -->

	<?php else: ?>

		<blockquote class="blockquote-bg">
			<?php 
			$quote_content = get_the_excerpt();
			if ( ! $quote_content ) {
				$quote_content = get_the_content();
			}
			echo do_shortcode( $quote_content );
			?>
		</blockquote>

		<div class="blockquote-meta">
			<!-- Date Time -->
			<?php if ( mipro_get_opt('kft_blog_details_date') ) : ?>					
				<div class="date-time date-time-meta">
					<i class="fa fa-calendar"></i> <?php echo get_the_time( get_option('date_format') ); ?>
				</div>
			<?php endif; ?>

			<!-- Post by -->
			<?php if ( mipro_get_opt('kft_blog_author') ) : ?>					
				<span class="vcard author"><?php esc_html_e( 'Posted by: ', 'mipro' ); ?><?php the_author_posts_link(); ?></span>
			<?php endif; ?>
		</div>

	<?php endif; ?>

</article>

<!-- Author bio -->
<?php if ( mipro_get_opt('kft_blog_details_author_box') && get_the_author_meta('description') ) : ?>
<div class="entry-author">
	<div class="author-avatar">
		<?php echo get_avatar( get_the_author_meta( 'user_email' ), 90 ); ?>
	</div>
	<div class="author-desc">
		<h3 class="author-name">
			<?php echo esc_html( get_the_author_meta( 'display_name' ) ); ?>
		</h3>
		<p class="author-bio">
			<?php the_author_meta( 'description' ); ?>
		</p>
		<a class="author-link" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author">
			<?php printf( esc_html__( 'View all posts by %s ', 'mipro' ), get_the_author() ); ?>
		</a>
	</div>
</div><!-- .entry-author -->
<?php endif; ?>

<!-- Single Navigation -->
<?php if ( mipro_get_opt('kft_blog_details_navigation') ) : ?>
	<div class="nav-single-post">
		<?php
		$next_post = get_next_post();
		$prev_post = get_previous_post();

		$archive_url = false;
		if ( get_post_type() == 'post' ) {
			$archive_page = get_option( 'page_for_posts' );
			$archive_url = get_permalink( $archive_page );
		}
		?>
		<div class="order-posts">
			<?php if ( ! empty( $prev_post ) ) : ?>
				<a href="<?php echo esc_url( get_permalink( $prev_post->ID ) ); ?>" rel="prev">
					<i class="icon-arrow-left"></i>
					<span class="post-title"><?php echo esc_html( get_the_title( $prev_post->ID ) ); ?></span>
				</a>
			<?php endif; ?>
		</div>

		<?php if ( $archive_url && 'page' == get_option( 'show_on_front' ) ) : ?>
			<div class="back-to-blog">
				<a href="<?php echo esc_url( $archive_url ); ?>"><span class="kft-tooltip"><?php esc_html_e( 'Back to list', 'mipro' ); ?></span></a>
			</div>
		<?php endif ?>

		<div class="newer-posts">
			<?php if ( ! empty( $next_post ) ) : ?>
				<a href="<?php echo esc_url( get_permalink( $next_post->ID ) ); ?>" rel="next">
					<span class="post-title"><?php echo esc_html( get_the_title( $next_post->ID ) ); ?></span>
					<i class="icon-arrow-right"></i>
				</a>
			<?php endif; ?>
		</div>
	</div><!-- .single-post-navigation -->
<?php endif; ?>

<!-- Related Post -->
<?php 
if ( mipro_get_opt('kft_blog_details_related_posts') ) {
	get_template_part( 'template-parts/post/related-posts' );
}

/* * Comment Template * */
if ( mipro_get_opt('kft_blog_details_comment_form') ) {
	if ( comments_open() || get_comments_number() ) {
		comments_template();
	}
}
?>
