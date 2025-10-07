<?php 
// Load saved values in Academia Theme Options
$academia_options = academia_get_global_options(); 
?>
<!DOCTYPE html>
<!--[if IE 7 | IE 8]>
<html class="ie" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<?php if ($academia_options['academia_custom_css'] == 1) { ?>
<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/custom.css" />
	<?php } ?>
<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	<!--[if lt IE 9]>
	<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
	<![endif]-->
	
	<?php wp_head(); ?>
	
	<?php print(stripslashes($academia_options['academia_script_header'])); ?>

</head>

<body <?php body_class(); ?>>

<div id="container">

	<header role="banner" class="site-header">
	
		<?php if (has_nav_menu( 'secondary' )) { ?>
		<div id="pre-header">
		
			<div class="wrapper">
			
				<nav role="navigation">
				<?php wp_nav_menu( array('container' => '', 'container_class' => '', 'menu_class' => 'secondary-menu', 'menu_id' => 'menu-secondary-menu', 'sort_column' => 'menu_order', 'depth' => '1', 'theme_location' => 'secondary') ); ?>
				</nav>

				<div class="cleaner">&nbsp;</div>
			
			</div><!-- .wrapper -->
		
		</div><!-- #pre-header -->
		<?php }	?>
		
		<div class="wrapper wrapper-header">
		
			<div id="logo" itemscope itemtype="http://schema.org/Organization">
				<meta itemprop="name" content="<?php echo get_bloginfo('name'); ?>" />
				<?php $default_logo = get_template_directory_uri() . '/images/logo.png'; ?>
				<a itemprop="url" href="<?php echo home_url(); ?>" title="<?php bloginfo('description'); ?>"><img itemprop="logo" src="<?php if (get_theme_mod('academia_logo_upload') != '') { echo get_theme_mod('academia_logo_upload'); } else { echo $default_logo; } ?>" alt="<?php bloginfo('name'); ?>" class="logo-img" /></a>
			</div><!-- #logo -->
			
			<?php if (is_active_sidebar('header-right')) { ?>
			
			<div class="header-widgets">
			
				<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Header') ) : ?> <?php endif; ?>
			
				<div class="cleaner">&nbsp;</div>
			
			</div><!-- .header-widgets -->
			
			<?php } ?>
			
			<div class="cleaner">&nbsp;</div>
			
	        <?php if ( has_nav_menu( 'primary' ) ) { ?>
	        <div class="navbar-header">

				<?php wp_nav_menu( array(
					'container_id'   => 'menu-main-slick',
					'menu_id' => 'menu-slide-in',
					'sort_column' => 'menu_order', 
					'theme_location' => 'primary'
				) ); 
				?>

	        </div><!-- .navbar-header -->
	        <?php } ?>

			<nav id="site-navigation" role="navigation">
				
			<?php if (has_nav_menu( 'primary' )) { 
				wp_nav_menu( array('container' => '', 'container_class' => '', 'menu_class' => 'dropdown', 'menu_id' => 'menu-main-menu', 'sort_column' => 'menu_order', 'theme_location' => 'primary' ) );
			}
			else
			{
				if (current_user_can('edit_theme_options')) {
					echo '<div id="menu-main-menu"><p class="academia-notice">Please set your Main Menu on the <a href="'.get_admin_url().'nav-menus.php">Appearance > Menus</a> page. For more information please <a href="http://www.academiathemes.com/documentation/blackboard/">read the documentation</a></p></div>';
				}
			}
			?>			
				
			</nav>

		</div><!-- .wrapper .wrapper-header -->
	
		<div id="header-separator">&nbsp;</div><!-- #header-separator -->
	
	</header><!-- .site-header -->