<?php

/*------------------------------------------*/
/* Academia: Contacts			           */
/*------------------------------------------*/
 
add_action('widgets_init', create_function('', 'return register_widget("academia_widget_contacts");'));

class academia_widget_contacts extends WP_Widget {
	
	public function __construct() {

		parent::__construct(
			'academia-widget-contacts',
			__( 'Academia: Contacts', 'academia_textdomain' ),
			array(
				'classname'   => 'academia-contacts',
				'description' => __( 'Displays contact options.', 'academia_textdomain' )
			)
		);

	}
	
	function widget( $args, $instance ) {
		
		extract( $args );

		/* User-selected settings. */
		$title 	= apply_filters('widget_title', $instance['widget_title'] );
		$contact_1_text	= $instance['contact_1_text'];
		$contact_1_icon	= $instance['contact_1_icon'];
		$contact_2_text	= $instance['contact_2_text'];
		$contact_2_icon	= $instance['contact_2_icon'];
		$contact_3_text	= $instance['contact_3_text'];
		$contact_3_icon	= $instance['contact_3_icon'];
		$contact_4_text	= $instance['contact_4_text'];
		$contact_4_icon	= $instance['contact_4_icon'];
		$contact_5_text	= $instance['contact_5_text'];
		$contact_5_icon	= $instance['contact_5_icon'];
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

				echo $title;

			echo $after_title;
		}
		
		?>

		<ul class="academia-contacts">
			<?php
			$i = 0;
			$m = 5;
			while ($i < $m) {
				$i++;
				
				$contact_text = 'contact_'.$i.'_text';
				$contact_icon = 'contact_'.$i.'_icon';
				
				if (strlen($$contact_text) > 0) {
				
					echo '<li class="academia-contact">';
					if ($$contact_icon != 'No Icon') { echo '<img src="'. get_template_directory_uri() .'/images/x.gif" width="16" height="18" alt="" class="academia-sprite-contact academia-contact-'.strtolower($$contact_icon).'" />'; }
					echo '<span class="academia-contact-value">';
					
					if ($$contact_icon == 'Email') {
						echo '<a href="mailto:'.$$contact_text.'">'.$$contact_text.'</a>';
					} else {
						echo $$contact_text;
					}
					echo '</span></li><!-- .academia-contact -->';
				
				}
				
			} 
			?>
		</ul><!-- .academia-contacts -->

		<?php

