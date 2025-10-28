<?php
defined( 'ABSPATH' ) || exit;
$layout = $args['layout'];
$pre_heading = get_sub_field('pre_heading');
$heading = get_sub_field('heading');
$description = get_sub_field('description');
$button = get_sub_field('button');
$header_args = array(
    'layout' => $layout,
    'pre_heading' => $pre_heading,
    'heading' => $heading,
    'description' => $description,
    'cta' => '',
);
$source = get_sub_field('source');
$posts_per_page = get_sub_field('posts_per_page') ?: 8;

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

// Get terms for filters
$terms = array();
if ($taxonomy) {
    $terms = get_terms(array(
        'taxonomy' => $taxonomy,
        'hide_empty' => true,
        'orderby' => 'term_id',
        'order' => 'ASC',
    ));
}

// Initial query for all posts
$initial_args = array(
    'post_type' => $post_type,
    'posts_per_page' => $posts_per_page,
    'paged' => 1,
    'post_status' => 'publish',
);

$initial_query = new WP_Query($initial_args);
$total_posts = $initial_query->found_posts;
?>

<?php get_template_part('template-parts/sections/section', 'header', $header_args); ?>

<div class="<?php echo $layout . '__bar'; ?>" data-animate-block>
    <div class="<?php echo $layout . '__filters'; ?>">
        <button 
            class="<?php echo $layout . '__filter text__body--bold text__size-body--sm'; ?> active" 
            data-term-id="all"
            data-taxonomy="<?php echo esc_attr($taxonomy); ?>"
        >
            All
        </button>
        <?php if (!empty($terms) && !is_wp_error($terms)): ?>
            <?php foreach ($terms as $term): 
                $term_text = get_field('text', $term);
                $term_video = get_field('video', $term);
            ?>
                <button 
                    class="<?php echo $layout . '__filter text__body--bold text__size-body--sm'; ?>" 
                    data-term-id="<?php echo esc_attr($term->term_id); ?>"
                    data-taxonomy="<?php echo esc_attr($taxonomy); ?>"
                    <?php if (!empty($term->description)): ?>data-has-tooltip="true"<?php endif; ?>
                >
                    <span class="<?php echo $layout . '__filter-label'; ?>">
                        <?php echo esc_html($term->name); ?>
                        <?php if (!empty($term->description)): ?>
                            <span class="<?php echo $layout . '__filter-icon'; ?>">
                                <?php icon_tooltip(); ?>
                            </span>
                        <?php endif; ?>
                    </span>

                    <?php if (!empty($term_text)): ?>
                        <span class="<?php echo $layout . '__filter-text'; ?>">
                            <?php echo esc_html($term_text); ?>
                        </span>
                    <?php endif; ?>
                    <?php if (!empty($term->description)): ?>
                        <span class="<?php echo $layout . '__tooltip'; ?>">
                            <span class="<?php echo $layout . '__tooltip-arrow'; ?>"></span>
                            <span class="<?php echo $layout . '__tooltip-content text__size-body--sm'; ?>">
                                <?php echo esc_html($term->description); ?>
                            </span>
                            <?php if (!empty($term_video)): ?>
                                <div class="<?php echo $layout . '__tooltip-link button__text'; ?>">
                                    Watch Video
                                </div>
                            <?php endif; ?>
                        </span>
                    <?php endif; ?>
                </button>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
    <?php if ($button): ?>
        <div class="<?php echo $layout . '__button'; ?>" >
            <?php button($button['title'], $button['url'], $button['target']); ?>
        </div>
    <?php endif; ?>
</div>

<p class="<?php echo $layout . '__results text__body--bold'; ?>" data-animate-block>
    Filtered Results (<span class="<?php echo $layout . '__results-count'; ?>"><?php echo $total_posts; ?></span>)
</p>

<div class="<?php echo $layout . '__posts-container'; ?>">
    <div 
        class="<?php echo $layout . '__posts'; ?>" 
        data-post-type="<?php echo esc_attr($post_type); ?>"
        data-taxonomy="<?php echo esc_attr($taxonomy); ?>"
        data-posts-per-page="<?php echo esc_attr($posts_per_page); ?>"
        data-current-page="1"
    >
        <?php if ($initial_query->have_posts()): ?>
            <?php while ($initial_query->have_posts()): $initial_query->the_post(); ?>
                <?php get_template_part('template-parts/content/content', 'card', array('layout' => $layout)); ?>
            <?php endwhile; ?>
        <?php endif; ?>
        <?php wp_reset_postdata(); ?>
    </div>
    
    <!-- Loading Overlay -->
    <div class="<?php echo $layout . '__loading-overlay'; ?>">
        <div class="<?php echo $layout . '__spinner'; ?>">
            <?php icon_spinner('var(--color-primary-1)'); ?>
        </div>
    </div>
</div>

<?php if ($initial_query->found_posts > $posts_per_page): ?>
    <div class="<?php echo $layout . '__load-more'; ?>">
        <button class="<?php echo $layout . '__load-more-button button button--primary'; ?>">
            Load More
        </button>
    </div>
<?php endif; ?>