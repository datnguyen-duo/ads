<?php
defined( 'ABSPATH' ) || exit;
$copyright = get_field('copyright', 'option');
$license = get_field('license', 'option');
$social_media_links = get_field('social_media_links', 'option');
$privacy_policy = get_privacy_policy_url();
?>
<div class="site-footer__bottom">
    <p class="site-footer__bottom-copyright text__size-body--sm">
        &copy;<?php echo date('Y'); ?> <?php echo $copyright ? $copyright : get_bloginfo('name') . ' All rights reserved.'; ?>
        <?php echo $license ? $license : ''; ?>
    </p>

    <a href="/booking-and-flights/booking-terms-and-conditions" class="site-footer__bottom-privacy-policy text__size-body--sm">Terms & Conditions</a>

    <?php if ($social_media_links): ?>
        <div class="site-footer__bottom-social-media">
            <?php 
            $platform_labels = [
                'facebook' => 'Facebook',
                'instagram' => 'Instagram',
                'linkedin' => 'LinkedIn',
                'twitter' => 'Twitter',
                'x' => 'X',
                'youtube' => 'YouTube',
                'google' => 'Google',
                'pinterest' => 'Pinterest',
                'vimeo' => 'Vimeo',
                'tiktok' => 'TikTok',
                'reddit' => 'Reddit',
                'whatsapp' => 'WhatsApp',
                'flickr' => 'Flickr',
                'snapchat' => 'Snapchat'
            ];
            foreach ($social_media_links as $link): 
                $platform = $link['platform'];
                $platform_label = isset($platform_labels[$platform]) ? $platform_labels[$platform] : $platform;
                $icon_function = 'icon_' . str_replace('+', '_plus', $platform);
            ?>
                <a class="site-footer__bottom-social-media-link" href="<?php echo esc_url($link['link']); ?>" aria-label="<?php echo esc_attr($platform_label); ?>">
                    <?php if (function_exists($icon_function)): ?>
                        <?php call_user_func($icon_function, 'currentColor'); ?>
                    <?php else: ?>
                        <?php echo esc_html($platform_label); ?>
                    <?php endif; ?>
                </a>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>