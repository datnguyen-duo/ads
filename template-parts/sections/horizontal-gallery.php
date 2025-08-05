<?php
defined( 'ABSPATH' ) || exit;
$layout = $args['layout'];
$images = get_sub_field('images');
?>

<div class="<?php echo $layout . '__background'; ?>">
    <img class="<?php echo $layout . '__background-image'; ?>" src="<?php echo get_template_directory_uri(); ?>/assets/horizontal-gallery__background.svg" alt="Horizontal Gallery Background" loading="lazy">
</div>

<div class="<?php echo $layout . '__container'; ?>">
    <?php foreach ($images as $image): ?>
        <div class="<?php echo $layout . '__media media-container' . (!empty($image['caption']) ? ' has-caption' : ''); ?>">
            <?php image($image['ID'], 'full', $layout . '__media-image'); ?>
            <?php if (!empty($image['caption'])): ?>
                <div class="<?php echo $layout . '__media-caption text__size-body--lg'; ?>"><?php echo $image['caption']; ?></div>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
</div>
