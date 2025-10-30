<?php 
defined( 'ABSPATH' ) || exit; 
$layout = $args['layout'];
$variation = get_sub_field('variation');
$heading = get_sub_field('heading');
$description = get_sub_field('description');
$source = get_sub_field('source');
$cards = get_sub_field('cards');
$reference = get_sub_field('reference');

// Prepare cards array based on source
$cards_to_display = array();

if ($source === 'reference' && $reference) {
    // Use reference posts
    $cards_to_display = $reference;
} elseif ($cards) {
    // Use manual cards
    $cards_to_display = $cards;
}

$header_args = array(
    'layout' => $layout,
    'pre_heading' => '',
    'heading' => $heading,
    'description' => $description,
    'cta' => '',
);

$is_autoplay = ($variation === 'autoplay');
?>
<div class="<?php echo $layout . '__container'; ?>">
    <?php get_template_part('template-parts/sections/section', 'header', $header_args); ?>
    <?php if ($is_autoplay): ?>
        <!-- Marquee mode for autoplay -->
        <div class="<?php echo $layout . '__cards--marquee'; ?>" data-marquee-container data-marquee-pause="true">
            <div class="<?php echo $layout . '__cards-track'; ?>" data-marquee data-marquee-speed="100">
                <!-- Wrap all cards in a single marquee__item, JS will clone this entire group -->
                <div class="marquee__item">
                <?php foreach ($cards_to_display as $card):
                if ($source === 'reference'): 
                    // Reference card (from Reviews post type)
                    $post_id = is_object($card) ? $card->ID : $card;
                    $featured_image_id = get_post_thumbnail_id($post_id);
                    $excerpt = get_field('excerpt', $post_id);
                    $author = get_field('author', $post_id);
                    $location = get_field('location', $post_id);
                    $url = get_field('url', $post_id) ?: get_permalink($post_id);
                    ?>
                    <a href="<?php echo esc_url($url); ?>" class="<?php echo $layout . '__card'; ?> <?php echo $layout . '__card--reference'; ?>" target="_blank" rel="noopener noreferrer">
                        <?php if ($featured_image_id): ?>
                            <?php image($featured_image_id, 'large', $layout . '__card-image'); ?>
                        <?php endif; ?>
                        <div class="<?php echo $layout . '__card-content'; ?>">
                            <?php if ($excerpt): ?>
                                <p class="text__size-body--sm card-slider__card-content-text--excerpt"><?php echo esc_html($excerpt); ?></p>
                            <?php endif; ?>
                            <?php if ($author): ?>
                                <p class="text__size-body--sm text__body--bold card-slider__card-content-text--author"><?php echo esc_html($author); ?></p>
                            <?php endif; ?>
                            <?php if ($location): ?>
                                <p class="text__size-body--sm card-slider__card-content-text--location"><?php echo esc_html($location); ?></p>
                            <?php endif; ?>
                        </div>
                    </a>
                <?php else: 
                    // Manual card
                    $image = $card['image'];
                    $content = $card['content'];
                    $link = $card['link'];
                    ?>
                    <div class="<?php echo $layout . '__card'; ?>">
                        <?php if ($image): ?>
                            <?php image($image['ID'], 'medium', $layout . '__card-image'); ?>
                        <?php endif; ?>
                        <?php if ($content): 
                            $title = $content['title'];
                            $text = $content['text'];
                            ?>
                            <div class="<?php echo $layout . '__card-content'; ?>">
                                <?php if ($title): ?>
                                    <p class="<?php echo $layout . '__card-content-title text__size-body--lg'; ?>"><?php echo $title; ?></p>
                                <?php endif; ?>
                                <?php if ($text): ?>
                                    <div class="<?php echo $layout . '__card-content-text rte'; ?>"><?php echo $text; ?></div>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                        <?php if ($link): ?>
                            <a class="<?php echo $layout . '__card-link button__text'; ?>" href="<?php echo $link['url']; ?>"><?php echo $link['title']; ?></a>
                        <?php endif; ?>
                    </div>
                <?php endif; 
                endforeach;
                ?>
                </div><?php // End marquee__item wrapper ?>
            </div>
        </div>
    <?php else: ?>
        <!-- Swiper mode for default -->
        <div class="<?php echo $layout . '__cards swiper'; ?>" data-variation="<?php echo esc_attr($variation); ?>">
            <div class="<?php echo $layout . '__cards-wrapper swiper-wrapper'; ?>">
                <?php foreach ($cards_to_display as $card): ?>
                    <?php if ($source === 'reference'): 
                        // Reference card (from Reviews post type)
                        $post_id = is_object($card) ? $card->ID : $card;
                        $featured_image_id = get_post_thumbnail_id($post_id);
                        $excerpt = get_field('excerpt', $post_id);
                        $author = get_field('author', $post_id);
                        $location = get_field('location', $post_id);
                        $url = get_field('url', $post_id) ?: get_permalink($post_id);
                        ?>
                        <a href="<?php echo esc_url($url); ?>" class="<?php echo $layout . '__card swiper-slide'; ?> <?php echo $layout . '__card--reference'; ?>" target="_blank" rel="noopener noreferrer">
                            <?php if ($featured_image_id): ?>
                                <?php image($featured_image_id, 'medium', $layout . '__card-image'); ?>
                            <?php endif; ?>
                            <div class="<?php echo $layout . '__card-content'; ?>">
                                <?php if ($excerpt): ?>
                                    <p class="text__size-body--sm card-slider__card-content-text--excerpt"><?php echo esc_html($excerpt); ?></p>
                                <?php endif; ?>
                                <?php if ($author): ?>
                                    <p class="text__size-body--sm text__body--bold card-slider__card-content-text--author"><?php echo esc_html($author); ?></p>
                                <?php endif; ?>
                                <?php if ($location): ?>
                                    <p class="text__size-body--sm card-slider__card-content-text--location"><?php echo esc_html($location); ?></p>
                                <?php endif; ?>
                            </div>
                        </a>
                    <?php else: 
                        // Manual card
                        $image = $card['image'];
                        $content = $card['content'];
                        $link = $card['link'];
                        ?>
                        <div class="<?php echo $layout . '__card swiper-slide'; ?>">
                            <?php if ($image): ?>
                                <?php image($image['ID'], 'medium', $layout . '__card-image'); ?>
                            <?php endif; ?>
                            <?php if ($content): 
                                $title = $content['title'];
                                $text = $content['text'];
                                ?>
                                <div class="<?php echo $layout . '__card-content'; ?>">
                                    <?php if ($title): ?>
                                        <p class="<?php echo $layout . '__card-content-title text__size-body--lg'; ?>"><?php echo $title; ?></p>
                                    <?php endif; ?>
                                    <?php if ($text): ?>
                                        <div class="<?php echo $layout . '__card-content-text rte'; ?>"><?php echo $text; ?></div>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                            <?php if ($link): ?>
                                <a class="<?php echo $layout . '__card-link button__text'; ?>" href="<?php echo $link['url']; ?>"><?php echo $link['title']; ?></a>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
            <div class="<?php echo $layout . '__cards-navigation swiper-buttons'; ?>">
                <button class="<?php echo $layout . '__cards-navigation-button swiper-button-prev button__icon'; ?>">
                    <?php icon_arrow(); ?>
                </button>
                <button class="<?php echo $layout . '__cards-navigation-button swiper-button-next button__icon'; ?>">
                    <?php icon_arrow(); ?>
                </button>
            </div>
        </div>
    <?php endif; ?>
</div>