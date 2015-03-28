<?php
function lilim_comment($comment, $args, $depth) {
    $GLOBALS['comment'] = $comment;
    global $commentcount;
    if(!$commentcount) {
        $page = ( !empty($in_comment_loop) ) ? get_query_var('cpage')-1 : get_page_of_comment( $comment->comment_ID, $args )-1;
        $cpp=get_option('comments_per_page');
        $commentcount = $cpp * $page;
    }
    ?>
    <li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>" <?php if( $depth > 1){ echo 'style="margin-left:65px;"';} ?>>
        <div id="comment-<?php comment_ID(); ?>" class="comment-body">
            <div class="comment-author">
                <?php echo get_avatar( $comment, $size = '60'); ?>
                <div class="comment-reply">
                    <?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth'], 'reply_text' => __('回复')))) ?>
                </div>
            </div>
            <div class="comment-wrapper">
                <div class="comment-head">
                    <span class="name"><?php comment_author_link(); ?>: </span>
                    <span class="comment-text"><?php comment_text() ?>
                        <?php if ($comment->comment_approved == '0') : ?>
                            <em><?php _e('Your comment is awaiting moderation.') ?></em>
                            <br />
                        <?php endif; ?>
                    </span>
                </div>
                <div class="comment-time">
                    <div class="date"><?php echo get_comment_date('F j, Y') ?></div>
                </div>
            </div>
        </div>
    </li>
<?php }



function ajaxify_comments($comment_ID, $comment_status) {
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
                    $output = '
                    <li id="comment-' . $commentdata['comment_ID'] . '" >
                        <div id="comment-'.$commentdata['comment_ID'].'" class="comment-body">
                            <div class="comment-author">
                                '. get_avatar($commentdata['comment_author_email'],$size = '60').'
                            </div>
							<div class="comment-wrapper">
								<div class="comment-head">
									<span class="name">
									    '.$commentdata['comment_author'].':
									</span>
								<span class="comment-text">
								'. $commentdata['comment_content'] .'
								</span>
							</div>
                            <div class="comment-time">
                                <div class="date">
                                    ' .get_comment_date( 'F j, Y', $commentdata['comment_ID']) .'
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

add_action('comment_post', 'ajaxify_comments', 25, 2);


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