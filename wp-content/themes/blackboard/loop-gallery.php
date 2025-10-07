<?php 
global $academia_options;

$args = array(
	'order'          => 'ASC',
	'orderby'          => 'menu_order',
	'post_type'      => 'attachment',
	'post_parent'    => $post->ID,
	'post_mime_type' => 'image',
	'post_status'    => null,
	'numberposts'    => -1
);
$attachments = get_posts($args);

$i = 0;

if (count($attachments) > 0) { ?>

<ul class="academia-gallery-list">

<?php foreach ($attachments as $attachment) { 
	$i++;
	$image_data = wp_get_attachment_image_src( $attachment->ID, 'large' ); 
	?>
	<li class="academia-gallery-item gallery-item-<?php echo $i; if ($i % 3 == 1) { echo ' gallery-item-first';} ?>">

		<div class="academia-gallery-item-wrapper">
		
			<div class="post-cover">
				<a href="<?php echo $image_data[0]; ?>" class="thickbox" title="<?php echo apply_filters( 'the_title', $attachment->post_title ); ?>" rel="academia-gallery"><?php echo wp_get_attachment_image( $attachment->ID, 'thumb-loop-gallery', false, array('class' => 'academia-loop-img') ); ?></a>
			</div><!-- .post-cover -->
			
			<div class="post-excerpt">
				<p><?php echo apply_filters( 'the_title', $attachment->post_title ); ?></p>
			</div><!-- .post-excerpt -->
			<div class="cleaner">&nbsp;</div>
		
		</div><!-- .academia-gallery-item-wrapper -->
		
	</li><!-- .academia-gallery-item -->
<?php 
	if ($i == 3) { $i = 0; } // reset the counter to zero
} // foreach ?>

</ul><!-- .academia-gallery-list -->

<div class="cleaner">&nbsp;</div>

<?php 
wp_reset_query();
} // if there are attachments

	$parent_id = $post->post_parent;
	
	if ($parent_id == 0) {
		$child_of = $post->ID;
	} // if no parent
	
	if ($child_of) {

		$children_pages = get_pages( array( 'child_of' => $child_of, 'parent' => $child_of, 'sort_column' => 'menu_order', 'sort_order' => 'ASC' ) );
		
		if (count($children_pages) > 0) {
			
			foreach ($children_pages as $page) {
				
				echo'<h2 class="title-s title-widget title-widget-gold"><a href="' . get_page_link( $page->ID ) . '">' . $page->post_title . '</a></h2>';

				$args = array(
					'order'          => 'ASC',
					'orderby'          => 'menu_order',
					'post_type'      => 'attachment',
					'post_parent'    => $page->ID,
					'post_mime_type' => 'image',
					'post_status'    => null,
					'numberposts'    => -1
				);
				$attachments = get_posts($args);
				
				$i = 0;

				if (count($attachments) > 0) { ?>
				
				<ul class="academia-gallery-list">
				
				<?php foreach ($attachments as $attachment) { 
					$i++;
					$image_data = wp_get_attachment_image_src( $attachment->ID, 'large' ); 
					?>
					<li class="academia-gallery-item gallery-item-<?php echo $i; if ($i % 3 == 1) { echo ' gallery-item-first';} ?>">
				
						<div class="academia-gallery-item-wrapper">
						
							<div class="post-cover">
								<a href="<?php echo $image_data[0]; ?>" class="thickbox" title="<?php echo apply_filters( 'the_title', $attachment->post_title ); ?>" rel="academia-gallery"><?php echo wp_get_attachment_image( $attachment->ID, 'thumb-loop-gallery', false, array('class' => 'academia-loop-img') ); ?></a>
							</div><!-- .post-cover -->
							
							<div class="post-excerpt">
								<p><?php echo apply_filters( 'the_title', $attachment->post_title ); ?></p>
							</div><!-- .post-excerpt -->
							<div class="cleaner">&nbsp;</div>
						
						</div><!-- .academia-gallery-item-wrapper -->
						
					</li><!-- .academia-gallery-item -->
				<?php 
					if ($i == 3) { $i = 0; } // reset the counter to zero
				} // foreach ?>
				
				</ul><!-- .academia-gallery-list -->
				
				<div class="cleaner">&nbsp;</div>
				
				<?php 
				wp_reset_query();
				} // if there are attachments
			
			} // foreach sub-page of the gallery
			
		}
	
		wp_reset_query();
	
	}
	
?>