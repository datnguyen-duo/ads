<?php
defined( 'ABSPATH' ) || exit;
$layout = $args['layout'];
$preload_images = get_sub_field('preload_images');
$background_file = get_sub_field('background_file');

$header_args = array(
    'layout' => $layout,
    'pre_heading' => get_sub_field('pre_heading'),
    'heading' => get_sub_field('heading'),
    'description' => get_sub_field('description'),
    'cta' => get_sub_field('cta'),
); ?>

<?php if ($preload_images): ?>
    <div class="<?php echo $layout . '__preload'; ?>">
        <?php foreach ($preload_images as $image): ?>
            <img class="<?php echo $layout . '__preload-image'; ?>" src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" loading="eager">
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?php if ($background_file): ?>
    <div class="<?php echo $layout . '__background'; ?>">
        <div class="<?php echo $layout . '__background-overlay'; ?>"></div>
        <?php if ($background_file['type'] == 'video'): 
            // Check for mobile-specific video
            $mobile_video = get_sub_field('background_file_mobile');
            
            // Use responsive video function if mobile version exists, otherwise fallback to regular video
            if ($mobile_video && $mobile_video['type'] == 'video'): 
                responsive_video($background_file, $mobile_video, $layout . '__background-video', 'muted loop playsinline');
            else:
                // Fallback: use desktop video for all devices
                video($background_file['url'], $background_file['mime_type'], $layout . '__background-video', 'muted loop playsinline');
            endif;
        elseif ($background_file['type'] == 'image'): 
            image($background_file['ID'], 'full', $layout . '__background-image', $background_file['alt'] ? $background_file['alt'] : 'Hero Image', 'eager');
        endif; ?>
    </div>
<?php endif; ?>

<div class="<?php echo $layout . '__content'; ?>">
    <?php get_template_part('template-parts/sections/section', 'header', $header_args); ?>
    <div class="<?php echo $layout . '__play-button'; ?>">
        <img src="<?php echo get_template_directory_uri(); ?>/assets/thumbnail__watch-video.png" alt="Watch Video" loading="lazy">
        <p>▶ Watch Full Video</p>
    </div>
</div>