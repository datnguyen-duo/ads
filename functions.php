<?php
defined( 'ABSPATH' ) || exit;


function theme_setup() {
	$primary_color = get_field('primary_color', 'option');
	$secondary_color = get_field('secondary_color', 'option');
	$background_color = get_field('background_color', 'option');
	$text_color = get_field('text_color', 'option');
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
    remove_theme_support('core-block-patterns');
	register_nav_menus(
		array(
			'primary' => esc_html__( 'Primary', 'theme' ),
			'secondary' => esc_html__( 'Secondary', 'theme' ),
			'footer' => esc_html__( 'Footer', 'theme' ),
			'header-buttons' => esc_html__( 'Header Buttons', 'theme' ),
			'footer-buttons' => esc_html__( 'Footer Buttons', 'theme' ),
		),
	);
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);
	add_theme_support( 'editor-color-palette', array(
        array(
            'name'  => __( 'Primary Color', 'theme' ),
            'slug'  => 'color-primary',
            'color' => $primary_color,
        ),
        array(
            'name'  => __( 'Secondary Color', 'theme' ),
            'slug'  => 'color-secondary',
            'color' => $secondary_color,
        ),
		array(
			'name'  => __( 'Background Color', 'theme' ),
			'slug'  => 'color-background',
			'color' => $background_color,
		),
		array(
			'name'  => __( 'Text Color', 'theme' ),
			'slug'  => 'color-text',
			'color' => $text_color,
		),
		array(
			'name'  => __( 'Black', 'theme' ),
			'slug'  => 'black',
			'color' => '#000000',
		),
		array(
			'name'  => __( 'White', 'theme' ),
			'slug'  => 'white',
			'color' => '#ffffff',
		),
    ) );
}
add_action( 'after_setup_theme', 'theme_setup' );

function add_acf_class_to_menu_links($atts, $item, $args, $depth) {
    // Check if this is a button menu
    if ($args->theme_location === 'header-buttons' || $args->theme_location === 'footer-buttons') {
        $menu = wp_get_nav_menu_object($args->menu);
        if ($menu) {
            $menu_items = wp_get_nav_menu_items($menu->term_id);
            // Find position of current item in menu
            $position = array_search($item->ID, array_column($menu_items, 'ID'));
            $button_type = ($position === 0) ? 'primary' : 'secondary';
            
            if (isset($atts['class'])) {
                $atts['class'] .= ' main-navigation__button button button--' . $button_type;
            } else {
                $atts['class'] = 'main-navigation__button button button--' . $button_type;
            }
        }
    }
    return $atts;
}
add_filter('nav_menu_link_attributes', 'add_acf_class_to_menu_links', 10, 4);

function remove_menus_and_submenus(){
	remove_submenu_page( 'themes.php', 'edit.php?post_type=wp_block' );
}

add_action( 'admin_menu', 'remove_menus_and_submenus' );

function theme_upload_mimes($mimes) {
    $mimes['woff'] = 'font/woff|application/font-woff|application/x-font-woff';
    $mimes['woff2'] = 'font/woff2|application/font-woff2';
    $mimes['otf'] = 'font/otf|application/x-font-opentype|font/opentype';
    $mimes['ttf'] = 'font/ttf|application/x-font-truetype|font/truetype';
    $mimes['eot'] = 'application/vnd.ms-fontobject';
    
    return $mimes;
}
add_filter('upload_mimes', 'theme_upload_mimes');

function theme_check_filetype_and_ext($data, $file, $filename, $mimes) {
    $filetype = wp_check_filetype($filename, $mimes);
    
    if (empty($data['ext']) && empty($data['type'])) {
        $wp_file_type = wp_check_filetype($filename);
        
        if (isset($wp_file_type['ext']) && in_array($wp_file_type['ext'], ['woff', 'woff2', 'otf', 'ttf', 'eot'])) {
            $data['ext'] = $wp_file_type['ext'];
            $data['type'] = $wp_file_type['type'];
        }
    }
    
    return $data;
}
add_filter('wp_check_filetype_and_ext', 'theme_check_filetype_and_ext', 10, 4);

