<?php 
defined( 'ABSPATH' ) || exit; 
$layout = $args['layout'];
$source = get_sub_field('source');

// Map source to post type and taxonomy
$post_type_map = array(
    'regions' => 'region',
    'lodging' => 'lodging',
    'reviews' => 'review',
);

$taxonomy_map = array(
    'lodging' => 'lodging-option',
    'reviews' => 'review-type',
);

$post_type = isset($post_type_map[$source]) ? $post_type_map[$source] : 'post';
$taxonomy = isset($taxonomy_map[$source]) ? $taxonomy_map[$source] : '';

// Get terms if taxonomy exists, otherwise create a single "All" group
$terms = array();
if ($taxonomy) {
    $terms = get_terms(array(
        'taxonomy' => $taxonomy,
        'hide_empty' => true,
        'orderby' => 'term_id', // Order by creation order (ID)
        'order' => 'ASC',
    ));
} else {
    // For regions (no taxonomy), create a pseudo-term
    $all_term = new stdClass();
    $all_term->term_id = 0;
    $all_term->name = 'All Regions';
    $all_term->slug = 'all';
    $terms = array($all_term);
}

if (empty($terms) || is_wp_error($terms)) {
    return;
}

?>

<div class="<?php echo $layout . '__container'; ?>">
    <!-- Tab Navigation -->
    <div class="<?php echo $layout . '__tabs-navigation'; ?>">
        <?php foreach ($terms as $index => $term): ?>
            <button 
                class="<?php echo $layout . '__tab'; ?><?php echo $index === 0 ? ' active' : ''; ?>" 
                data-tab="<?php echo $term->term_id; ?>"
                data-tab-name="<?php echo esc_attr($term->name); ?>"
                data-source="<?php echo esc_attr($post_type); ?>"
                data-taxonomy="<?php echo esc_attr($taxonomy); ?>"
            >
                <?php echo esc_html($term->name); ?>
            </button>
        <?php endforeach; ?>
        <span class="<?php echo $layout . '__tab-indicator'; ?>"></span>
    </div>

    <!-- Slider Header -->
    <div class="<?php echo $layout . '__header'; ?>">
        <h2 class="<?php echo $layout . '__heading text__size-3'; ?>" data-active-tab-name>
            <?php echo esc_html($terms[0]->name); ?>
        </h2>
        <div class="<?php echo $layout . '__navigation swiper-buttons'; ?>">
            <button class="<?php echo $layout . '__navigation-button swiper-button-prev button__icon'; ?>">
                <?php icon_arrow(); ?>
            </button>
            <button class="<?php echo $layout . '__navigation-button swiper-button-next button__icon'; ?>">
                <?php icon_arrow(); ?>
            </button>
        </div>
    </div>

    <!-- Slider Content for each term -->
    <div class="<?php echo $layout . '__tabs-content'; ?>">
        <?php foreach ($terms as $index => $term): 
            // Query posts for this term
            $args = array(
                'post_type' => $post_type,
                'posts_per_page' => -1,
                'post_status' => 'publish',
            );

            if ($taxonomy && $term->term_id !== 0) {
                $args['tax_query'] = array(
                    array(
                        'taxonomy' => $taxonomy,
                        'field' => 'term_id',
                        'terms' => $term->term_id,
                    ),
                );
            }

            $query = new WP_Query($args);
            ?>

            <div 
                class="<?php echo $layout . '__slider-wrapper'; ?><?php echo $index === 0 ? ' active' : ''; ?>" 
                data-tab-content="<?php echo $term->term_id; ?>"
            >
                <?php if ($query->have_posts()): ?>
                    <div class="<?php echo $layout . '__slider swiper'; ?>">
                        <div class="<?php echo $layout . '__slides swiper-wrapper'; ?>">
                            <?php while ($query->have_posts()): $query->the_post(); 
                                $post_id = get_the_ID();
                                $featured_image_id = get_post_thumbnail_id($post_id);
                                $title = get_the_title();
                                $excerpt = get_field('excerpt', $post_id);
                                $author = get_field('author', $post_id);
                                $location = get_field('location', $post_id);
                                $dates = get_field('dates', $post_id);
                                if ($dates):
                                    $start_date = $dates['start_date'];
                                    $end_date = $dates['end_date'];
                                    $date_range = $start_date . ' - ' . $end_date;
                                endif;
                                $url = get_field('url', $post_id) ?: get_permalink($post_id);
                                ?>
                                <div class="<?php echo $layout . '__slide swiper-slide'; ?>">
                                    <div class="<?php echo $layout . '__card'; ?>">
                                        <?php if ($featured_image_id): ?>
                                            <div class="<?php echo $layout . '__card-media'; ?>">
                                                <?php image($featured_image_id, 'large', $layout . '__card-image'); ?>
                                            </div>
                                        <?php endif; ?>
                                        <h3 class="<?php echo $layout . '__card-title text__size-body--md text__body--bold'; ?>">
                                            <?php echo esc_html($title); ?>
                                        </h3>
                                        <?php if ($source === 'reviews'): ?>
                                            <p class="<?php echo $layout . '__card-excerpt'; ?>">
                                                <?php echo esc_html($excerpt); ?>
                                            </p>

                                            <a href="<?php echo esc_url($url); ?>" target="_blank" class="<?php echo $layout . '__card-link button button--primary'; ?>">
                                                <?php echo esc_html('Read Story'); ?>
                                            </a>

                                            <?php if ($author): ?>
                                                <p class="<?php echo $layout . '__card-author text__body--bold'; ?>">
                                                    <?php echo esc_html($author); ?>
                                                </p>
                                            <?php endif; ?>
                                            <?php if ($location): ?>
                                                <p class="<?php echo $layout . '__card-location text__size-body--sm'; ?>">
                                                    <?php echo esc_html($location); ?>
                                                </p>
                                            <?php endif; ?>
                                            <?php if ($date_range): ?>
                                                <p class="<?php echo $layout . '__card-date text__size-body--sm'; ?>">
                                                    <?php echo esc_html($date_range); ?>
                                                </p>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        </div>
                    </div>
                <?php else: ?>
                    <p class="<?php echo $layout . '__empty text__size-body--md'; ?>">No posts found.</p>
                <?php endif; ?>
                <?php wp_reset_postdata(); ?>
            </div>
        <?php endforeach; ?>
    </div>
</div>