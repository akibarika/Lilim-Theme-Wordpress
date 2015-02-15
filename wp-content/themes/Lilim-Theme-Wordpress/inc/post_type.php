<?php
/**
 * Created by PhpStorm.
 * User: akibarika
 * Date: 13/08/14
 * Time: 2:30 下午
 */
function cutom_post_type_label_args($typeName){
    return $labels = array(
        'name' => $typeName,
        'singular_name' => $typeName,
        'add_new' => 'Add New',
        'add_new_item' => 'Add New '.$typeName,
        'edit_item' => 'Edit '.$typeName,
        'new_item' => 'New '.$typeName,
        'all_items' => 'All '.$typeName,
        'view_item' => 'View '.$typeName,
        'search_items' => 'Search '.$typeName,
        'not_found' =>  'No '.$typeName.' found',
        'not_found_in_trash' => 'No '.$typeName.' found in Trash',
        'parent_item_colon' => '',
        'menu_name' => $typeName
    );
}
function custom_post_type_args($typeName,$postType="post",$public=true,$queryable=true,$show_ui=true,$show_menu=true,$query_var=true,$has_archive = true, $hierarchical = false,$menu_position = null){
    return $args = array(
        'labels' => cutom_post_type_label_args($typeName),
        'public' => $public,
        'publicly_queryable' => $queryable,
        'show_ui' => $show_ui,
        'show_in_menu' => $show_menu,
        'query_var' => $query_var,
        'rewrite' => array( 'slug' => strtolower($typeName)),
        'capability_type' => $postType,
        'has_archive' => $has_archive,
        'hierarchical' => $hierarchical,
        'menu_position' => $menu_position,
        'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments','custom-fields' )
    );
}

function custom_post_type() {
    register_post_type( 'website', custom_post_type_args("Website"));
    register_post_type( 'theme', custom_post_type_args("Theme"));
    register_post_type( 'illustration', custom_post_type_args("Illustration"));
}
add_action( 'init', 'custom_post_type' );

add_filter( 'manage_edit-website_columns', 'custom_columns' );
add_filter( 'manage_edit-theme_columns', 'custom_columns' );
add_filter( 'manage_edit-illustration_columns', 'custom_columns' );
function custom_columns( $columns ) {
    $columns = array(
        'cb' => '<input type="checkbox" />',
        'title' => 'Name',
        'haslink' => 'Line to',
        'des' => 'Description',
        'thumbnail' => 'Thumbnail',
        'date' => 'Date'
    );
    return $columns;
}

add_action( 'manage_website_posts_custom_column', 'manage_custom_columns', 10, 2 );
add_action( 'manage_theme_posts_custom_column', 'manage_custom_columns', 10, 2 );
add_action( 'manage_illustration_posts_custom_column', 'manage_custom_columns', 10, 2 );
function manage_custom_columns( $column, $post_id ) {
    global $post;
    switch( $column ) {
        case "haslink":
            if(get_post_meta($post->ID, "link", true)){
                echo get_post_meta($post->ID, "link", true);
            } else { echo '----'; }
                break;
        case "des":
            if(get_post_meta($post->ID, "des", true)){
                echo get_post_meta($post->ID, "des", true);
            } else { echo '----'; }
                break;
        case "thumbnail":
                $pic = get_post_meta($post->ID, "pic", true);
                echo '<img src="'.$pic.'" width="95" alt="" />';
                break;
        default :
            break;
    }
}