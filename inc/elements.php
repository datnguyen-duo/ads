<?php 
function image($ID, $size, $class = '', $alt = 'Feature Image', $loading = 'lazy') {
    // Only prevent output in true admin context, not during frontend AJAX
    if (is_admin() && !wp_doing_ajax()) {
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
    
    // If no mobile video provided, use regular video function
    if (!$mobile_video || !is_array($mobile_video) || !isset($mobile_video['url']) || !isset($mobile_video['mime_type'])) {
        video($desktop_video['url'], $desktop_video['mime_type'], $class, $settings, $poster, $captions);
        return;
    }
    
    // Add responsive data attributes
    $enhanced_settings = $settings;
    if (strpos($settings, 'data-responsive') === false) {
        $enhanced_settings .= ' data-responsive="true"';
    }
    if (strpos($settings, 'data-desktop-src') === false) {
        $enhanced_settings .= ' data-desktop-src="' . esc_url($desktop_video['url']) . '"';
        $enhanced_settings .= ' data-desktop-type="' . esc_attr($desktop_video['mime_type']) . '"';
    }
    if (strpos($settings, 'data-mobile-src') === false) {
        $enhanced_settings .= ' data-mobile-src="' . esc_url($mobile_video['url']) . '"';
        $enhanced_settings .= ' data-mobile-type="' . esc_attr($mobile_video['mime_type']) . '"';
    }
    // Choose initial source based on server-side detection for better first load
    $is_likely_mobile = function_exists('wp_is_mobile') ? wp_is_mobile() : false;
    $initial_video = $is_likely_mobile ? $mobile_video : $desktop_video;
    ?>
    <video class="<?php echo esc_attr($class); ?>" <?php echo $enhanced_settings; ?> poster="<?php echo esc_url($poster); ?>">
        <!-- Initial source - will be switched by JavaScript if needed -->
        <source src="<?php echo esc_url($initial_video['url']); ?>" type="<?php echo esc_attr($initial_video['mime_type']); ?>">
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