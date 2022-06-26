<?php 
global $post, $wp_query;
$post_format = get_post_format();
$post_class = 'blog-post-default post-item hentry';
$show_blog_thumbnail = mipro_get_opt('kft_blog_thumbnail');
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( $post_class ) ?>>
	<?php if ( $post_format != 'quote' ) : ?>
		<?php if ( has_post_thumbnail() ): ?>
			<header class="entry-header">
				<?php if ( $show_blog_thumbnail ) : ?>
					<?php mipro_post_thumb( array( 'size' => 'full', 'class' => 'post-image' ) ); ?>
				<?php endif; ?>

				<!-- Date Time -->
				<?php if ( mipro_get_opt('kft_blog_date') && $show_blog_thumbnail && ( $post_format == 'gallery' || $post_format === false || $post_format == 'standard' ) ) : ?>
					<div class="date-time date-content">
						<span class="day"><?php echo get_the_time('d'); ?></span>
						<span class="month"><?php echo get_the_time('M'); ?></span>
					</div>
				<?php endif; ?>
			</header>
		<?php endif; ?>
		
		<div class="entry-content">
			<?php if ( $post_format == 'video' || $post_format == 'audio' ) : ?>
				<!-- Blog Date -->
				<?php if ( mipro_get_opt('kft_blog_date') ) : ?>
					<span class="date-time date-audio">
						<?php echo get_the_time( get_option('date_format') ); ?>
					</span>
				<?php endif; ?>
			<?php endif; ?>
			<!-- Categories -->
			<?php $categories_list = get_the_category_list( ', ' ); ?>
			<?php if ( $categories_list && mipro_get_opt('kft_blog_categories') ) : ?>
				<div class="cate-view">
				<div class="cats-link cate-content">
					<span class="cat-links"><?php echo trim( $categories_list ); ?></span>
				</div>        
			<?php endif; ?>
			<!-- Comment -->
				<?php if ( mipro_get_opt('kft_blog_comment') ) : ?>
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
				<?php endif; ?>
				<!-- View -->
			<?php if ( mipro_get_opt('kft_blog_count_view') ) : ?>
				<div class="count-view">
					<i class="icon-eye"></i>
					<?php echo mipro_get_post_views( get_the_ID() ); ?>
					<?php echo esc_html_e( ' View','mipro' ); ?>
				</div>
			<?php endif; ?>

			</div>
			<!-- Title -->
			<?php if ( mipro_get_opt('kft_blog_title') ) : ?>
				<h3 class="entry-title">
					<a class="post-title" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>

					<?php if ( is_sticky() && is_home() && ! is_paged() ) {
						printf( '<span class="sticky-post">%s</span>', esc_html__( 'Featured', 'mipro' ) );
					} ?>
				</h3>
			<?php endif; ?>

			<!-- Author -->
			<?php if ( mipro_get_opt('kft_blog_author') ) : ?>
				<span class="vcard author"><?php esc_html_e( 'Posted by ', 'mipro' ); ?>
				<?php echo get_avatar( get_the_author_meta( 'ID' ), 32 ); ?>
				<?php the_author_posts_link(); ?></span>
			<?php endif; ?>

			

			
			<div class="entry-summary">
				<?php if ( mipro_get_opt('kft_blog_excerpt') ) : ?>
					<div class="blog-content">
						<?php 
						$max_words = (int) mipro_get_opt('kft_blog_excerpt_max_words') ? (int) mipro_get_opt('kft_blog_excerpt_max_words') : 125;
						$strip_tags = mipro_get_opt('kft_blog_excerpt_strip_tags') ? true : false;
						mipro_the_excerpt_max_words( $max_words, $strip_tags, ' ', true ); 
						?>
					</div>
				<?php endif; ?>

				<?php if ( mipro_get_opt('kft_blog_read_more') ) : ?>
					<div class="read-content">
					<a class="button-readmore readmore-content" href="<?php the_permalink() ; ?>"><?php esc_html_e( 'Read More', 'mipro' ); ?></a>
					</div>
				<?php endif; ?>
				<!-- Social Sharing -->
				<?php if ( mipro_get_opt('kft_blog_details_sharing') && function_exists('mipro_template_social_sharing_blog' ) ) : ?>
				<div class="blog-share">
					
					<?php if ( $post_format == 'video' || $post_format == 'audio' ) : ?>
						<!-- Blog Date -->
						<?php if ( mipro_get_opt('kft_blog_date') ) : ?>
							<span class="date-time date-audio">
								<?php echo get_the_time( get_option('date_format') ); ?>
							</span>
						<?php endif; ?>
					<?php endif; ?>

				</div>
			<?php endif; ?>
				
			</div><!-- .entry-summary -->
			
			<?php if ( mipro_get_opt('kft_blog_tags') ) : ?>
				<?php   
				$tags_list = get_the_tag_list( '', ', ' ); 
				if ( $tags_list ) : ?>
					<div class="entry-footer">
						<!-- Tags -->
						<span class="tags-link">
							<span><?php esc_html_e( 'Tags: ','mipro' ); ?></span>
							<span class="tag-links">
								<?php echo trim( $tags_list ); ?>
							</span>
						</span> 
					</div>
				<?php endif; ?>
			<?php endif; ?>
		</div><!-- .entry-content -->

	<?php else: /* Post format is quote */ ?>

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
			<!-- Author -->
			<?php if ( mipro_get_opt('kft_blog_author') ) : ?>
				<span class="vcard author"><?php esc_html_e( 'Posted by: ', 'mipro' ); ?><?php the_author_posts_link(); ?></span>
			<?php endif; ?>

			<!-- Blog Date -->
			<?php if ( mipro_get_opt('kft_blog_date') ) : ?>
				<span class="date-time">
					<?php echo get_the_time( get_option('date_format') ); ?>
				</span>
			<?php endif; ?>
		</div>
	<?php endif; ?>
</article>
