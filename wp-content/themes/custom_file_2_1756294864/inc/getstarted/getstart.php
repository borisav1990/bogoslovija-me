<?php

// about theme info
add_action( 'admin_menu', 'lifeline_hospital_gettingstarted_page' );
function lifeline_hospital_gettingstarted_page() {      
    add_theme_page( esc_html__('Lifeline Hospital', 'lifeline-hospital'), esc_html__('All About Lifeline Hospital', 'lifeline-hospital'), 'edit_theme_options', 'lifeline_hospital_mainpage', 'lifeline_hospital_main_content');   
}

function lifeline_hospital_notice(){
    global $pagenow;
    if ( is_admin() && ('themes.php' == $pagenow) && isset( $_GET['activated'] ) ) {?>
    <div class="notice notice-success is-dismissible getting_started">
        <div class="notice-content">
            <p><?php esc_html_e('Thanks For Choosing CA WP Themes', 'lifeline-hospital'); ?></p>
            <h2><?php esc_html_e('Thanks for installing Lifeline Hospital Free Theme!', 'lifeline-hospital'); ?></h2>
            <p><?php esc_html_e('Please Click on the link below to Check The Full Theme Edit Documentation', 'lifeline-hospital'); ?></p>
            <div class="info-link">
                <a href="<?php echo esc_url( lifeline_hospital_PRO_DOCUMENTATION ); ?>" target="_blank" class="button button-primary"> <?php esc_html_e('Documentation', 'lifeline-hospital'); ?></a>
            </div>
            <h2><?php esc_html_e('Now the Premium Version is only at $39.99 with Lifetime Access!Grab the deal now!', 'lifeline-hospital'); ?></h2>
            <h2><?php esc_html_e('Check The Pro Version: Lifeline Hospital Premium WordPress Theme for Amazing Features for Unlimited Site', 'lifeline-hospital'); ?></h2>
            <div class="info-link">
                <a href="<?php echo esc_url( lifeline_hospital_PRO_URL ); ?>" target="_blank" class="button button-primary"> <?php esc_html_e('Upgrade to Pro', 'lifeline-hospital'); ?></a>
            </div>
            <div class="info-link">
                <a href="<?php echo esc_url( lifeline_hospital_PRO_DEMO ); ?>" target="_blank" class="button button-primary"> <?php esc_html_e('Premium Demo', 'lifeline-hospital'); ?></a>
            </div>

        </div>
    </div>
    <?php }
}
add_action('admin_notices', 'lifeline_hospital_notice');

// Add a Custom CSS file to WP Admin Area
function lifeline_hospital_admin_page_theme_style() {
   wp_enqueue_style('lifeline-hospital-custom-admin-style', esc_url(get_template_directory_uri()) . '/inc/getstarted/getstarted.css');
}
add_action('admin_enqueue_scripts', 'lifeline_hospital_admin_page_theme_style');

// About Theme Info
function lifeline_hospital_main_content() { 

    // Custom function about theme customizer

    $return = add_query_arg( array()) ;
    $theme = wp_get_theme( 'lifeline-hospital' );
?>

<div class="admin-main-box">
    <div class="admin-left-box">
        <h2><?php esc_html_e('Welcome to Lifeline Hospital Theme', 'lifeline-hospital'); ?> <span class="version"><?php $theme_info = wp_get_theme();
echo $theme_info->get( 'Version' );?></span></h2>
        <p><?php esc_html_e('CA WP Themes is a premium WordPress theme development company that provides high-quality themes for various types of websites. They specialize in creating themes for businesses, eCommerce, portfolios, blogs, and many more. Their themes are easy to use and customize, making them perfect for those who want to create a professional-looking website without any coding skills.', 'lifeline-hospital'); ?></p>
        <p><?php esc_html_e('CA WP Themes offers a wide range of themes that are designed to be responsive and compatible with the latest versions of WordPress. Our themes are also SEO optimized, ensuring that your website will rank well on search engines. They come with a variety of features such as customizable widgets, social media integration, and custom page templates.', 'lifeline-hospital'); ?></p>
        <p><?php esc_html_e('One of the unique things about CA WP Themes is their focus on providing excellent customer support. They have a dedicated team of support staff who are available 24/7 to help customers with any issues they may encounter. Their support team is knowledgeable and friendly, ensuring that customers receive the best possible experience.', 'lifeline-hospital'); ?></p>
    </div>
    <div class="admin-right-box">
        <div class="admin_text-btn">
            <h4><?php esc_html_e('Buy Lifeline Hospital Premium Theme', 'lifeline-hospital'); ?></h4>
            <p><?php esc_html_e('Now the Premium Version is only at $39.99 with Lifetime Access!Grab the deal now!', 'lifeline-hospital'); ?></p>
            <div class="info-link">
                <a href="<?php echo esc_url( lifeline_hospital_PRO_URL ); ?>" target="_blank" class="button button-primary"> <?php esc_html_e('Upgrade to Pro', 'lifeline-hospital'); ?></a>
            </div>
        </div>
        <hr>
        <div class="admin_text-btn">
            <h4><?php esc_html_e('Premium Theme Demo', 'lifeline-hospital'); ?></h4>
            <div class="info-link">
                <a href="<?php echo esc_url( lifeline_hospital_PRO_DEMO ); ?>" target="_blank" class="button button-primary"> <?php esc_html_e('Demo', 'lifeline-hospital'); ?></a>
            </div>
        </div>
        <hr>
        <div class="admin_text-btn">
            <h4><?php esc_html_e('Need Support? / Contact Us', 'lifeline-hospital'); ?></h4>
            <div class="info-link">
                <a href="<?php echo esc_url( lifeline_hospital_PRO_SUPPORT ); ?>" target="_blank" class="button button-primary"> <?php esc_html_e('Contact Us', 'lifeline-hospital'); ?></a>
            </div>
        </div>
        <hr>
        <div class="admin_text-btn">
            <h4><?php esc_html_e('Documentation', 'lifeline-hospital'); ?></h4>
            <div class="info-link">
                <a href="<?php echo esc_url( lifeline_hospital_PRO_DOCUMENTATION ); ?>" target="_blank" class="button button-primary"> <?php esc_html_e('Docs', 'lifeline-hospital'); ?></a>
            </div>
        </div>
        <hr>
        <div class="admin_text-btn">
            <h4><?php esc_html_e('Free Theme', 'lifeline-hospital'); ?></h4>
            <div class="info-link">
                <a href="<?php echo esc_url( lifeline_hospital_FREE_URL ); ?>" target="_blank" class="button button-primary"> <?php esc_html_e('Demo', 'lifeline-hospital'); ?></a>
            </div>
        </div>

    </div>
</div>

<?php } ?>