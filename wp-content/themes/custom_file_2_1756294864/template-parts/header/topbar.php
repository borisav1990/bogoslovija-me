<div class="container">
    <div class="row">
        <div class="col-lg-6">
           <div class="contact-details-top">
                <?php
                $email = get_theme_mod('legal_justice_pro_topbar_email', '');
                $phone = get_theme_mod('legal_justice_pro_topbar_phone', '');
                ?>

                <?php if ($email) : ?>
                    <span>
                        <a href="mailto:<?php echo esc_attr($email); ?>">Email</a>
                    </span>
                <?php endif; ?>

                <span class="border-span"></span>

                <?php if ($phone) : ?>
                    <span>
                        <a href="tel:<?php echo esc_attr($phone); ?>"><?php echo esc_html($phone); ?></a>
                    </span>
                <?php endif; ?>
            </div>
        </div>

        <div class="col-lg-6 col-md-6 col-6">
            <?php if (get_theme_mod('legal_justice_pro_header_toggle_switch_control', false)) : ?>
                <div class="social-theme-icon">
                    <?php if ($fb_link = get_theme_mod('legal_justice_pro_social_fb_link')) : ?>
                        <a href="<?php echo esc_url($fb_link); ?>" target="_blank" rel="noopener noreferrer"><i class="fab fa-facebook"></i></a>
                    <?php endif; ?>

                    <?php if ($insta_link = get_theme_mod('legal_justice_pro_social_insta_link')) : ?>
                        <a href="<?php echo esc_url($insta_link); ?>" target="_blank" rel="noopener noreferrer"><i class="fab fa-instagram"></i></a>
                    <?php endif; ?>

                    <?php if ($twitter_link = get_theme_mod('legal_justice_pro_social_twitter_link')) : ?>
                        <a href="<?php echo esc_url($twitter_link); ?>" target="_blank" rel="noopener noreferrer"><i class="fab fa-twitter-square"></i></a>
                    <?php endif; ?>

                    <?php if ($reddit_link = get_theme_mod('legal_justice_pro_social_reddit_link')) : ?>
                        <a href="<?php echo esc_url($reddit_link); ?>" target="_blank" rel="noopener noreferrer"><i class="fab fa-reddit"></i></a>
                    <?php endif; ?>

                    <?php if ($youtube_link = get_theme_mod('legal_justice_pro_social_youtube_link')) : ?>
                        <a href="<?php echo esc_url($youtube_link); ?>" target="_blank" rel="noopener noreferrer"><i class="fab fa-youtube"></i></a>
                    <?php endif; ?>

                    <?php if ($telegram_link = get_theme_mod('legal_justice_pro_social_telegram_link')) : ?>
                        <a href="<?php echo esc_url($telegram_link); ?>" target="_blank" rel="noopener noreferrer"><i class="fab fa-telegram"></i></a>
                    <?php endif; ?>
                </div>
            <?php else : ?>
                <!-- Content to display when the toggle switch is OFF -->
            <?php endif; ?>
        </div>
    </div>
</div>
