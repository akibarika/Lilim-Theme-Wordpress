<?php
function lilim_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	global $commentcount;
	if ( ! $commentcount ) {
		$page         = ( ! empty( $in_comment_loop ) ) ? get_query_var( 'cpage' ) - 1 : get_page_of_comment( $comment->comment_ID, $args ) - 1;
		$cpp          = get_option( 'comments_per_page' );
		$commentcount = $cpp * $page;
	}
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>" <?php if ( $depth > 1 ) {
		echo 'style="margin-left:65px;"';
	} ?>>
		<div id="comment-<?php comment_ID(); ?>" class="comment-body">
			<div class="comment-author">
				<?php echo get_avatar( $comment, $size = '60' ); ?>
				<div class="comment-reply">
					<?php comment_reply_link( array_merge( $args, array(
						'reply_text' => '回复',
						'depth'      => $depth,
						'max_depth'  => $args['max_depth']
					) ) ) ?>
				</div>
			</div>
			<div class="comment-wrapper">
				<div class="comment-head">
					<span class="name"><?php comment_author_link(); ?>: </span>
                    <span class="comment-text"><?php comment_text() ?>
	                    <?php if ( $comment->comment_approved == '0' ) : ?>
		                    <em><?php _e( 'Your comment is awaiting moderation.' ) ?></em>
		                    <br/>
	                    <?php endif; ?>
                    </span>
				</div>
				<div class="comment-time">
					<div class="date"><?php echo get_comment_date( 'F j, Y' ) ?></div>
				</div>
			</div>
		</div>
	</li>
<?php }


function ajaxify_comments( $comment_ID, $comment_status ) {
	if ( ! empty( $_SERVER['HTTP_X_REQUESTED_WITH'] ) && strtolower( $_SERVER['HTTP_X_REQUESTED_WITH'] ) == 'xmlhttprequest' ) {
		//If AJAX Request Then
		switch ( $comment_status ) {
			case '0':
				wp_notify_moderator( $comment_ID );
			case '1':
				$commentdata = &get_comment( $comment_ID, ARRAY_A );
				$post        = &get_post( $commentdata['comment_post_ID'] );
				$permaurl    = get_permalink( $post->ID );
				$url         = str_replace( 'http://', '/', $permaurl );
				if ( $commentdata['comment_parent'] == 0 ) {
					$output = '
                    <li id="comment-' . $commentdata['comment_ID'] . ' " >
                        <div id="comment-' . $commentdata['comment_ID'] . '" class="comment-body">
                            <div class="comment-author">
                                ' . get_avatar( $commentdata['comment_author_email'], $size = '60' ) . '
                            </div>
							<div class="comment-wrapper">
								<div class="comment-head">
									<span class="name">
									    ' . $commentdata['comment_author'] . ':
									</span>
								<span class="comment-text">
								' . $commentdata['comment_content'] . '
								</span>
							</div>
                            <div class="comment-time">
                                <div class="date">
                                    ' . get_comment_date( 'F j, Y', $commentdata['comment_ID'] ) . '
                                </div>
                            </div>
                        </div>
                    </li>';
					echo $output;
				}
				else {
					$output = '
                    <li id="comment-' . $commentdata['comment_ID'] . '" style="margin-left:65px;" >
                        <div id="comment-' . $commentdata['comment_ID'] . '" class="comment-body">
                            <div class="comment-author">
                                ' . get_avatar( $commentdata['comment_author_email'], $size = '60' ) . '
                            </div>
							<div class="comment-wrapper">
								<div class="comment-head">
									<span class="name">
									    ' . $commentdata['comment_author'] . ':
									</span>
								<span class="comment-text">
								' . $commentdata['comment_content'] . '
								</span>
							</div>
                            <div class="comment-time">
                                <div class="date">
                                    ' . get_comment_date( 'F j, Y', $commentdata['comment_ID'] ) . '
                                </div>
                            </div>
                        </div>
                    </li>';
					echo $output;
				}
				wp_notify_postauthor( $comment_ID, $commentdata['comment_type'] );
				break;
			default:
				echo "error";
		}
		exit;
	}
}

add_action( 'comment_post', 'ajaxify_comments', 25, 2 );


