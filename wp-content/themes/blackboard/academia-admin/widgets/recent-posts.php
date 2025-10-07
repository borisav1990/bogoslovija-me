<?php

/*------------------------------------------*/
/* Academia: Recent Posts           */
/*------------------------------------------*/
 
add_action('widgets_init', create_function('', 'return register_widget("academia_recent_posts");'));

class academia_recent_posts extends WP_Widget {
	
	public function __construct() {

		parent::__construct(
			'academia-recent-posts',
			__( 'Academia: Recent Posts', 'academia_textdomain' ),
			array(
				'classname'   => 'recent-posts',
				'description' => __( 'A list of posts, optionally filtered by category.', 'academia_textdomain' )
			)
		);

	}
	
	function widget( $args, $instance ) {
		
		extract( $args );

		/* User-selected settings. */
		$title 			= apply_filters('widget_title', $instance['title'] );
		$category 		= $instance['category'];
		$show_count 	= $instance['show_count'];
		$show_date = $instance['datetime'];
		$show_thumb = $instance['show_thumb'];
		$show_category = $instance['show_category'];
		$show_excerpt = $instance['show_excerpt'];
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
		

		echo '<ul class="academia-posts academia-posts-archive">';
		
		$academia_loop = new WP_Query( array( 'posts_per_page' => $show_count, 'orderby' => 'date', 'order' => 'DESC', 'cat' => $category ) );
		while ( $academia_loop->have_posts() ) : $academia_loop->the_post();
		unset($prev); 
		?>

			<li class="academia-post">
									
				<?php
				if ($show_thumb == 'on') {
					get_the_image( array( 'size' => 'thumb-loop-main', 'width' => 100, 'height' => 60, 'before' => '<div class="post-cover"><div class="post-cover-wrapper">', 'after' => '</div><!-- .post-cover-wrapper --></div><!-- .post-cover -->' ) );
				}
				?>
		
				<div class="post-content">
					<h2 class="title-s title-post"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'academia_textdomain' ), the_title_attribute( 'echo=0' ) ); ?>"><?php the_title(); ?></a></h2>
					<?php if ($show_date == 'on' || $show_category == 'on') { ?>
					<p class="post-meta"><?php if ($show_date == 'on') { ?><time datetime="<?php the_time("Y-m-d"); ?>" pubdate><?php the_time(get_option('date_format')); ?></time><?php $prev = TRUE; } ?>
					<span class="category"><?php if ($show_category == 'on') { if ($prev) {echo ' / '; } the_category(', '); } ?></span></p>
					<?php } ?>
					<?php if ($show_excerpt == 'on') { ?><p class="post-excerpt"><?php echo get_the_excerpt(); ?></p><?php } ?>
				</div><!-- .post-content -->
			
				<div class="cleaner">&nbsp;</div>
										
			</li><!-- .academia-post -->
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
		$instance['category'] = $new_instance['category'];
		$instance['show_count'] = $new_instance['show_count'];
		$instance['datetime'] = $new_instance['datetime'];
		$instance['show_thumb'] = $new_instance['show_thumb'];
		$instance['show_excerpt'] = $new_instance['show_excerpt'];
		$instance['show_category'] = $new_instance['show_category'];
		$instance['widget_style'] = $new_instance['widget_style'];

		return $instance;
	}
	
	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array( 'title' => 'Widget Title', 'category' => 0, 'show_count' => 3, 'datetime' => 'on', 'show_thumb' => 'on', 'show_category' => 'on');
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
			<label for="<?php echo $this->get_field_id( 'title' ); ?>" style="display: block; font-size: 11px; font-weight: bold; margin: 0 0 5px;"><?php _e('Widget title', 'academia_textdomain'); ?>:</label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" type="text" class="widefat" style="padding: 7px 5px; font-size: 11px;" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'category' ); ?>" style="display: block; font-size: 11px; font-weight: bold; margin: 0 0 5px;"><?php _e('Category of posts', 'academia_textdomain'); ?>:</label>
				<select id="<?php echo $this->get_field_id('category'); ?>" name="<?php echo $this->get_field_name('category'); ?>" class="widefat" style="font-size: 11px;">
					<option value="0">- show from all categories -</option>
					<?php
					
					$cats = get_categories('hide_empty=0');
					foreach ($cats as $cat) {
					$option = '<option value="'.$cat->term_id;
					if ($cat->term_id == $instance['category']) { $option .='" selected="selected';}
					$option .= '">';
					$option .= $cat->cat_name;
					$option .= ' ('.$cat->category_count.')';
					$option .= '</option>';
					echo $option;
					}
				?>
				</select>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'show_count' ); ?>"><?php _e('Number of posts to display', 'academia_textdomain'); ?>:</label>
			<input id="<?php echo $this->get_field_id( 'show_count' ); ?>" name="<?php echo $this->get_field_name( 'show_count' ); ?>" value="<?php echo $instance['show_count']; ?>" size="3" type="text" style="padding: 7px 5px; font-size: 11px;" />
		</p>

		<p>
			<input class="checkbox" type="checkbox" id="<?php echo $this->get_field_id('show_thumb'); ?>" name="<?php echo $this->get_field_name('show_thumb'); ?>" <?php if ($instance['show_thumb'] == 'on') { echo ' checked="checked"';  } ?> /> 
			<label for="<?php echo $this->get_field_id('show_thumb'); ?>" style="font-size: 11px; font-weight: bold; margin: 0 0 5px;"><?php _e('Display thumbnail', 'academia_textdomain'); ?></label>
		</p>

		<p>
			<input class="checkbox" type="checkbox" id="<?php echo $this->get_field_id('show_excerpt'); ?>" name="<?php echo $this->get_field_name('show_excerpt'); ?>" <?php if ($instance['show_excerpt'] == 'on') { echo ' checked="checked"';  } ?> /> 
			<label for="<?php echo $this->get_field_id('show_excerpt'); ?>" style="font-size: 11px; font-weight: bold; margin: 0 0 5px;"><?php _e('Display excerpt', 'academia_textdomain'); ?></label>
		</p>
		
		<p>
			<input class="checkbox" type="checkbox" id="<?php echo $this->get_field_id('datetime'); ?>" name="<?php echo $this->get_field_name('datetime'); ?>" <?php if ($instance['datetime'] == 'on') { echo ' checked="checked"';  } ?> /> 
			<label for="<?php echo $this->get_field_id('datetime'); ?>" style="font-size: 11px; font-weight: bold; margin: 0 0 5px;"><?php _e('Display date', 'academia_textdomain'); ?></label>
		</p>
		<p>
			<input class="checkbox" type="checkbox" id="<?php echo $this->get_field_id('show_category'); ?>" name="<?php echo $this->get_field_name('show_category'); ?>" <?php if ($instance['show_category'] == 'on') { echo ' checked="checked"';  } ?> /> 
			<label for="<?php echo $this->get_field_id('show_category'); ?>" style="font-size: 11px; font-weight: bold; margin: 0 0 5px;"><?php _e('Display post category', 'academia_textdomain'); ?></label>
		</p>
		
		<?php
	}
}