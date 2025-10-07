<?php 
// Load saved values in Academia Theme Options
$academia_options = academia_get_global_options(); 
?>
	<footer class="site-footer">
	
		<?php if ($academia_options['academia_footer_sidebars_display'] == 1) { ?>
		
		<div id="footer-main">
		
			<div class="wrapper wrapper-footer-main">
			
				<div class="academia-column academia-column-narrow">
					
					<div class="academia-column-wrapper">
					
						<?php if ( isset($academia_options['academia_footer_logo_display']) && $academia_options['academia_footer_logo_display'] == 1) { ?>
						
						<?php $default_logo = get_template_directory_uri() . '/images/logo-footer.png'; ?>
						<a itemprop="url" href="<?php echo home_url(); ?>"><img src="<?php if (get_theme_mod('academia_logo_alt_upload') != '') { echo get_theme_mod('academia_logo_alt_upload'); } else { echo $default_logo; } ?>" alt="<?php bloginfo('name'); ?>" class="footer-logo" /></a>

						<div class="cleaner">&nbsp;</div>
						
						<?php } ?>
						
						<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Footer: Column 1') ) : ?> <?php endif; ?>
						
						<div class="cleaner">&nbsp;</div>
					
					</div><!-- .academia-column-wrapper -->
				
				</div><!-- .academia-column .academia-column-narrow -->
				
				<div class="academia-column academia-column-double">
					
					<div class="academia-column-wrapper">
					
						<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Footer: Column 2') ) : ?> <?php endif; ?>
						
						<div class="cleaner">&nbsp;</div>
					
					</div><!-- .academia-column-wrapper -->
				
				</div><!-- .academia-column .academia-column-double -->
				
				<div class="academia-column academia-column-narrow academia-column-last">
					
					<div class="academia-column-wrapper">
					
						<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Footer: Column 3') ) : ?> <?php endif; ?>

						<div class="cleaner">&nbsp;</div>
					
					</div><!-- .academia-column-wrapper -->
				
				</div><!-- .academia-column .academia-column-narrow -->
				
				<div class="cleaner">&nbsp;</div>
			
			</div><!-- .wrapper .wrapper-footer-main -->
		
		</div><!-- #footer-main -->
		
		<?php } ?>
		
		<div id="footer-copy">
		
			<div class="wrapper wrapper-footer-copy">
				
				<?php if ($academia_options['academia_misc_credit'] == 1) { ?>
				<p class="academia-credit"><?php _e('Theme by', 'academia_textdomain'); ?> <a href="http://www.academiathemes.com" target="_blank">AcademiaThemes</a></p>
				<?php } ?>
				<?php $copyright_default = __('Copyright &copy; ','academia_textdomain') . date("Y",time()) . ' ' . get_bloginfo('name') . '. ' . __('All Rights Reserved', 'academia_textdomain'); ?>
				<p class="copy"><?php echo $copyright_default; ?></p>
	
				<div class="cleaner">&nbsp;</div>
			
			</div><!-- .wrapper .wrapper-footer-copy -->
		
		</div><!-- #footer-copy -->

	</footer><!-- .site-footer -->
	
</div><!-- #container -->

<?php 
wp_footer(); 
wp_reset_query();
?>
<?php print(stripslashes($academia_options['academia_script_footer'])); ?>

</body>
</html>