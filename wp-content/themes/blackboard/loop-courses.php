<table class="taxonomy-table">
	<thead>
		<tr>
			<th><?php _e('Course Title', 'academia_textdomain'); ?></th>
			<th><?php _e('Code', 'academia_textdomain'); ?></th>
			<th><?php _e('Location', 'academia_textdomain'); ?></th>
		</tr>
	</thead>
	
	<tbody>

	<?php 
	$i = 0;
	
	global $wp_query, $academia_options;
	
	// print_r($wp_query);
	
	if ( get_query_var('paged') ) {
		$paged = get_query_var('paged');
	} elseif ( get_query_var('page') ) { 
		$paged = get_query_var('page');
	} else { 
		$paged = 1;
	}
				 
	$args['post_type'] = 'course';
	if (isset($wp_query->queried_object->slug)) { $args[$wp_query->queried_object->taxonomy] = $wp_query->queried_object->slug; }
	if (isset($wp_query->query_vars['s'])) { $args['s'] = sanitize_text_field($wp_query->query_vars['s']); }
	$args['orderby'] = 'title';
	$args['order'] = 'ASC';
	// $args['posts_per_page'] = get_option('posts_per_page');
	$args['posts_per_page'] = $academia_options['academia_courses_perpage'];
	$args['paged'] = $paged;
	
	query_posts($args);

	while (have_posts()) : the_post(); $i++;
	$parentMeta = get_post_custom(); 
	$course_code = $parentMeta['academia_course_code'][0];
	$course_location = $parentMeta['academia_course_location'][0];
	?>

		<tr class="<?php if ($i % 2 == 0) { echo 'row-even'; } else { echo 'row-odd'; } ?>">
			<td class="course-title"><h2 class="title-xs title-post"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2></td>
			<td><?php echo $course_code; ?></td>
			<td><?php echo $course_location; ?></td>
		</tr>
	
	<?php endwhile; ?>

	</tbody>
</table><!-- .taxonomy-table -->

<?php get_template_part( 'pagination'); ?>

<?php wp_reset_query(); ?>