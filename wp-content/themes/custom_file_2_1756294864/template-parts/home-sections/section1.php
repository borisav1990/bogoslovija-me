<?php
/**
 * Home Section 1 Template
 *
 * @package Lifeline Hospital
 */

// All section-specific code goes here...

$subsection_title = get_theme_mod('lifeline_hospital_section1_subtitle', 'Explore Our Insights: Expert Healthcare Services Tailored for You');

$lifeline_hospital_section_one = get_theme_mod( 'lifeline_hospital_section1_enable' );
if ( 'Disable' == $lifeline_hospital_section_one ) {
  return;
} ?>

<section id="section1" class="featured-posts">
  <div class="container-fluid">
    <div class="section-heading-main">
      <?php if(get_theme_mod('lifeline_hospital_section1_title',true) != ''){?>
    <h2 class="section-title"><?php echo esc_html(get_theme_mod('lifeline_hospital_section1_title')); ?></h2>
    <?php } ?>
    <p class="section-subtitle mb-6"><?php echo esc_html($subsection_title); ?></p>
    </div>
    <div class="row">
      <?php
        // Define the query to get the latest posts from the "Features" category
        $args = array(
          'category_name' =>  get_theme_mod('lifeline_hospital_section1_category'),
          'posts_per_page' => get_theme_mod('lifeline_hospital_section1_category_number_of_posts_setting'),
          'order' => 'DESC'
        );
        $query = new WP_Query( $args );
        // Loop through the posts
        while ( $query->have_posts() ) : $query->the_post();
      ?>
      <div class="col-lg-4 col-md-4 col-sm-12">
        <div class="post-box-section">
          <?php if ( has_post_thumbnail() ) : ?>
          <div class="post-thumbnail">
            <a href="<?php the_permalink(); ?>">
              <?php the_post_thumbnail(); ?>
            </a>
          </div>
          <?php endif; ?>
          <div class="data-inner">
              <?php if ( get_theme_mod( 'lifeline_hospital_post_meta_toggle_switch_control', true ) ) : ?>
              <div class="sec2-meta">
                <span><?php echo esc_html(get_the_date()); ?></span>
                <span class="separator">|</span>
                <span><?php echo esc_html( get_the_author() ); ?></span>
              </div>
            <?php else : ?>
            <!-- Content to display when the toggle switch is OFF -->
            <?php endif; ?>
            <h2 class="post-title">
              <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
            </h2>
            <!-- Read More Button -->
            <div class="theme-btn">
              <a href="<?php the_permalink(); ?>">Read More</a>
            </div>
          </div>
        </div>
      </div>
      
      <?php endwhile; wp_reset_postdata(); ?>
      
    </div>
  </div>
</section>
