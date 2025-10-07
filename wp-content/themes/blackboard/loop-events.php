<?php 
global $academia_options, $display_events;

$current_time = current_time('mysql');
list( $today_year, $today_month, $today_day, $hour, $minute, $second ) = preg_split( '([^0-9])', $current_time );
$current_timestamp = $today_year . $today_month . $today_day . $hour . $minute;

if ( get_query_var('paged') ) {
	$paged = get_query_var('paged');
} elseif ( get_query_var('page') ) { 
	$paged = get_query_var('page');
} else { 
	$paged = 1;
}

if ($display_events == 'Future') {
	$sign = '>';
	$eventsorder = 'ASC';
} else {
	$sign = '<';
	$eventsorder = 'DESC';
}
			 
$meta_query = array(
	array(
		'key' => '_end_eventtimestamp',
		'value' => $current_timestamp,
		'compare' => $sign
	)
);

$args = array( 
	'post_type' => 'event',
	'meta_query' => $meta_query,
	'meta_key' => '_end_eventtimestamp',
	'orderby'=> 'meta_value_num',
	'order' => $eventsorder,
	'posts_per_page' => get_option('posts_per_page'),
	'paged' => $paged
);

query_posts($args);

// $events = new WP_Query( $args );

if (have_posts()) {
	$i = 0;
	?>

	<ul class="academia-posts academia-posts-archive">
	
	<?php
	$i = 0;
	
	while ( have_posts() ) : the_post();
	unset($same_day,$same_time,$parentMeta); 
	$same_day = false;
	$same_time = false; 
	
	$parentMeta = get_post_custom();
	$event_start_day = $parentMeta['_start_day'][0];
	$event_start_month = $parentMeta['_start_month'][0];
	$event_start_year = $parentMeta['_start_year'][0];
	$event_end_day = $parentMeta['_end_day'][0];
	$event_end_month = $parentMeta['_end_month'][0];
	$event_end_year = $parentMeta['_end_year'][0];
	$event_start_hour = $parentMeta['_start_hour'][0];
	$event_start_minute = $parentMeta['_start_minute'][0];
	$event_end_hour = $parentMeta['_end_hour'][0];
	$event_end_minute = $parentMeta['_end_minute'][0];
	
	$metaDateStart = "$event_start_day/$event_start_month/$event_start_year";
	$metaDateEnd = "$event_end_day/$event_end_month/$event_end_year";
	if ($event_start_hour != '00' && $event_start_minute != '00') {
		$metaTimeStart = "$event_start_hour:$event_start_minute";
	}
	$metaTimeEnd = "$event_end_hour:$event_end_minute";
	$isoDateStart = "$event_start_year-$event_start_month-$event_start_day";
	$isoDateEnd = "$event_end_year-$event_end_month-$event_end_day";
	
	if ($metaDateEnd && ($metaDateEnd != $metaDateStart)) {
		$metaDate = "$metaDateStart - $metaDateEnd";
	}
	else {
		$metaDate = "$metaDateStart";
	}
	
	$day_start = date("j", mktime(0,0,0,$event_start_month, $event_start_day, $event_start_year));
	$month_start = date("F", mktime(0,0,0,$event_start_month, $event_start_day, $event_start_year));
	$year_start = date("Y", mktime(0,0,0,$event_start_month, $event_start_day, $event_start_year));
	$day_end = date("j", mktime(0,0,0,$event_end_month, $event_end_day, $event_end_year));
	$month_end = date("F", mktime(0,0,0,$event_end_month, $event_end_day, $event_end_year));
	$year_end = date("Y", mktime(0,0,0,$event_end_month, $event_end_day, $event_end_year));
	
	if (($day_start == $day_end) && ($month_start == $month_end)) {
		$same_day = true;
	}
	
	if ($same_day && ($event_start_hour == $event_end_hour) && ($event_start_minute == $event_end_minute)) {
		$same_time = true;
	}
	$classes = array('academia-post');
	
	?>

		<li <?php post_class($classes); ?>>
		
			<?php
			get_the_image( array( 'size' => 'thumb-loop-main', 'width' => 100, 'height' => 60, 'before' => '<div class="post-cover"><div class="post-cover-wrapper">', 'after' => '</div><!-- .post-cover-wrapper --></div><!-- .post-cover -->' ) );
			?>
			
			<div class="post-content">
				<h2 class="title-s title-post"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
				<?php if ($metaDate) { ?>
				<p class="post-meta"><span class="meta-date">
					<span class="value value-date"><?php echo $day_start; ?></span>
					<span class="value value-month"><?php echo $month_start; ?></span>
					<span class="value value-year"><?php echo $year_start; ?></span>
					
					<?php if ($same_day == false && $same_time == false) { ?>
					<?php _e('at', 'academia_textdomain');?> <span class="value value-time"><?php echo "$event_start_hour:$event_start_minute"; ?></span>
					<?php } ?>

					<?php if ($same_day == false) { ?>
					<span class="value value-date"> &mdash; <?php echo $day_end; ?></span>
					<span class="value value-month"><?php echo $month_end; ?></span>
					<span class="value value-year"><?php echo $year_end; ?></span>

					<?php if ($same_time == false) { ?>
					<?php _e('at', 'academia_textdomain');?> <span class="value value-time"><?php echo "$event_end_hour:$event_end_minute"; ?></span>
					<?php } ?>

					<?php } // if same day == false ?>

					<?php if ($same_day == true && $same_time == false) { ?>
					<?php _e('at', 'academia_textdomain');?> <span class="value value-time"><?php echo "$event_start_hour:$event_start_minute - $event_end_hour:$event_end_minute"; ?></span>
					<?php } // if same day == true and same time == false ?>

				</span><!-- .meta-date -->
				</p><!-- .post-meta -->
				<?php } ?>
				<p class="post-excerpt"><?php echo get_the_excerpt(); ?></p>
			</div><!-- .post-content -->
		
			<div class="cleaner">&nbsp;</div>
			
		</li><!-- .academia-post -->

		<?php endwhile; ?>
	
	</ul><!-- .academia-posts .academia-events -->

	<?php get_template_part( 'pagination','taxonomy'); ?>

<?php 
} // if there are pages
wp_reset_query();
?>

<div class="cleaner">&nbsp;</div>