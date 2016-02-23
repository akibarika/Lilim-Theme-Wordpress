<?php
//$nmjson = new nmjson();
//
//function netease_music() {
//	echo netease_music_output();
//}
//
//function netease_music_output() {
//	$max_page = get_netease_max_page();
//	$output   = get_netease_music();
//	$output .= '<div class="music-page-navi">';
//
//	if ( $max_page > 1 ) {
//		$output .= '<a class="nm-loadmore" data-paged="2" data-max="' . $max_page . '" href="javascript:;">加载更多音乐</a>';
//	}
//
//	return $output;
//}
//
//function get_netease_music( $paged = null ) {
//	$index    = 0;
//	$userid   = nm_get_setting( 'id' ) ? nm_get_setting( 'id' ) : 30829298;
//	$row      = nm_get_setting( 'number' ) ? nm_get_setting( 'number' ) : 4;
//	$contents = nmjson::get_instance()->netease_user( $userid );
//	array_shift( $contents );
//	$per_page = nm_get_setting( 'perpage' ) ? nm_get_setting( 'perpage' ) : 16;
//	$count    = count( $contents );
//	$max_page = ceil( $count / $per_page );
//	$paged    = $paged ? $paged : 1;
//	$contents = array_slice( $contents, ( ( $paged - 1 ) * $per_page ), $per_page );
//	$is_small = nm_get_setting( 'small' );
//	$size     = 500;
//	$output   = '<div class="album-list">';
//	foreach ( $contents as $content ) {
//		$index ++;
//		$output .= '<div class="album--nice" data-type="163collect" data-thumbnail="' . $content['playlist_coverImgUrl'] . '" data-id="' . $content['playlist_id'] . '"  data-tooltip="' . $content['playlist_name'] . '"><img src="' . $content['playlist_coverImgUrl'] . '?param=' . $size . 'y' . $size . '">
//<i class="fxfont"></i><span class="music-info">' . $content['playlist_name'] . '</span>
//</div>';
//
//		if ( $index % $row == 0 && $index < $per_page ) {
//			$output .= '</div><div class="album-list">';
//		}
//	}
//	$output .= '</div>';
//
//	return $output;
//
//}