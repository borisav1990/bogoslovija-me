<ul class="academia-posts academia-posts-archive">

	<?php while (have_posts()) : the_post(); unset($prev); $m++; ?>
	<li <?php post_class('academia-post'); ?>>
	
		<?php
		get_the_image( array( 'size' => 'thumb-loop-main', 'width' => 100, 'height' => 60, 'before' => '<div class="post-cover"><div class="post-cover-wrapper">', 'after' => '</div><!-- .post-cover-wrapper --></div><!-- .post-cover -->' ) );
		?>
		
		<div class="post-content">
			<h2 class="title-s title-post"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
			<p class="post-meta"><time datetime="<?php the_time("Y-m-d"); ?>" pubdate><?php the_time(get_option('date_format')); ?></time> / <span class="category"><?php the_category(', '); ?></span></p>
			<p class="post-excerpt"><?php echo get_the_excerpt(); ?></p>
		</div><!-- .post-content -->
	
		<div class="cleaner">&nbsp;</div>
		
	</li><!-- .academia-post -->
	<?php endwhile; ?>

</ul><!-- .academia-posts -->

<?php get_template_part( 'pagination'); ?>

<?php wp_reset_query(); ?>