<?php

/*------------------------------------------*/
/* AcademiaThemes: Custom Menu				*/
/*------------------------------------------*/
 
/**
 * Navigation Menu widget class
 *
 * @since 3.0.0
 */
 class academia_nav_menu_widget extends WP_Widget {

	public function __construct() {

		parent::__construct(
			'academia-menu-widget',
			__( 'Academia: Custom Menu', 'academia_textdomain' ),
			array(
				'classname'   => 'widget_nav_menu',
				'description' => __( 'Use this widget to add one of your custom menus as a widget.', 'academia_textdomain' )
			)
		);

	}

	function widget($args, $instance) {
		extract($args);
		// Get menu
		$nav_menu = ! empty( $instance['nav_menu'] ) ? wp_get_nav_menu_object( $instance['nav_menu'] ) : false;

		if ( !$nav_menu )
			return;

		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
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

		if ( $title ) { 
			echo $before_title;

				echo $title;

			echo $after_title;
		}

		wp_nav_menu( array( 'fallback_cb' => '', 'menu' => $nav_menu ) );

		echo $args['after_widget'];
	}

	function update( $new_instance, $old_instance ) {
		$instance['title'] = strip_tags( stripslashes($new_instance['title']) );
		$instance['nav_menu'] = (int) $new_instance['nav_menu'];
		$instance['widget_style'] = strip_tags($new_instance['widget_style']);
		return $instance;
	}

	function form( $instance ) {
		$title = isset( $instance['title'] ) ? $instance['title'] : '';
		$widget_style = strip_tags($instance['widget_style']);
		$nav_menu = isset( $instance['nav_menu'] ) ? $instance['nav_menu'] : '';

		// Get menus
		$menus = get_terms( 'nav_menu', array( 'hide_empty' => false ) );

		// If no menus exists, direct the user to go and create some.
		if ( !$menus ) {
			echo '<p>'. sprintf( __('No menus have been created yet. <a href="%s">Create some</a>.', 'academia_textdomain'), admin_url('nav-menus.php') ) .'</p>';
			return;
		}
		?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'academia_textdomain') ?>:</label>
			<input type="text" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $title; ?>" class="widefat" style="padding: 7px 5px; font-size: 11px;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'nav_menu' ); ?>" style="display: block; font-size: 11px; font-weight: bold; margin: 0 0 5px;"><?php _e('Select Menu', 'academia_textdomain'); ?>:</label>
			<select id="<?php echo $this->get_field_id('nav_menu'); ?>" name="<?php echo $this->get_field_name('nav_menu'); ?>" class="widefat" style="font-size: 11px;">
		<?php
			foreach ( $menus as $menu ) {
				echo '<option value="' . $menu->term_id . '"'
					. selected( $nav_menu, $menu->term_id, false )
					. '>'. $menu->name . '</option>';
			}
		?>
			</select>
		</p>
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
		<?php
	}
}

add_action('widgets_init', create_function('', 'return register_widget("academia_nav_menu_widget");'));