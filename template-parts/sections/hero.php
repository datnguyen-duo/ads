<?php
defined( 'ABSPATH' ) || exit;
$layout = $args['layout'];
$background_file = get_sub_field('background_file');
$header_args = array(
    'layout' => $layout,
    'pre_heading' => get_sub_field('pre_heading'),
    'heading' => get_sub_field('heading'),
    'description' => get_sub_field('description'),
    'cta' => get_sub_field('cta'),
); ?>
<?php if ($background_file): ?>
    <div class="<?php echo $layout . '__background'; ?>">
        <?php if ($background_file['type'] == 'video'): 
            $mobile_video = get_sub_field('background_file_mobile');
            if ($mobile_video && $mobile_video['type'] == 'video'): 
                responsive_video($background_file, $mobile_video, $layout . '__background-video', 'autoplay muted loop playsinline');
            else:
                video($background_file['url'], $background_file['mime_type'], $layout . '__background-video', 'autoplay muted loop playsinline');
            endif;
        elseif ($background_file['type'] == 'image'): 
            image($background_file['ID'], 'full', $layout . '__background-image', $background_file['alt'] ? $background_file['alt'] : 'Hero Image', 'eager');
        endif; ?>
    </div>
<?php endif; ?>
<div class="<?php echo $layout . '__content'; ?>">
    <?php get_template_part('template-parts/sections/section', 'header', $header_args); ?>
</div>