<?php 
global $academia_options;
if ($academia_options['academia_breadcrumbs'] == 1) { ?>
<div class="academia-breadcrumbs">
	<p class="crumbs"><?php academia_breadcrumbs(); ?></p>
</div><!-- .academia-breadcrumbs -->
<?php } ?>