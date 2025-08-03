<?php
defined( 'ABSPATH' ) || exit;
$layout = 'archive';
$term_id = get_queried_object_id();
$settings = array(
    'post_type' => 'post',
    'filter_term' => 'category',
    'term_id' => $term_id,
);

set_query_var('layout', $layout);
set_query_var('settings', $settings);
set_query_var('variation', 'default');

?>
<?php if (have_posts()) : ?>
    <div class="<?php echo $layout . '__items posts cards --type-' . $settings['post_type']; ?>" data-post-type="<?php echo $settings['post_type']; ?>" data-filter-term="<?php echo $settings['filter_term']; ?>" data-posts-per-page="9" data-current-term-id="<?php echo $settings['term_id']?>" style="--posts-per-page: 3;"> 
        <?php 
        while (have_posts()) : 
            the_post(); 
            get_template_part('template-parts/content/content', 'card');
        endwhile; wp_reset_postdata();
        $current_page = 1;
        global $wp_query;
        $total_pages = $wp_query->max_num_pages;
        $range = 1;
        $has_more_post = ($total_pages > 1);
        if ($current_page <= 2) {
            $start_page = 1;
            $end_page = min(3, $total_pages);
        } elseif ($current_page >= $total_pages - 1) {
            $start_page = max(1, $total_pages - 2);
            $end_page = $total_pages;
        } else {
            $start_page = $current_page - $range;
            $end_page = $current_page + $range;
        }
        set_query_var('current_page', $current_page);
        set_query_var('total_pages', $total_pages);
        set_query_var('start_page', $start_page);
        set_query_var('end_page', $end_page);

        ?>
        <?php else :
            get_template_part('template-parts/content/content', 'none');
        endif; wp_reset_postdata(); ?>
    </div>
<?php if ($has_more_post) :
    get_template_part('template-parts/content/content', 'pagination');
endif; ?>

