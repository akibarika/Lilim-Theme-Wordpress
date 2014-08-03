<?php
//adding menu selecting support
add_theme_support( 'menus' );if( function_exists( 'register_nav_menus' ) ) {register_nav_menus(array('menu' => 'Menu','footer-menu' => 'Footer Menu',));}

//adding thumb support
add_theme_support( 'post-thumbnails' );
set_post_thumbnail_size( 430, 9999, true);
add_image_size( 'home-thumbnail', 430, 9999 ); //430 pixels wide (and unlimited height)

// 中文截断文字
function cut_str($string, $sublen, $start = 0, $code = 'UTF-8'){if($code == 'UTF-8'){$pa = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|\xe0[\xa0-\xbf][\x80-\xbf]|[\xe1-\xef][\x80-\xbf][\x80-\xbf]|\xf0[\x90-\xbf][\x80-\xbf][\x80-\xbf]|[\xf1-\xf7][\x80-\xbf][\x80-\xbf][\x80-\xbf]/";preg_match_all($pa, $string, $t_string);if(count($t_string[0]) - $start > $sublen) return join('', array_slice($t_string[0], $start, $sublen))."...";return join('', array_slice($t_string[0], $start, $sublen));}else{$start = $start*2;$sublen = $sublen*2;$strlen = strlen($string);$tmpstr = '';for($i=0; $i<$strlen; $i++){ if($i>=$start && $i<($start+$sublen)){if(ord(substr($string, $i, 1))>129) $tmpstr.= substr($string, $i, 2);else $tmpstr.= substr($string, $i, 1);}if(ord(substr($string, $i, 1))>129) $i++;}if(strlen($tmpstr)<$strlen ) $tmpstr.= "...";return $tmpstr;}}

//邮件提醒
/* comment_mail_notify v1.0 by willin kan. (所有回复都发邮件) */
function comment_mail_notify($comment_id) {
  $comment = get_comment($comment_id);
  $parent_id = $comment->comment_parent ? $comment->comment_parent : '';
  $spam_confirmed = $comment->comment_approved;
  if (($parent_id != '') && ($spam_confirmed != 'spam')) {
    $wp_email = 'rika-is-baka@' . preg_replace('#^www\.#', '', strtolower($_SERVER['SERVER_NAME'])); //e-mail 发出點, no-reply 可改為可用的 e-mail.
    $to = trim(get_comment($parent_id)->comment_author_email);
    $subject = '您在 [' . get_option("blogname") . '] 的留言有了回應';
    $message = '
    <div style="background-color:#eef2fa; border:1px solid #d8e3e8; color:#111; padding:0 15px; -moz-border-radius:5px; -webkit-border-radius:5px; -khtml-border-radius:5px;">
      <p>' . trim(get_comment($parent_id)->comment_author) . ', 您好!</p>
      <p>您曾在《' . get_the_title($comment->comment_post_ID) . '》的留言:<br />'
       . trim(get_comment($parent_id)->comment_content) . '</p>
      <p>' . trim($comment->comment_author) . ' 給您的回复:<br />'
       . trim($comment->comment_content) . '<br /></p>
      <p>您可以点击 <a href="' . htmlspecialchars(get_comment_link($parent_id)) . '">查看回复完整內容</a></p>
      <p>欢迎再度光临 <a href="' . get_option('home') . '">' . get_option('blogname') . '</a></p>
      <p>(此邮件由系统自动发送，请勿回复.)</p>
    </div>';
    $from = "From: \"" . get_option('blogname') . "\" <$wp_email>";
    $headers = "$from\nContent-Type: text/html; charset=" . get_option('blog_charset') . "\n";
    wp_mail( $to, $subject, $message, $headers );
    //echo 'mail to ', $to, '<br/> ' , $subject, $message; // for testing
  }
}
add_action('comment_post', 'comment_mail_notify');
// -- END ----------------------------------------
//adding category css support

/* wpbeginner_numeric_posts_nav  */
function wpbeginner_numeric_posts_nav() {

if( is_singular() )
return;

global $wp_query;

/** Stop execution if there's only 1 page */
if( $wp_query->max_num_pages <= 1 )
return;

$paged = get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ) : 1;
$max   = intval( $wp_query->max_num_pages );

/**	Add current page to the array */
if ( $paged >= 1 )
$links[] = $paged;

/**	Add the pages around the current page to the array */
if ( $paged >= 3 ) {
$links[] = $paged - 1;
$links[] = $paged - 2;
}

if ( ( $paged + 2 ) <= $max ) {
$links[] = $paged + 2;
$links[] = $paged + 1;
}

echo '<div class="navigation"><ul>' . "\n";

/**	Previous Post Link */
if ( get_previous_posts_link() )
printf( '<li>%s</li>' . "\n", get_previous_posts_link('<i class="fa-angle-left"></i>') );

/**	Link to first page, plus ellipses if necessary */
if ( ! in_array( 1, $links ) ) {
$class = 1 == $paged ? ' class="active"' : '';

printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( 1 ) ), '1' );

if ( ! in_array( 2, $links ) )
echo '<li>…</li>';
}

/**	Link to current page, plus 2 pages in either direction if necessary */
sort( $links );
foreach ( (array) $links as $link ) {
$class = $paged == $link ? ' class="active"' : '';
printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $link ) ), $link );
}

/**	Link to last page, plus ellipses if necessary */
if ( ! in_array( $max, $links ) ) {
if ( ! in_array( $max - 1, $links ) )
echo '<li>…</li>' . "\n";

$class = $paged == $max ? ' class="active"' : '';
printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $max ) ), $max );
}

/**	Next Post Link */
if ( get_next_posts_link() )
printf( '<li>%s</li>' . "\n", get_next_posts_link('<i class="fa-angle-right"></i>') );

echo '</ul></div>' . "\n";

}

/* Mini Pagenavi v1.0 by Willin Kan. */
function pagenavi( $p = 2 ) {if ( is_singular() ) return; global $wp_query, $paged;$max_page = $wp_query->max_num_pages;if ( $max_page == 1 ) return; if ( empty( $paged ) ) $paged = 1;echo '<span class="pagescout">Page: ' . $paged . ' of ' . $max_page . ' </span> '; if ( $paged > $p + 1 ) p_link( 1, '第 1 页' );if ( $paged > $p + 2 ) echo '<span class="page-numbers"> ... </span>';for( $i = $paged - $p; $i <= $paged + $p; $i++ ) { if ( $i > 0 && $i <= $max_page ) $i == $paged ? print "<span class='page-numbers current'>{$i}</span> " : p_link( $i );}if ( $paged < $max_page - $p - 1 ) echo '<span class="page-numbers"> ... </span>';if ( $paged < $max_page - $p ) p_link( $max_page, '最末页' );}
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
//自定义评论结构
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
			<div class="comment-content left">
				<div class="comment-name"><?php printf(__('%s'), get_comment_author_link()) ?></div>
                <div class="comment-entry"><?php comment_text() ?></div>
                <div class="comment-meta clearfix">
                    <div class="comment-date left"><?php comment_date('Y.m.j') ?> at <?php comment_time('H:i'); ?></div>
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
<?php }?>