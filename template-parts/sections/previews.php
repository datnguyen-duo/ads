<?php 
defined( 'ABSPATH' ) || exit; 
$layout = $args['layout'];
$pre_heading = get_sub_field('pre_heading');
$heading = get_sub_field('heading');
$description = get_sub_field('description');
$cta = get_sub_field('cta');
$media = get_sub_field('media');

$header_args = array(
    'layout' => $layout,
    'pre_heading' => $pre_heading,
    'heading' => $heading,
    'description' => $description,
    'cta' => $cta,
); ?>

<div class="<?php echo $layout . '__line'; ?>"></div>

<div class="<?php echo $layout . '__background'; ?>">
    <img class="<?php echo $layout . '__background-image'; ?>" src="<?php echo get_template_directory_uri(); ?>/assets/previews__background-1.svg" alt="Process Background" loading="lazy">
    <img class="<?php echo $layout . '__background-image'; ?>" src="<?php echo get_template_directory_uri(); ?>/assets/previews__background-2.svg" alt="Process Background" loading="lazy">
</div>

<?php if ($media): ?>
    <div class="<?php echo $layout . '__media'; ?>">
        <?php foreach ($media as $item): 
            $link = $item['link'];
            $file = $item['file'];
            ?>
            <a class="<?php echo $layout . '__media-item'; ?>" href="<?php echo $link['url']; ?>" target="<?php echo $link['target']; ?>">
                <div class="<?php echo $layout . '__media-item-inner media-container'; ?>">
                    <?php if ($file): 
                        $type = $file['type'];
                        if ($type === 'image'): ?>
                            <img class="<?php echo $layout . '__media-item-image'; ?>" src="<?php echo $file['url']; ?>" alt="<?php echo $file['title']; ?>" loading="lazy">
                        <?php elseif ($type === 'video'): ?>
                            <video class="<?php echo $layout . '__media-item-video'; ?>" src="<?php echo $file['url']; ?>" alt="<?php echo $file['title']; ?>"></video>
                        <?php endif; ?>
                    <?php endif; ?>
                    <p class="<?php echo $layout . '__media-item-text'; ?>">
                        <?php echo $link['title']; ?>
                    </p>
                </div>
            </a>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?php get_template_part('template-parts/sections/section', 'header', $header_args); ?>
