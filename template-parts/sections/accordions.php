<?php 
defined( 'ABSPATH' ) || exit; 
$layout = $args['layout'];
$pre_heading = get_sub_field('pre_heading');
$heading = get_sub_field('heading');
$description = get_sub_field('description');
$accordions = get_sub_field('accordions');
$header_args = array(
    'layout' => $layout,
    'pre_heading' => $pre_heading,
    'heading' => $heading,
    'description' => $description,
    'cta' => '',
);
?>
<div class="<?php echo $layout . '__container'; ?>">
    <?php get_template_part('template-parts/sections/section', 'header', $header_args); ?>
    <div class="<?php echo $layout . '__accordions'; ?>" data-animate-block>
        <?php foreach ($accordions as $accordion): ?>
            <div class="<?php echo $layout . '__accordion'; ?>">
                <div class="<?php echo $layout . '__accordion-header'; ?>">
                    <h3 class="<?php echo $layout . '__accordion-title text__size-body--lg'; ?>"><?php echo $accordion['title']; ?></h3>
                    <div class="<?php echo $layout . '__accordion-icon'; ?>">
                        <div class="<?php echo $layout . '__accordion-icon-line'; ?>"></div>
                        <div class="<?php echo $layout . '__accordion-icon-line'; ?>"></div>
                    </div>
                </div>
                <div class="<?php echo $layout . '__accordion-text'; ?>">
                    <div class="<?php echo $layout . '__accordion-text-inner'; ?>">
                        <?php echo $accordion['text']; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>