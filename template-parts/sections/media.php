<?php 
defined( 'ABSPATH' ) || exit; 
$layout = $args['layout'];
$media = get_sub_field('media');
$media_type = $media['type'];
?>
<div class="<?php echo $layout . '__background'; ?>">
    <img class="<?php echo $layout . '__background-image'; ?>" src="<?php echo get_template_directory_uri(); ?>/assets/experience-paths__background-1.svg" alt="Experience Paths Background" loading="lazy">
    <img class="<?php echo $layout . '__background-image'; ?>" src="<?php echo get_template_directory_uri(); ?>/assets/experience-paths__background-2.svg" alt="Experience Paths Background" loading="lazy">
</div>
<div class="<?php echo $layout . '__container'; ?>" data-animate-image>
    <?php if ($media_type == 'image'): ?>
        <?php image($media['ID'], 'full', $layout . '__image'); ?>
    <?php elseif ($media_type == 'video'): ?>
        <div class="video-play-container">
            <?php responsive_video($media, null, $layout . '__video', 'playsinline'); ?>
            <div class="video-play__button js-video-play">
                <div class="video-play__button-icon">
                    <?php icon_play('var(--color-light)'); ?>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>