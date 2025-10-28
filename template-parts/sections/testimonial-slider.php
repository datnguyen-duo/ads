<?php 
defined( 'ABSPATH' ) || exit; 
$layout = $args['layout'];
$pre_heading = get_sub_field('pre_heading');
$heading = get_sub_field('heading');
$description = get_sub_field('description');
$badge = get_sub_field('badge');
$testimonials = get_sub_field('testimonials');
$header_args = array(
    'layout' => $layout,
    'pre_heading' => $pre_heading,
    'heading' => $heading,
    'description' => $description,
    'cta' => '',
); ?>
<div class="<?php echo $layout . '__top'; ?>">
    <?php get_template_part('template-parts/sections/section', 'header', $header_args); ?>
    <?php if ($badge): ?>
        <div class="<?php echo $layout . '__badge'; ?>" data-animate-block>
            <?php image($badge['ID'], 'full', $layout . '__badge-image'); ?>
            <p class="<?php echo $layout . '__badge-text'; ?>">89 Reviews <span class="text__body--bold">100% Approval</span></p>
        </div>
    <?php endif; ?>
</div>
<div class="<?php echo $layout . '__bottom'; ?>">
    <?php if ($testimonials): ?>
        <div class="<?php echo $layout . '__testimonials swiper'; ?>" data-centered-slides="true">
            <div class="<?php echo $layout . '__testimonials-wrapper'; ?> swiper-wrapper">
                <?php foreach ($testimonials as $testimonial):
                    $image = $testimonial['image'];
                    $quote = $testimonial['quote'];
                    $attribution = $testimonial['attribution'];
                    $location = $testimonial['location'];
                    $additional_details = $testimonial['additional_details'];
                    $button = $testimonial['button'];
                    ?>
                    <div class="<?php echo $layout . '__testimonial swiper-slide'; ?>">
                        <?php if ($image): ?>
                            <?php image($image['ID'], 'large', $layout . '__testimonial-image'); ?>
                        <?php endif; ?>
                        <?php if ($quote): ?>
                            <p class="<?php echo $layout . '__testimonial-quote text__size-3--italic'; ?>"><?php echo $quote; ?></p>
                        <?php endif; ?>
                        <?php if ($attribution || $location): ?>
                            <div class="<?php echo $layout . '__testimonial-attribution'; ?>">
                                <p class="<?php echo $layout . '__testimonial-attribution-name text__body--bold'; ?>"><?php echo $attribution; ?></p>
                                <?php if ($location): ?>
                                    <p class="<?php echo $layout . '__testimonial-attribution-location'; ?>"><?php echo $location; ?></p>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                        <?php if ($additional_details): ?>
                            <p class="<?php echo $layout . '__testimonial-additional-details'; ?>"><?php echo $additional_details; ?></p>
                        <?php endif; ?>
                        <?php if ($button): ?>
                            <?php button($button['title'], $button['url'], $button['target'] ?? '_self', $layout . '__testimonial-button'); ?>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="<?php echo $layout . '__testimonials-buttons swiper-buttons'; ?>">
                <button class="<?php echo $layout . '__testimonials-button swiper-button-prev button__icon'; ?>">
                    <?php icon_arrow(); ?>
                </button>
                <button class="<?php echo $layout . '__testimonials-button swiper-button-next button__icon'; ?>">
                    <?php icon_arrow(); ?>
                </button>
            </div>
        </div>
    <?php endif; ?>
</div>