<?php
defined('ABSPATH') || exit;
$layout = isset($args['layout']) ? $args['layout'] : 'posts';
$post_id = get_the_ID();
$post_type = get_post_type($post_id);
$title = get_the_title();

// Get image - check featured image first, then gallery field
$image_id = get_post_thumbnail_id($post_id);
if (!$image_id) {
    $gallery = get_field('gallery', $post_id);
    if ($gallery && is_array($gallery) && !empty($gallery)) {
        // Gallery field can return array of IDs or array of image objects
        $first_image = $gallery[0];
        if (is_array($first_image)) {
            // If it's an image object, get the ID
            $image_id = isset($first_image['ID']) ? $first_image['ID'] : (isset($first_image['id']) ? $first_image['id'] : null);
        } else {
            // If it's just an ID
            $image_id = $first_image;
        }
    }
}

// DEBUG: Uncomment to see what's being found
// error_log('Post ID: ' . $post_id . ' | Image ID: ' . ($image_id ? $image_id : 'NONE') . ' | Post Type: ' . $post_type);

// Get URL - reviews use ACF field, others use permalink
if ($post_type === 'review') {
    $url = get_field('url', $post_id);
    if (!$url) {
        $url = get_permalink($post_id);
    }
} else {
    $url = get_permalink($post_id);
}
?>

<a href="<?php echo esc_url($url); ?>" class="<?php echo $layout . '__card'; ?>">
    <div class="<?php echo $layout . '__card-media'; ?>">
        <?php if ($image_id): ?>
            <?php image($image_id, 'large', $layout . '__card-image'); ?>
        <?php else: ?>
            <div class="<?php echo $layout . '__card-placeholder'; ?>" style="width: 100%; height: 100%; background-color: #e5e7eb; display: flex; align-items: center; justify-content: center; color: #9ca3af;">
                No Image
            </div>
        <?php endif; ?>
    </div>
    <h3 class="<?php echo $layout . '__card-title text__size-body--md text__body--bold'; ?>">
        <?php echo esc_html($title); ?>
    </h3>
</a>

