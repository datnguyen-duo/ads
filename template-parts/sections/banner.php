<?php 
defined( 'ABSPATH' ) || exit; 
$layout = $args['layout'];
$pre_heading = get_sub_field('pre_heading');
$heading = get_sub_field('heading');
$text = get_sub_field('text');
$image = get_sub_field('image');

$header_args = array(
    'layout' => $layout,
    'pre_heading' => $pre_heading,
    'heading' => $heading,
    'description' => '',
    'cta' => '',
);
?>
<div class="<?php echo $layout . '__container'; ?>">
    <?php image($image['ID'], 'full', $layout . '__image'); ?>
    <div class="<?php echo $layout . '__content'; ?>">
        <div class="<?php echo $layout . '__content-inner'; ?>">
            <?php get_template_part('template-parts/sections/section', 'header', $header_args); ?>
            <?php if ($text): ?>
                <div class="<?php echo $layout . '__text rte'; ?>" data-animate-block><?php echo $text; ?></div>
            <?php endif; ?>
        </div>
    </div>
</div>