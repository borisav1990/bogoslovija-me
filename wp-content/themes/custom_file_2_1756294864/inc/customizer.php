<?php
/**
 * Add custom settings and controls to the WordPress Customizer
 */


//----------- Code to add the Upgrade to Pro button in the Customizer ----------

function lifeline_hospital_customize_register_btn( $wp_customize ) {
    $wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
    $wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
    $wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

    include get_template_directory() . '/inc/customizer-button/upsell-section.php';

    if ( isset( $wp_customize->selective_refresh ) ) {
        $wp_customize->selective_refresh->add_partial( 'blogname', array(
            'selector'        => '.site-title a',
            'render_callback' => 'lifeline_hospital_customize_partial_blogname',
        ) );
        $wp_customize->selective_refresh->add_partial( 'blogdescription', array(
            'selector'        => '.site-description',
            'render_callback' => 'lifeline_hospital_customize_partial_blogdescription',
        ) );
    }

    $wp_customize->register_section_type( 'lifeline_hospital_Customize_Upsell_Section' );

    // Register section.
    $wp_customize->add_section(
        new lifeline_hospital_Customize_Upsell_Section(
            $wp_customize,
            'theme_upsell',
            array(
                'title'    => esc_html__( 'Lifeline Hospital Pro', 'lifeline-hospital' ),
                'pro_text' => esc_html__( 'Upgrade To Pro', 'lifeline-hospital' ),
                'pro_url'  => 'https://cawpthemes.com/lifeline-hospital-premium-wordpress-theme/',
                'priority' => 1,
            )
        )
    );
}
add_action( 'customize_register', 'lifeline_hospital_customize_register_btn' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function lifeline_hospital_customize_partial_blogname() {
    bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function lifeline_hospital_customize_partial_blogdescription() {
    bloginfo( 'description' );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function lifeline_hospital_customize_preview_js() {
    wp_enqueue_script( 'lifeline-hospital-customizer', get_template_directory_uri() . '/inc/customizer-button/customizer.js', array( 'customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', 'lifeline_hospital_customize_preview_js' );

/**
 * Customizer control scripts and styles.
 *
 * @since 1.0.0
 */
function lifeline_hospital_customizer_control_scripts() {

    wp_enqueue_style( 'lifeline-hospital-customize-controls', get_template_directory_uri() . '/inc/customizer-button/customize-controls.css', '', '1.0.0' );

    wp_enqueue_script( 'lifeline-hospital-customize-controls', get_template_directory_uri() . '/inc/customizer-button/customize-controls.js', array( 'customize-controls' ), '1.0.0', true );
}
add_action( 'customize_controls_enqueue_scripts', 'lifeline_hospital_customizer_control_scripts', 0 );


//---------------------Code to add the Upgrade to Pro button in the Customizer End----------


//------------------Theme Information--------------------

function lifeline_hospital_customize_register( $wp_customize ) {



      // Add a custom setting for the Site Identity color
  $wp_customize->add_setting( 'lifeline_hospital_site_identity_color', array(
    'default' => '#000',
    'sanitize_callback' => 'sanitize_hex_color',
  ) );

  // Add a custom control for the primary color
  $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'lifeline_hospital_site_identity_color', array(
    'label' => __( 'Site Identity Color', 'lifeline-hospital' ),
    'section' => 'title_tagline',
    'settings' => 'lifeline_hospital_site_identity_color',
  ) ) );


  // Add a custom setting for the Site Identity color
  $wp_customize->add_setting( 'lifeline_hospital_site_identity_tagline_color', array(
    'default' => '#000',
    'sanitize_callback' => 'sanitize_hex_color',
  ) );

  // Add a custom control for the primary color
  $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'lifeline_hospital_site_identity_tagline_color', array(
    'label' => __( 'Tagline Color', 'lifeline-hospital' ),
    'section' => 'title_tagline',
    'settings' => 'lifeline_hospital_site_identity_tagline_color',
  ) ) );

//------------------Site Identity Ends---------------------

  
  // Add a custom setting for the primary color
  $wp_customize->add_setting( 'lifeline_hospital_primary_color', array(
    'default' => '#1E0B9B',
    'sanitize_callback' => 'sanitize_hex_color',
  ) );

  // Add a custom control for the primary color
  $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'lifeline_hospital_primary_color', array(
    'label' => __( 'Primary Color', 'lifeline-hospital' ),
    'section' => 'colors',
    'settings' => 'lifeline_hospital_primary_color',
  ) ) );

  //-----------------------------------Home Front Page-------------------------------

  $wp_customize->add_panel( 'lifeline_hospital_panel', array(
    'title'    => __( 'Front Page Settings', 'lifeline-hospital' ),
    'priority' => 6,
  ) );


  //-------------------------------------Banner Image Section--------------

      $wp_customize->add_section( 'lifeline_hospital_section_banner', array(
        'title'    => __( 'Home First Section', 'lifeline-hospital' ),
        'panel'    => 'lifeline_hospital_panel',
    ) );


  //-----------------Enable Option banner-------------

  $wp_customize->add_setting('lifeline_hospital_section_banner',array(
      'default' => 'Enable',
      'sanitize_callback' => 'lifeline_hospital_sanitize_choices'
  ));
  $wp_customize->add_control('lifeline_hospital_section_banner',array(
        'type' => 'radio',
        'label' => __('Do you want this section', 'lifeline-hospital'),
        'section' => 'lifeline_hospital_section_banner',
        'choices' => array(
            'Enable' => __('Enable', 'lifeline-hospital'),
            'Disable' => __('Disable', 'lifeline-hospital')
  )));

  $wp_customize->add_setting('lifeline_hospital_section_bannerimage_section',array(
    'default' => '',
    'sanitize_callback' => 'esc_url_raw',
  ));
  $wp_customize->add_control(
    new WP_Customize_Image_Control( $wp_customize,'lifeline_hospital_section_bannerimage_section',array(
    'label' => __('Section Side Image','lifeline-hospital'),
    'description' => __('Dimention 500 * 500','lifeline-hospital'),
    'section' => 'lifeline_hospital_section_banner',
    'settings' => 'lifeline_hospital_section_bannerimage_section'
  )));

    $wp_customize->add_setting('lifeline_hospital_section_bannerimage_section_title',array(
      'default' => '',
      'sanitize_callback' => 'sanitize_text_field'
    )
  );
  $wp_customize->add_control('lifeline_hospital_section_bannerimage_section_title',array(
      'label' => __('Section Title','lifeline-hospital'),
      'section' => 'lifeline_hospital_section_banner',
      'setting' => 'lifeline_hospital_section_bannerimage_section_title',
      'type'    => 'text'
    )
  ); 

      $wp_customize->add_setting('lifeline_hospital_section_bannerimage_section_text',array(
      'default' => '',
      'sanitize_callback' => 'sanitize_text_field'
    )
  );
  $wp_customize->add_control('lifeline_hospital_section_bannerimage_section_text',array(
      'label' => __('Section Text','lifeline-hospital'),
      'section' => 'lifeline_hospital_section_banner',
      'setting' => 'lifeline_hospital_section_bannerimage_section_text',
      'type'    => 'text'
    )
  );

    $wp_customize->add_setting('lifeline_hospital_banner_btn_text',array(
      'default' => '',
      'sanitize_callback' => 'sanitize_text_field'
    )
  );
  $wp_customize->add_control('lifeline_hospital_banner_btn_text',array(
      'label' => __('Button Text','lifeline-hospital'),
      'section' => 'lifeline_hospital_section_banner',
      'setting' => 'lifeline_hospital_banner_btn_text',
      'type'    => 'text'
    )
  );


    $wp_customize->add_setting('lifeline_hospital_banner_btn_text_url',array(
      'default' => '',
      'sanitize_callback' => 'sanitize_text_field'
    )
  );
  $wp_customize->add_control('lifeline_hospital_banner_btn_text_url',array(
      'label' => __('Button URL','lifeline-hospital'),
      'section' => 'lifeline_hospital_section_banner',
      'setting' => 'lifeline_hospital_banner_btn_text_url',
      'type'    => 'text'
    )
  );


  //-------------------------------------Services Section--------------

      $wp_customize->add_section( 'lifeline_hospital_services_section', array(
        'title'    => __( 'Services Section', 'lifeline-hospital' ),
        'panel'    => 'lifeline_hospital_panel',
    ) );


  //-----------------Enable Option banner-------------

  $wp_customize->add_setting('lifeline_hospital_section_services_enable',array(
      'default' => 'Enable',
      'sanitize_callback' => 'lifeline_hospital_sanitize_choices'
  ));
  $wp_customize->add_control('lifeline_hospital_section_services_enable',array(
        'type' => 'radio',
        'label' => __('Do you want this section', 'lifeline-hospital'),
        'section' => 'lifeline_hospital_services_section',
        'choices' => array(
            'Enable' => __('Enable', 'lifeline-hospital'),
            'Disable' => __('Disable', 'lifeline-hospital')
  )));


    $wp_customize->add_setting('lifeline_hospital_service_title',array(
      'default' => '',
      'sanitize_callback' => 'sanitize_text_field'
    )
  );
  $wp_customize->add_control('lifeline_hospital_service_title',array(
      'label' => __('Section Title','lifeline-hospital'),
      'section' => 'lifeline_hospital_services_section',
      'setting' => 'lifeline_hospital_service_title',
      'type'    => 'text'
    )
  );

    $wp_customize->add_setting('lifeline_hospital_service_subtitle',array(
      'default' => '',
      'sanitize_callback' => 'sanitize_text_field'
    )
  );
  $wp_customize->add_control('lifeline_hospital_service_subtitle',array(
      'label' => __('Section Sub Title','lifeline-hospital'),
      'section' => 'lifeline_hospital_services_section',
      'setting' => 'lifeline_hospital_service_subtitle',
      'type'    => 'text'
    )
  );