function theme_allow_font_uploads($types) {
    $types['woff'] = 'font/woff';
    $types['woff2'] = 'font/woff2';
    $types['otf'] = 'font/otf';
    $types['ttf'] = 'font/ttf';
    $types['eot'] = 'application/vnd.ms-fontobject';
    
    return $types;
}
add_filter('upload_mimes', 'theme_allow_font_uploads');

function theme_increase_upload_size_for_fonts($size) {
    if (isset($_FILES) && !empty($_FILES)) {
        foreach ($_FILES as $file) {
            if (isset($file['name']) && preg_match('/\.(woff2?|ttf|otf|eot)$/i', $file['name'])) {
                return max($size, 10 * 1024 * 1024); 
            }
        }
    }
    return $size;
}
add_filter('upload_size_limit', 'theme_increase_upload_size_for_fonts');

function theme_scripts() {
	if (is_admin()) {
		return;
	}
	
	$theme_version = wp_get_theme()->get('Version');

	$sections = get_field('sections');

	wp_enqueue_style( 'variables', get_stylesheet_directory_uri() . '/theme-variables.css', array(), $theme_version );
    wp_enqueue_style( 'stylesheet', get_stylesheet_directory_uri() . '/style.css', array(), $theme_version );
	wp_enqueue_script('lenis', get_stylesheet_directory_uri() . '/scripts/libs/lenis.min.js', array(), $theme_version, array(
		'strategy' => 'defer'
	));
	wp_enqueue_script(
		'swiper-js', 
		get_stylesheet_directory_uri() . '/scripts/libs/swiper.min.js', 
		array(),
		$theme_version,
		array(
			'strategy' => 'defer'
		)
	);
	wp_enqueue_script(
		'gsap',
		get_stylesheet_directory_uri() . '/scripts/libs/gsap.min.js',
		array(),
		$theme_version,
		array(
			'strategy' => 'defer'
		)
	);
	wp_enqueue_script(
		'scrollTrigger',
		get_stylesheet_directory_uri() . '/scripts/libs/ScrollTrigger.min.js',
		array(),
		$theme_version,
		array(
			'strategy' => 'defer'
		)
	);
	wp_enqueue_script(
		'splitText',
		get_stylesheet_directory_uri() . '/scripts/libs/SplitText.min.js',
		array(),
		$theme_version,
		array(
			'strategy' => 'defer'
		)
	);
	wp_enqueue_script(
		'global-script',
		get_stylesheet_directory_uri() . '/scripts/global.min.js',
		array(),
		$theme_version,
		array(
			'strategy' => 'defer'
		)
	);

	// Localize script for AJAX
	wp_localize_script(
		'global-script',
		'ajax_object',
		array(
			'ajax_url' => admin_url('admin-ajax.php'),
			'nonce' => wp_create_nonce('ajax-nonce')
		)
	);
	
}
add_action( 'wp_enqueue_scripts', 'theme_scripts' );

add_filter('body_class', 'add_page_slug_body_class');

function add_page_slug_body_class($classes) {
    if (is_page()) {
        global $post;
        $classes[] = 'page-' . $post->post_name;
    }
    return $classes;
}

function dequeue_scripts(){
	// Only dequeue on frontend, not admin
	if (is_admin()) {
		return;
	}
	
	wp_dequeue_style( 'wp-block-library' );
	wp_dequeue_style( 'wp-block-library-theme' );
	wp_dequeue_style('classic-theme-styles');
	wp_dequeue_style( 'wc-block-style' );
	wp_dequeue_style( 'global-styles' ); 
}
add_action( 'wp_enqueue_scripts', 'dequeue_scripts', 100 );

function disable_gutenberg( $is_enabled, $post_type ) {
	return false;
}
add_filter( 'use_block_editor_for_post_type', 'disable_gutenberg', 10, 2 );
add_filter('wpcf7_autop_or_not', '__return_false');
require_once('inc/login.php');
require_once('inc/acf.php');
require_once('inc/icons.php');
require_once('inc/elements.php');
require_once('inc/mega-menu-walker.php');
require_once('inc/mega-menu-functions.php');
require_once('inc/load-more-posts.php');