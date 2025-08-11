<?php 
function image($ID, $size, $class = '', $alt = 'Feature Image', $loading = 'lazy') {
    if (is_admin() && (wp_doing_ajax() || (isset($_POST) && !empty($_POST)))) {
        return;
    }
    if (is_array($size) && isset($size[0]) && isset($size[1]) && $size[0] === 'auto') {
        $height = $size[1];
        $image_url = wp_get_attachment_image_url($ID, 'large');
        if ($image_url) {
            echo '<img src="' . esc_url($image_url) . '" class="' . esc_attr($class) . '" alt="' . esc_attr($alt) . '" loading="' . esc_attr($loading) . '" aria-label="' . esc_attr($alt) . '" title="' . esc_attr($alt) . '" draggable="false" style="height: ' . $height . 'px; width: auto; object-fit: cover;">';
        }
    } else {
        echo wp_get_attachment_image($ID, $size, false, 
            array(
                'class' => $class, 
                'alt' => $alt,
                'loading' => $loading,
                'aria-label' => $alt,
                'title' => $alt,
                'draggable' => 'false'
            )
        );
    }
}
function video($src, $mime_type, $class = '', $settings = '', $poster = '', $captions = '') { 
    if (is_admin() && (wp_doing_ajax() || (isset($_POST) && !empty($_POST)))) {
        return;
    }
    if (empty($src) || empty($mime_type)) {
        return;
    }
    ?>
    <video class="<?php echo esc_attr($class); ?>" <?php echo $settings; ?> poster="<?php echo esc_url($poster); ?>">
        <source src="<?php echo esc_url($src); ?>" type="<?php echo esc_attr($mime_type); ?>">
        <?php if ($captions): ?>
            <track kind="captions" src="<?php echo esc_url($captions); ?>" srclang="en">
        <?php endif; ?>
        Your browser does not support the video tag.
    </video>
<?php }
function responsive_video($desktop_video, $mobile_video = null, $class = '', $settings = '', $poster = '', $captions = '') {
    if (is_admin() && (wp_doing_ajax() || (isset($_POST) && !empty($_POST)))) {
        return;
    }
    if (!is_array($desktop_video) || !isset($desktop_video['url']) || !isset($desktop_video['mime_type'])) {
        return; 
    }
    if (!$mobile_video || !is_array($mobile_video) || !isset($mobile_video['url']) || !isset($mobile_video['mime_type'])) {
        video($desktop_video['url'], $desktop_video['mime_type'], $class, $settings, $poster, $captions);
        return;
    }
    $is_mobile = function_exists('wp_is_mobile') ? wp_is_mobile() : false;
    $selected_video = $is_mobile ? $mobile_video : $desktop_video;
    $enhanced_settings = $settings;
    if (strpos($settings, 'data-responsive') === false) {
        $enhanced_settings .= ' data-responsive="true"';
    }
    ?>
    <video class="<?php echo esc_attr($class); ?>" <?php echo $enhanced_settings; ?> poster="<?php echo esc_url($poster); ?>">
        <?php if ($is_mobile && is_array($mobile_video) && isset($mobile_video['url']) && isset($mobile_video['mime_type'])): ?>
            <source src="<?php echo esc_url($mobile_video['url']); ?>" type="<?php echo esc_attr($mobile_video['mime_type']); ?>" media="(max-width: 768px)">
        <?php endif; ?>
        <source src="<?php echo esc_url($desktop_video['url']); ?>" type="<?php echo esc_attr($desktop_video['mime_type']); ?>" media="(min-width: 769px)">
        <!-- Fallback source for all devices -->
        <source src="<?php echo esc_url($selected_video['url']); ?>" type="<?php echo esc_attr($selected_video['mime_type']); ?>">
        <?php if ($captions): ?>
            <track kind="captions" src="<?php echo esc_url($captions); ?>" srclang="en">
        <?php endif; ?>
        Your browser does not support the video tag.
    </video>
<?php }
function button($text, $link = '#', $target = '_self', $class = '') {
    if (is_admin()) {
        return;
    }
    if (wp_doing_ajax() || (isset($_POST) && !empty($_POST))) {
        return;
    }
    // Add primary class by default if no button variation is specified
    if (strpos($class, 'button--') === false) {
        $class .= ' button--primary';
    }
    if (!empty($text)) {
        echo '<a href="' . esc_url($link) . '" class="button ' . esc_attr($class) . '" target="' . esc_attr($target) . '">' . esc_html($text) . '</a>';
    }
}