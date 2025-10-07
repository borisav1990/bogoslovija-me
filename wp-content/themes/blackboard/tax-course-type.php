<div class="widget widget_nav_menu">
	<p class="title-s title-widget title-widget-gold"><?php _e('Course Types','academia_textdomain'); ?></p>
	
	<?php

	$args = array( 'taxonomy' => 'course-type', 'orderby' => 'name', 'order' => 'ASC', 'hide_empty' => 1 );
	$terms = get_terms('course-type', $args);
	
	$count = count($terms); $i=0;
	if ($count > 0) {
		
		$term_list = '<ul class="tax-meta-list">';
		
		$queried_object = get_queried_object();
		$current_tax = $queried_object->slug;
		
		foreach ($terms as $term) {
			
			$i++;
			$term_list .= '<li class="tax-meta-item menu-item';
			if ($current_tax == $term->slug) { $term_list .=' current-menu-item'; }
			$term_list .='"><a href="' . get_term_link( $term ) . '" title="' . the_title_attribute('echo=0') . '">' . $term->name . '</a> ('. $term->count .')</li><!-- .tax-meta-item -->';
			if ($count == $i) { $term_list .= '</ul><!-- .tax-meta-list -->'; }
		}
		
		echo $term_list;
	}
	?>
	
</div><!-- .widget-->