/*ajax comment submit*/
add_action( 'wp_ajax_nopriv_ajax_comment', 'ajax_comment' );
add_action( 'wp_ajax_ajax_comment', 'ajax_comment' );
function ajax_comment() {
	global $wpdb;
//nocache_headers();
	$comment_post_ID = isset( $_POST['comment_post_ID'] ) ? (int) $_POST['comment_post_ID'] : 0;
	$post            = get_post( $comment_post_ID );
	$post_author     = $post->post_author;
	if ( empty( $post->comment_status ) ) {
		do_action( 'comment_id_not_found', $comment_post_ID );
		ajax_comment_err( 'Invalid comment status.' );
	}
	$status     = get_post_status( $post );
	$status_obj = get_post_status_object( $status );
	if ( ! comments_open( $comment_post_ID ) ) {
		do_action( 'comment_closed', $comment_post_ID );
		ajax_comment_err( 'Sorry, comments are closed for this item.' );
	}
	elseif ( 'trash' == $status ) {
		do_action( 'comment_on_trash', $comment_post_ID );
		ajax_comment_err( 'Invalid comment status.' );
	}
	elseif ( ! $status_obj->public && ! $status_obj->private ) {
		do_action( 'comment_on_draft', $comment_post_ID );
		ajax_comment_err( 'Invalid comment status.' );
	}
	elseif ( post_password_required( $comment_post_ID ) ) {
		do_action( 'comment_on_password_protected', $comment_post_ID );
		ajax_comment_err( 'Password Protected' );
	}
	else {
		do_action( 'pre_comment_on_post', $comment_post_ID );
	}
	$comment_author       = ( isset( $_POST['author'] ) ) ? trim( strip_tags( $_POST['author'] ) ) : null;
	$comment_author_email = ( isset( $_POST['email'] ) ) ? trim( $_POST['email'] ) : null;
	$comment_author_url   = ( isset( $_POST['url'] ) ) ? trim( $_POST['url'] ) : null;
	$comment_content      = ( isset( $_POST['comment'] ) ) ? trim( $_POST['comment'] ) : null;
	$edit_id              = ( isset( $_POST['edit_id'] ) ) ? $_POST['edit_id'] : null; // 提取 edit_id
	$user                 = wp_get_current_user();
	if ( $user->exists() ) {
		if ( empty( $user->display_name ) ) {
			$user->display_name = $user->user_login;
		}
		$comment_author       = $wpdb->escape( $user->display_name );
		$comment_author_email = $wpdb->escape( $user->user_email );
		$comment_author_url   = $wpdb->escape( $user->user_url );
		$user_ID              = $wpdb->escape( $user->ID );
		if ( current_user_can( 'unfiltered_html' ) ) {
			if ( wp_create_nonce( 'unfiltered-html-comment_' . $comment_post_ID ) != $_POST['_wp_unfiltered_html_comment'] ) {
				kses_remove_filters();
				kses_init_filters();
			}
		}
	}
	else {
		if ( get_option( 'comment_registration' ) || 'private' == $status ) {
			ajax_comment_err( 'Sorry, you must be logged in to post a comment.' );
		}
	}
	$comment_type = '';
	if ( get_option( 'require_name_email' ) && ! $user->exists() ) {
		if ( 6 > strlen( $comment_author_email ) || '' == $comment_author ) {
			ajax_comment_err( 'Error: please fill the required fields (name, email).' );
		}
		elseif ( ! is_email( $comment_author_email ) ) {
			ajax_comment_err( 'Error: please enter a valid email address.' );
		}
	}
	if ( '' == $comment_content ) {
		ajax_comment_err( 'Error: please type a comment.' );
	}
	$dupe = "SELECT comment_ID FROM $wpdb->comments WHERE comment_post_ID = '$comment_post_ID' AND ( comment_author = '$comment_author' ";
	if ( $comment_author_email ) {
		$dupe .= "OR comment_author_email = '$comment_author_email' ";
	}
	$dupe .= ") AND comment_content = '$comment_content' LIMIT 1";
	if ( $wpdb->get_var( $dupe ) ) {
		ajax_comment_err( 'Duplicate comment detected; it looks as though you&#8217;ve already said that!' );
	}
	if ( $lasttime = $wpdb->get_var( $wpdb->prepare( "SELECT comment_date_gmt FROM $wpdb->comments WHERE comment_author = %s ORDER BY comment_date DESC LIMIT 1", $comment_author ) ) ) {
		$time_lastcomment = mysql2date( 'U', $lasttime, false );
		$time_newcomment  = mysql2date( 'U', current_time( 'mysql', 1 ), false );
		$flood_die        = apply_filters( 'comment_flood_filter', false, $time_lastcomment, $time_newcomment );
		if ( $flood_die ) {
			ajax_comment_err( 'You are posting comments too quickly.  Slow down.' );
		}
	}
	$comment_parent = isset( $_POST['comment_parent'] ) ? absint( $_POST['comment_parent'] ) : 0;
	$commentdata    = compact( 'comment_post_ID', 'comment_author', 'comment_author_email', 'comment_author_url', 'comment_content', 'comment_type', 'comment_parent', 'user_ID' );
	if ( $edit_id ) {
		$comment_id = $commentdata['comment_ID'] = $edit_id;
		if ( ihacklog_user_can_edit_comment( $commentdata, $comment_id ) ) {
			wp_update_comment( $commentdata );
		}
		else {
			ajax_comment_err( 'Cheatin&#8217; uh?' );
		}
	}
	else {
		$comment_id = wp_new_comment( $commentdata );
	}
	$comment = get_comment( $comment_id );
	do_action( 'set_comment_cookies', $comment, $user );
	$comment_depth = 1;
	$tmp_c         = $comment;
	while ( $tmp_c->comment_parent != 0 ) {
		$comment_depth ++;
		$tmp_c = get_comment( $tmp_c->comment_parent );
	}
	$GLOBALS['comment'] = $comment;
	?>
<li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>" <?php if ( $comment_depth > 1 ) {
	echo 'style="margin-left:65px;"';
} ?>>
	<div id="comment-<?php comment_ID(); ?>" class="comment-body cf">
		<div class="comment-author">
			<?php echo get_avatar( $comment, $size = '60' ); ?>
			<div class="comment-reply">

			</div>
		</div>
		<div class="comment-wrapper">
			<div class="comment-head">
				<span class="name"><?php comment_author_link(); ?>: </span>
                    <span class="comment-text"><?php comment_text() ?>
	                    <?php if ( $comment->comment_approved == '0' ) : ?>
		                    <em><?php _e( 'Your comment is awaiting moderation.' ) ?></em>
		                    <br/>
	                    <?php endif; ?>
                    </span>
			</div>
			<div class="comment-time">
				<div class="date"><?php echo get_comment_date( 'F j, Y' ) ?></div>
			</div>
		</div>
	</div>

	<?php die();
}

