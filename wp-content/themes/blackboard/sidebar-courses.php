<?php get_template_part('tax-course-type'); ?>

<?php if (is_active_sidebar('sidebar')) { ?>
<div class="aside-wrapper">
	<?php
	if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Sidebar') ) : ?> <?php endif;
	?>
	<div class="cleaner">&nbsp;</div>
</div><!-- .aside-wrapper -->
<?php } ?>

<div class="cleaner">&nbsp;</div>