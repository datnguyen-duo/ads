<?php
defined('ABSPATH') || exit;

add_action('wp_ajax_search_posts', 'search_posts');
add_action('wp_ajax_nopriv_search_posts', 'search_posts');

function search_posts() {
    ob_start();
    $paged = 1;
    $posts_per_page = isset($_POST['posts_per_page']) ? sanitize_text_field($_POST['posts_per_page']) : '';
    $post_type = isset($_POST['post_type']) ? sanitize_text_field($_POST['post_type']) : 'post';
    $search_value = isset($_POST['search_value']) ? sanitize_text_field($_POST['search_value']) : '';
    $filter_term = isset($_POST['filter_term']) ? sanitize_text_field($_POST['filter_term']) : '';
    $term_id = isset($_POST['term_id']) ? sanitize_text_field($_POST['term_id']) : '';

    $settings = array(
        'post_type' => $post_type,
    );

    set_query_var('settings', $settings);

    $args = array(
        'post_type' => $post_type,
        'paged' => $paged,
        'posts_per_page' => $posts_per_page,
        'post_status' => 'publish',
        's' => $search_value,
        'orderby' => 'date',
        'order' => 'DESC',
    );

    // Add taxonomy query if term is selected
    if ($term_id) {
        $args['tax_query'] = array(
            array(
                'taxonomy' => $filter_term,
                'field' => 'term_id',
                'terms' => $term_id,
            ),
        );
    }

    $query = new WP_Query($args);
    
    $current_page = $paged;
    $total_pages = $query->max_num_pages;
    $start_page = 1;
    $end_page = min(3, $total_pages);
    
    set_query_var('current_page', $current_page);
    set_query_var('total_pages', $total_pages);
    set_query_var('start_page', $start_page);
    set_query_var('end_page', $end_page);


    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $ID = get_the_ID();
            get_template_part('template-parts/content/content', 'card');
        }
    } else {
        get_template_part('template-parts/content/content', 'none');
    }
    wp_reset_postdata();
    $content = ob_get_clean();
    echo $content;
    wp_die();
}
?>