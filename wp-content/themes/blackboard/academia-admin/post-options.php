<?php
 
/*----------------------------------*/
/* Custom Posts Options				*/
/*----------------------------------*/

add_action('admin_menu', 'academia_options_box');

function academia_options_box() {
	
	add_meta_box('academia_post_slideshow', 'Slideshow Options', 'academia_post_slideshow', 'post', 'side', 'high');

	$template_file = '';
	
	add_meta_box('academia_course_options', 'Course Options', 'academia_course_options', 'course', 'side', 'high');
	add_meta_box('academia_staff_options', 'Staff Options', 'academia_staff_options', 'staff', 'side', 'high');
	add_meta_box('academia_testimonial_options', 'Testimonial Options', 'academia_testimonial_options', 'testimonial', 'side', 'high');
	
	// get the id of current post/page
	if (isset($_GET['post']) || isset($_GET['post']) || isset($_POST['post_ID'])) {
		$post_id = $_GET['post'] ? $_GET['post'] : $_POST['post_ID'];
	}

	// get the template file used (if a page)
	if (isset($post_id)) {
		$template_file = get_post_meta($post_id,'_wp_page_template',TRUE);
	}
	
	// if we are using the events.php page template, add additional meta boxes
	if ( isset($template_file) && ($template_file == 'page-templates/events.php') ) {
		add_meta_box('academia_events_template', 'Events Options', 'academia_events_options', 'page', 'side', 'high');
	}
	
}

add_action('save_post', 'custom_add_save');

function custom_add_save($postID){
	
	$academia_options = academia_get_global_options(); // get all options saved in Theme Options
	
	// called after a post or page is saved
	if($parent_id = wp_is_post_revision($postID))
	{
		$postID = $parent_id;
	}
	
	if (isset($_POST['saveSlideshow'])) {
		update_custom_meta($postID, $_POST['academia_post_featured'], 'academia_post_featured');
		update_custom_meta($postID, $_POST['academia_post_featured_title'], 'academia_post_featured_title');
		update_custom_meta($postID, $_POST['academia_post_featured_url'], 'academia_post_featured_url');
	}
	if (isset($_POST['saveCourse'])) {
		update_custom_meta($postID, $_POST['academia_course_code'], 'academia_course_code');
		update_custom_meta($postID, $_POST['academia_course_location'], 'academia_course_location');
		update_custom_meta($postID, $_POST['academia_course_delivery'], 'academia_course_delivery');
		update_custom_meta($postID, $_POST['academia_course_duration'], 'academia_course_duration');
		update_custom_meta($postID, $_POST['academia_course_credits'], 'academia_course_credits');
		update_custom_meta($postID, $_POST['academia_course_next'], 'academia_course_next');
		update_custom_meta($postID, $_POST['academia_course_contacts'], 'academia_course_contacts');
	}
	if (isset($_POST['saveEvents'])) {
		update_custom_meta($postID, $_POST['academia_events_type'], 'academia_events_type');
	}
	if (isset($_POST['saveStaff'])) {
		update_custom_meta($postID, $_POST['academia_staff_position'], 'academia_staff_position');
		update_custom_meta($postID, $_POST['academia_staff_location'], 'academia_staff_location');
		update_custom_meta($postID, $_POST['academia_staff_personal_title'], 'academia_staff_personal_title');
		update_custom_meta($postID, $_POST['academia_staff_telephone'], 'academia_staff_telephone');
		update_custom_meta($postID, $_POST['academia_staff_email'], 'academia_staff_email');
	}
	if (isset($_POST['saveTestimonial'])) {
		update_custom_meta($postID, $_POST['academia_testimonial_author'], 'academia_testimonial_author');
		update_custom_meta($postID, $_POST['academia_testimonial_country'], 'academia_testimonial_country');
		update_custom_meta($postID, $_POST['academia_testimonial_date'], 'academia_testimonial_date');
	}

}

function update_custom_meta($postID, $newvalue, $field_name) {
	// To create new meta
	if(!get_post_meta($postID, $field_name)){
		add_post_meta($postID, $field_name, $newvalue);
	}else{
		// or to update existing meta
		update_post_meta($postID, $field_name, $newvalue);
	}
	
}

