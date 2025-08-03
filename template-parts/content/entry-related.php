<?php
defined( 'ABSPATH' ) || exit;
$categories = get_the_category();
$post_type = get_post_type();
$settings = array(
    'post_type' => $post_type,
);
set_query_var( 'settings', $settings );

if ( $categories ) {
    $category_ids = array();
    foreach ( $categories as $category ) {
        $category_ids[] = $category->term_id;
    }
    $args = array(
        'post_type'           => $post_type,
        'post__not_in'        => array( get_the_ID() ),
        'posts_per_page'      => 3,
        'ignore_sticky_posts' => 1,
        // 'category__in'        => $category_ids,
    );
}
    $related_query = new WP_Query( $args );
    if ( $related_query->have_posts() ) : 
        $counter = 0;
        ?>
        <div class="entry__related" style="--posts-per-page: 3">
            <div class="entry__related-container container">
                <p class="entry__related-title text__size-2">Continue Reading</p>
                <div class="posts posts--related cards --type-<?php echo $post_type;?>">
                    <?php while ( $related_query->have_posts() ){
                        $related_query->the_post();
                        $ID = get_the_ID();
                        $counter++;
                        set_query_var('counter', $counter);
                        get_template_part('template-parts/content/content',  'card');    
                    }; wp_reset_postdata(); ?>
                </div>
                <div class="entry__related-button">
                    <a href="/insights/#all-articles" class="button --light">View All Articles</a>
                </div>
            </div>
        </div>
    <?php else :
        get_template_part('template-parts/content/content', 'none');
    endif;

?>