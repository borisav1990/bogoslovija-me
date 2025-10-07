<?php 
$child_of = $post->ID;
$loop = new WP_Query( array( 'post_parent' => $child_of, 'post_type' => 'page', 'nopaging' => 1, 'orderby' => 'menu_order', 'order' => 'ASC' ) );

if ($loop->have_posts()) {
$i = 0;
?>

<ul class="academia-posts academia-posts-archive">

	<?php while ( $loop->have_posts() ) : $loop->the_post(); ?>
	<li <?php post_class('academia-post'); ?>>
	
		<?php
		get_the_image( array( 'size' => 'thumb-loop-main', 'width' => 100, 'height' => 60, 'before' => '<div class="post-cover"><div class="post-cover-wrapper">', 'after' => '</div><!-- .post-cover-wrapper --></div><!-- .post-cover -->' ) );
		?>
		
		<div class="post-content">
			<h2 class="title-s title-post"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
			<p class="post-excerpt"><?php echo get_the_excerpt(); ?></p>
		</div><!-- .post-content -->
	
		<div class="cleaner">&nbsp;</div>
		
	</li><!-- .academia-post -->
	<?php endwhile; ?>

</ul><!-- .academia-posts -->

<?php } ?>

<div class="cleaner">&nbsp;</div>

<?php wp_reset_query(); ?>