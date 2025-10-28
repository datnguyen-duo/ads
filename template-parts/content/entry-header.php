<?php
defined( 'ABSPATH' ) || exit;
$ID = get_the_ID();
$title = get_the_title();
$description = get_field('description', $ID);
$gallery = get_field('gallery', $ID);

?>
<div class="entry__header">
    <?php if ($gallery) : ?>
        <div class="entry__header-gallery swiper" data-centered-slides="true" data-fade="true">
            <div class="entry__header-gallery-wrapper swiper-wrapper">
                <?php foreach ($gallery as $key => $image) : ?>
                    <div class="entry__header-gallery-item swiper-slide">
                        <?php image($image['ID'], 'full', 'entry__header-gallery-item-image'); ?>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="entry__header-content">
                <h1 class="entry__title" data-animate-words data-play-immediately><?php echo $title; ?></h1>
                <?php if ($description) : ?>
                    <p class="entry__description" data-animate-block><?php echo $description; ?></p>
                <?php endif; ?>
                <div class="entry__header-gallery-navigation">
                    <div class="entry__header-gallery-dots swiper-pagination"></div>
                    <div class="entry__header-gallery-buttons swiper-buttons">
                        <button class="entry__header-gallery-navigation-button swiper-button-prev button__icon --ghost">
                            <?php icon_arrow(); ?>
                        </button>
                        <button class="entry__header-gallery-navigation-button swiper-button-next button__icon --ghost">
                            <?php icon_arrow(); ?>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>