<?php

/*------------------------------------------*/
/* Academia: Recent Comments (with gravatar)	*/
/*------------------------------------------*/
 
add_action('widgets_init', create_function('', 'return register_widget("academia_recent_comments");'));

class academia_recent_comments extends WP_Widget {
	
	public function __construct() {

		parent::__construct(
			'academia-recent-comments',
			__( 'Academia: Recent Comments', 'academia_textdomain' ),
			array(
				'classname'   => 'recent-comments',
				'description' => __( 'A list of recent comments from all posts.', 'academia_textdomain' )
			)
		);

	}
	
 	function widget( $args, $instance ) {
		extract( $args );

		/* User-selected settings. */
		$title = apply_filters('widget_title', $instance['title'] );
		$show_count = $instance['show_count'];
		$show_avatar = isset( $instance['show_avatar'] ) ? $instance['show_avatar'] : false;
		$avatar_size = $instance['avatar_size'];
		$excerpt_length = $instance['excerpt_length'];
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
				
			$comments = get_comments(array(
				'number' => $show_count,
				'status' => 'approve',
				'type' => 'comment'
			));
			
			echo '<ul class="recent-comments-list">';
			
			foreach($comments as $comment) :
				
				$comm_title = get_the_title($comment->comment_post_ID);
				$comm_link = get_comment_link($comment->comment_ID);
			?>
		
		<li class="recent-comment">
			<?php
				if ( $show_avatar ) {
					echo '<div class="post-cover"><a href="' . $comm_link . '">' . get_avatar($comment,$size=$avatar_size) . '</a></div>';
				}
			?>
			<a href="<?php echo($comm_link)?>"><?php echo($comment->comment_author)?>:</a> <?php echo substr(get_comment_excerpt( $comment->comment_ID ), 0, $excerpt_length); ?><div class="cleaner">&nbsp;</div>
			<div class="cleaner">&nbsp;</div>
		</li><!-- .recent-comment -->
		
			<?php 
			endforeach;
			
			echo '</ul><!-- .recent-comments-list -->';
		

		/* After widget (defined by themes). */
		echo $after_widget;
	}
	
 	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags (if needed) and update the widget settings. */
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['show_count'] = $new_instance['show_count'];
		$instance['show_avatar'] = $new_instance['show_avatar'];
		$instance['avatar_size'] = $new_instance['avatar_size'];
		$instance['excerpt_length'] = $new_instance['excerpt_length'];
		$instance['widget_style'] = $new_instance['widget_style'];

		return $instance;
	}
	
 	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array( 'title' => 'Recent Comments', 'show_count' => 3, 'show_avatar' => true, 'avatar_size' => 30, 'excerpt_length' => 60 );
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
			<label for="<?php echo $this->get_field_id( 'show_count' ); ?>"><?php _e('Number of comments to show', 'academia_textdomain'); ?>:</label>
			<select id="<?php echo $this->get_field_id( 'show_count' ); ?>" name="<?php echo $this->get_field_name( 'show_count' ); ?>">
				<?php
				for ( $i = 1; $i < 11; $i++ ) {
					echo '<option' . ( $i == $instance['show_count'] ? ' selected="selected"' : '' ) . '>' . $i . '</option>';
				}
				?>
			</select>
		</p>
		
		<p>
			<input class="checkbox" type="checkbox" <?php checked( $instance['show_avatar'], 'on' ); ?> id="<?php echo $this->get_field_id( 'show_avatar' ); ?>" name="<?php echo $this->get_field_name( 'show_avatar' ); ?>" />
			<label for="<?php echo $this->get_field_id( 'show_avatar' ); ?>"><?php _e('Show gravatar', 'academia_textdomain'); ?>:</label>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'avatar_size' ); ?>"><?php _e('Gravatar size', 'academia_textdomain'); ?>:</label>
			<input id="<?php echo $this->get_field_id( 'avatar_size' ); ?>" name="<?php echo $this->get_field_name( 'avatar_size' ); ?>" value="<?php echo $instance['avatar_size']; ?>" size="3" type="text" style="padding: 7px 5px; font-size: 11px;" /> px
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'excerpt_length' ); ?>"><?php _e('Comment excerpt length', 'academia_textdomain'); ?>:</label>
			<input id="<?php echo $this->get_field_id( 'excerpt_length' ); ?>" name="<?php echo $this->get_field_name( 'excerpt_length' ); ?>" value="<?php echo $instance['excerpt_length']; ?>" size="3" type="text" style="padding: 7px 5px; font-size: 11px;" />
		</p>
		
		<?php
	}
}