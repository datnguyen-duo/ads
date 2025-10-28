<?php
defined( 'ABSPATH' ) || exit;
$layout = $args['layout'];
$slides = get_sub_field('slides');
?>
<div class="<?php echo $layout . '__container'; ?>" data-flip-slider>
    <div class="<?php echo $layout . '__stack'; ?>">
        <?php foreach ($slides as $index => $slide):
            $image = $slide['image'];
            $caption = $slide['caption'];
            ?>
            <div class="<?php echo $layout . '__slide js-flip-item'; ?>" data-slide-index="<?php echo $index; ?>">
                <div class="<?php echo $layout . '__slide-inner js-flip-content media-container'; ?>">
                    <?php image($image['ID'], 'full', $layout . '__slide-image'); ?>
                    <?php if ($caption): ?>
                        <div class="<?php echo $layout . '__slide-caption text__size-body--md'; ?>"><?php echo $caption; ?></div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    
    <!-- Navigation Buttons -->
    <div class="<?php echo $layout . '__navigation'; ?>">
        <button class="<?php echo $layout . '__navigation-button ' . $layout . '__navigation-button--prev button__icon'; ?>" data-flip-prev>
            <img class="button__icon-image" src="<?php echo get_template_directory_uri(); ?>/assets/icons/arrow.svg" alt="Previous slide" loading="lazy">
        </button>
        <button class="<?php echo $layout . '__navigation-button ' . $layout . '__navigation-button--next button__icon'; ?>" data-flip-next>
            <img class="button__icon-image" src="<?php echo get_template_directory_uri(); ?>/assets/icons/arrow.svg" alt="Next slide" loading="lazy">
        </button>
    </div>
</div>