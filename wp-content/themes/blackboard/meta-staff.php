<?php
$parentMeta = get_post_custom();
$staff_position = $parentMeta['academia_staff_position'][0];
$staff_location = $parentMeta['academia_staff_location'][0];
$staff_title = $parentMeta['academia_staff_personal_title'][0];
$staff_telephone = $parentMeta['academia_staff_telephone'][0];
$staff_email = $parentMeta['academia_staff_email'][0];
?>

<div class="widget">
	<p class="title-s title-widget title-widget-gold title-nomarginbot"><?php _e('Contact Information','academia_textdomain'); ?></p>
	
	<ul class="tax-meta-list">
		<?php if (isset($staff_position) && strlen($staff_position)) { ?>
		<li class="tax-meta-item">
			<span class="tax-label"><?php _e('Position Title','academia_textdomain'); ?>:</span>
			<span class="tax-value"><?php echo $staff_position; ?></span> 
		</li><!-- .tax-meta-item -->
		<?php } ?>
		<?php if (isset($staff_title) && strlen($staff_title)) { ?>
		<li class="tax-meta-item">
			<span class="tax-label"><?php _e('Personal Title','academia_textdomain'); ?>:</span>
			<span class="tax-value"><?php echo $staff_title; ?></span> 
		</li><!-- .tax-meta-item -->
		<?php } ?>
		<?php if (isset($staff_location) && strlen($staff_location)) { ?>
		<li class="tax-meta-item">
			<span class="tax-label"><?php _e('Location','academia_textdomain'); ?>:</span>
			<span class="tax-value"><?php echo $staff_location; ?></span> 
		</li><!-- .tax-meta-item -->
		<?php } ?>
		<?php if (isset($staff_telephone) && strlen($staff_telephone)) { ?>
		<li class="tax-meta-item">
			<span class="tax-label"><?php _e('Telephone number','academia_textdomain'); ?>:</span>
			<span class="tax-value"><?php echo $staff_telephone; ?></span> 
		</li><!-- .tax-meta-item -->
		<?php } ?>
		<?php if (isset($staff_email) && strlen($staff_email)) { ?>
		<li class="tax-meta-item">
			<span class="tax-label"><?php _e('E-mail address','academia_textdomain'); ?>:</span>
			<span class="tax-value"><?php echo $staff_email; ?></span> 
		</li><!-- .tax-meta-item -->
		<?php } ?>
	</ul><!-- .course-meta-list -->
	
</div><!-- .widget-->