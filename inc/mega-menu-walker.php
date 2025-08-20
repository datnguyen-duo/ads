<?php
defined( 'ABSPATH' ) || exit;

/**
 * Custom Walker for Mega Menu with ACF Integration
 * 
 * Handles multi-level navigation with:
 * - Depth-specific CSS classes
 * - ACF image fields at any level
 * - ACF sidebar content at top level
 * - Mega menu containers for top-level items
 */
class Mega_Menu_Walker extends Walker_Nav_Menu {
    
    /**
     * Track current depth and mega menu state
     */
    private $current_depth = 0;
    private $mega_menu_open = false;
    private $has_mega_menu = false;
    private $current_mega_menu_item = null;
    
    /**
     * Start Level - output the `<ul>` for sub-menus
     */
    public function start_lvl( &$output, $depth = 0, $args = null ) {
        $indent = str_repeat("\t", $depth);
        $class_names = "sub-menu sub-menu--level-" . ($depth + 1);
        
        // For level 1 (first dropdown), check if we need mega menu container
        if ($depth === 0 && $this->has_mega_menu && $this->current_mega_menu_item) {
            $output .= "\n$indent<div class=\"mega-menu\">\n";
            $output .= "$indent\t<div class=\"mega-menu-container\">\n";
            $output .= "$indent\t\t<div class=\"mega-menu-content\">\n";
            $this->mega_menu_open = true;
        }
        
        $output .= "\n$indent<ul class=\"$class_names\">\n";
    }
    
    /**
     * End Level - close the `</ul>` for sub-menus
     */
    public function end_lvl( &$output, $depth = 0, $args = null ) {
        $indent = str_repeat("\t", $depth);
        $output .= "$indent</ul>\n";
        
        // Close mega menu container for level 1 and add sidebar
        if ($depth === 0 && $this->mega_menu_open && $this->current_mega_menu_item) {
            $output .= "$indent\t\t</div>\n"; // Close mega-menu-content
            
            // Add sidebar content if present
            $add_sidebar = get_field('add_sidebar', $this->current_mega_menu_item->ID);
            $sidebar_content = get_field('sidebar_content', $this->current_mega_menu_item->ID);
            
            if ($add_sidebar && $sidebar_content) {
                $output .= "$indent\t\t<div class=\"mega-menu-sidebar\">\n";
                
                // Add sidebar content
                if (!empty($sidebar_content['content'])) {
                    $output .= "$indent\t\t\t<div class=\"mega-menu-sidebar__content\">\n";
                    $output .= "$indent\t\t\t\t" . $sidebar_content['content'] . "\n";
                    $output .= "$indent\t\t\t</div>\n";
                }
                
                // Add sidebar button
                if (!empty($sidebar_content['button'])) {
                    $button = $sidebar_content['button'];
                    $button_class = 'mega-menu-sidebar__button button button--primary';
                    $button_target = !empty($button['target']) ? ' target="' . esc_attr($button['target']) . '"' : '';
                    
                    $output .= "$indent\t\t\t<a href=\"" . esc_url($button['url']) . "\"$button_target class=\"$button_class\">\n";
                    $output .= "$indent\t\t\t\t" . esc_html($button['title']) . "\n";
                    $output .= "$indent\t\t\t</a>\n";
                }
                
                $output .= "$indent\t\t</div>\n"; // Close mega-menu-sidebar
            }
            
            $output .= "$indent\t</div>\n"; // Close mega-menu-container
            $output .= "$indent</div>\n"; // Close mega-menu
            $this->mega_menu_open = false;
            $this->current_mega_menu_item = null;
        }
    }
    
    /**
     * Start Element - output the `<li>` and `<a>` for each menu item
     */
    public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
        $this->current_depth = $depth;
        $indent = str_repeat("\t", $depth);
        
