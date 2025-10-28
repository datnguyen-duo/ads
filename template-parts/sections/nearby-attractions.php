<?php 
defined( 'ABSPATH' ) || exit; 
$layout = $args['layout'];
$reference = get_sub_field('reference');
?>
<h2 class="<?php echo $layout . '__heading text__size-3'; ?>">Nearby Attractions</h2>
<?php if ($reference): ?>
    <div class="<?php echo $layout . '__cards travel-cards'; ?>">
        <?php foreach ($reference as $post): 
            // Get post data
            $post_id = $post->ID;
            $title = get_the_title($post_id);
            $permalink = get_permalink($post_id);
            
            // Get first image from gallery field
            $gallery = get_field('gallery', $post_id);
            $first_image = !empty($gallery) ? $gallery[0] : null;
        ?>
            <a href="<?php echo esc_url($permalink); ?>" class="<?php echo $layout . '__card travel-cards__card'; ?>">
                <?php if ($first_image): ?>
                    <div class="<?php echo $layout . '__card-media travel-cards__card-media'; ?>">
                        <?php image($first_image['ID'], 'large', $layout . '__card-image travel-cards__card-image'); ?>
                    </div>
                <?php endif; ?>
                <h3 class="<?php echo $layout . '__card-title travel-cards__card-title text__size-body--md text__body--bold'; ?>">
                    <?php echo esc_html($title); ?>
                </h3>
            </a>
        <?php endforeach; ?>
    </div>
<?php endif; ?>