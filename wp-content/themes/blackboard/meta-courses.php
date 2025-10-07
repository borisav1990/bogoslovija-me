<?php
$parentMeta = get_post_custom();
$course_code = $parentMeta['academia_course_code'][0];
$course_location = $parentMeta['academia_course_location'][0];
$course_delivery = $parentMeta['academia_course_delivery'][0];
$course_duration = $parentMeta['academia_course_duration'][0];
$course_credits = $parentMeta['academia_course_credits'][0];
$course_next = $parentMeta['academia_course_next'][0];
$course_contracts = $parentMeta['academia_course_contacts'][0];
?>

<div class="widget">
	<p class="title-s title-widget title-widget-gold title-nomarginbot"><?php _e('Course Information','academia_textdomain'); ?></p>
	
	<ul class="tax-meta-list">
		<?php if (isset($course_code) && strlen($course_code)) { ?>
		<li class="tax-meta-item">
			<span class="tax-label"><?php _e('Course Code','academia_textdomain'); ?>:</span>
			<span class="tax-value"><?php echo $course_code; ?></span> 
		</li><!-- .tax-meta-item -->
		<?php } ?>
		<?php if (isset($course_location) && strlen($course_location)) { ?>
		<li class="tax-meta-item">
			<span class="tax-label"><?php _e('Course Location','academia_textdomain'); ?>:</span>
			<span class="tax-value"><?php echo $course_location; ?></span> 
		</li><!-- .tax-meta-item -->
		<?php } ?>
		<?php if (isset($course_delivery) && strlen($course_delivery)) { ?>
		<li class="tax-meta-item">
			<span class="tax-label"><?php _e('Course Delivery','academia_textdomain'); ?>:</span>
			<span class="tax-value"><?php echo $course_delivery; ?></span> 
		</li><!-- .tax-meta-item -->
		<?php } ?>
		<?php if (isset($course_duration) && strlen($course_duration)) { ?>
		<li class="tax-meta-item">
			<span class="tax-label"><?php _e('Course Duration','academia_textdomain'); ?>:</span>
			<span class="tax-value"><?php echo $course_duration; ?></span> 
		</li><!-- .tax-meta-item -->
		<?php } ?>
		<?php if (isset($course_credits) && strlen($course_credits)) { ?>
		<li class="tax-meta-item">
			<span class="tax-label"><?php _e('Course Credits','academia_textdomain'); ?>:</span>
			<span class="tax-value"><?php echo $course_credits; ?></span> 
		</li><!-- .tax-meta-item -->
		<?php } ?>
		<?php if (isset($course_next) && strlen($course_next)) { ?>
		<li class="tax-meta-item">
			<span class="tax-label"><?php _e('Next Course Intake','academia_textdomain'); ?>:</span>
			<span class="tax-value"><?php echo $course_next; ?></span> 
		</li><!-- .tax-meta-item -->
		<?php } ?>
		<?php if (isset($course_contracts) && strlen($course_contracts)) { ?>
		<li class="tax-meta-item">
			<span class="tax-label"><?php _e('Contacts','academia_textdomain'); ?>:</span>
			<span class="tax-value"><?php echo $course_contracts; ?></span> 
		</li><!-- .tax-meta-item -->
		<?php } ?>
	</ul><!-- .tax-meta-list -->
	
</div><!-- .widget-->