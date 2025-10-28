<?php
/**
 * Reusable Gallery Slider Component
 * Matches the exact structure of entry__header-gallery
 * 
 * @param array $args {
 *     @type string $layout          Layout/section name for BEM classes (e.g., 'hero', 'entry__header')
 *     @type array  $images          Array of image IDs or image arrays
 *     @type string $size            Image size (default: 'full')
 *     @type string $content_slot    HTML content to inject inside the gallery (default: empty)
 *     @type bool   $show_navigation Show prev/next buttons inside content (default: true)
 *     @type bool   $show_pagination Show dots/pagination inside content (default: true)
 *     @type bool   $centered_slides Swiper centered slides option (default: true)
 *     @type bool   $fade            Enable fade effect (default: false)
 * }
 */
defined('ABSPATH') || exit;

$layout = $args['layout'] ?? 'gallery-slider';
$images = $args['images'] ?? array();
$size = $args['size'] ?? 'full';
$content_slot = $args['content_slot'] ?? '';
$show_navigation = $args['show_navigation'] ?? true;
$show_pagination = $args['show_pagination'] ?? true;
$centered_slides = $args['centered_slides'] ?? true;
$fade = $args['fade'] ?? false;

if (empty($images)) return;

$swiper_attrs = array();
if ($centered_slides) $swiper_attrs[] = 'data-centered-slides="true"';
if ($fade) $swiper_attrs[] = 'data-fade="true"';
$swiper_attrs_string = implode(' ', $swiper_attrs);
?>

<div class="<?php echo $layout; ?>__gallery swiper" <?php echo $swiper_attrs_string; ?>>
    <div class="<?php echo $layout; ?>__gallery-wrapper swiper-wrapper">
        <?php foreach ($images as $image) : 
            $image_id = is_array($image) ? $image['ID'] : $image;
            ?>
            <div class="<?php echo $layout; ?>__gallery-item swiper-slide">
                <?php image($image_id, $size, $layout . '__gallery-item-image'); ?>
            </div>
        <?php endforeach; ?>
    </div>
    <?php if ($content_slot): ?>
        <?php echo $content_slot; ?>
    <?php endif; ?>
</div>

