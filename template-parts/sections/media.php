<?php 
defined( 'ABSPATH' ) || exit; 
$layout = $args['layout'];
$autoplay = get_sub_field('autoplay');
$autoplay = isset($autoplay) ? $autoplay : true; // Default to true for backwards compatibility
?>
<div class="<?php echo $layout . '__background'; ?>">
    <img class="<?php echo $layout . '__background-image'; ?>" src="<?php echo get_template_directory_uri(); ?>/assets/experience-paths__background-1.svg" alt="Experience Paths Background" loading="lazy">
    <img class="<?php echo $layout . '__background-image'; ?>" src="<?php echo get_template_directory_uri(); ?>/assets/experience-paths__background-2.svg" alt="Experience Paths Background" loading="lazy">
</div>
<div class="<?php echo $layout . '__container'; ?>" data-animate-image>
    <?php if ($autoplay):
        // Autoplay mode: use HTML5 video or image file
        $media = get_sub_field('media');
        $media_type = $media['type'];
        
        if ($media_type == 'image'): ?>
            <?php image($media['ID'], 'full', $layout . '__image'); ?>
        <?php elseif ($media_type == 'video'): ?>
            <div class="video-play-container">
                <?php responsive_video($media, null, $layout . '__video', 'autoplay loop muted playsinline'); ?>
            </div>
        <?php endif; ?>
    <?php else:
        // Non-autoplay mode: use embed with modal
        $video_title = get_sub_field('video_title');
        $poster_image = get_sub_field('poster_image');
        $video_embed = get_sub_field('video_embed');
        
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
            <div class="video-play-container" 
                 data-video-trigger 
                 data-video-src="<?php echo esc_attr($embed_src); ?>"
                 data-video-title="<?php echo esc_attr($video_title); ?>">
                <?php image($poster_image['ID'], 'full', $layout . '__video'); ?>
                <div class="video-play__button">
                    <div class="video-play__button-icon">
                        <?php icon_play('var(--color-light)'); ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    <?php endif; ?>
</div>