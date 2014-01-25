<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title><?php if ( is_tag() ) { echo wp_title('Tag:');if($paged > 1) printf(' - 第%s页',$paged);echo ' | '; bloginfo( 'name' );} elseif ( is_archive() ) {echo wp_title('');  if($paged > 1) printf(' - 第%s页',$paged);    echo ' | ';    bloginfo( 'name' );} elseif ( is_search() ) {echo '&quot;'.wp_specialchars($s).'&quot;的搜索结果 | '; bloginfo( 'name' );} elseif ( is_home() ) {bloginfo( 'name' );$paged = get_query_var('paged'); if($paged > 1) printf(' - 第%s页',$paged);}  elseif ( is_404() ) {echo '页面不存在！ | '; bloginfo( 'name' );} else {echo wp_title( ' | ', false, right )  ; bloginfo( 'name' );} ?></title>
		<meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"> 
<!--[if lt IE 9]>  
    <script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>  
<![endif]--> 		
		<meta name="description" content="<?php bloginfo('description'); ?>">
		<script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
		<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/all.js"></script>
		<script src="<?php bloginfo('template_url'); ?>/comments-ajax.js" type="text/javascript"></script>
<!-- 		style file -->
		<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/style.css">
		<link rel="stylesheet/less" type="text/css" href="<?php bloginfo('template_directory'); ?>/main_styling.less">
		<script src="<?php bloginfo('template_directory'); ?>/js/less.min.js" type="text/javascript"> </script>
		<script src="<?php bloginfo('template_directory'); ?>/js/masonry.min.js"></script>
		<script src="<?php bloginfo('template_directory'); ?>/js/imagesloaded.pkgd.min.js"></script>		
		<link href="<?php bloginfo('template_url'); ?>/css/font-awesome.css" rel="stylesheet">
		<link rel="Shortcut Icon" href="<?php bloginfo('template_url'); ?>/favicon.ico"> 
		<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?php bloginfo('rss2_url'); ?>" />
		<link rel="alternate" type="application/rss+xml" title="RSS 1.0" href="<?php bloginfo('rss_url'); ?>" />
		<link rel="alternate" type="application/atom+xml" title="ATOM 1.0" href="<?php bloginfo('atom_url'); ?>" />
		
		<?php wp_head(); ?> 
	</head>
	<body>
		<header class="transition">
			<a id="logo" href="http://moe.akibarika.org">
				Akiba
				<span>Rika</span>
			</a>
			<nav id="header-cate" class="transition">
				<ul>
					<li><a href="https://twitter.com/Akiba_Rika" target="_blank"><i class="fa-twitter fa-3x"></i></a></li>
					<li><a href="http://weibo.com/rikatan" target="_blank"><i class="fa-weibo fa-3x"></i></a></li>
					<li><a href="http://www.flickr.com/photos/akibarika/" target="_blank"><i class="fa-flickr fa-3x"></i></a></li>
					<li><a href="https://plus.google.com/u/0/103659577793041448146" target="_blank"><i class="fa-google-plus-square fa-3x"></i></a></li>
					<li><a href="http://instagram.com/akibarika" target="_blank"><i class="fa-instagram fa-3x"></i></a></li>
					<li><a href="https://foursquare.com/akiba_rika" target="_blank"><i class="fa-foursquare fa-3x"></i></a></li>
				</ul>	
			</nav>
		</header>
		<nav id="menu" class="clearfix transition">
			<a id="more" class="left"><i class="fa-bars fa-2x"></i> Page</a>
			<?php  wp_nav_menu( array( 'theme_location' => 'menu' ,'container'=>'','menu_id'=>'1st-menu') ); ?>
			<div id="search">
				<?php get_search_form(); ?>
			</div>			
		</nav>
		<nav id="fixed_menu" class="clearfix transition none">
			<a id="more_more" class="left"><i class="fa-bars fa-2x"></i> Page</a>
			<?php  wp_nav_menu( array( 'theme_location' => 'menu' ,'container'=>'','menu_id'=>'2nd-menu') ); ?>
			<a id="tool" class="right"><i class="fa-gears fa-2x"></i> Tool</a>		
		</nav>	
		<section id="content" class="clearfix">
			<aside id="left-sidebar">
				<ul>
					<li>
						<a href="http://moe.akibarika.org/"><i class="fa-home fa-2x"></i><span>Home</span></a>
					</li>				
					<li>
						<a href="http://moe.akibarika.org/about"><i class="fa-user fa-2x"></i><span>About</span></a>
					</li>
					<li>
						<a href="http://moe.akibarika.org/links"><i class="fa-link fa-2x"></i><span>Links</span></a>
					</li>
					<li>
						<a href="#"><i class="fa-comment fa-2x"></i><span>Contact</span></a>
					</li>
				</ul>
			</aside>
			<aside id="right-sidebar">
				<div id="mini-search">
					<form method="get" action="<?php bloginfo ('url');?>" role="search">
						<input placeholder="//search" type="text" name="s" id="mini-s" class="text"  x-webkit-speech />
					</form>
				</div>		