		/* After widget (defined by themes). */
		echo $after_widget;
	}
	
	
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags (if needed) and update the widget settings. */
		$instance['widget_title'] = strip_tags( $new_instance['widget_title'] );
		$instance['contact_1_text'] = strip_tags( $new_instance['contact_1_text'] );
		$instance['contact_1_icon'] = strip_tags( $new_instance['contact_1_icon'] );
		$instance['contact_2_text'] = strip_tags( $new_instance['contact_2_text'] );
		$instance['contact_2_icon'] = strip_tags( $new_instance['contact_2_icon'] );
		$instance['contact_3_text'] = strip_tags( $new_instance['contact_3_text'] );
		$instance['contact_3_icon'] = strip_tags( $new_instance['contact_3_icon'] );
		$instance['contact_4_text'] = strip_tags( $new_instance['contact_4_text'] );
		$instance['contact_4_icon'] = strip_tags( $new_instance['contact_4_icon'] );
		$instance['contact_5_text'] = strip_tags( $new_instance['contact_5_text'] );
		$instance['contact_5_icon'] = strip_tags( $new_instance['contact_5_icon'] );
		$instance['widget_style'] = $new_instance['widget_style'];
		return $instance;
	}
	
	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array( 'widget_title' => 'Contact Us');
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
			<label for="<?php echo $this->get_field_id( 'widget_title' ); ?>" style="display: block; font-size: 11px; font-weight: bold; margin: 0 0 5px;"><?php _e('Widget Title', 'academia_textdomain'); ?>:</label>
			<input id="<?php echo $this->get_field_id( 'widget_title' ); ?>" name="<?php echo $this->get_field_name( 'widget_title' ); ?>" value="<?php echo $instance['widget_title']; ?>" type="text" class="widefat" style="padding: 7px 5px; font-size: 11px;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'contact_1_text' ); ?>" style="display: block; font-size: 11px; font-weight: bold; margin: 0 0 5px;"><?php _e('Contact 1 Text', 'academia_textdomain'); ?>:</label>
			<input id="<?php echo $this->get_field_id( 'contact_1_text' ); ?>" name="<?php echo $this->get_field_name( 'contact_1_text' ); ?>" value="<?php echo $instance['contact_1_text']; ?>" type="text" class="widefat" style="padding: 7px 5px; font-size: 11px;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'contact_1_icon' ); ?>" style="display: block; font-size: 11px; font-weight: bold; margin: 0 0 5px;"><?php _e('Contact 1 Icon', 'academia_textdomain'); ?>:</label>
			<select id="<?php echo $this->get_field_id( 'contact_1_icon' ); ?>" name="<?php echo $this->get_field_name( 'contact_1_icon' ); ?> class="widefat" style="font-size: 11px;">
				<option<?php selected( $instance['contact_1_icon'], 'No Icon' ); ?>><?php _e('No Icon','academia_textdomain'); ?></option>
				<option<?php selected( $instance['contact_1_icon'], 'Marker' ); ?>><?php _e('Marker','academia_textdomain'); ?></option>
				<option<?php selected( $instance['contact_1_icon'], 'Phone' ); ?>><?php _e('Phone','academia_textdomain'); ?></option>
				<option<?php selected( $instance['contact_1_icon'], 'Fax' ); ?>><?php _e('Fax','academia_textdomain'); ?></option>
				<option<?php selected( $instance['contact_1_icon'], 'Email' ); ?>><?php _e('Email','academia_textdomain'); ?></option>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'contact_2_text' ); ?>" style="display: block; font-size: 11px; font-weight: bold; margin: 0 0 5px;"><?php _e('Contact 2 Text', 'academia_textdomain'); ?>:</label>
			<input id="<?php echo $this->get_field_id( 'contact_2_text' ); ?>" name="<?php echo $this->get_field_name( 'contact_2_text' ); ?>" value="<?php echo $instance['contact_2_text']; ?>" type="text" class="widefat" style="padding: 7px 5px; font-size: 11px;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'contact_2_icon' ); ?>" style="display: block; font-size: 11px; font-weight: bold; margin: 0 0 5px;"><?php _e('Contact 2 Icon', 'academia_textdomain'); ?>:</label>
			<select id="<?php echo $this->get_field_id( 'contact_2_icon' ); ?>" name="<?php echo $this->get_field_name( 'contact_2_icon' ); ?> class="widefat" style="font-size: 11px;">
				<option<?php selected( $instance['contact_2_icon'], 'No Icon' ); ?>><?php _e('No Icon','academia_textdomain'); ?></option>
				<option<?php selected( $instance['contact_2_icon'], 'Marker' ); ?>><?php _e('Marker','academia_textdomain'); ?></option>
				<option<?php selected( $instance['contact_2_icon'], 'Phone' ); ?>><?php _e('Phone','academia_textdomain'); ?></option>
				<option<?php selected( $instance['contact_2_icon'], 'Fax' ); ?>><?php _e('Fax','academia_textdomain'); ?></option>
				<option<?php selected( $instance['contact_2_icon'], 'Email' ); ?>><?php _e('Email','academia_textdomain'); ?></option>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'contact_3_text' ); ?>" style="display: block; font-size: 11px; font-weight: bold; margin: 0 0 5px;"><?php _e('Contact 3 Text', 'academia_textdomain'); ?>:</label>
			<input id="<?php echo $this->get_field_id( 'contact_3_text' ); ?>" name="<?php echo $this->get_field_name( 'contact_3_text' ); ?>" value="<?php echo $instance['contact_3_text']; ?>" type="text" class="widefat" style="padding: 7px 5px; font-size: 11px;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'contact_3_icon' ); ?>" style="display: block; font-size: 11px; font-weight: bold; margin: 0 0 5px;"><?php _e('Contact 3 Icon', 'academia_textdomain'); ?>:</label>
			<select id="<?php echo $this->get_field_id( 'contact_3_icon' ); ?>" name="<?php echo $this->get_field_name( 'contact_3_icon' ); ?> class="widefat" style="font-size: 11px;">
				<option<?php selected( $instance['contact_3_icon'], 'No Icon' ); ?>><?php _e('No Icon','academia_textdomain'); ?></option>
				<option<?php selected( $instance['contact_3_icon'], 'Marker' ); ?>><?php _e('Marker','academia_textdomain'); ?></option>
				<option<?php selected( $instance['contact_3_icon'], 'Phone' ); ?>><?php _e('Phone','academia_textdomain'); ?></option>
				<option<?php selected( $instance['contact_3_icon'], 'Fax' ); ?>><?php _e('Fax','academia_textdomain'); ?></option>
				<option<?php selected( $instance['contact_3_icon'], 'Email' ); ?>><?php _e('Email','academia_textdomain'); ?></option>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'contact_4_text' ); ?>" style="display: block; font-size: 11px; font-weight: bold; margin: 0 0 5px;"><?php _e('Contact 4 Text', 'academia_textdomain'); ?>:</label>
			<input id="<?php echo $this->get_field_id( 'contact_4_text' ); ?>" name="<?php echo $this->get_field_name( 'contact_4_text' ); ?>" value="<?php echo $instance['contact_4_text']; ?>" type="text" class="widefat" style="padding: 7px 5px; font-size: 11px;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'contact_4_icon' ); ?>" style="display: block; font-size: 11px; font-weight: bold; margin: 0 0 5px;"><?php _e('Contact 4 Icon', 'academia_textdomain'); ?>:</label>
			<select id="<?php echo $this->get_field_id( 'contact_4_icon' ); ?>" name="<?php echo $this->get_field_name( 'contact_4_icon' ); ?> class="widefat" style="font-size: 11px;">
				<option<?php selected( $instance['contact_4_icon'], 'No Icon' ); ?>><?php _e('No Icon','academia_textdomain'); ?></option>
				<option<?php selected( $instance['contact_4_icon'], 'Marker' ); ?>><?php _e('Marker','academia_textdomain'); ?></option>
				<option<?php selected( $instance['contact_4_icon'], 'Phone' ); ?>><?php _e('Phone','academia_textdomain'); ?></option>
				<option<?php selected( $instance['contact_4_icon'], 'Fax' ); ?>><?php _e('Fax','academia_textdomain'); ?></option>
				<option<?php selected( $instance['contact_4_icon'], 'Email' ); ?>><?php _e('Email','academia_textdomain'); ?></option>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'contact_5_text' ); ?>" style="display: block; font-size: 11px; font-weight: bold; margin: 0 0 5px;"><?php _e('Contact 5 Text', 'academia_textdomain'); ?>:</label>
			<input id="<?php echo $this->get_field_id( 'contact_5_text' ); ?>" name="<?php echo $this->get_field_name( 'contact_5_text' ); ?>" value="<?php echo $instance['contact_5_text']; ?>" type="text" class="widefat" style="padding: 7px 5px; font-size: 11px;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'contact_5_icon' ); ?>" style="display: block; font-size: 11px; font-weight: bold; margin: 0 0 5px;"><?php _e('Contact 5 Icon', 'academia_textdomain'); ?>:</label>
			<select id="<?php echo $this->get_field_id( 'contact_5_icon' ); ?>" name="<?php echo $this->get_field_name( 'contact_5_icon' ); ?> class="widefat" style="font-size: 11px;">
				<option<?php selected( $instance['contact_5_icon'], 'No Icon' ); ?>><?php _e('No Icon','academia_textdomain'); ?></option>
				<option<?php selected( $instance['contact_5_icon'], 'Marker' ); ?>><?php _e('Marker','academia_textdomain'); ?></option>
				<option<?php selected( $instance['contact_5_icon'], 'Phone' ); ?>><?php _e('Phone','academia_textdomain'); ?></option>
				<option<?php selected( $instance['contact_5_icon'], 'Fax' ); ?>><?php _e('Fax','academia_textdomain'); ?></option>
				<option<?php selected( $instance['contact_5_icon'], 'Email' ); ?>><?php _e('Email','academia_textdomain'); ?></option>
			</select>
		</p>
		
		<?php
	}
}
?>