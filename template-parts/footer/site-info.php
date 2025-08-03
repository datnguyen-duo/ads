<?php
defined( 'ABSPATH' ) || exit;
$primary_logo = get_field('primary_logo', 'option');
$tagline = get_bloginfo('description');
$email = get_field('email', 'option');
$phone = get_field('phone', 'option');
$address = get_field('address', 'option');
$social_media_links = get_field('social_media_links', 'option');
?>

<div class="site-info">
    <?php if ($primary_logo): ?>
        <div class="site-info__logo">
            <?php image($primary_logo['id'], 'full', 'site-info__logo-image'); ?>
        </div>
    <?php endif; ?>
    
    <?php if ($tagline): ?>
        <p class="site-info__tagline">
            <?php echo $tagline; ?>
        </p>
    <?php endif; ?>

    <?php if ($email || $phone || $address): ?>
        <a href="mailto:<?php echo $email; ?>" class="text__size-5"><?php echo $email; ?></a>
    <?php endif; ?>
    <?php if ($phone): ?>
        <a href="tel:<?php echo $phone; ?>" class="text__size-5"><?php echo $phone; ?></a>
    <?php endif; ?>
    <?php if ($address): ?>
        <p class="text__size-5"><?php echo $address; ?></p>
    <?php endif; ?>
    <?php if ($social_media_links): ?>
        <div class="site-info__social-media">
            <?php 
            $platform_labels = [
                'facebook' => 'Facebook',
                'instagram' => 'Instagram',
                'linkedin' => 'LinkedIn',
                'twitter' => 'Twitter',
                'x' => 'X',
                'youtube' => 'YouTube',
                'pinterest' => 'Pinterest',
                'tiktok' => 'TikTok',
                'reddit' => 'Reddit',
                'whatsapp' => 'WhatsApp',
                'flickr' => 'Flickr',
                'snapchat' => 'Snapchat'
            ];
            foreach ($social_media_links as $link): 
                $platform_label = isset($platform_labels[$link['platform']]) ? 
                    $platform_labels[$link['platform']] : $link['platform'];
            ?>
                <a href="<?php echo esc_url($link['link']); ?>" class="text__size-4"><?php echo esc_html($platform_label); ?></a>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

</div> 