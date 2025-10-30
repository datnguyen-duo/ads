<?php
defined( 'ABSPATH' ) || exit;
$layout = $args['layout'];
$pre_heading = get_sub_field('pre_heading');
$heading = get_sub_field('heading');
$media = get_sub_field('media_');
$count = $media ? count($media) : 0;
$count_class = $count > 1 ? 'multiple' : 'single';
$content = get_sub_field('content');
$header_args = array(
    'layout' => $layout,
    'pre_heading' => $pre_heading,
    'heading' => $heading,
    'description' => '',
    'cta' => '',
);
?>
<?php if ($pre_heading || $heading): ?>
    <?php get_template_part('template-parts/sections/section', 'header', $header_args); ?>
<?php endif; ?>
<?php if ($media): ?>
    <div class="<?php echo $layout . '__media'; ?> <?php echo $layout . '__media--' . $count_class; ?>">
        <?php foreach ($media as $key => $item):
            // ACF true/false field - default to true if not set
            $autoplay = isset($item['autoplay']) ? $item['autoplay'] : true;
            
            if ($autoplay) {
                // Autoplay mode: use HTML5 video or image file
                $file = $item['file'];
                $type = $file['type'];
                
                if ($type == 'image') { ?>
                    <div class="media-container"  data-animate-image>
                        <?php image($file['ID'], 'full', $layout . '__media-image'); ?>
                    </div>
                <?php } else if ($type == 'video') { ?>
                    <div class="media-container video-play-container" data-animate-image>
                        <?php responsive_video($file, null, $layout . '__media-video', 'autoplay loop muted playsinline', ''); ?>
                    </div>
                <?php }
            } else {
                // Non-autoplay mode: use embed with modal
                $video_title = isset($item['video_title']) ? $item['video_title'] : '';
                $poster_image = isset($item['poster_image']) ? $item['poster_image'] : null;
                $video_embed = isset($item['video_embed']) ? $item['video_embed'] : '';
                
                // Extract embed src
                $embed_src = '';
                if ($video_embed) {
                    preg_match('/src="([^"]+)"/', $video_embed, $matches);
                    $embed_src = $matches[1] ?? '';
                    // Add autoplay parameter for modal
                    if ($embed_src && strpos($embed_src, 'autoplay=') === false) {
                        $separator = strpos($embed_src, '?') !== false ? '&' : '?';
                        $embed_src .= $separator . 'autoplay=1';
                    }
                }
                ?>
                <?php if ($embed_src && $poster_image): ?>
                    <div class="media-container" data-animate-image 
                         data-video-trigger 
                         data-video-src="<?php echo esc_attr($embed_src); ?>"
                         data-video-title="<?php echo esc_attr($video_title); ?>">
                        <?php image($poster_image['ID'], 'full', $layout . '__media-video'); ?>
                        <div class="video-play__button">
                            <div class="video-play__button-icon">
                                <?php icon_play('var(--color-light)'); ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            <?php } ?>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
<?php if ($content):
    $pre_heading = $content['pre_heading'];
    $heading = $content['heading'];
    $description = $content['description'];
    $cta = $content['cta'];
    ?>
    <div class="<?php echo $layout . '__content show-more-container'; ?>" data-content-height="700">
        <?php if ($pre_heading): ?>
            <p class="<?php echo $layout . '__content-pre-heading text__size-body--lg'; ?>" data-animate-block><?php echo $pre_heading; ?></p>
        <?php endif; ?>
        <?php if ($heading): ?>
            <h2 class="<?php echo $layout . '__content-heading'; ?>" data-animate-words><?php echo $heading; ?></h2>
        <?php endif; ?>
        <?php if ($description): ?>
            <div class="<?php echo $layout . '__content-description rte'; ?>"><?php echo $description; ?></div>
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
        <button class="show-more-button text__size-body--sm">
            <span class="show-more-button-text">Show more</span> 
            <span class="show-more-button-icon">
                <?php icon_arrow('var(--color-light)'); ?>
            </span>
        </button>
    </div>
<?php endif; ?>