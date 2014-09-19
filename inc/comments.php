<?php
/**
 * Created by PhpStorm.
 * User: Akiba
 * Date: 14-9-1
 * Time: 下午8:47
 */
//评论表情
if ( !isset( $wpsmiliestrans ) ) {
    $wpsmiliestrans = array(
        ':em01:' => '01.gif',
        ':em02:' => '02.gif',
        ':em03:' => '03.gif',
        ':em04:' => '04.gif',
        ':em05:' => '05.gif',
        ':em06:' => '06.gif',
        ':em07:' => '07.gif',
        ':em08:' => '08.gif',
        ':em09:' => '09.gif',
        ':em10:' => '10.gif',
    );
}
function custom_smilies_src($src, $img)
{
    return get_bloginfo('template_directory').'/smilies/' . $img;
}
add_filter('smilies_src', 'custom_smilies_src', 10, 2);

function otakism_comment($comment, $args, $depth) {
    $GLOBALS['comment'] = $comment;
    global $commentcount,$comment_depth;
    $otakism_comment_depth = $comment_depth-1;
    if(!$otakism_comment_depth){
        $otakism_comment_depth = '&nbsp;&nbsp';
    }
    if(!$commentcount) {
        $page = ( !empty($in_comment_loop) ) ? get_query_var('cpage')-1 : get_page_of_comment( $comment->comment_ID, $args )-1;
        $cpp=get_option('comments_per_page');
        $commentcount = $cpp * $page;
    }
    ?>
    <li <?php comment_class(); ?><?php if( $depth > 1){ echo ' style="margin-left:35px;"';} ?> id="comment-<?php comment_ID() ?>" >
        <div id="comment-<?php comment_ID(); ?>" class="comment-body clearfix">
            <div class="comment-avatar left"><a href="<?php comment_author_url(); ?>"><?php echo get_avatar( $comment, $size = '50'); ?></a></div>
            <div class="comment-content">
                <div class="comment-name"><?php printf(__('%s'), get_comment_author_link()) ?></div>
                <div class="comment-entry"><?php comment_text() ?></div>
                <div class="comment-meta clearfix">
                    <div class="comment-date left"><?php echo get_comment_date('F j, Y') ?></div>
                    <div class="comment-reply left"><?php comment_reply_link(array_merge( $args, array('reply_text' => '回复','depth' => $depth, 'max_depth' => $args['max_depth']))) ?></div>
                    <div class="useragent left">
                        <?php if (function_exists("CID_init")) {CID_print_comment_browser();} ?>
                    </div>
                </div>
            </div>
            <div class="comment-floor right">
                <?php
                if(get_option('default_comments_page')=='newest'){
                    if(!$parent_id = $comment->comment_parent ){
                        ++$commentcount;
                    }
                    echo '<span>#'.$commentcount.'<strong>'.$otakism_comment_depth .'</strong></span>';
                }else{

                    if(!$parent_id = $comment->comment_parent ){
                        --$commentcount;
                    }
                    echo '<span>#'.$commentcount.'<strong>'.$otakism_comment_depth .'</strong></span>';

                }
                ?>
            </div>
        </div>
    </li>
<?php }

