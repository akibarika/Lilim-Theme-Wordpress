<?php
define( 'LILIM_VERSION', '4.1.0' );
define( 'LILIM_URL', get_template_directory_uri() );
define( 'LILIM_PATH', get_template_directory() );

require LILIM_PATH . '/inc/post_type.php';
require LILIM_PATH . '/inc/comments.php';
require LILIM_PATH . '/inc/pagenav.php';
require LILIM_PATH . '/inc/commons.php';


//WordPress setting goes here

function lilim_setup() {
	//Adding menu selecting support
	add_theme_support( 'menus' );
	if ( function_exists( 'register_nav_menus' ) ) {
		register_nav_menus( array( 'cat-menu' => 'Category Menu', 'page-menu' => 'Page Menu' ) );
	}

	//Adding thumb support
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 430, 9999, true );
	add_image_size( 'home-thumbnail', 430, 9999 );
	//Adding post formats
	add_theme_support( 'post-formats', array( 'aside', 'quote', 'link', 'status', 'gallery' ) );
}

add_action( 'after_setup_theme', 'lilim_setup' );