// Slideshow-Related Post Options
function academia_post_slideshow() {
	global $post;
	?>
	<fieldset>
		<input type="hidden" name="saveSlideshow" id="saveSlideshow" value="1" />
		<div>
			
			<p>
				<input class="checkbox" type="checkbox" id="academia_post_featured" name="academia_post_featured" value="on" <?php checked( get_post_meta($post->ID, 'academia_post_featured', true), 'on' ); ?>
 				<label for="academia_post_featured"> <?php _e('Feature Post in Slideshow on Homepage','academia_textdomain'); ?></label><br />
			</p>

			<p>
				<label for="academia_post_featured_title"><?php _e('Custom Title', 'academia_textdomain'); ?> <em><?php _e('(optional)', 'academia_textdomain'); ?></em>:</label><br />
				<input type="text" style="width:90%;" name="academia_post_featured_title" id="academia_post_featured_title" value="<?php echo get_post_meta($post->ID, 'academia_post_featured_title', true); ?>"><br />
				<span class="description">Use this to use a custom post title</span>
			</p>			

			<p>
				<label for="academia_post_featured_url"><?php _e('Custom URL', 'academia_textdomain'); ?> <em><?php _e('(optional)', 'academia_textdomain'); ?></em>:</label><br />
				<input type="text" style="width:90%;" name="academia_post_featured_url" id="academia_post_featured_url" value="<?php echo get_post_meta($post->ID, 'academia_post_featured_url', true); ?>"><br />
				<span class="description">Use this to link to a custom post/page</span>
			</p>
			
			<!--<div style="border-top: solid 1px #ddd; font-size: 1px; line-height: 1px; height: 1px; margin: 5px 0;">&nbsp;</div>-->

  		</div>
	</fieldset>
	<?php
}

// Course Options
function academia_course_options() {
	global $post;
	?>
	<fieldset>
		<input type="hidden" name="saveCourse" id="saveCourse" value="1" />
		<div>
			<p>
				<label for="academia_course_code"><?php _e('Code', 'academia_textdomain'); ?>:</label><br />
				<input type="text" style="width:90%;" name="academia_course_code" id="academia_course_code" value="<?php echo get_post_meta($post->ID, 'academia_course_code', true); ?>"><br />
				<span class="description">Example: ARCH-123</span>
			</p>
			<p>
				<label for="academia_course_location"><?php _e('Location', 'academia_textdomain'); ?>:</label><br />
				<input type="text" style="width:90%;" name="academia_course_location" id="academia_course_location" value="<?php echo get_post_meta($post->ID, 'academia_course_location', true); ?>"><br />
			</p>
			<p>
				<label for="academia_course_delivery"><?php _e('Delivery mode', 'academia_textdomain'); ?>:</label><br />
				<input type="text" style="width:90%;" name="academia_course_delivery" id="academia_course_delivery" value="<?php echo get_post_meta($post->ID, 'academia_course_delivery', true); ?>"><br />
				<span class="description">Example: On Campus</span>
			</p>
			<p>
				<label for="academia_course_duration"><?php _e('Duration', 'academia_textdomain'); ?>:</label><br />
				<input type="text" style="width:90%;" name="academia_course_duration" id="academia_course_duration" value="<?php echo get_post_meta($post->ID, 'academia_course_duration', true); ?>"><br />
			</p>
			<p>
				<label for="academia_course_credits"><?php _e('Credits', 'academia_textdomain'); ?>:</label><br />
				<input type="text" style="width:90%;" name="academia_course_credits" id="academia_course_credits" value="<?php echo get_post_meta($post->ID, 'academia_course_credits', true); ?>"><br />
			</p>
			<p>
				<label for="academia_course_next"><?php _e('Next intake', 'academia_textdomain'); ?>:</label><br />
				<input type="text" style="width:90%;" name="academia_course_next" id="academia_course_next" value="<?php echo get_post_meta($post->ID, 'academia_course_next', true); ?>"><br />
				<span class="description">Example: April (Trimester 1), August (Trimester 2)</span>
			</p>
			<p>
				<label for="academia_course_contacts"><?php _e('Contacts', 'academia_textdomain'); ?>:</label><br />
				<input type="text" style="width:90%;" name="academia_course_contacts" id="academia_course_contacts" value="<?php echo get_post_meta($post->ID, 'academia_course_contacts', true); ?>"><br />
				<span class="description">Example: +(0-800) 1234 5678</span>
			</p>
  		</div>
	</fieldset>
	<?php
	}

