<?php 
defined( 'ABSPATH' ) || exit; 
$layout = $args['layout'];
$pre_heading = get_sub_field('pre_heading');
$heading = get_sub_field('heading');
$description = get_sub_field('description');
$paths = get_sub_field('paths');
$header_args = array(
    'layout' => $layout,
    'pre_heading' => $pre_heading,
    'heading' => $heading,
    'description' => $description,
    'cta' => '',
); ?>
<div class="<?php echo $layout . '__background'; ?>">
    <img class="<?php echo $layout . '__background-image'; ?>" src="<?php echo get_template_directory_uri(); ?>/assets/experience-paths__background-1.svg" alt="Experience Paths Background" loading="lazy">
    <img class="<?php echo $layout . '__background-image'; ?>" src="<?php echo get_template_directory_uri(); ?>/assets/experience-paths__background-2.svg" alt="Experience Paths Background" loading="lazy">
</div>
<?php get_template_part('template-parts/sections/section', 'header', $header_args); ?>
<?php if ($paths): ?>
    <div class="<?php echo $layout . '__paths'; ?>">
        <?php foreach ($paths as $path): 
            $images = $path['images'];
            $title = $path['title'];
            $description = $path['description'];
            $cta = $path['cta'];
            ?>
            <?php if ($cta): ?>
                <a href="<?php echo $cta['url']; ?>" class="<?php echo $layout . '__path'; ?>">
                    <?php if ($images): ?>
                    <div class="<?php echo $layout . '__path-images'; ?>">
                        <?php foreach ($images as $image): ?>
                            <div class="<?php echo $layout . '__path-media media-container'; ?>">
                                <?php image($image['image']['ID'], 'full', $layout . '__path-image'); ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                    <?php if ($title): ?>
                        <h3 class="<?php echo $layout . '__path-title'; ?>"><?php echo $title; ?></h3>
                    <?php endif; ?>
                    <?php if ($description): ?>
                        <p class="<?php echo $layout . '__path-description'; ?>"><?php echo $description; ?></p>
                    <?php endif; ?>
                    <span class="<?php echo $layout . '__path-cta button__text'; ?>"><?php echo $cta['title']; ?></span>
                </a>
            <?php else: ?>
                <div class="<?php echo $layout . '__path'; ?>">
                    <?php if ($images): ?>
                    <div class="<?php echo $layout . '__path-images'; ?>">
                        <?php foreach ($images as $image): ?>
                            <div class="<?php echo $layout . '__path-media media-container'; ?>">
                                <?php image($image['image']['ID'], 'full', $layout . '__path-image'); ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                    <?php if ($title): ?>
                        <h3 class="<?php echo $layout . '__path-title'; ?>"><?php echo $title; ?></h3>
                    <?php endif; ?>
                    <?php if ($description): ?>
                        <p class="<?php echo $layout . '__path-description'; ?>"><?php echo $description; ?></p>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
        <svg class="<?php echo $layout . '__line --base'; ?>" width="844" height="1328" viewBox="0 0 844 1328" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M843.254 1.90723C557.087 2.57389 -11.7463 68.4072 2.25374 326.407C19.7537 648.907 677.754 528.907 769.254 881.907C842.454 1164.31 288.42 1295.91 2.25374 1326.41" stroke="var(--color-neutral-3)" stroke-width="3" stroke-dasharray="5 10" />
        </svg>
        <svg class="<?php echo $layout . '__line --active'; ?>" width="844" height="1328" viewBox="0 0 844 1328" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M843.254 1.90723C557.087 2.57389 -11.7463 68.4072 2.25374 326.407C19.7537 648.907 677.754 528.907 769.254 881.907C842.454 1164.31 288.42 1295.91 2.25374 1326.41" stroke="var(--color-primary-1)" stroke-width="3" stroke-dasharray="5 10" />
        </svg>
    </div>
<?php endif; ?>