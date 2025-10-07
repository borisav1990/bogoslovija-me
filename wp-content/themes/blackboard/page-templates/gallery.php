<?php
/**
 * Template Name: Gallery
 */

get_header(); ?>

<?php 
// Load saved values in Academia Theme Options
$academia_options = academia_get_global_options(); 
?>

<div id="content">
	
	<?php while (have_posts()) : the_post();
	$post_meta = get_post_custom($post->ID);
	endwhile;
	?>

	<div class="wrapper wrapper-content-main">
	
		<div class="academia-column academia-column-large academia-column-main">
		
			<div class="academia-column-inside">

				<?php get_template_part('breadcrumbs'); ?>

				<?php while (have_posts()) : the_post(); ?>
				
				<div class="post-meta-single">
					<h1 class="title title-l title-post-single"><?php the_title(); ?></h1>
				</div><!-- .post-meta -->
	
				<div class="divider">&nbsp;</div>
	
				<div class="post-single">
				
					<?php the_content(); ?>
					
					<div class="cleaner">&nbsp;</div>
					
					<?php wp_link_pages(array('before' => '<p class="page-navigation"><strong>'.__('Pages', 'academia_textdomain').':</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
					
				</div><!-- .post-single -->
				
				<?php endwhile; ?>
				
				<?php get_template_part('loop-gallery'); ?>
			
			</div><!-- .academia-column -->
			
			<div class="cleaner">&nbsp;</div>

		</div><!-- .academia-column-inside -->

		<div class="academia-column academia-column-narrow">
		
			<div class="academia-column-wrapper">
			
				<?php get_sidebar(); ?>
			
			</div><!-- .academia-column-wrapper -->

		</div><!-- .academia-column .academia-column-narrow -->
		
		<div class="cleaner">&nbsp;</div>
	
	</div><!-- .wrapper .wrapper-content-main -->

</div><!-- #content -->
	
<?php get_footer(); ?>