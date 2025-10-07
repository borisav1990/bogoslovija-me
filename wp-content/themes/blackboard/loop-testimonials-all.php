<?php 
global $academia_options;

if ( get_query_var('paged') ) {
	$paged = get_query_var('paged');
} elseif ( get_query_var('page') ) { 
	$paged = get_query_var('page');
} else { 
	$paged = 1;
}
 
$academia_loop = new WP_Query( array( 'post_type' => 'testimonial', 'paged' => $paged ) );

if ($academia_loop->have_posts()) {
	$i = 0;
	?>

<ul class="academia-testimonials">

	<?php while ( $academia_loop->have_posts() ) : $academia_loop->the_post(); $i++; 

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
					<h2 class="title-s title-post"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
					<?php the_content(); ?>
				</div><!-- .post-excerpt -->
				<div class="cleaner">&nbsp;</div>
			</blockquote><!-- .academia-testimonial-quote -->

			<figcaption class="academia-author"><?php if ($testimonial_author) { echo "<strong>$testimonial_author</strong>, "; } ?>
			<?php if ($testimonial_country) { echo "$testimonial_country"; } ?>
			<?php if ($testimonial_date) { echo " &mdash; $testimonial_date"; } ?></figcaption>

		</figure>
	</li><!-- .academia-testimonial -->
	<?php endwhile; ?>

</ul><!-- .academia-testimonials -->
<div class="cleaner">&nbsp;</div>
	<?php 
	} // if there are pages
wp_reset_query();
?>