// Regular Posts Options
function academia_events_options() {
	global $post;
	?>
	<fieldset>
		<input type="hidden" name="saveEvents" id="saveEvents" value="1" />
		<div>
			
			<p>
 				<label for=""><?php _e('What events to display', 'academia_textdomain'); ?>:</label><br />
				<select name="academia_events_type" id="academia_events_type">
					<option<?php selected( get_post_meta($post->ID, 'academia_events_type', true), 'Future' ); ?>><?php _e('Future','academia_textdomain'); ?></option>
					<option<?php selected( get_post_meta($post->ID, 'academia_events_type', true), 'Past' ); ?>><?php _e('Past','academia_textdomain'); ?></option>
				</select>
			</p>
			
  		</div>
	</fieldset>
	<?php
}

// Staff Options
function academia_staff_options() {
	global $post;
	?>
	<fieldset>
		<input type="hidden" name="saveStaff" id="saveStaff" value="1" />
		<div>
			<p>
				<label for="academia_staff_position"><?php _e('Position Title', 'academia_textdomain'); ?>:</label><br />
				<input type="text" style="width:90%;" name="academia_staff_position" id="academia_staff_position" value="<?php echo get_post_meta($post->ID, 'academia_staff_position', true); ?>"><br />
			</p>
			<p>
				<label for="academia_staff_location"><?php _e('Location', 'academia_textdomain'); ?>:</label><br />
				<input type="text" style="width:90%;" name="academia_staff_location" id="academia_staff_location" value="<?php echo get_post_meta($post->ID, 'academia_staff_location', true); ?>"><br />
				<span class="description"><?php _e('Location', 'academia_textdomain'); ?></span>
			</p>
			<p>
				<label for="academia_staff_personal_title"><?php _e('Personal Title', 'academia_textdomain'); ?>:</label><br />
				<input type="text" style="width:90%;" name="academia_staff_personal_title" id="academia_staff_personal_title" value="<?php echo get_post_meta($post->ID, 'academia_staff_personal_title', true); ?>"><br />
				<span class="description"><?php _e('Example: On Campus', 'academia_textdomain'); ?></span>
			</p>
			<p>
				<label for="academia_staff_telephone"><?php _e('Telephone Number', 'academia_textdomain'); ?>:</label><br />
				<input type="text" style="width:90%;" name="academia_staff_telephone" id="academia_staff_telephone" value="<?php echo get_post_meta($post->ID, 'academia_staff_telephone', true); ?>"><br />
			</p>
			<p>
				<label for="academia_staff_email"><?php _e('Email Address', 'academia_textdomain'); ?>:</label><br />
				<input type="text" style="width:90%;" name="academia_staff_email" id="academia_staff_email" value="<?php echo get_post_meta($post->ID, 'academia_staff_email', true); ?>"><br />
			</p>
  		</div>
	</fieldset>
	<?php
	}
	
// Testimonials Options
function academia_testimonial_options() {
	global $post;
	?>
	<fieldset>
		<input type="hidden" name="saveTestimonial" id="saveTestimonial" value="1" />
		<div>
			<p>
				<label for="academia_testimonial_author"><?php _e('Testimonial Author', 'academia_textdomain'); ?>:</label><br />
				<input type="text" style="width:90%;" name="academia_testimonial_author" id="academia_testimonial_author" value="<?php echo get_post_meta($post->ID, 'academia_testimonial_author', true); ?>"><br />
			</p>
			<p>
				<label for="academia_testimonial_country"><?php _e('Author Location', 'academia_textdomain'); ?>:</label><br />
				<input type="text" style="width:90%;" name="academia_testimonial_country" id="academia_testimonial_country" value="<?php echo get_post_meta($post->ID, 'academia_testimonial_country', true); ?>"><br />
				<span class="description"><?php _e('Example: Rome, Italy', 'academia_textdomain'); ?></span>
			</p>
			<p>
				<label for="academia_testimonial_date"><?php _e('Testimonial Date', 'academia_textdomain'); ?>:</label><br />
				<input type="text" style="width:90%;" name="academia_testimonial_date" id="academia_testimonial_date" value="<?php echo get_post_meta($post->ID, 'academia_testimonial_date', true); ?>"><br />
				<span class="description"><?php _e('Example: 15th December, 2012', 'academia_textdomain'); ?></span>
			</p>
			
  		</div>
	</fieldset>
	<?php
	}