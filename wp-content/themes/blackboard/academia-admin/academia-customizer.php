<?php			

/* Add theme customizer to <head> 
================================== */

function academia_customizer_head() {

	/*
	This block refers to the functionality of the Appearance > Customize screen.
	*/
	echo '<style type="text/css">';
	generate_css('body', 'font-family', 'academia_font_main');
	generate_css('body, .post-single', 'color', 'academia_color_body', '#666666');
	generate_css('a', 'color', 'academia_color_link', '#26bcd7');
	generate_css('a:hover', 'color', 'academia_color_link_hover', '#e21735');
	generate_css('#site-navigation', 'font-family', 'academia_font_menu');
	generate_css('#site-navigation', 'background-color', 'academia_bgcolor_menu', '#6f000d');
	generate_css('.title-widget, footer .title-widget', 'font-family', 'academia_font_widget');
	generate_css('header', 'background-color', 'academia_bgcolor_header', '#e8dfd6'); 
	generate_css('#footer-main', 'background-color', 'academia_bgcolor_footer', '#f3f0ec');
	generate_css('#footer-main a', 'color', 'academia_color_footer_link', '#555555');
	generate_css('#footer-main a:hover', 'color', 'academia_color_footer_link_hover', '#222222');
	generate_css('#footer-copy', 'background-color', 'academia_bgcolor_footercopy', '#48080f');
	generate_css('#footer-copy', 'color', 'academia_color_footercopy', '#ae8c90');
	echo '</style>
';

}
add_action('wp_head', 'academia_customizer_head');

/**
 * Adds the Customize page to the WordPress admin area
function academia_customizer_menu() {
	add_theme_page( __('Customize','academia_textdomain'), __('Customize','academia_textdomain'), 'edit_theme_options', 'customize.php' );
}
add_action( 'admin_menu', 'academia_customizer_menu' );
 */

/**
 * Adds the individual sections, settings, and controls to the theme customizer
 */

