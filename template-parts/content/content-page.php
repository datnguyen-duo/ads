<?php
defined( 'ABSPATH' ) || exit;
if (have_rows('sections')) {
    while (have_rows('sections')) {
        the_row();
        $layout = get_row_layout();
        $section_path = 'template-parts/sections/' . $layout;
        $background_image = get_sub_field('background_image');
        $background_color = get_sub_field('background_color');
        $text_color = get_sub_field('text_color');
        $variation = get_sub_field('variation') ? " --" . get_sub_field('variation') : null;
        $settings = get_sub_field('settings');
        $show_filter = is_array($settings) && isset($settings['show_filter']) && $settings['show_filter'] ? " --has-filter" : null;
        $show_pagination = is_array($settings) && isset($settings['show_pagination']) && $settings['show_pagination'] ? " --has-pagination" : null;
        $show_search = is_array($settings) && isset($settings['show_search']) && $settings['show_search'] ? " --has-search" : null;
        $combined_style = '';
        if ($background_image) {
            $combined_style .= 'background: url(' . $background_image['url'] . ') 50% 50% / cover no-repeat;';
        }
        if ($background_color) {
            $combined_style .= ' --color-section-background: ' . $background_color . ';';
        }
        if ($text_color) {
            $combined_style .= ' --color-section-text: ' . $text_color . ';';
        }
        
        // Global section references output at top level (they handle their own wrappers)
        if ($layout === 'global-section-reference') {
            get_template_part($section_path, null, array('layout' => $layout));
        } else {
            ?>
            <section class="<?php echo $layout . $variation . $show_filter . $show_pagination . $show_search; ?>"<?php echo $combined_style ? ' style="' . $combined_style . '"' : ''; ?>
            <?php echo $background_color ? 'data-has-background-color' : ''; ?>>
                <div class="page-container">
                    <?php get_template_part($section_path, null, array('layout' => $layout)); ?>
                </div>
            </section>
            <?php
        }
    }
}
?>