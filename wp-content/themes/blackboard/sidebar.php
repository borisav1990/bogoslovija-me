<?php if (is_page() || is_page_template()) { get_template_part('related-pages'); } ?>

<?php if (is_active_sidebar('sidebar')) { ?>
<div class="aside-wrapper">
	<?php
	if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Sidebar: Left') ) : ?> <?php endif;
	?>
	<div class="cleaner">&nbsp;</div>
</div><!-- .aside-wrapper -->
<?php } ?>

<div class="cleaner">&nbsp;</div>