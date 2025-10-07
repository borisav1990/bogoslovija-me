<?php get_header(); ?>

<?php 
// Load saved values in Academia Theme Options
$academia_options = academia_get_global_options(); 
?>

<div id="content">
	
	<div class="wrapper wrapper-content-main">
	
		<div class="academia-column academia-column-large academia-column-main">
		
			<div class="academia-column academia-column-double academia-column-inside">

				<div class="academia-column-wrapper">
				
					<?php get_template_part('breadcrumbs'); ?>

					<div class="post-meta-single">
						<h1 class="title title-l title-post-single"><?php _e('Page not found', 'academia_textdomain'); ?></h1>
					</div><!-- .post-meta -->

					<div class="post-single">
					
						<p><?php _e( 'Apologies, but the requested page cannot be found. Perhaps searching will help find a related page.', 'academia_textdomain' ); ?></p>
						
						<div class="cleaner">&nbsp;</div>
						
						<p class="title-s title-widget title-widget-special"><?php _e( 'Browse Categories', 'academia_textdomain' ); ?></p>
						<ul>
							<?php wp_list_categories('title_li=&hierarchical=0&show_count=1'); ?>	
						</ul>
					
						<p class="title-s title-widget title-widget-special"><?php _e( 'Monthly Archives', 'academia_textdomain' ); ?></p>
						<ul>
							<?php wp_get_archives('type=monthly&show_post_count=1'); ?>	
						</ul>
			
						<div class="cleaner">&nbsp;</div>
		
					</div><!-- .post-single -->

				</div><!-- .academia-column-wrapper -->
			
			</div><!-- .academia-column .academia-column-double -->
			
			<div class="academia-column academia-column-narrow">
			
				<?php
				if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Sidebar: Right') ) : ?> <?php endif;
				?>

			</div><!-- .academia-column .academia-column-narrow -->
			
			<div class="cleaner">&nbsp;</div>

		</div><!-- .academia-column .academia-column-large -->

		<div class="academia-column academia-column-narrow">
		
			<div class="academia-column-wrapper">
			
				<?php get_sidebar(); ?>
			
			</div><!-- .academia-column-wrapper -->

		</div><!-- .academia-column .academia-column-narrow -->
		
		<div class="cleaner">&nbsp;</div>
	
	</div><!-- .wrapper .wrapper-content-main -->

</div><!-- #content -->

<?php get_footer(); ?>