function ajax_comment_err( $a ) {
	header( 'HTTP/1.0 500 Internal Server Error' );
	header( 'Content-Type: text/plain;charset=UTF-8' );
	echo $a;
	exit;
}


function ihacklog_user_can_edit_comment( $new_cmt_data, $comment_ID = 0 ) {
	if ( current_user_can( 'edit_comment', $comment_ID ) ) {
		return true;
	}
	$comment       = get_comment( $comment_ID );
	$old_timestamp = strtotime( $comment->comment_date );
	$new_timestamp = current_time( 'timestamp' );
	// 不用get_comment_author_email($comment_ID) , get_comment_author_IP($comment_ID)
	$rs = $comment->comment_author_email === $new_cmt_data['comment_author_email']
	      && $comment->comment_author_IP === $_SERVER['REMOTE_ADDR']
	      && $new_timestamp - $old_timestamp < 3600;

	return $rs;
}

function get_ssl_avatar( $avatar ) {
	$avatar = preg_replace( '/.*\/avatar\/(.*)\?s=([\d]+)&.*/', '<img src="https://secure.gravatar.com/avatar/$1?s=$2"
	                                                                  class="avatar avatar-$2" height="$2" width="$2">',
		$avatar );

	return $avatar;
}

add_filter( 'get_avatar', 'get_ssl_avatar' );