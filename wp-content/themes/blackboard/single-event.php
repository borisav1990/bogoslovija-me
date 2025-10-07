<?php get_header(); ?>

<?php 
// Load saved values in Academia Theme Options
$academia_options = academia_get_global_options(); 
?>

<div id="content">
	
	<?php while (have_posts()) : the_post();
	
	$post_meta = get_post_custom($post->ID);
	
	$event_start_day = $post_meta['_start_day'][0];
	$event_start_month = $post_meta['_start_month'][0];
	$event_start_year = $post_meta['_start_year'][0];
	$event_end_day = $post_meta['_end_day'][0];
	$event_end_month = $post_meta['_end_month'][0];
	$event_end_year = $post_meta['_end_year'][0];
	$event_start_hour = $post_meta['_start_hour'][0];
	$event_start_minute = $post_meta['_start_minute'][0];
	$event_end_hour = $post_meta['_end_hour'][0];
	$event_end_minute = $post_meta['_end_minute'][0];
	
	$metaDateStart = "$event_start_day/$event_start_month/$event_start_year";
	$metaDateEnd = "$event_end_day/$event_end_month/$event_end_year";
	if ($event_start_hour != '00' && $event_start_minute != '00') {
		$metaTimeStart = "$event_start_hour:$event_start_minute";
	}
	$metaTimeEnd = "$event_end_hour:$event_end_minute";
	$isoDateStart = "$event_start_year-$event_start_month-$event_start_day";
	$isoDateEnd = "$event_end_year-$event_end_month-$event_end_day";
	$datetime_format = get_option('date_format') . " " . get_option('time_format');  
	$date_default_start = date($datetime_format, mktime($event_start_hour, $event_start_minute, 0, $event_start_month, $event_start_day, $event_start_year));
	$date_default_end = date($datetime_format, mktime($event_end_hour, $event_end_minute, 0, $event_end_month, $event_end_day, $event_end_year));
	
	if ($date_default_end && ($date_default_end != $date_default_start)) {
		$metaDate = "$date_default_start - $date_default_end";
	}
	else {
		$metaDate = "$date_default_start";
	}

	endwhile;
	?>

	<div class="wrapper wrapper-content-main">
	
		<div class="academia-column academia-column-large academia-column-main">
		
			<div class="academia-column academia-column-double academia-column-inside">

				<div class="academia-column-wrapper">
				
					<?php get_template_part('breadcrumbs'); ?>

					<?php while (have_posts()) : the_post(); ?>
					
					<div class="post-meta-single">
						<h1 class="title title-l title-post-single"><?php the_title(); ?></h1>
						<?php if ($metaDate) { ?>
						<p class="post-meta"><span class="meta-date"><?php echo $metaDate; ?></span></p><!-- .meta-date -->
						<?php } ?>
					</div><!-- .post-meta -->
		
					<div class="divider">&nbsp;</div>
		
					<div class="post-single">
					
						<?php the_content(); ?>
						
						<div class="cleaner">&nbsp;</div>
						
						<?php wp_link_pages(array('before' => '<p class="page-navigation"><strong>'.__('Pages', 'academia_textdomain').':</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
						
					</div><!-- .post-single -->
					
					<?php endwhile; ?>
		
					<?php if ($academia_options['academia_post_comments'] == 1) { ?>
					
					<div class="divider divider-notop">&nbsp;</div>
					
					<div id="academia-comments">
						<?php comments_template(); ?>  
					</div><!-- #comments -->
		
					<?php } ?>

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