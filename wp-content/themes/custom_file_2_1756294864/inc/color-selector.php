<?php


//-----------------------------Site Identity Color----------------

	$lifeline_hospital_site_identity_color = get_theme_mod('lifeline_hospital_site_identity_color');
	$lifeline_hospital_site_identity_tagline_color = get_theme_mod('lifeline_hospital_site_identity_tagline_color');


// ----------------Primary Color------------

	$lifeline_hospital_primary_color = get_theme_mod('lifeline_hospital_primary_color');



//=====================Whole CSS===================================


	$custom_css ='.display_only h1 a,.display_only p{';
	
	$custom_css .='}';





//==============Main Setting Section===========================================


// ----------------Site Identity Color--------------------

	if($lifeline_hospital_site_identity_color != false){
		$custom_css .='.display_only h1 a{';
			if($lifeline_hospital_site_identity_color != false)
		    	$custom_css .='color: '.esc_html($lifeline_hospital_site_identity_color).'!important;';
		$custom_css .='}';
	}

	if($lifeline_hospital_site_identity_tagline_color != false){
		$custom_css .='.display_only p{';
			if($lifeline_hospital_site_identity_tagline_color != false)
		    	$custom_css .='color: '.esc_html($lifeline_hospital_site_identity_tagline_color).'!important;';
		$custom_css .='}';
	}

//----------------------Primary Color---------------

	if($lifeline_hospital_primary_color != false){
		$custom_css .='h4.product-title a:hover,a.added_to_cart.wc-forward,.readmore-latest a,h4.product-title a:hover,a.added_to_cart.wc-forward,.nav-previous a:hover, .nav-next a:hover,footer a:hover{';
			if($lifeline_hospital_primary_color != false)
		    	$custom_css .='color: '.esc_html($lifeline_hospital_primary_color).'!important;';
		$custom_css .='}';
	}

	if($lifeline_hospital_primary_color != false){
		$custom_css .='.theme-btn a,span.arrival-cart a:hover,span.product-sale-tag,.theme-btn a,span.arrival-cart a:hover,span.product-sale-tag{';
			if($lifeline_hospital_primary_color != false)
		    	$custom_css .='background-color: '.esc_html($lifeline_hospital_primary_color).'!important;';
		$custom_css .='}';
	}


?>