        // Get ACF fields for this menu item
        $add_image = get_field('add_image', $item->ID);
        $image = get_field('image', $item->ID);
        $add_sidebar = get_field('add_sidebar', $item->ID);
        $sidebar_content = get_field('sidebar_content', $item->ID);
        
        // Build CSS classes
        $classes = empty($item->classes) ? array() : (array) $item->classes;
        $classes[] = 'menu-item-' . $item->ID;
        $classes[] = 'menu-item--level-' . $depth;
        
        // Check if this item has children
        $has_children = in_array('menu-item-has-children', $classes);
        
        // Add mega menu class for top-level items with children and sidebar
        if ($depth === 0 && $has_children && ($add_sidebar || $this->item_has_mega_menu_children($item))) {
            $classes[] = 'has-mega-menu';
            
            // Add levels count class
            $levels_count = get_menu_item_levels_count($item->ID);
            $classes[] = 'has-' . $levels_count . '-levels';
            
            $this->has_mega_menu = true;
            $this->current_mega_menu_item = $item; // Store the mega menu item
        } else {
            $this->has_mega_menu = false;
        }
        
        // Add image class if image is present
        if ($add_image && $image) {
            $classes[] = 'has-menu-image';
        }
        
        // Add sidebar class for top-level items
        if ($depth === 0 && $add_sidebar && $sidebar_content) {
            $classes[] = 'has-menu-sidebar';
        }
        
        /**
         * Filters the arguments for a single nav menu item.
         */
        $args = apply_filters( 'nav_menu_item_args', $args, $item, $depth );
        
        /**
         * Filters the CSS classes applied to a menu item's list item element.
         */
        $class_names = implode( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth ) );
        $class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';
        
        /**
         * Filters the ID applied to a menu item's list item element.
         */
        $id = apply_filters( 'nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args, $depth );
        $id = $id ? ' id="' . esc_attr( $id ) . '"' : '';
        
        $output .= $indent . '<li' . $id . $class_names .'>';
        
        // Build link attributes
        $attributes = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
        $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
        $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
        $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
        
        /**
         * Filters the HTML attributes applied to a menu item's anchor element.
         */
        $attributes = apply_filters( 'nav_menu_link_attributes', $attributes, $item, $args, $depth );
        
        // Build link content
        $link_content = '';
        
        // Add image if present
        if ($add_image && $image) {
            $image_html = wp_get_attachment_image( 
                $image['ID'], 
                'large', 
                false, 
                array(
                    'class' => 'menu-item__image',
                    'alt' => $image['alt'] ?: $item->title,
                    'loading' => 'lazy'
                )
            );
            $link_content .= $image_html;
        }
        
        // Add menu item title
        $title = apply_filters( 'the_title', $item->title, $item->ID );
        $link_content .= '<span class="menu-item__text">' . $title . '</span>';
        
        // Add dropdown indicator for items with children
        if ($has_children) {
            $link_content .= '<span class="menu-item__indicator" aria-hidden="true"></span>';
        }
        
        $item_output = isset( $args->before ) ? $args->before : '';
        $item_output .= '<a' . $attributes . ' class="menu-item__link">';
        $item_output .= ( isset( $args->link_before ) ? $args->link_before : '' ) . $link_content . ( isset( $args->link_after ) ? $args->link_after : '' );
        $item_output .= '</a>';
        $item_output .= isset( $args->after ) ? $args->after : '';
        
        /**
         * Filters a menu item's starting output.
         */
        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    }
    
    /**
     * End Element - close the `</li>` for each menu item
     */
    public function end_el( &$output, $item, $depth = 0, $args = null ) {
        $output .= "</li>\n";
    }
    
    /**
     * Helper function to determine if item should have mega menu
     * This is a simplified check - you can expand this logic as needed
     */
    private function item_has_mega_menu_children($item) {
        // For now, we'll consider any top-level item with children as potential mega menu
        // You can add more sophisticated logic here based on your needs
        return true;
    }
}
