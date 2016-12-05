<?php

function fa_converse_webp_filter( $content ) {
	global $post;
	if ( preg_match_all( '/\ src=\"([^\"]+)\.(png|jpg|jpeg)/i', $content, $matches ) == false ) {
		return $this;
	}
	$imageList = array();
	foreach ( $matches[0] as $index => $match ) {

		// Convert the URL to a valid path
		$imageUrl = $matches[1][ $index ] . '.' . $matches[2][ $index ];
		$webpUrl  = convertImageUrlToWebp( $imageUrl );
		$content  = str_replace( $imageUrl, $webpUrl, $content );
	}


	return $content;
}

function convertImageUrlToWebp( $imageUrl ) {
	$imagePath = getImagePathFromUrl( $imageUrl );
	$webpPath  = convertToWebp( $imagePath );
	$webpUrl   = getImageUrlFromPath( $webpPath );

	return $webpUrl;
}

function convertToWebp( $imagePath ) {
	$webpPath = preg_replace( '/\.(png|jpg|jpeg)$/i', '.webp', $imagePath );
	$cwebp    = '/usr/local/bin/cwebp';
	$cmd      = $cwebp . '  -quiet ' . $imagePath . ' -o ' . $webpPath;
	exec( $cmd, $output, $return );

	return $webpPath;
}

function convertToWebpViaBinary( $imagePath, $webpPath ) {
	if ( $this->hasBinarySupport() == false ) {
		return false;
	}

	$cwebp = $this->getCwebpBinary();
	$cmd   = $cwebp . '  -quiet ' . $imagePath . ' -o ' . $webpPath;
	exec( $cmd, $output, $return );

	return $webpPath;
}

function getImagePathFromUrl( $imageUrl ) {
	$systemPath = getcwd();

	if ( preg_match( '/^http/', $imageUrl ) ) {
		if ( strstr( $imageUrl, get_home_url() ) ) {
			return str_replace( get_home_url(), $systemPath, $imageUrl );
		}
	}
}

function getImageUrlFromPath( $imagePath ) {
	$systemPath = getcwd();
	if ( strstr( $imagePath, $systemPath ) ) {
		return str_replace( $systemPath, get_home_url(), $imagePath );
	}
}

function rika_is_support_webp() {
	return strstr( $_SERVER['HTTP_ACCEPT'], 'image/webp' );
}

if ( rika_is_support_webp() ) {
	add_filter( 'the_content', 'fa_converse_webp_filter' );
}