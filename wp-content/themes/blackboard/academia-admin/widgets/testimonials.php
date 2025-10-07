<?php

/*------------------------------------------*/
/* Academia: Testimonials           */
/*------------------------------------------*/
 
add_action('widgets_init', create_function('', 'return register_widget("academia_widget_testimonials");'));

class academia_widget_testimonials extends WP_Widget {
	
	public function __construct() {

		parent::__construct(
			'academia-widget-testimonials',
			__( 'Academia: Testimonials', 'academia_textdomain' ),
			array(
				'classname'   => 'academia-testimonials',
				'description' => __( 'Displays testimonials according to chosen criteria.', 'academia_textdomain' )
			)
		);

	}
	
	function widget( $args, $instance ) {
		
		extract( $args );

		/* User-selected settings. */
		$title 	= apply_filters('widget_title', $instance['title'] );
		$link_to_page	= $instance['link_to_page'];
		$show_count	= $instance['show_count'];
		$show_title = $instance['show_title'];
		$show_photo = $instance['show_photo'];
		$show_author = $instance['show_author'];
		$show_country = $instance['show_country'];
		$show_date = $instance['show_date'];
		$show_random = $instance['show_random'];
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
	
		if ( $title ) { 
			echo $before_title;
			
			if ($link_to_page) {
				echo '<a href="' . get_page_link( $link_to_page ) . '">'.$title.'</a>';
			}
			else {
				echo $title;
			}
			
			echo $after_title;
		}
		

		if ($show_random == 'on')
		{
			$orderby = 'rand';
		}
		else
		{
			$orderby = 'date';
		}

		$loop = new WP_Query( array( 'post_type' => 'testimonial', 'posts_per_page' => $show_count, 'orderby' => $orderby ) );		
		?>
		<ul class="academia-testimonials">
		<?php
		
		while ( $loop->have_posts() ) : $loop->the_post(); global $post;
		
		$testimonial_author = get_post_meta($post->ID, 'academia_testimonial_author', true);
		$testimonial_country = get_post_meta($post->ID, 'academia_testimonial_country', true);
		$testimonial_date = get_post_meta($post->ID, 'academia_testimonial_date', true);
		?>
		
		<li class="academia-testimonial">
	
			<figure>
				
				<blockquote class="academia-testimonial-content">
					<?php
					get_the_image( array( 'size' => 'thumb-loop-main', 'width' => 100, 'height' => 60, 'before' => '<div class="post-cover">', 'after' => '</div><!-- .post-cover -->' ) );
					?>
					<div class="post-excerpt">
						<?php if ($show_title == 'on') { ?><h2 class="title-s title-post"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2><?php } ?>
						<?php the_content(); ?>
					</div><!-- .post-excerpt -->
				</blockquote><!-- .academia-testimonial-quote -->
	
				<figcaption class="academia-author"><?php if ($testimonial_author) { echo "<strong>$testimonial_author</strong>, "; } ?>
				<?php if ($testimonial_country) { echo "$testimonial_country"; } ?>
				<?php if ($testimonial_date) { echo " &mdash; $testimonial_date"; } ?></figcaption>
	
			</figure>
		</li><!-- .academia-testimonial -->
		<?php endwhile; ?>
		</ul><!-- .academia-testimonials -->
		<?php
		wp_reset_query();

		/* After widget (defined by themes). */
		echo $after_widget;
	}
	
	
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags (if needed) and update the widget settings. */
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['link_to_page'] = strip_tags( $new_instance['link_to_page'] );
		$instance['show_count'] = strip_tags( $new_instance['show_count'] );
		$instance['show_title'] = $new_instance['show_title'];
		$instance['show_photo'] = $new_instance['show_photo'];
		$instance['show_author'] = $new_instance['show_author'];
		$instance['show_country'] = $new_instance['show_country'];
		$instance['show_date'] = $new_instance['show_date'];
		$instance['show_random'] = $new_instance['show_random'];
		$instance['widget_style'] = $new_instance['widget_style'];
		return $instance;
	}
	
	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array( 'title' => 'Widget Title', 'show_count' => 1, 'show_author' => 'on', 'show_country' => 'on', 'show_date' => 'on');
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
			<label for="<?php echo $this->get_field_id( 'link_to_page' ); ?>"><?php _e('Link Widget Title to Page', 'academia_textdomain'); ?>:</label><br />
			<select id="<?php echo $this->get_field_id('link_to_page'); ?>" name="<?php echo $this->get_field_name('link_to_page'); ?>" class="widefat" style="font-size: 11px;">
				<option value="0"><?php _e('Choose page', 'academia_textdomain'); ?>:</option>
				<?php
				$pages = get_pages();
				
				foreach ($pages as $page) {
				$option = '<option value="'.$page->ID;
				if ($page->ID == $instance['link_to_page']) { $option .='" selected="selected';}
				$option .= '">';
				$option .= $page->post_title;
				$option .= '</option>';
				echo $option;
				}
			?>
			</select>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'show_count' ); ?>" style="display: block; font-size: 11px; font-weight: bold; margin: 0 0 5px;"><?php _e('How many testimonials to display', 'academia_textdomain'); ?></label>
			<input id="<?php echo $this->get_field_id( 'show_count' ); ?>" name="<?php echo $this->get_field_name( 'show_count' ); ?>" value="<?php echo $instance['show_count']; ?>" type="text" style="padding: 7px 5px; width: 40px;" />
		</p>

		<p>
			<input class="checkbox" type="checkbox" id="<?php echo $this->get_field_id('show_title'); ?>" name="<?php echo $this->get_field_name('show_title'); ?>" <?php if ($instance['show_title'] == 'on') { echo ' checked="checked"';  } ?> />
			<label for="<?php echo $this->get_field_id( 'show_title' ); ?>" style="font-size: 11px; font-weight: bold; margin: 0 0 5px;"><?php _e('Display Testimonial Title', 'academia_textdomain'); ?></label>
		</p>
		<p>
			<input class="checkbox" type="checkbox" id="<?php echo $this->get_field_id('show_photo'); ?>" name="<?php echo $this->get_field_name('show_photo'); ?>" <?php if ($instance['show_photo'] == 'on') { echo ' checked="checked"';  } ?> />
			<label for="<?php echo $this->get_field_id( 'show_photo' ); ?>" style="font-size: 11px; font-weight: bold; margin: 0 0 5px;"><?php _e('Display Featured Image', 'academia_textdomain'); ?></label>
		</p>
		<p>
			<input class="checkbox" type="checkbox" id="<?php echo $this->get_field_id('show_author'); ?>" name="<?php echo $this->get_field_name('show_author'); ?>" <?php if ($instance['show_author'] == 'on') { echo ' checked="checked"';  } ?> />
			<label for="<?php echo $this->get_field_id( 'show_author' ); ?>" style="font-size: 11px; font-weight: bold; margin: 0 0 5px;"><?php _e('Display Author Name', 'academia_textdomain'); ?></label>
		</p>
		<p>
			<input class="checkbox" type="checkbox" id="<?php echo $this->get_field_id('show_country'); ?>" name="<?php echo $this->get_field_name('show_country'); ?>" <?php if ($instance['show_country'] == 'on') { echo ' checked="checked"';  } ?> />
			<label for="<?php echo $this->get_field_id( 'show_country' ); ?>" style="font-size: 11px; font-weight: bold; margin: 0 0 5px;"><?php _e('Display Author Location', 'academia_textdomain'); ?></label>
		</p>
		<p>
			<input class="checkbox" type="checkbox" id="<?php echo $this->get_field_id('show_date'); ?>" name="<?php echo $this->get_field_name('show_date'); ?>" <?php if ($instance['show_date'] == 'on') { echo ' checked="checked"';  } ?> />
			<label for="<?php echo $this->get_field_id( 'show_date' ); ?>" style="font-size: 11px; font-weight: bold; margin: 0 0 5px;"><?php _e('Display Testimonial Date', 'academia_textdomain'); ?></label>
		</p>
		<p>
			<input class="checkbox" type="checkbox" id="<?php echo $this->get_field_id('show_random'); ?>" name="<?php echo $this->get_field_name('show_random'); ?>" <?php if ($instance['show_random'] == 'on') { echo ' checked="checked"';  } ?> />
			<label for="<?php echo $this->get_field_id( 'show_random' ); ?>" style="font-size: 11px; font-weight: bold; margin: 0 0 5px;"><?php _e('Display Random Testimonial', 'academia_textdomain'); ?></label>
		</p>
		
		<?php
	}
}
?>