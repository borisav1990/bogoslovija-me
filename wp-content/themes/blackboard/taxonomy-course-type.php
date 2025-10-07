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
					<h1 class="title title-l title-post-single"><?php single_cat_title(); ?></h1>
					<?php edit_post_link( __('Edit page', 'academia_textdomain'), '<p class="post-meta">', '</p>'); ?>
				</div><!-- .post-meta -->

				<?php if (category_description()) { ?>
				<div class="category-excerpt">
				
					<?php echo category_description(); ?>
					
					<div class="cleaner">&nbsp;</div>
					
				</div><!-- .category-excerpt -->
				
				<div class="divider">&nbsp;</div>
				
				<?php } ?>
	
				<?php get_template_part('loop','courses'); ?>
			
			</div><!-- .academia-column .academia-column-double -->
			
			<div class="cleaner">&nbsp;</div>

		</div><!-- .academia-column .academia-column-large -->

		<div class="academia-column academia-column-narrow">
		
			<div class="academia-column-wrapper">
			
				<?php get_sidebar('courses'); ?>
			
			</div><!-- .academia-column-wrapper -->

		</div><!-- .academia-column .academia-column-narrow -->
		
		<div class="cleaner">&nbsp;</div>
	
	</div><!-- .wrapper .wrapper-content-main -->
	
</div><!-- #content -->

<?php get_footer(); ?>