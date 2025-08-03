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
			'footer' => esc_html__( 'Footer', 'theme' ),
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

function remove_menus_and_submenus(){
	remove_submenu_page( 'themes.php', 'edit.php?post_type=wp_block' );
}

add_action( 'admin_menu', 'remove_menus_and_submenus' );

function theme_upload_mimes($mimes) {
    $mimes['woff'] = 'application/font-woff';
    $mimes['woff2'] = 'application/font-woff2';
    $mimes['otf'] = 'application/x-font-opentype';
    $mimes['ttf'] = 'application/x-font-truetype';
    return $mimes;
}
add_filter('upload_mimes', 'theme_upload_mimes');

function theme_scripts() {
	// Only load frontend scripts on frontend (NOT in admin)
	if (is_admin()) {
		return;
	}
	
	$theme_version = wp_get_theme()->get('Version');

	$sections = get_field('sections');
	$primary_font = get_field('primary_font', 'option');
	$secondary_font = get_field('secondary_font', 'option');
	
	if ($primary_font['upload_type'] == 'url') {
		wp_enqueue_style( 'primary-font', $primary_font['url'], array(), false, 'all' );
	}
	if ($secondary_font['upload_type'] == 'url') {
		wp_enqueue_style( 'secondary-font', $secondary_font['url'], array(), false, 'all' );
	}

	wp_enqueue_style( 'variables', get_stylesheet_directory_uri() . '/theme-variables.css', array(), $theme_version );
    wp_enqueue_style( 'stylesheet', get_stylesheet_directory_uri() . '/style.css', array(), $theme_version );
	wp_enqueue_script('lenis', 'https://unpkg.com/lenis@1.3.8/dist/lenis.min.js', array(), $theme_version, array(
		'strategy' => 'defer'
	));
	wp_enqueue_script(
		'swiper-js', 
		'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js', 
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
		get_stylesheet_directory_uri() . '/scripts/global.js',
		array(),
		$theme_version,
		array(
			'strategy' => 'defer'
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
	wp_dequeue_style( 'bcct_custom_style' );
    wp_dequeue_style( 'bcct_style' );
    wp_dequeue_style( 'bctt-block-editor-css' );
}
add_action( 'wp_enqueue_scripts', 'dequeue_scripts', 100 );

function disable_gutenberg( $is_enabled, $post_type ) {
	if ($post_type == 'page') {
		return false;
	}
	return $is_enabled;
}
add_filter( 'use_block_editor_for_post_type', 'disable_gutenberg', 10, 2 );
add_filter('wpcf7_autop_or_not', '__return_false');
require_once('inc/login.php');
require_once('inc/acf.php');
require_once('inc/icons.php');
require_once('inc/elements.php');
require_once('inc/filter-posts.php');
require_once('inc/load-more-posts.php');
require_once('inc/search-posts.php');