function academia_customizer( $wp_customize ) {

	// Define array of web safe fonts
	$academia_fonts = array(
		'default' => 'Default',
		'Arial, Helvetica, sans-serif' => 'Arial, Helvetica, sans-serif',
		'Georgia, serif' => 'Georgia, serif',
		'Impact, Charcoal, sans-serif' => 'Impact, Charcoal, sans-serif',
		'"Open Sans", Arial, Helvetica, sans-serif' => 'Open Sans, Arial, Helvetica, sans-serif',
		'"Palatino Linotype", "Book Antiqua", Palatino, serif' => 'Palatino Linotype, Book Antique, Palatino, serif',
		'Tahoma, Geneva, sans-serif' => 'Tahoma, Geneva, sans-serif',
	);

	$wp_customize->add_section(
		'academia_section_general',
		array(
			'title' => 'General Settings',
			'description' => 'This controls various general theme settings.',
			'priority' => 5,
		)
	);

	$wp_customize->add_section(
		'academia_section_fonts',
		array(
			'title' => 'Fonts',
			'description' => 'Customize theme fonts.',
			'priority' => 35,
		)
	);


	$wp_customize->add_setting( 'academia_logo_upload' );
	
	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'logo-upload',
			array(
				'label' => 'Logo File Upload',
				'section' => 'academia_section_general',
				'settings' => 'academia_logo_upload'
			)
		)
	);

	$wp_customize->add_setting( 'academia_logo_alt_upload' );
	
	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'logo-alt-upload',
			array(
				'label' => 'Footer Logo File Upload',
				'section' => 'academia_section_general',
				'settings' => 'academia_logo_alt_upload'
			)
		)
	);

	$wp_customize->add_setting(
		'academia_font_main',
		array(
			'default' => 'default',
		)
	);
	
	$wp_customize->add_control(
		'academia_font_main',
		array(
			'type' => 'select',
			'label' => 'Choose the main body font',
			'section' => 'academia_section_fonts',
			'choices' => $academia_fonts,
			'priority' => 1,
		)
	);

	$wp_customize->add_setting(
		'academia_font_menu',
		array(
			'default' => 'default',
		)
	);
	
	$wp_customize->add_control(
		'academia_font_menu',
		array(
			'type' => 'select',
			'label' => 'Choose the Menu font',
			'section' => 'academia_section_fonts',
			'choices' => $academia_fonts,
			'priority' => 2,
		)
	);

	$wp_customize->add_setting(
		'academia_font_widget',
		array(
			'default' => 'default',
		)
	);
	
	$wp_customize->add_control(
		'academia_font_widget',
		array(
			'type' => 'select',
			'label' => 'Choose the Widget Title font',
			'section' => 'academia_section_fonts',
			'choices' => $academia_fonts,
			'priority' => 3,
		)
	);

	$wp_customize->add_setting(
		'academia_color_body',
		array(
			'default' => '#666666',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'academia_color_body',
			array(
				'label' => 'Main body text color',
				'section' => 'colors',
				'settings' => 'academia_color_body',
				'priority' => 1,
			)
		)
	);

	$wp_customize->add_setting(
		'academia_color_link',
		array(
			'default' => '#26bcd7',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'academia_color_link',
			array(
				'label' => 'Main body link color',
				'section' => 'colors',
				'settings' => 'academia_color_link',
				'priority' => 2,
			)
		)
	);

	$wp_customize->add_setting(
		'academia_color_link_hover',
		array(
			'default' => '#e21735',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'academia_color_link_hover',
			array(
				'label' => 'Main body link :hover color',
				'section' => 'colors',
				'settings' => 'academia_color_link_hover',
				'priority' => 3,
			)
		)
	);

	$wp_customize->add_setting(
		'academia_bgcolor_header',
		array(
			'default' => '#e8dfd6',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'academia_bgcolor_header',
			array(
				'label' => 'Header background color',
				'section' => 'colors',
				'settings' => 'academia_bgcolor_header',
				'priority' => 4,
			)
		)
	);

	$wp_customize->add_setting(
		'academia_bgcolor_menu',
		array(
			'default' => '#6f000d',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'academia_bgcolor_menu',
			array(
				'label' => 'Main menu background color',
				'section' => 'colors',
				'settings' => 'academia_bgcolor_menu',
				'priority' => 5,
			)
		)
	);

	$wp_customize->add_setting(
		'academia_bgcolor_footer',
		array(
			'default' => '#f3f0ec',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'academia_bgcolor_footer',
			array(
				'label' => 'Footer background color',
				'section' => 'colors',
				'settings' => 'academia_bgcolor_footer',
				'priority' => 6,
			)
		)
	);

	$wp_customize->add_setting(
		'academia_color_footer_link',
		array(
			'default' => '#555555',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'academia_color_footer_link',
			array(
				'label' => 'Footer link color',
				'section' => 'colors',
				'settings' => 'academia_color_footer_link',
				'priority' => 7,
			)
		)
	);

	$wp_customize->add_setting(
		'academia_color_footer_link_hover',
		array(
			'default' => '#222222',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'academia_color_footer_link_hover',
			array(
				'label' => 'Footer link :hover color',
				'section' => 'colors',
				'settings' => 'academia_color_footer_link_hover',
				'priority' => 8,
			)
		)
	);

	$wp_customize->add_setting(
		'academia_bgcolor_footercopy',
		array(
			'default' => '#48080f',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'academia_bgcolor_footercopy',
			array(
				'label' => 'Footer (copyrights) background color',
				'section' => 'colors',
				'settings' => 'academia_bgcolor_footercopy',
				'priority' => 9,
			)
		)
	);

	$wp_customize->add_setting(
		'academia_color_footercopy',
		array(
			'default' => '#ae8c90',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'academia_color_footercopy',
			array(
				'label' => 'Footer (copyrights) text color',
				'section' => 'colors',
				'settings' => 'academia_color_footercopy',
				'priority' => 10,
			)
		)
	);

}
add_action( 'customize_register', 'academia_customizer' );

/**
* This will generate a line of CSS for use in header output. If the setting
* ($mod_name) has no defined value, the CSS will not be output.
* 
* @uses get_theme_mod()
* @param string $selector CSS selector
* @param string $style The name of the CSS *property* to modify
* @param string $mod_name The name of the 'theme_mod' option to fetch
* @param string $mod_name The default value in the theme, which will be ignored
* @param string $prefix Optional. Anything that needs to be output before the CSS property
* @param string $postfix Optional. Anything that needs to be output after the CSS property
* @param bool $echo Optional. Whether to print directly to the page (default: true).
* @return string Returns a single line of CSS with selectors and a property.
*/
function generate_css( $selector, $style, $mod_name, $default='', $prefix='', $postfix='', $echo=true ) {
	$return = '';
	$mod = get_theme_mod($mod_name);
	if ( ! empty( $mod ) && $mod != 'default' && $mod != $default ) {
		$return = sprintf('%s { %s: %s; }
		',
			$selector,
			$style,
			$prefix.$mod.$postfix
		);
		if ( $echo ) {
			echo $return;
		}
	}
	return $return;
}