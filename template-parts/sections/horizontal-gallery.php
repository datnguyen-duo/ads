<?php
defined( 'ABSPATH' ) || exit;
$layout = $args['layout'];
$images = get_sub_field('images');
?>

<div class="<?php echo $layout . '__container'; ?>">
    <?php foreach ($images as $image): ?>
        <div class="<?php echo $layout . '__media media-container'; ?>">
            <?php image($image['ID'], 'full', $layout . '__media-image'); ?>
        </div>
    <?php endforeach; ?>
</div>
