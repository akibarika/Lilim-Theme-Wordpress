<?php

function lilim_css_url( $css_url ) {
	return LILIM_URL . "/css/{$css_url}.css";
}

function lilim_js_url( $js_url ) {
	return LILIM_URL . "/js/{$js_url}.js";
}

// 中文截断文字
function cut_str( $string, $sublen, $start = 0, $code = 'UTF-8' ) {
	if ( $code == 'UTF-8' ) {
		$pa = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|\xe0[\xa0-\xbf][\x80-\xbf]|[\xe1-\xef][\x80-\xbf][\x80-\xbf]|\xf0[\x90-\xbf][\x80-\xbf][\x80-\xbf]|[\xf1-\xf7][\x80-\xbf][\x80-\xbf][\x80-\xbf]/";
		preg_match_all( $pa, $string, $t_string );
		if ( count( $t_string[0] ) - $start > $sublen ) {
			return join( '', array_slice( $t_string[0], $start, $sublen ) ) . "...";
		}

		return join( '', array_slice( $t_string[0], $start, $sublen ) );
	}
	else {
		$start  = $start * 2;
		$sublen = $sublen * 2;
		$strlen = strlen( $string );
		$tmpstr = '';
		for ( $i = 0; $i < $strlen; $i ++ ) {
			if ( $i >= $start && $i < ( $start + $sublen ) ) {
				if ( ord( substr( $string, $i, 1 ) ) > 129 ) {
					$tmpstr .= substr( $string, $i, 2 );
				}
				else {
					$tmpstr .= substr( $string, $i, 1 );
				}
			}
			if ( ord( substr( $string, $i, 1 ) ) > 129 ) {
				$i ++;
			}
		}
		if ( strlen( $tmpstr ) < $strlen ) {
			$tmpstr .= "...";
		}

		return $tmpstr;
	}
}

//邮件提醒
/* comment_mail_notify v1.0 by willin kan. (所有回复都发邮件) */
function comment_mail_notify( $comment_id ) {
	$comment        = get_comment( $comment_id );
	$parent_id      = $comment->comment_parent ? $comment->comment_parent : '';
	$spam_confirmed = $comment->comment_approved;
	if ( ( $parent_id != '' ) && ( $spam_confirmed != 'spam' ) ) {
		$wp_email = 'rika-is-baka@akibarika.org';
		$to       = trim( get_comment( $parent_id )->comment_author_email );
		$subject  = '您在 [' . get_option( "blogname" ) . '] 的留言有了回應';
		$message  = '
    <div style="background-color:#eef2fa; border:1px solid #d8e3e8; color:#111; padding:0 15px; -moz-border-radius:5px; -webkit-border-radius:5px; -khtml-border-radius:5px;">
      <p>' . trim( get_comment( $parent_id )->comment_author ) . ', 您好!</p>
      <p>您曾在《' . get_the_title( $comment->comment_post_ID ) . '》的留言:<br />'
		            . trim( get_comment( $parent_id )->comment_content ) . '</p>
      <p>' . trim( $comment->comment_author ) . ' 給您的回复:<br />'
		            . trim( $comment->comment_content ) . '<br /></p>
      <p>您可以点击 <a href="' . htmlspecialchars( get_comment_link( $parent_id ) ) . '">查看回复完整內容</a></p>
      <p>欢迎再度光临 <a href="' . get_option( 'home' ) . '">' . get_option( 'blogname' ) . '</a></p>
      <p>(此邮件由系统自动发送，请勿回复.)</p>
    </div>';
		$from     = "From: \"" . get_option( 'blogname' ) . "\" <$wp_email>";
		$headers  = "$from\nContent-Type: text/html; charset=" . get_option( 'blog_charset' ) . "\n";
		wp_mail( $to, $subject, $message, $headers );
	}
}

add_action( 'comment_post', 'comment_mail_notify' );
// -- END ----------------------------------------

//Scripts
function lilim_scripts_styles() {
	wp_enqueue_script( 'lilim_vendor', lilim_js_url( 'vendor' ), array(), LILIM_VERSION, true );
	wp_enqueue_script( 'lilim', lilim_js_url( 'app' ), array(), LILIM_VERSION, true );
	if ( is_single() ) {
		wp_enqueue_script( 'lilim_post', lilim_js_url( 'post' ), array(), LILIM_VERSION, true );
	}
	wp_localize_script( 'lilim', 'lilimajax', array(
		'ajax_url'   => admin_url('admin-ajax.php'),
		'jplayerurl' => lilim_js_url( 'jquery.jplayer.min' ),
		'nonce'      => wp_create_nonce( 'akibarika' )
	) );

	wp_enqueue_script( 'lilim_comment', lilim_js_url( 'comment' ), array(), LILIM_VERSION, true );
    wp_localize_script( 'lilim_comment', 'ajaxcomment', array(
        'ajax_url'   => admin_url('admin-ajax.php')
    ) );
}

