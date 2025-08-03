<?php 
defined( 'ABSPATH' ) || exit; 
$layout = $args['layout'];
$pre_heading = get_sub_field('pre_heading');
$heading = get_sub_field('heading');
$description = get_sub_field('description');
$cta = get_sub_field('cta');
$steps = get_sub_field('steps');

$header_args = array(
    'layout' => $layout,
    'pre_heading' => $pre_heading,
    'heading' => $heading,
    'description' => $description,
    'cta' => $cta,
); ?>

<div class="<?php echo $layout . '__background'; ?>">
    <img class="<?php echo $layout . '__background-image'; ?>" src="<?php echo get_template_directory_uri(); ?>/assets/process__background.png" alt="Process Background" loading="lazy">
</div>
<?php get_template_part('template-parts/sections/section', 'header', $header_args); ?>

<div class="<?php echo $layout . '__steps'; ?>">
    <?php foreach ($steps as $key => $step): 
        $title = $step['title'];
        $description = $step['description'];
        ?>
        <div class="<?php echo $layout . '__step'; ?>">
            <div class="<?php echo $layout . '__step-number text__size-2--italic'; ?>"><?php echo $key < 9 ? '0' . $key + 1 : $key + 1; ?></div>
            <?php if ($title): ?>
                <h3 class="<?php echo $layout . '__step-title'; ?>"><?php echo $title; ?></h3>
            <?php endif; ?>
            <?php if ($description): ?>
                <p class="<?php echo $layout . '__step-description text__body--bold'; ?>"><?php echo $description; ?></p>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
</div>