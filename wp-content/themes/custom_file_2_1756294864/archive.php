<?php
/**
 * The template for displaying archive pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package lifeline-hospital
 */

get_header(); ?>

<main id="content">
	<section class="archive-section">
	    <div class="container">
	        <div class="row">
	            <div class="col-lg-8 col-md-8 col-12">
	                <?php if ( have_posts() ) : ?>
	                    <?php while ( have_posts() ) : the_post(); ?>
	                        <article class="post">
	                            <div class="post-thumbnail">
	                                <?php if ( has_post_thumbnail() ) {
	                                    the_post_thumbnail();
	                                } ?>
	                            </div>
	                            <div class="post-content">
	                            	<?php if ( get_theme_mod( 'lifeline_hospital_post_meta_toggle_switch_control', true ) ) : ?>
							            <div class="sec2-meta">
							              	<span><?php echo esc_html(get_the_date()); ?></span>
                    						<span class="separator">|</span>
                    						<span><?php echo esc_html( get_the_author() ); ?></span>
							            </div>
							          <?php else : ?>
							          <!-- Content to display when the toggle switch is OFF -->
							          <?php endif; ?>
	                                <h2 class="entry-title"><?php the_title(); ?></h2>
						          <div class="entry-content">
					                <?php the_content(); ?>
					              </div>
					              <div class="entry-tags">
					                  <?php the_tags( '<span class="tag-links">' . __( 'Tags:', 'lifeline-hospital' ) . '</span> ' ); ?>
					                </div>
					                <div class="entry-share">
					                  <span><?php esc_html_e( 'Share:', 'lifeline-hospital' ); ?></span>
					                  <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo esc_url( get_permalink() ); ?>" target="_blank"><span class=""><?php esc_html_e( "Facebook", 'lifeline-hospital' ) ?></span></a>
					                  <a href="https://twitter.com/intent/tweet?text=<?php echo esc_attr( get_the_title() ); ?>&url=<?php echo esc_url( get_permalink() ); ?>&via=twitterusername" target="_blank"><span class=""><?php esc_html_e( "Twitter", 'lifeline-hospital' ) ?></span></a>
					                  <a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo esc_url( get_permalink() ); ?>&title=<?php echo esc_attr  ( get_the_title() ); ?>&summary=<?php echo esc_attr( get_the_excerpt() ); ?>&source=LinkedIn" target="_blank"><span class=""><?php esc_html_e( "Linkedin", 'lifeline-hospital' ) ?></span></a>
					                </div>
	                        </article>

	                    <?php endwhile; ?>

	                     <div class="post-navigation">
				            <div class="nav-previous"><?php previous_post_link( '%link', '%title' ); ?></div>
				            <div class="nav-next"><?php next_post_link( '%link', '%title' ); ?></div>
				          </div>


	                <?php else : ?>

	                    <p><?php esc_html_e( 'Sorry, no posts matched your criteria.', 'lifeline-hospital' ); ?></p>

	                <?php endif; ?>

	            </div>
	            <div class="col-lg-4 col-md-4 col-4">
	                <?php get_sidebar(); ?>
	            </div>
	        </div>
	    </div>
	</section>
</main>

<?php get_footer(); ?>

