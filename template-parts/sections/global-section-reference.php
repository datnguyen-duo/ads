<?php
/**
 * Global Section Reference
 * 
 * Allows referencing global sections stored in Theme Settings > Global Sections
 * Supports: Lodging CTA, Lodging Form, Footer Logos, Footer CTA Marquee
 */
defined('ABSPATH') || exit;

$layout = $args['layout'];
$reference = get_sub_field('reference');

if (!$reference) return;

// Get office data for lodging form
$us_office = get_field('us_office', 'option');
$tanzania_office = get_field('tanzania_office', 'option');

switch ($reference) {
    case 'lodging_cta':
        $lodging_cta = get_field('lodging_cta', 'option');
        if (!$lodging_cta) break;
        
        $background_color = $lodging_cta['background_color'] ?? 'var(--color-primary-1)';
        $text_color = $lodging_cta['text_color'] ?? 'var(--color-light)';
        $combined_style = '--color-section-background: ' . $background_color . '; --color-section-text: ' . $text_color . ';';
        ?>
        <div class="lodging-cta cta" style="<?php echo $combined_style; ?>" data-has-background-color>
            <div class="page-container">
                <?php 
                get_template_part('template-parts/sections/cta', null, array(
                    'layout' => 'cta',
                    'data' => $lodging_cta
                )); 
                ?>
            </div>
        </div>
        <?php
        break;

    case 'lodging_form':
        $lodging_form = get_field('lodging_form', 'option');
        if (!$lodging_form) break;
        
        get_template_part('template-parts/sections/lodging', 'form', array(
            'layout' => 'lodging-form',
            'data' => $lodging_form,
            'us_office' => $us_office,
            'tanzania_office' => $tanzania_office
        ));
        break;

    case 'footer_logos':
        $logos = get_field('logos', 'option');
        if (!$logos) break;
        ?>
        <div class="logo-grid">
            <div class="page-container">
                <?php 
                get_template_part('template-parts/sections/logo', 'grid', array(
                    'layout' => 'logo-grid',
                    'logos' => $logos
                )); 
                ?>
            </div>
        </div>
        <?php
        break;

    case 'footer_marquee':
        $cta = get_field('cta', 'option');
        if (!$cta) break;
        ?>
        <div class="cta-marquee">
            <?php 
            get_template_part('template-parts/sections/cta', 'marquee', array(
                'layout' => 'cta-marquee',
                'cta' => $cta
            )); 
            ?>
        </div>
        <?php
        break;
}