$wp_customize->add_setting('lifeline_hospital_service_count', array(
    'default' => 2,
    'sanitize_callback' => 'absint',
));

$wp_customize->add_control('lifeline_hospital_service_count', array(
    'label' => __('Number of Services', 'lifeline-hospital'),
    'section' => 'lifeline_hospital_services_section',
    'type' => 'number',
    'input_attrs' => array('min' => 1, 'max' => 4),
));

for ($i = 1; $i <= 2; $i++) {
    // Service Title
    $wp_customize->add_setting('lifeline_hospital_service_title_' . $i, array(
        'default' => sprintf(__('Service %d', 'lifeline-hospital'), $i),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('lifeline_hospital_service_title_' . $i, array(
        'label' => sprintf(__('Service Title %d', 'lifeline-hospital'), $i),
        'section' => 'lifeline_hospital_services_section',
        'setting' => 'lifeline_hospital_service_title_' . $i,
        'type' => 'text',
    ));

    // Service Content
    $wp_customize->add_setting('lifeline_hospital_service_content_' . $i, array(
        'default' => sprintf(__('Details about Service %d', 'lifeline-hospital'), $i),
        'sanitize_callback' => 'sanitize_textarea_field',
    ));
    $wp_customize->add_control('lifeline_hospital_service_content_' . $i, array(
        'label' => sprintf(__('Service Content %d', 'lifeline-hospital'), $i),
        'section' => 'lifeline_hospital_services_section',
        'setting' => 'lifeline_hospital_service_content_' . $i,
        'type' => 'textarea',
    ));

    // Service URL
    $wp_customize->add_setting('lifeline_hospital_service_url_' . $i, array(
        'default' => '#',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control('lifeline_hospital_service_url_' . $i, array(
        'label' => sprintf(__('Service URL %d', 'lifeline-hospital'), $i),
        'section' => 'lifeline_hospital_services_section',
        'setting' => 'lifeline_hospital_service_url_' . $i,
        'type' => 'url',
    ));

    // Button Text
    $wp_customize->add_setting('lifeline_hospital_service_button_text_' . $i, array(
        'default' => __('View Details', 'lifeline-hospital'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('lifeline_hospital_service_button_text_' . $i, array(
        'label' => sprintf(__('Button Text for Service %d', 'lifeline-hospital'), $i),
        'section' => 'lifeline_hospital_services_section',
        'setting' => 'lifeline_hospital_service_button_text_' . $i,
        'type' => 'text',
    ));
}



  //-------------Section One (Featured Post)-------------------

  $wp_customize->add_section( 'lifeline_hospital_section1', array(
        'title'    => __( 'Latest Post', 'lifeline-hospital' ),
        'panel'    => 'lifeline_hospital_panel',
    ) );


  //-----------------Enable Option Section One-------------

  $wp_customize->add_setting('lifeline_hospital_section1_enable',array(
      'default' => 'Enable',
      'sanitize_callback' => 'lifeline_hospital_sanitize_choices'
  ));
  $wp_customize->add_control('lifeline_hospital_section1_enable',array(
        'type' => 'radio',
        'label' => __('Do you want this section', 'lifeline-hospital'),
        'section' => 'lifeline_hospital_section1',
        'choices' => array(
            'Enable' => __('Enable', 'lifeline-hospital'),
            'Disable' => __('Disable', 'lifeline-hospital')
  )));

    //--------------Section One Title-----------------------

    $wp_customize->add_setting('lifeline_hospital_section1_title',array(
      'default' => '',
      'sanitize_callback' => 'sanitize_text_field'
    )
  );
  $wp_customize->add_control('lifeline_hospital_section1_title',array(
      'label' => __('Section Title','lifeline-hospital'),
      'section' => 'lifeline_hospital_section1',
      'setting' => 'lifeline_hospital_section1_title',
      'type'    => 'text'
    )
  ); 

      $wp_customize->add_setting('lifeline_hospital_section1_subtitle',array(
      'default' => '',
      'sanitize_callback' => 'sanitize_text_field'
    )
  );
  $wp_customize->add_control('lifeline_hospital_section1_subtitle',array(
      'label' => __('Section Sub Title','lifeline-hospital'),
      'section' => 'lifeline_hospital_section1',
      'setting' => 'lifeline_hospital_section1_subtitle',
      'type'    => 'text'
    )
  );

  //-----------Category------------

  $categories = get_categories();
  $cats = array();
  $i = 0;
  foreach($categories as $category){
    if($i==0){
      $default = $category->name;
      $i++;
    }
    $cats[$category->name] = $category->name;
  }

  $wp_customize->add_setting('lifeline_hospital_section1_category',array(
  'sanitize_callback' => 'sanitize_text_field',
  ));
  $wp_customize->add_control('lifeline_hospital_section1_category',array(
    'type'    => 'select',
    'choices' => $cats,
    'label' => __('Select Category to Display Post','lifeline-hospital'),
    'section' => 'lifeline_hospital_section1',
    'sanitize_callback' => 'sanitize_text_field',
  ));



    $wp_customize->add_setting('lifeline_hospital_section1_category_number_of_posts_setting',array(
    'default' => '6',
    'sanitize_callback' => 'sanitize_text_field'
  ));
  $wp_customize->add_control('lifeline_hospital_section1_category_number_of_posts_setting',array(
    'label' => __('Number of Posts','lifeline-hospital'),
    'section' => 'lifeline_hospital_section1',
    'setting' => 'lifeline_hospital_section1_category_number_of_posts_setting',
    'type'    => 'number'
  ));


  //------------------------Blog Page Settings--------------------------


  $wp_customize->add_section( 'lifeline_hospital_blogpage_settings', array(
        'title'    => __( 'Blog Page Settings', 'lifeline-hospital' ),
        'panel'    => 'lifeline_hospital_panel',
    ) );

    //--------------Section One Title-----------------------

    $wp_customize->add_setting('lifeline_hospital_blogpage_title',array(
      'default' => '',
      'sanitize_callback' => 'sanitize_text_field'
    )
  );
  $wp_customize->add_control('lifeline_hospital_blogpage_title',array(
      'label' => __('Blog Page Title','lifeline-hospital'),
      'section' => 'lifeline_hospital_blogpage_settings',
      'setting' => 'lifeline_hospital_blogpage_title',
      'type'    => 'text'
    )
  ); 

  //-----------Category------------

  $categories = get_categories();
  $cats = array();
  $i = 0;
  foreach($categories as $category){
    if($i==0){
      $default = $category->name;
      $i++;
    }
    $cats[$category->name] = $category->name;
  }

  $wp_customize->add_setting('lifeline_hospital_blogpage_category',array(
  'sanitize_callback' => 'sanitize_text_field',
  ));
  $wp_customize->add_control('lifeline_hospital_blogpage_category',array(
    'type'    => 'select',
    'choices' => $cats,
    'label' => __('Select Category to Display Post on Blog Page','lifeline-hospital'),
    'section' => 'lifeline_hospital_blogpage_settings',
    'sanitize_callback' => 'sanitize_text_field',
  ));

    $wp_customize->add_setting('lifeline_hospitalblog_page_category_number_of_posts_setting',array(
    'default' => '18',
    'sanitize_callback' => 'sanitize_text_field'
  ));
  $wp_customize->add_control('lifeline_hospitalblog_page_category_number_of_posts_setting',array(
    'label' => __('Number of Posts','lifeline-hospital'),
    'section' => 'lifeline_hospital_blogpage_settings',
    'setting' => 'lifeline_hospitalblog_page_category_number_of_posts_setting',
    'type'    => 'number'
  )); 



  //-------------------------Footer Settings------------------------------


    $wp_customize->add_section( 'lifeline_hospital_footer', array(
        'title'    => __( 'Footer Settings', 'lifeline-hospital' ),
        'panel'    => 'lifeline_hospital_panel',
    ) );


  // Add a custom setting for the footer text
  $wp_customize->add_setting( 'lifeline_hospital_footer_text', array(
    'default' => 'Lifeline Hospital WordPress Theme',
    'sanitize_callback' => 'sanitize_text_field',
  ) );

  // Add a custom control for the footer text
  $wp_customize->add_control( 'lifeline_hospital_footer_text', array(
    'label' => __( 'Footer Text', 'lifeline-hospital' ),
    'section' => 'lifeline_hospital_footer',
    'type' => 'text',
  ) );


 //-------------------404 Page-----------

  $wp_customize->add_section( 'lifeline_hospital_404page', array(
    'title'    => __( '404 Page Settings', 'lifeline-hospital' ),
    'panel'    => 'lifeline_hospital_panel',
    ) );


  // Add a custom setting for the footer text
  $wp_customize->add_setting( 'lifeline_hospital_404page_title', array(
    'default' => '',
    'sanitize_callback' => 'sanitize_text_field',
  ) );

  // Add a custom control for the footer text
  $wp_customize->add_control( 'lifeline_hospital_404page_title', array(
    'label' => __( 'Page Not Found Title', 'lifeline-hospital' ),
    'section' => 'lifeline_hospital_404page',
    'type' => 'text',
  ) );

  // Add a custom setting for the footer text
  $wp_customize->add_setting( 'lifeline_hospital_404page_text', array(
    'default' => '',
    'sanitize_callback' => 'sanitize_text_field',
  ) );

  // Add a custom control for the footer text
  $wp_customize->add_control( 'lifeline_hospital_404page_text', array(
    'label' => __( 'Page Not Found Text', 'lifeline-hospital' ),
    'section' => 'lifeline_hospital_404page',
    'type' => 'text',
  ) );

//------------------------General Settings------------------------------------------

  $wp_customize->add_section( 'lifeline_hospital_general', array(
        'title'    => __( 'General Settings', 'lifeline-hospital' ),
        'panel'    => 'lifeline_hospital_panel',
    ) );

    $wp_customize->add_setting( 'lifeline_hospital_post_meta_toggle_switch_control', array(
        'default'   => true,
        'sanitize_callback' => 'sanitize_text_field', // Use a suitable sanitization function based on your needs
        'transport' => 'refresh', // or 'postMessage' for instant preview without page refresh
    ) );

    $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'lifeline_hospital_post_meta_toggle_switch_control', array(
        'label'    => __( 'Display Time/Author', 'lifeline-hospital' ),
        'section'  => 'lifeline_hospital_general',
        'settings' => 'lifeline_hospital_post_meta_toggle_switch_control',
        'type'     => 'checkbox',
    ) ) );

    $wp_customize->add_setting( 'lifeline_hospital_post_meta_toggle_switch_control', array(
        'default'   => true,
        'sanitize_callback' => 'sanitize_text_field', // Use a suitable sanitization function based on your needs
        'transport' => 'refresh', // or 'postMessage' for instant preview without page refresh
    ) );

    $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'lifeline_hospital_post_meta_toggle_switch_control', array(
        'label'    => __( 'Display Read More Link', 'lifeline-hospital' ),
        'section'  => 'lifeline_hospital_general',
        'settings' => 'lifeline_hospital_post_meta_toggle_switch_control',
        'type'     => 'checkbox',
    ) ) );


}
add_action( 'customize_register', 'lifeline_hospital_customize_register' );



