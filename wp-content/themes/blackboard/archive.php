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
						<?php the_archive_title( '<h1 class="title title-l title-post-single">', '</h1>' ); ?>
					</div><!-- .post-meta-single -->

					<?php if (category_description()) { ?>
					<div class="category-excerpt">
					
						<?php echo category_description(); ?>
						
					</div><!-- .category-excerpt -->

					<div class="divider">&nbsp;</div>
					
					<?php } ?>
					
					<?php get_template_part('loop'); ?>

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