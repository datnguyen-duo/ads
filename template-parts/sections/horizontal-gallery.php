<?php
defined( 'ABSPATH' ) || exit;
$layout = $args['layout'];
$images = get_sub_field('images');
?>
<div class="<?php echo $layout . '__background'; ?>">
    <img class="<?php echo $layout . '__background-image'; ?>" src="<?php echo get_template_directory_uri(); ?>/assets/horizontal-gallery__background.svg" alt="Horizontal Gallery Background" loading="lazy">
</div>
<div class="<?php echo $layout . '__container swiper'; ?>" data-centered-slides="true">
    <div class="<?php echo $layout . '__wrapper swiper-wrapper'; ?>">
        <?php foreach ($images as $image): ?>
            <div class="<?php echo $layout . '__media media-container swiper-slide' . (!empty($image['caption']) ? ' has-caption' : ''); ?>">
                <?php image($image['ID'], 'full', $layout . '__media-image'); ?>
                <?php if (!empty($image['caption'])): ?>
                    <div class="<?php echo $layout . '__media-caption text__size-body--md'; ?>"><?php echo $image['caption']; ?></div>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
    <div class="<?php echo $layout . '__navigation swiper-buttons'; ?>">
        <button class="<?php echo $layout . '__navigation-button swiper-button-prev button__icon'; ?>">
            <?php icon_arrow(); ?>
        </button>
        <button class="<?php echo $layout . '__navigation-button swiper-button-next button__icon'; ?>">
            <?php icon_arrow(); ?>
        </button>
    </div>
</div>