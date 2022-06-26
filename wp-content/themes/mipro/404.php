<?php get_header(); ?>

<div class="container">
	<div id="primary" class="content-area">
		<main id="main" class="site-main" >
			<header class="page-header">
				<h2>4<span class="color-p">0</span>4</h2>
			</header>
			<div class="page-content">
				<h2><?php echo esc_html_e( 'Oops, This Page Could Not Be Found!', 'mipro' ); ?></h2>
				<p><?php echo esc_html_e( 'Can\'t find what you need? Take a moment and do a search below!', 'mipro' ); ?></p>
				<div class="search-page-search-form">
					<?php echo get_search_form(); ?>
				</div>
			</div>
		</main><!-- #main -->
	</div><!-- #primary -->
</div><!-- .container -->

<?php 
get_footer();
