<?php 
/*-----------------------------------------------------------------------------------*/
/* Initializing Widgetized Areas (Sidebars)																			 */
/*-----------------------------------------------------------------------------------*/

/*----------------------------------*/
/* Sidebar							*/
/*----------------------------------*/
 
register_sidebar(array(
'name'=>'Sidebar: Left',
'id' => 'sidebar',
'before_widget' => '<div class="widget %2$s" id="%1$s">',
'after_widget' => '<div class="cleaner">&nbsp;</div></div>',
'before_title' => '<p class="title-s title-widget title-widget-gold">',
'after_title' => '</p>',
));

register_sidebar(array(
'name'=>'Sidebar: Right',
'id' => 'sidebar-right',
'before_widget' => '<div class="widget %2$s" id="%1$s">',
'after_widget' => '<div class="cleaner">&nbsp;</div></div>',
'before_title' => '<p class="title-s title-widget title-widget-gold">',
'after_title' => '</p>',
));

/*----------------------------------*/
/* Homepage					 		*/
/*----------------------------------*/
 
register_sidebar(array(
'name'=>'Homepage Content: Middle Column',
'id' => 'home-col-1',
'before_widget' => '<div class="widget %2$s" id="%1$s">',
'after_widget' => '<div class="cleaner">&nbsp;</div></div>',
'before_title' => '<p class="title-s title-widget title-widget-gold">',
'after_title' => '</p>',
));

/*----------------------------------*/
/* Header					 		*/
/*----------------------------------*/
 
register_sidebar(array(
'name'=>'Header',
'id' => 'header-right',
'description'=>'It is recommended to add no more than 2 widgets. Best works with Search and Text widgets.',
'before_widget' => '<div class="widget %2$s" id="%1$s">',
'after_widget' => '<div class="cleaner">&nbsp;</div></div>',
'before_title' => '<p class="title-s title-widget">',
'after_title' => '</p>',
));

/*----------------------------------*/
/* Footer					 		*/
/*----------------------------------*/
 
register_sidebar(array('name'=>'Footer: Column 1',
'id' => 'footer-col-1',
'before_widget' => '<div class="widget %2$s" id="%1$s">',
'after_widget' => '<div class="cleaner">&nbsp;</div></div>',
'before_title' => '<p class="title-widget">',
'after_title' => '</p>',
));

register_sidebar(array('name'=>'Footer: Column 2',
'id' => 'footer-col-2',
'before_widget' => '<div class="widget %2$s" id="%1$s">',
'after_widget' => '<div class="cleaner">&nbsp;</div></div>',
'before_title' => '<p class="title-widget">',
'after_title' => '</p>',
));

register_sidebar(array('name'=>'Footer: Column 3',
'id' => 'footer-col-3',
'before_widget' => '<div class="widget %2$s" id="%1$s">',
'after_widget' => '<div class="cleaner">&nbsp;</div></div>',
'before_title' => '<p class="title-widget">',
'after_title' => '</p>',
));