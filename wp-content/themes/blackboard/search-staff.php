<?php get_header(); ?>

<?php 
// Load saved values in Academia Theme Options
$academia_options = academia_get_global_options(); 
?>

<div id="content">
	
	<div class="wrapper wrapper-content-main">
	
		<div class="academia-column academia-column-large academia-column-main">
		
			<div class="academia-column-inside">

				<?php get_template_part('breadcrumbs'); ?>

				<div class="post-meta-single">
					<h1 class="title title-l title-post-single"><?php _e('Search Results for', 'academia_textdomain');?>: <strong><?php the_search_query(); ?></strong></h1>
				</div><!-- .post-meta -->
				
				<?php 
				get_template_part('form', 'staff');
				get_template_part('loop', 'staff'); 
				?>
			
			</div><!-- .academia-column-inside -->
			
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