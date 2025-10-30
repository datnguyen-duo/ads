<?php
defined( 'ABSPATH' ) || exit; 
$post_type = get_post_type();
$ID = get_the_ID();

//Sidebar content start
$location = get_field('location', $ID);
$best_months = get_field('best_months_to_visit', $ID);
$most_known_for = get_field('most_known_for', $ID);
$activities = get_field('activities', $ID);
$wildlife = get_field('wildlife', $ID);
$video = get_field('video', $ID);
$video_title = get_field('video_title', $ID);
$video_poster = get_field('video_poster', $ID);

$best_known_for = get_field('best_known_for', $ID);
$size = get_field('size', $ID);
$topography = get_field('topography', $ID);
$main_species = get_field('main_species', $ID);
//Sidebar content end

$map_url = get_field('map_url', $ID);

// Collect section data for navigation using get_field to avoid consuming the loop
$section_nav_items = array();
$sections_data = get_field('sections', $ID);
if ($sections_data) :
    $section_index = 0;
    foreach ($sections_data as $section) :
        $layout = $section['acf_fc_layout'];
        $heading = isset($section['heading']) ? $section['heading'] : '';
        
        // Generate label: use heading if available, otherwise format layout name
        $label = $heading ? $heading : ucwords(str_replace('-', ' ', $layout));
        
        $section_nav_items[] = array(
            'layout' => $layout,
            'label' => $label,
            'index' => $section_index
        );
        
        $section_index++;
    endforeach;
endif;
?>
<div class="entry__content">
    <div class="entry__content-navigation">
        <div class="entry__content-navigation-container page-container">
            <?php if (!empty($section_nav_items)) : ?>
                <nav class="entry__content-navigation-menu">
                    <?php foreach ($section_nav_items as $item): ?>
                        <a href="#<?php echo $item['layout']; ?>" class="entry__content-navigation-link button button--neutral">
                            <?php echo esc_html($item['label']); ?>
                        </a>
                    <?php endforeach; ?>
                </nav>
            <?php endif; ?>
            <?php if ($map_url) : ?>
                <a href="<?php echo $map_url; ?>" target="_blank" class="entry__content-navigation-link button button--primary">
                    <?php _e('Show on Map', 'africadreamsafaris'); ?>
                </a>
            <?php endif; ?>
        </div>
    </div>
    <?php if (have_rows('sections', $ID)) : ?>
        <div class="entry__content-container page-container">
            <div class="entry__content-sections">
                <?php while (have_rows('sections', $ID)) : 
                    the_row(); 
                    $layout = get_row_layout();
                    $section_path = 'template-parts/sections/' . $layout;
                    ?>
                    <section class="<?php echo $layout; ?>" id="<?php echo $layout; ?>" style="--color-section-background: var(--color-light);">
                        <?php get_template_part($section_path, null, array('layout' => $layout)); ?>
                    </section>
                <?php 
                endwhile; ?>
            </div>
            <div class="entry__content-sidebar" data-lenis-prevent>
                <?php 
                // Define sidebar sections with their labels and fields
                $sidebar_sections = array(
                    array(
                        'label' => 'Location',
                        'content' => $location
                    ),
                    array(
                        'label' => 'Best Months to Visit',
                        'content' => $best_months
                    ),
                    array(
                        'label' => 'Video',
                        'content' => $video,
                        'type' => 'video',
                        'video_title' => $video_title,
                        'video_poster' => $video_poster
                    ),
                    array(
                        'label' => 'Most Known For',
                        'content' => $most_known_for
                    ),
                    array(
                        'label' => 'Activities',
                        'content' => $activities
                    ),
                    array(
                        'label' => 'Wildlife',
                        'content' => $wildlife
                    ),
                    array(
                        'label' => 'Best Known For',
                        'content' => $best_known_for
                    ),
                    array(
                        'label' => 'Size',
                        'content' => $size
                    ),
                    array(
                        'label' => 'Topography',
                        'content' => $topography
                    ),
                    array(
                        'label' => 'Main Species',
                        'content' => $main_species
                    )
                );
                
                // Loop through and output sections
                foreach ($sidebar_sections as $section) :
                    if (empty($section['content'])) continue;
                    $type = isset($section['type']) ? $section['type'] : 'default';
                    
                    // For video sections, check if we have valid data before showing anything
                    if ($type === 'video') {
                        $video_title = isset($section['video_title']) ? $section['video_title'] : '';
                        $video_poster = isset($section['video_poster']) ? $section['video_poster'] : null;
                        $video_embed = $section['content']; // This is the oEmbed HTML
                        
                        // Extract embed src
                        $embed_src = '';
                        if ($video_embed) {
                            preg_match('/src="([^"]+)"/', $video_embed, $matches);
                            $embed_src = $matches[1] ?? '';
                            // Add autoplay parameter for modal
                            if ($embed_src && strpos($embed_src, 'autoplay=') === false) {
                                $separator = strpos($embed_src, '?') !== false ? '&' : '?';
                                $embed_src .= $separator . 'autoplay=1';
                            }
                        }
                        
                        // Skip if no valid video data
                        if (!$embed_src || !$video_poster) continue;
                    }
                    ?>
                    <div class="entry__content-sidebar-section">
                        <p class="entry__content-sidebar-section-label text__body--bold"><?php echo esc_html($section['label']); ?></p>
                        <?php if ($type === 'video') : ?>
                            <div class="entry__content-sidebar-section-video"
                                 data-video-trigger 
                                 data-video-src="<?php echo esc_attr($embed_src); ?>"
                                 data-video-title="<?php echo esc_attr($video_title ? $video_title : 'Watch Video'); ?>">
                                <img src="<?php echo esc_url($video_poster['sizes']['medium']); ?>" alt="<?php echo esc_attr($video_title ? $video_title : 'Watch Video'); ?>" class="entry__content-sidebar-section-video-thumb">
                                <div class="video-play__button">
                                    <div class="video-play__button-icon">
                                        <?php icon_play('var(--color-light)'); ?>
                                    </div>
                                </div>
                            </div>
                        <?php else : ?>
                            <div class="entry__content-sidebar-section-content text__size-body--sm"><?php echo $section['content']; ?></div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>
</div>