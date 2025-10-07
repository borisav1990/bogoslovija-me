<?php
/**
 * Home Section 1 Template
 *
 * @package Lifeline Hospital
 */

$lifeline_hospital_section_one = get_theme_mod('lifeline_hospital_section_services_enable');
if ('Disable' == $lifeline_hospital_section_one) {
    return;
}

// Retrieve number of services from Customizer
$number_of_services = get_theme_mod('lifeline_hospital_service_count', 4);

// Section header and sub-header from Customizer
$section_title = get_theme_mod('lifeline_hospital_service_title', 'We Provide Specialized Healthcare Services');
$subsection_title = get_theme_mod('lifeline_hospital_service_subtitle', 'Explore our wide range of expert healthcare services tailored for you.');
?>

<section id="services" class="services-section py-5">
    <div class="container-fluid">
        <!-- Section Title -->
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="section-title"><?php echo esc_html($section_title); ?></h2>
                <p class="section-subtitle mb-6"><?php echo esc_html($subsection_title); ?></p>
            </div>
        </div>

        <!-- Horizontal Tabs Design -->
        <div class="row">
            <div class="col-md-4">
                <ul class="nav flex-column nav-tabs-box" id="serviceTabs" role="tablist">
                    <?php for ($i = 1; $i <= $number_of_services; $i++) : ?>
                        <?php
                        $service_title = get_theme_mod('lifeline_hospital_service_title_' . $i, 'Service ' . $i);
                        ?>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link <?php echo $i === 1 ? 'active' : ''; ?>" id="tab-<?php echo $i; ?>" data-bs-toggle="tab" href="#content-<?php echo $i; ?>" role="tab" aria-controls="content-<?php echo $i; ?>" aria-selected="<?php echo $i === 1 ? 'true' : 'false'; ?>">
                                <?php echo esc_html($service_title); ?>
                            </a>
                        </li>
                    <?php endfor; ?>
                </ul>
            </div>
            <div class="col-md-8">
                <!-- Tab Content -->
                <div class="tab-content" id="serviceTabsContent">
                    <?php for ($i = 1; $i <= $number_of_services; $i++) : ?>
                        <?php
                        $service_title = get_theme_mod('lifeline_hospital_service_title_' . $i, 'Service ' . $i); // Fetching dynamically for each content section
                        $service_content = get_theme_mod('lifeline_hospital_service_content_' . $i, 'Details about Service ' . $i);
                        $service_url = get_theme_mod('lifeline_hospital_service_url_' . $i, '#');
                        $view_details_text = get_theme_mod('lifeline_hospital_service_button_text_' . $i, 'View Details');
                        ?>
                        <div class="tab-pane fade <?php echo $i === 1 ? 'show active' : ''; ?>" id="content-<?php echo $i; ?>" role="tabpanel" aria-labelledby="tab-<?php echo $i; ?>">
                            <div class="service-content">
                                <div class="service-header">
                                    <h3 class="service-title"><?php echo esc_html($service_title); ?></h3>
                                </div>
                                <p class="service-description"><?php echo esc_html($service_content); ?></p>
                                <a href="<?php echo esc_url($service_url); ?>" class="btn btn-primary service-btn"><?php echo esc_html($view_details_text); ?></a>
                            </div>
                        </div>
                    <?php endfor; ?>
                </div>
            </div>
        </div>
    </div>
</section>
