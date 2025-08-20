<?php
defined( 'ABSPATH' ) || exit;

/**
 * Helper functions for Mega Menu functionality
 */

/**
 * Check if a menu item has ACF image field
 */
function menu_item_has_image($item_id) {
    $add_image = get_field('add_image', $item_id);
    $image = get_field('image', $item_id);
    
    return $add_image && !empty($image);
}

/**
 * Check if a menu item has ACF sidebar content
 */
function menu_item_has_sidebar($item_id) {
    $add_sidebar = get_field('add_sidebar', $item_id);
    $sidebar_content = get_field('sidebar_content', $item_id);
    
    return $add_sidebar && !empty($sidebar_content);
}

/**
 * Get menu item image HTML
 */
function get_menu_item_image($item_id, $size = 'large', $classes = 'menu-item__image') {
    if (!menu_item_has_image($item_id)) {
        return '';
    }
    
    $image = get_field('image', $item_id);
    
    return wp_get_attachment_image( 
        $image['ID'], 
        $size, 
        false, 
        array(
            'class' => $classes,
            'alt' => $image['alt'] ?: get_the_title($item_id),
            'loading' => 'lazy'
        )
    );
}

/**
 * Get menu item sidebar content
 */
function get_menu_item_sidebar($item_id) {
    if (!menu_item_has_sidebar($item_id)) {
        return '';
    }
    
    $sidebar_content = get_field('sidebar_content', $item_id);
    $output = '';
    
    if (!empty($sidebar_content['content'])) {
        $output .= '<div class="mega-menu-sidebar__content">';
        $output .= $sidebar_content['content'];
        $output .= '</div>';
    }
    
    if (!empty($sidebar_content['button'])) {
        $button = $sidebar_content['button'];
        $button_target = !empty($button['target']) ? ' target="' . esc_attr($button['target']) . '"' : '';
        
        $output .= '<a href="' . esc_url($button['url']) . '"' . $button_target . ' class="mega-menu-sidebar__button button button--primary">';
        $output .= esc_html($button['title']);
        $output .= '</a>';
    }
    
    return $output;
}

/**
 * Determine if a menu location should use mega menu walker
 */
function should_use_mega_menu_walker($theme_location) {
    $mega_menu_locations = array('primary'); // Add more locations as needed
    return in_array($theme_location, $mega_menu_locations);
}

/**
 * Enhanced nav menu args with mega menu walker
 */
function get_mega_menu_args($theme_location, $additional_args = array()) {
    $default_args = array(
        'theme_location' => $theme_location,
        'container'      => false,
        'menu_class'     => 'menu',
        'fallback_cb'    => false,
    );
    
    // Use mega menu walker for specific locations
    if (should_use_mega_menu_walker($theme_location)) {
        $default_args['walker'] = new Mega_Menu_Walker();
    }
    
    return array_merge($default_args, $additional_args);
}

/**
 * Get menu depth class
 */
function get_menu_depth_class($depth) {
    return 'menu-item--level-' . intval($depth);
}

/**
 * Check if menu item should trigger mega menu
 */
function is_mega_menu_trigger($item, $depth = 0) {
    // Only top-level items can be mega menu triggers
    if ($depth !== 0) {
        return false;
    }
    
    // Check if item has children
    $has_children = in_array('menu-item-has-children', $item->classes);
    if (!$has_children) {
        return false;
    }
    
    // Check if item has sidebar content
    $has_sidebar = menu_item_has_sidebar($item->ID);
    
    // Check if any children have images (indicates rich content)
    $has_rich_children = menu_has_images_in_children($item->ID);
    
    return $has_sidebar || $has_rich_children;
}

/**
 * Check if menu item's children have images
 */
function menu_has_images_in_children($parent_item_id) {
    // Get all menu items for the current menu
    $menu_items = wp_get_nav_menu_items(get_nav_menu_locations()['primary']);
    
    if (!$menu_items) {
        return false;
    }
    
    // Find children of the parent item
    foreach ($menu_items as $item) {
        if ($item->menu_item_parent == $parent_item_id) {
            if (menu_item_has_image($item->ID)) {
                return true;
            }
            
            // Check grandchildren recursively
            if (menu_has_images_in_children($item->ID)) {
                return true;
            }
        }
    }
    
    return false;
}

/**
 * Calculate the maximum depth of children for a menu item
 */
function get_menu_item_max_depth($parent_item_id, $current_depth = 0) {
    // Get all menu items for the current menu
    $menu_locations = get_nav_menu_locations();
    if (!isset($menu_locations['primary'])) {
        return $current_depth;
    }
    
    $menu_items = wp_get_nav_menu_items($menu_locations['primary']);
    
    if (!$menu_items) {
        return $current_depth;
    }
    
    $max_depth = $current_depth;
    
    // Find children of the parent item
    foreach ($menu_items as $item) {
        if ($item->menu_item_parent == $parent_item_id) {
            // Recursively check children
            $child_depth = get_menu_item_max_depth($item->ID, $current_depth + 1);
            $max_depth = max($max_depth, $child_depth);
        }
    }
    
    return $max_depth;
}

/**
 * Get the total levels count for a menu item (including itself)
 */
function get_menu_item_levels_count($item_id) {
    $max_child_depth = get_menu_item_max_depth($item_id);
    // Add 1 to include the parent level itself
    return $max_child_depth + 1;
}

/**
 * Add body class for mega menu support
 */
function add_mega_menu_body_class($classes) {
    if (is_admin()) {
        return $classes;
    }
    
    // Check if current page has mega menu
    $has_mega_menu = false;
    
    // You can add logic here to detect if mega menu is present
    // For now, we'll add it to all pages with primary menu
    if (has_nav_menu('primary')) {
        $has_mega_menu = true;
    }
    
    if ($has_mega_menu) {
        $classes[] = 'has-mega-menu';
    }
    
    return $classes;
}
add_filter('body_class', 'add_mega_menu_body_class');

/**
 * Enqueue mega menu specific scripts and styles
 */
function enqueue_mega_menu_assets() {
    // You can add JavaScript for mega menu interactions here
    // wp_enqueue_script('mega-menu-js', get_template_directory_uri() . '/scripts/mega-menu.js', array('jquery'), '1.0.0', true);
}
add_action('wp_enqueue_scripts', 'enqueue_mega_menu_assets');