add_action( 'wp_enqueue_scripts', 'lilim_scripts_styles');




function lilim( $e ) {
	$option = get_option( 'lilim_config' );
	if ( ! empty( $option[ $e ] ) ) {
		return $option[ $e ];
	}

	return false;
}

//Adding Description to head
function lilim_description() {
	global $s, $post, $wp_query;
	$description = '';
	$blog_name   = get_bloginfo( 'name' );
	if ( is_singular() ) {
		$ID          = $post->ID;
		$title       = $post->post_title;
		$author      = $post->post_author;
		$user_info   = get_userdata( $author );
		$post_author = $user_info->display_name;
		if ( ! get_post_meta( $ID, "meta-description", true ) ) {
			$description = $title . ' - 作者: ' . $post_author . ',首发于' . $blog_name;
		}
		else {
			$description = get_post_meta( $ID, "meta-description", true );
		}
	}
	elseif ( is_home() ) {
		$description = lilim( 'description' );
	}
	elseif ( is_tag() ) {
		$description = single_tag_title( '', false ) . " - " . trim( strip_tags( tag_description() ) );
	}
	elseif ( is_category() ) {
		$description = single_cat_title( '', false ) . " - " . trim( strip_tags( category_description() ) );
	}
	elseif ( is_archive() ) {
		$description = $blog_name . "'" . trim( wp_title( '', false ) ) . "'";
	}
	elseif ( is_search() ) {
		$description = $blog_name . ": '" . esc_html( $s, 1 ) . "' 的搜索結果";
	}
	else {
		$description = $blog_name . "'" . trim( wp_title( '', false ) ) . "'";
	}
	$description = mb_substr( $description, 0, 220, 'utf-8' );
	echo "<meta name=\"description\" content=\"$description\">\n";
}

add_action( 'wp_head', 'lilim_description', 1 );

//Adding title display function
function lilim_wp_title( $title, $sep ) {
	global $paged, $page;
	if ( is_feed() ) {
		return $title;
	}
	$title .= get_bloginfo( 'name', 'display' );
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) ) {
		$title = "$title $sep $site_description";
	}
	if ( $paged >= 2 || $page >= 2 ) {
		$title = "$title $sep " . sprintf( __( 'Page %s', 'lilim' ), max( $paged, $page ) );
	}

	return $title;
}

add_filter( 'wp_title', 'lilim_wp_title', 10, 2 );

//Insert Images within Figure Element
function html5_insert_image( $html, $id, $caption, $title, $align, $url, $size, $alt ) {
	$image_tag = get_image_tag( $id, '', $title, $align, $size );
	$linkptrn  = "/<a[^>]*>/";
	$found     = preg_match( $linkptrn, $html, $a_elem );
	if ( $found > 0 ) {
		$a_elem = $a_elem[0];

		if ( strstr( $a_elem, "class=\"" ) !== false ) { // If link already has class defined inject it to attribute
			$a_elem = str_replace( "class=\"", "class=\"colorbox ", $a_elem );
		}
		else { // If no class defined, just add class attribute
			$a_elem = str_replace( "<a ", "<a class=\"colorbox\" ", $a_elem );
		}
	}
	else {
		$a_elem = "";
	}
	$attributes = ( ! empty( $id ) ? ' id="attachment_' . esc_attr( $id ) . '"' : '' );
	$attributes .= ' class="thumbnail wp-caption ' . 'align' . esc_attr( $align ) . '"';
	$output = '<figure' . $attributes . '>';
	$output .= $a_elem;
	$output .= $image_tag;

	if ( $a_elem != "" ) {
		$output .= '</a>';
	}
	if ( $caption ) {
		$output .= '<figcaption class="caption wp-caption-text">' . $caption . '</figcaption>';
	}
	$output .= '</figure>';

	return $output;
}

add_filter( 'image_send_to_editor', 'html5_insert_image', 10, 9 );
add_filter( 'disable_captions', create_function( '$a', 'return true;' ) );

add_filter( 'nav_menu_link_attributes', 'my_nav_menu_attribs', 10, 3 );
function my_nav_menu_attribs( $atts, $item, $args ) {
	// The ID of the target menu item
	$menu_targets = array( 258, 257, 256, 254, 255 );

	// inspect $item
	foreach ( $menu_targets as $menu_target ) {
		if ( $item->ID == $menu_target ) {
			$atts['data-content'] = strip_tags($item->title);
		}
	}
	return $atts;
}


