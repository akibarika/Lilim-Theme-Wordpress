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
        <div class="comment-body clearfix">
            <div class="comment-avatar left"><a href="<?php comment_author_url(); ?>"><?php echo get_avatar( $comment, $size = '50'); ?></a></div>
            <div class="comment-content">
                <div class="comment-name"><?php printf(__('%s'), get_comment_author_link()) ?></div>
                <div class="comment-entry"><?php comment_text() ?></div>
                <div class="comment-meta clearfix">
                    <div class="comment-date left"><?php echo get_comment_date('F j, Y') ?></div>
                    <div class="comment-reply left"><?php comment_reply_link(array_merge( $args, array('reply_text' => '回复','depth' => $depth, 'max_depth' => $args['max_depth']))) ?></div>
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

add_action('init', 'ajaxcomments_load_js');

function ajaxify_comments_jaya($comment_ID, $comment_status) {
    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
        //If AJAX Request Then
        switch ($comment_status) {
            case '0':
                wp_notify_moderator($comment_ID);
            case '1':
                $commentdata = &get_comment($comment_ID, ARRAY_A);
                $post = &get_post($commentdata['comment_post_ID']);
                $permaurl = get_permalink( $post->ID );
                $url = str_replace('http://', '/', $permaurl);
                if($commentdata['comment_parent'] == 0){
                    $output = '<li id="comment-' . $commentdata['comment_ID'] . '" >
                        <div class="comment-body clearfix">
                            <div class="comment-avatar left">'. get_avatar($commentdata['comment_author_email'],$size = '50').'</div>
                                <div class="comment-content">
                                <div class="comment-name">' . $commentdata['comment_author'] . '</div>
                                <div class="comment-entry">' . $commentdata['comment_content'] . '</div>
                                <div class="comment-meta clearfix">
                                    <div class="comment-date left">' .get_comment_date( 'F j, Y', $commentdata['comment_ID']) .'</div>
                                    <div class="comment-reply left"></div>
                                </div>
                            </div>
                        </div>
                    </li>';
                    echo $output;
			   } else {
                    $output = '<ul class="children"><li id="comment-' . $commentdata['comment_ID'] . '"><div class="comment-body clearfix"><div class="comment-avatar left">'. get_avatar($commentdata['comment_author_email'],$size = '50').'</div><div class="comment-content"><div class="comment-name">' . $commentdata['comment_author'] . '</div><div class="comment-entry">' . $commentdata['comment_content'] . '</div><div class="comment-meta clearfix"><div class="comment-date left">' .get_comment_date( 'F j, Y', $commentdata['comment_ID']) .'</div><div class="comment-reply left"></div></div></div></div></li></ul>';
                    echo $output;
			   }
                wp_notify_postauthor($comment_ID, $commentdata['comment_type']);
                break;
            default:
                echo "error";
        }
        exit;
    }
}

add_action('comment_post', 'ajaxify_comments_jaya', 25, 2);


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

function get_ssl_avatar($avatar) {
   $avatar = preg_replace('/.*\/avatar\/(.*)\?s=([\d]+)&.*/','<img src="https://secure.gravatar.com/avatar/$1?s=$2" class="avatar avatar-$2" height="$2" width="$2">',$avatar);
   return $avatar;
}
add_filter('get_avatar', 'get_ssl_avatar');