<?php
/**
 * Home Section 1 Template
 *
 * @package Lifeline Hospital
 */

// All section-specific code goes here...


$lifeline_hospital_section_one = get_theme_mod('lifeline_hospital_section_banner');
if ('Disable' == $lifeline_hospital_section_one) {
    return;
}
?>

<section id="banner-section-first">
        <div class="main-banner-main">
            <?php if(get_theme_mod('lifeline_hospital_section_bannerimage_section')!=''){ ?>
                    <img src="<?php echo esc_url(get_theme_mod('lifeline_hospital_section_bannerimage_section')); ?>" alt="<?php esc_attr_e('Image', 'lifeline-hospital'); ?>">
                <div class="text-box">
                    <h2><?php echo esc_html(get_theme_mod('lifeline_hospital_section_bannerimage_section_title')); ?></h2>
                    <p><?php echo esc_html(get_theme_mod('lifeline_hospital_section_bannerimage_section_text')); ?></p>


                    <?php if(get_theme_mod('lifeline_hospital_banner_btn_text')!=''){ ?>
                        <div class="theme-btn">
                          <a href="<?php echo esc_url(get_theme_mod('lifeline_hospital_banner_btn_text_url')); ?>"><?php echo esc_html(get_theme_mod('lifeline_hospital_banner_btn_text')); ?></a>
                        </div>
                  <?php } ?>
                </div>
            <?php } ?>
        </div>
</section>
