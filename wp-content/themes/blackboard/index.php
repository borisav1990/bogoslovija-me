<?php get_header(); ?>

<?php 
// Load saved values in Academia Theme Options
$academia_options = academia_get_global_options(); 
?>

<div id="content">
	
	<div class="wrapper wrapper-content-main">
	
		<div class="academia-column academia-column-large academia-column-main">
		
			<?php get_template_part('slideshow', 'home'); ?>

			<div class="academia-column academia-column-double">

				<div class="academia-column-wrapper">
				
					<?php
					if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Homepage Content: Middle Column') ) : ?> <?php endif;
					?>
					
					<div class="cleaner">&nbsp;</div>

				</div><!-- .academia-column-wrapper -->
			
			</div><!-- .academia-column .academia-column-double -->
			
			<div class="academia-column academia-column-narrow">
			
				<?php
				if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Sidebar: Right') ) : ?> <?php endif;
				?>
				
				<div class="cleaner">&nbsp;</div>

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