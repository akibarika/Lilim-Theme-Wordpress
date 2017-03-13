<?php
/**
 * Created by PhpStorm.
 * User: Akiba
 * Date: 14-9-1
 * Time: 下午8:51
 */
add_action('wp_ajax_nopriv_ajax_pagination', 'my_ajax_pagination');
add_action('wp_ajax_ajax_pagination', 'my_ajax_pagination');

function my_ajax_pagination()
{
    $args = isset($_POST['query']) ? array_map('esc_attr', $_POST['query']) : array();
    $args['post_type'] = isset($args['post_type']) ? esc_attr($args['post_type']) : 'post';
    $args['paged'] = esc_attr($_POST['page']);
    $args['post_status'] = 'publish';
    if ( isset($_POST['currentCat']) && $_POST['currentCat'] ) {
        $args['cat'] = $_POST['currentCat'];
    }
    if ( isset($_POST['currentTag']) && $_POST['currentTag'] ) {
        $args['tag'] = $_POST['currentTag'];
    }
    ob_start();
    $loop = new WP_Query($args);
    if ($loop->have_posts()): while ($loop->have_posts()): $loop->the_post();
        get_template_part('content');
    endwhile; endif;
    wp_reset_postdata();
    $data = ob_get_clean();
    wp_send_json_success($data);
    wp_die();
}