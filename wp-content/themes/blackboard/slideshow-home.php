<?php 
global $academia_options;

$slideshow_autoplay = 0;

if (is_home()) {
	$slideshow_autoplay = $academia_options['academia_gallery_autoplay'];
	$slideshow_speed = $academia_options['academia_gallery_autoplay_speed'];
}

$academia_loop = new WP_Query( array( 
	'order'          => 'DESC',
	'orderby'          => 'date',
	'post__not_in' => get_option( 'sticky_posts' ),
	'posts_per_page' => $academia_options['academia_gallery_page_num'],
	'meta_key' => 'academia_post_featured',
	'meta_value' => 'on'				
) );

$default_image = get_template_directory_uri() . '/images/x.gif';

if ($academia_loop->have_posts()) { ?>

<div id="academia-slideshow" class="flexslider widget">
	<ul class="academia-slides">

		<?php while ( $academia_loop->have_posts() ) : $academia_loop->the_post();
		
		$post_meta = get_post_custom($post->ID);
		if (isset($post_meta['academia_post_featured_title'][0]) && strlen($post_meta['academia_post_featured_title'][0]) > 1) { $slide_title = esc_attr($post_meta['academia_post_featured_title'][0]); } else { $slide_title = get_the_title(); }
		if (isset($post_meta['academia_post_featured_url'][0]) && strlen($post_meta['academia_post_featured_url'][0]) > 1) { $slide_url = esc_attr($post_meta['academia_post_featured_url'][0]); } else { $slide_url = get_permalink($post->ID); }
		?>
		<li class="academia-slide">
		
			<a href="<?php echo $slide_url; ?>"><?php get_the_image( array( 'size' => 'thumb-academia-slideshow', 'width' => 710, 'height' => 350, 'default_image' => $default_image, 'link_to_post' => false ) ); ?></a>
			<h2 class="title-m title-special title-post"><a href="<?php echo $slide_url; ?>"><?php echo $slide_title; ?></a></h2>

		</li><!-- .academia-slide -->
		<?php endwhile; ?>

	</ul><!-- .academia-slides -->
</div><!-- #academia-slideshow .flexslider -->

<script type="text/javascript">
jQuery(document).ready(function() {
	
	jQuery("#academia-slideshow").flexslider({
        selector: ".academia-slides > .academia-slide",
		animationLoop: true,
        initDelay: 1000,
		smoothHeight: false,
		<?php if ($slideshow_autoplay == 1) { ?>
		slideshow: true,
		slideshowSpeed: <?php echo $slideshow_speed; ?>,
		<?php } else { ?>
		slideshow: false,
		<?php } ?>
		pauseOnAction: true,
        controlNav: false,
		directionNav: true,
		useCSS: true,
		touch: false,
        animationSpeed: 500
    });	 

});
</script>
<?php 
} // if there are attachments
elseif (!$academia_loop->have_posts() && current_user_can('edit_theme_options')) { ?>
<div class="widget"><p class="academia-notice">Please mark some posts as "Featured" for the Homepage Slideshow.<br />For more information please <a href="http://www.academiathemes.com/documentation/blackboard/">read the documentation</a></p></div>
<?php } ?>