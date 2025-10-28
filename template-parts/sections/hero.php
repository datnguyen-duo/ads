<?php
defined( 'ABSPATH' ) || exit;
$layout = $args['layout'];
$variation = get_sub_field('variation');
$background_file = get_sub_field('background_file');
$gallery = get_sub_field('gallery');
$header_args = array(
    'layout' => $layout,
    'pre_heading' => get_sub_field('pre_heading'),
    'heading' => get_sub_field('heading'),
    'description' => get_sub_field('description'),
    'cta' => get_sub_field('cta'),
); ?>

<?php if ($variation == 'medium-impact' && $gallery): ?>
    <!-- Medium Impact: Clone of entry__header structure with section-header content -->
    <?php 
    // Build the content slot HTML (matches entry__header-content structure)
    ob_start();
    ?>
    <div class="<?php echo $layout; ?>__content">
        <?php get_template_part('template-parts/sections/section', 'header', $header_args); ?>
        <div class="<?php echo $layout; ?>__gallery-navigation">
            <div class="<?php echo $layout; ?>__gallery-dots swiper-pagination"></div>
            <div class="<?php echo $layout; ?>__gallery-buttons swiper-buttons">
                <button class="<?php echo $layout; ?>__gallery-navigation-button swiper-button-prev button__icon --ghost">
                    <?php icon_arrow(); ?>
                </button>
                <button class="<?php echo $layout; ?>__gallery-navigation-button swiper-button-next button__icon --ghost">
                    <?php icon_arrow(); ?>
                </button>
            </div>
        </div>
    </div>
    <?php
    $content_slot = ob_get_clean();
    
    // Use reusable gallery slider with cloned entry__header structure
    get_template_part('template-parts/sections/gallery', 'slider', array(
        'layout' => $layout,
        'images' => $gallery,
        'size' => 'full',
        'content_slot' => $content_slot,
        'centered_slides' => true,
        'fade' => true
    )); 
    ?>

<?php elseif ($background_file && $variation == 'high-impact'): ?>
    <!-- High Impact: Video or image background -->
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
    <div class="<?php echo $layout . '__content'; ?>">
        <?php get_template_part('template-parts/sections/section', 'header', $header_args); ?>
    </div>

<?php else: ?>
    <!-- Low Impact: Simple content only -->
    <div class="<?php echo $layout . '__content'; ?>">
        <?php get_template_part('template-parts/sections/section', 'header', $header_args); ?>
    </div>
<?php endif; ?>