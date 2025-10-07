<?php

/*------------------------------------------*/
/* Academia: Recent Events           */
/*------------------------------------------*/
 
add_action('widgets_init', create_function('', 'return register_widget("academia_recent_events");'));

class academia_recent_events extends WP_Widget {
	
	public function __construct() {

		parent::__construct(
			'academia-recent-events',
			__( 'Academia: Events', 'academia_textdomain' ),
			array(
				'classname'   => 'recent-events',
				'description' => __( 'Displays a list of upcoming events.', 'academia_textdomain' )
			)
		);

	}
	
	function widget( $args, $instance ) {
		
		extract( $args );

		/* User-selected settings. */
		$title 			= apply_filters('widget_title', $instance['title'] );
		$show_count 	= $instance['show_count'];
		$show_excerpt = $instance['show_excerpt'];
		$show_date = $instance['datetime'];
		$widget_style = $instance['widget_style'];
		
		/* Prepare the widget title for alternate styles */
		$re1 = '.*?'; # Non-greedy match on filler
		$re2 = '(gold|grey|blue|red)'; # Matching one of these styles
		
		if ( $c = preg_match_all ("/".$re1.$re2."/is", $before_title, $matches)) {
			
			$current_style = $matches[1][0];
			$length = strlen($current_style);
			
			$pos = strpos($before_title ,$current_style);
			$before_title=substr_replace($before_title, '' . $widget_style, $pos, $length);
		}

		/* Before widget (defined by themes). */
		echo $before_widget;
		
		/* Title of widget (before and after defined by themes). */
		if ( $title )
			echo $before_title . $title . $after_title;
		

		echo '<ul class="academia-posts academia-events academia-events-widget">';
		
		$current_time = current_time('mysql');
		list( $today_year, $today_month, $today_day, $hour, $minute, $second ) = preg_split( '([^0-9])', $current_time );
		$current_timestamp = $today_year . $today_month . $today_day . $hour . $minute;

		$meta_query = array(
			array(
				'key' => '_end_eventtimestamp',
				'value' => $current_timestamp,
				'compare' => '>'
			)
		);

		$academia_loop = new WP_Query( array( 'post_type' => 'event', 'meta_query' => $meta_query, 'meta_key' => '_end_eventtimestamp', 'orderby'=> 'meta_value_num', 'order' => 'ASC', 'posts_per_page' => $show_count, 'cat' => $category ) );
		while ( $academia_loop->have_posts() ) : $academia_loop->the_post();
		
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
		
		$metaDateStart = "$event_start_day";
		$metaDateEnd = "$event_end_day";
		if ($event_start_hour != '00' && $event_start_minute != '00') {
			$metaTimeStart = "$event_start_hour:$event_start_minute";
		}
		$metaTimeEnd = "$event_end_hour:$event_end_minute";
		$isoDateStart = "$event_start_year-$event_start_month-$event_start_day";
		$isoDateEnd = "$event_end_year-$event_end_month-$event_end_day";
		
		/*
		if ($metaDateEnd && ($metaDateEnd != $metaDateStart)) {
			$metaDate = "$metaDateStart - $metaDateEnd";
		}
		else {
			$metaDate = "$metaDateStart";
		}
		*/
		$metaDate = "$metaDateStart";
		
		$day_start = date("j", mktime(0,0,0,$event_start_month, $event_start_day, $event_start_year));
		$month_start = date("M", mktime(0,0,0,$event_start_month, $event_start_day, $event_start_year));
		$year_start = date("Y", mktime(0,0,0,$event_start_month, $event_start_day, $event_start_year));
		$day_end = date("j", mktime(0,0,0,$event_end_month, $event_end_day, $event_end_year));
		$month_end = date("M", mktime(0,0,0,$event_end_month, $event_end_day, $event_end_year));
		$year_end = date("Y", mktime(0,0,0,$event_end_month, $event_end_day, $event_end_year));
		
		if ($event_start_month != $event_end_month) {
			$metaDate = $event_start_day;
		}
		?>

			<li class="academia-post academia-event">
			
				<?php if ($show_date == 'on') { ?>
				<div class="post-cover">
					
					<div class="post-cover-wrapper">
					
						<span class="event-date"><?php echo $metaDate; ?></span>
						<span class="event-month"><?php echo $month_start; ?></span>
						
					</div><!-- .post-cover-wrapper -->
					
				</div><!-- .post-cover -->
				<?php } ?>
				
				<div class="post-content">
					<h2 class="title-s title-post"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'academia_textdomain' ), the_title_attribute( 'echo=0' ) ); ?>"><?php the_title(); ?></a></h2>
					<?php if ($show_excerpt == 'on') { the_excerpt(); } ?>
				</div><!-- .post-excerpt -->
			
				<div class="cleaner">&nbsp;</div>
				
			</li><!-- .academia-post .academia-event -->

			<?php
			endwhile; 
			
			//Reset query_posts
			wp_reset_query();			
		echo '</ul><!-- .academia-posts -->';

		/* After widget (defined by themes). */
		echo $after_widget;
	}
	
	
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags (if needed) and update the widget settings. */
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['show_count'] = $new_instance['show_count'];
		$instance['show_excerpt'] = $new_instance['show_excerpt'];
		$instance['datetime'] = $new_instance['datetime'];
		$instance['widget_style'] = $new_instance['widget_style'];

		return $instance;
	}
	
	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array( 'title' => 'Widget Title', 'show_count' => 3, 'show_excerpt' => 'on', 'show_excerpt' => 'on', 'datetime' => 'on');
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'widget_style' ); ?>" style="display: block; font-size: 11px; font-weight: bold; margin: 0 0 5px;"><?php _e('Widget color style', 'academia_textdomain'); ?>:</label>
				<select id="<?php echo $this->get_field_id('widget_style'); ?>" name="<?php echo $this->get_field_name('widget_style'); ?>" class="widefat" style="font-size: 11px;">
					<option value="0"<?php if (!$instance['widget_style'] || $instance['widget_style'] == '0') { echo ' selected="selected"';} ?>><?php _e('Default', 'academia_textdomain'); ?></option>
					<option value="blue"<?php if ($instance['widget_style'] == 'blue') { echo ' selected="selected"';} ?>><?php _e('Blue', 'academia_textdomain'); ?></option>
					<option value="gold"<?php if ($instance['widget_style'] == 'gold') { echo ' selected="selected"';} ?>><?php _e('Gold', 'academia_textdomain'); ?></option>
					<option value="grey"<?php if ($instance['widget_style'] == 'grey') { echo ' selected="selected"';} ?>><?php _e('Grey', 'academia_textdomain'); ?></option>
					<option value="red"<?php if ($instance['widget_style'] == 'red') { echo ' selected="selected"';} ?>><?php _e('Red', 'academia_textdomain'); ?></option>
				</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>" style="display: block; font-size: 11px; font-weight: bold; margin: 0 0 5px;"><?php _e('Widget Title', 'academia_textdomain'); ?>:</label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" type="text" class="widefat" style="padding: 7px 5px; font-size: 11px;" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'show_count' ); ?>"><?php _e('Number of posts to display', 'academia_textdomain'); ?>:</label>
			<input id="<?php echo $this->get_field_id( 'show_count' ); ?>" name="<?php echo $this->get_field_name( 'show_count' ); ?>" value="<?php echo $instance['show_count']; ?>" size="3" type="text" style="padding: 7px 5px; font-size: 11px;" />
		</p>
		
		<p>
			<input class="checkbox" type="checkbox" id="<?php echo $this->get_field_id('show_excerpt'); ?>" name="<?php echo $this->get_field_name('show_excerpt'); ?>" <?php if ($instance['show_excerpt'] == 'on') { echo ' checked="checked"';  } ?> /> 
			<label for="<?php echo $this->get_field_id('show_excerpt'); ?>" style="font-size: 11px; font-weight: bold; margin: 0 0 5px;"><?php _e('Display excerpt', 'academia_textdomain'); ?></label>
		</p>

		<p>
			<input class="checkbox" type="checkbox" id="<?php echo $this->get_field_id('datetime'); ?>" name="<?php echo $this->get_field_name('datetime'); ?>" <?php if ($instance['datetime'] == 'on') { echo ' checked="checked"';  } ?> /> 
			<label for="<?php echo $this->get_field_id('datetime'); ?>" style="font-size: 11px; font-weight: bold; margin: 0 0 5px;"><?php _e('Display date', 'academia_textdomain'); ?></label>
		</p>
		
		<?php
	}
}