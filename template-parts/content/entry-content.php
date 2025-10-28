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
            <div class="entry__content-sidebar">
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
                        'type' => 'video'
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
                    ?>
                    <div class="entry__content-sidebar-section">
                        <p class="entry__content-sidebar-section-label text__body--bold"><?php echo esc_html($section['label']); ?></p>
                        <?php if ($type === 'video' && !empty($section['content']) && is_array($section['content'])) : 
                            $video_url = isset($section['content']['url']) ? $section['content']['url'] : '';
                            $video_thumb = isset($section['content']['sizes']['medium']) ? $section['content']['sizes']['medium'] : '';
                            ?>
                            <?php if ($video_url) : ?>
                            <div class="entry__content-sidebar-section-video">
                                <a href="<?php echo esc_url($video_url); ?>" class="entry__content-sidebar-section-video-link" target="_blank">
                                    <?php if ($video_thumb) : ?>
                                        <img src="<?php echo esc_url($video_thumb); ?>" alt="Watch Video" class="entry__content-sidebar-section-video-thumb">
                                    <?php endif; ?>
                                    <span class="entry__content-sidebar-section-video-play">▶ Watch Video</span>
                                </a>
                            </div>
                            <?php endif; ?>
                        <?php else : ?>
                            <div class="entry__content-sidebar-section-content text__size-body--sm"><?php echo $section['content']; ?></div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>
</div>