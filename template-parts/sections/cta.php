<?php 
defined( 'ABSPATH' ) || exit; 
$layout = $args['layout'];

// Check if data is passed via $args (for global/reusable CTAs)
// Otherwise fall back to get_sub_field (for flexible content)
if (isset($args['data'])) {
    $data = $args['data'];
    $has_texture = $data['has_texture'] ?? false;
    $has_lines = $data['has_lines'] ?? false;
    $texture = $data['texture'] ?? null;
    $images = $data['images'] ?? null;
    $pre_heading = $data['pre_heading'] ?? null;
    $heading = $data['heading'] ?? null;
    $description = $data['description'] ?? null;
    $cta = $data['cta'] ?? null;
} else {
    $has_texture = get_sub_field('has_texture');
    $has_lines = get_sub_field('has_lines');
    $texture = get_sub_field('texture');
    $images = get_sub_field('images');
    $pre_heading = get_sub_field('pre_heading');
    $heading = get_sub_field('heading');
    $description = get_sub_field('description');
    $cta = get_sub_field('cta');
}

$header_args = array(
    'layout' => $layout,
    'pre_heading' => $pre_heading,
    'heading' => $heading,
    'description' => $description,
    'cta' => $cta,
);
if ($has_texture): ?>
    <div class="<?php echo $layout . '__texture'; ?>">
        <?php image($texture['ID'], 'full', $layout . '__texture-image'); ?>
    </div>
<?php endif;

if ($has_lines): ?>
    <div class="<?php echo $layout . '__line --active'; ?>">
        <img class="<?php echo $layout . '__line-image'; ?>" src="<?php echo get_template_directory_uri(); ?>/assets/cta__line--active.svg" alt="CTA Images Line" loading="lazy">
        <img class="<?php echo $layout . '__line-image'; ?>" src="<?php echo get_template_directory_uri(); ?>/assets/cta__line--active.svg" alt="CTA Images Line" loading="lazy">
    </div>
<?php endif; ?>
<?php if ($images): ?>
    <div class="<?php echo $layout . '__images'; ?>" style="--images-count: <?php echo count($images); ?>">

        <?php foreach ($images as $key => $image): ?>
            <div class="<?php echo $layout . '__image media-container'; ?>" <?php echo $key !== 2 ? 'data-animate-image' : ''; ?>>
                <?php image($image['ID'], 'full', $layout . '__image-image'); ?>
            </div>
        <?php endforeach; ?>

    </div>
<?php endif; ?>
<?php get_template_part('template-parts/sections/section', 'header', $header_args); ?>