/*ajax comment submit*/
add_action('wp_ajax_nopriv_ajax_comment', 'ajax_comment');
add_action('wp_ajax_ajax_comment', 'ajax_comment');
function ajax_comment(){
    global $wpdb;
    //nocache_headers();
    $comment_post_ID = isset($_POST['comment_post_ID']) ? (int) $_POST['comment_post_ID'] : 0;
    $post = get_post($comment_post_ID);
    $post_author = $post->post_author;
    if ( empty($post->comment_status) ) {
        do_action('comment_id_not_found', $comment_post_ID);
        ajax_comment_err('Invalid comment status.');
    }
    $status = get_post_status($post);
    $status_obj = get_post_status_object($status);
    if ( !comments_open($comment_post_ID) ) {
        do_action('comment_closed', $comment_post_ID);
        ajax_comment_err('Sorry, comments are closed for this item.');
    } elseif ( 'trash' == $status ) {
        do_action('comment_on_trash', $comment_post_ID);
        ajax_comment_err('Invalid comment status.');
    } elseif ( !$status_obj->public && !$status_obj->private ) {
        do_action('comment_on_draft', $comment_post_ID);
        ajax_comment_err('Invalid comment status.');
    } elseif ( post_password_required($comment_post_ID) ) {
        do_action('comment_on_password_protected', $comment_post_ID);
        ajax_comment_err('Password Protected');
    } else {
        do_action('pre_comment_on_post', $comment_post_ID);
    }
    $comment_author       = ( isset($_POST['author']) )  ? trim(strip_tags($_POST['author'])) : null;
    $comment_author_email = ( isset($_POST['email']) )   ? trim($_POST['email']) : null;
    $comment_author_url   = ( isset($_POST['url']) )     ? trim($_POST['url']) : null;
    $comment_content      = ( isset($_POST['comment']) ) ? trim($_POST['comment']) : null;
    $edit_id              = ( isset($_POST['edit_id']) ) ? $_POST['edit_id'] : null; // 提取 edit_id
    $user = wp_get_current_user();
    if ( $user->exists() ) {
        if ( empty( $user->display_name ) )
            $user->display_name=$user->user_login;
        $comment_author       = $wpdb->escape($user->display_name);
        $comment_author_email = $wpdb->escape($user->user_email);
        $comment_author_url   = $wpdb->escape($user->user_url);
        $user_ID			  = $wpdb->escape($user->ID);
        if ( current_user_can('unfiltered_html') ) {
            if ( wp_create_nonce('unfiltered-html-comment_' . $comment_post_ID) != $_POST['_wp_unfiltered_html_comment'] ) {
                kses_remove_filters();
                kses_init_filters();
            }
        }
    } else {
        if ( get_option('comment_registration') || 'private' == $status )
            ajax_comment_err('Sorry, you must be logged in to post a comment.');
    }
    $comment_type = '';
    if ( get_option('require_name_email') && !$user->exists() ) {
        if ( 6 > strlen($comment_author_email) || '' == $comment_author )
            ajax_comment_err( 'Error: please fill the required fields (name, email).' );
        elseif ( !is_email($comment_author_email))
            ajax_comment_err( 'Error: please enter a valid email address.' );
    }
    if ( '' == $comment_content )
        ajax_comment_err( 'Error: please type a comment.' );
    $dupe = "SELECT comment_ID FROM $wpdb->comments WHERE comment_post_ID = '$comment_post_ID' AND ( comment_author = '$comment_author' ";
    if ( $comment_author_email ) $dupe .= "OR comment_author_email = '$comment_author_email' ";
    $dupe .= ") AND comment_content = '$comment_content' LIMIT 1";
    if ( $wpdb->get_var($dupe) ) {
        ajax_comment_err('Duplicate comment detected; it looks as though you&#8217;ve already said that!');
    }
    if ( $lasttime = $wpdb->get_var( $wpdb->prepare("SELECT comment_date_gmt FROM $wpdb->comments WHERE comment_author = %s ORDER BY comment_date DESC LIMIT 1", $comment_author) ) ) {
        $time_lastcomment = mysql2date('U', $lasttime, false);
        $time_newcomment  = mysql2date('U', current_time('mysql', 1), false);
        $flood_die = apply_filters('comment_flood_filter', false, $time_lastcomment, $time_newcomment);
        if ( $flood_die ) {
            ajax_comment_err('You are posting comments too quickly.  Slow down.');
        }
    }
    $comment_parent = isset($_POST['comment_parent']) ? absint($_POST['comment_parent']) : 0;
    $commentdata = compact('comment_post_ID', 'comment_author', 'comment_author_email', 'comment_author_url', 'comment_content', 'comment_type', 'comment_parent', 'user_ID');

    if ( $edit_id )
    {
        $comment_id = $commentdata['comment_ID'] = $edit_id;
        if( ihacklog_user_can_edit_comment($commentdata,$comment_id) )
        {
            wp_update_comment( $commentdata );
        }
        else
        {
            ajax_comment_err( 'Cheatin&#8217; uh?' );
        }

    }
    else
    {
        $comment_id = wp_new_comment( $commentdata );
    }

    $comment = get_comment($comment_id);
    do_action('set_comment_cookies', $comment, $user);
    $comment_depth = 1;
    $tmp_c = $comment;
    while($tmp_c->comment_parent != 0){
        $comment_depth++;
        $tmp_c = get_comment($tmp_c->comment_parent);
    }
    $GLOBALS['comment'] = $comment;
    ?>
<li <?php comment_class(); ?><?php if( $depth > 1){ echo ' style="margin-left:35px;"';} ?> id="comment-<?php comment_ID() ?>" >
    <div id="comment-<?php comment_ID(); ?>" class="comment-body clearfix">
        <div class="comment-avatar left"><a href="<?php comment_author_url(); ?>"><?php echo get_avatar( $comment, $size = '50'); ?></a></div>
        <div class="comment-content">
            <div class="comment-name"><?php printf(__('%s'), get_comment_author_link()) ?></div>
            <div class="comment-entry"><?php comment_text() ?></div>
            <div class="comment-meta clearfix">
                <div class="comment-date left"><?php echo get_comment_date('F j, Y') ?></div>
                <div class="comment-reply left"></div>
                <div class="useragent left">
                    <?php if (function_exists("CID_init")) {CID_print_comment_browser();} ?>
                </div>
            </div>
        </div>
    </div>
    <?php die();
}
function ajax_comment_err($a) {
    header('HTTP/1.0 500 Internal Server Error');
    header('Content-Type: text/plain;charset=UTF-8');
    echo $a;
    exit;
}

function ihacklog_user_can_edit_comment($new_cmt_data,$comment_ID = 0) {
    if(current_user_can('edit_comment', $comment_ID)) {
        return true;
    }
    $comment = get_comment( $comment_ID );
    $old_timestamp = strtotime( $comment->comment_date);
    $new_timestamp = current_time('timestamp');
    // 不用get_comment_author_email($comment_ID) , get_comment_author_IP($comment_ID)
    $rs = $comment->comment_author_email === $new_cmt_data['comment_author_email']
        && $comment->comment_author_IP === $_SERVER['REMOTE_ADDR']
        && $new_timestamp - $old_timestamp < 3600;
    return $rs;
}
