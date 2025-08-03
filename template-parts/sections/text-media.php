<?php
defined( 'ABSPATH' ) || exit;
$layout = $args['layout'];
$pre_heading = get_sub_field('pre_heading');
$heading = get_sub_field('heading');
$media = get_sub_field('media');
$content = get_sub_field('content');
$header_args = array(
    'layout' => $layout,
    'pre_heading' => $pre_heading,
    'heading' => $heading,
    'description' => '',
    'cta' => '',
);
?>

<?php get_template_part('template-parts/sections/section', 'header', $header_args); ?>

<?php if ($media): ?>
    <div class="<?php echo $layout . '__media media-container'; ?>" data-animate-image>
        <?php if ($media['type'] === 'image') {
            image($media['id'], 'full', $layout . '__image');
        } else if ($media['type'] === 'video') {
            // Check for mobile video version (optional - only if you want responsive videos in this section)
            $mobile_media = get_sub_field('media_mobile');
            
            if ($mobile_media && $mobile_media['type'] === 'video') {
                // Use responsive video if mobile version exists
                responsive_video($media, $mobile_media, $layout . '__video', 'autoplay loop muted playsinline');
            } else {
                // Fallback: use single video for all devices
                video($media['url'], $media['mime_type'], $layout . '__video', 'autoplay loop muted playsinline');
            }
        } ?>
    </div>
<?php endif; ?>

<?php if ($content):
    $pre_heading = $content['pre_heading'];
    $heading = $content['heading'];
    $description = $content['description'];
    $cta = $content['cta'];
    ?>
    <div class="<?php echo $layout . '__content'; ?>">
        <?php if ($pre_heading): ?>
            <p class="<?php echo $layout . '__content-pre-heading text__size-body--lg'; ?>" data-animate-block><?php echo $pre_heading; ?></p>
        <?php endif; ?>
        <?php if ($heading): ?>
            <h2 class="<?php echo $layout . '__content-heading'; ?>" data-animate-words><?php echo $heading; ?></h2>
        <?php endif; ?>
        <?php if ($description): ?>
            <div class="<?php echo $layout . '__content-description'; ?>" data-animate-lines><?php echo $description; ?></div>
        <?php endif; ?>
        <?php if (!empty($cta)): ?>
            <div class="<?php echo $layout . '__content-cta'; ?>">
                <?php 
                foreach($cta as $key => $link) { 
                    if (!empty($link['link']['url']) && !empty($link['link']['title'])) {
                        $url = $link['link']['url'];
                        $target = $link['link']['target'];
                        $class = "primary --light";
                        $title = $link['link']['title'];
                        echo "<div class='" . $layout . "__cta-link'>";
                        button($title, $url, $target);
                        echo "</div>";
                    } 
                }
                ?>
            </div>
        <?php endif; ?>
    </div>
<?php endif; ?>