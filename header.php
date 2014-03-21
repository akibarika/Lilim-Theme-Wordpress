<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title><?php if ( is_tag() ) { echo wp_title('Tag:');if($paged > 1) printf(' - 第%s页',$paged);echo ' | '; bloginfo( 'name' );} elseif ( is_archive() ) {echo wp_title('');  if($paged > 1) printf(' - 第%s页',$paged);    echo ' | ';    bloginfo( 'name' );} elseif ( is_search() ) {echo '&quot;'.wp_specialchars($s).'&quot;的搜索结果 | '; bloginfo( 'name' );} elseif ( is_home() ) {bloginfo( 'name' );$paged = get_query_var('paged'); if($paged > 1) printf(' - 第%s页',$paged);}  elseif ( is_404() ) {echo '页面不存在！ | '; bloginfo( 'name' );} else {echo wp_title( ' | ', false, right )  ; bloginfo( 'name' );} ?></title>
		<meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"> 
		<!--[if lt IE 9]>  
		    <script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>  
		<![endif]--> 		
		<meta name="description" content="这里是里香奇奇怪怪的部落格">
		<meta name="keywords" content="奥克兰,新西兰,动漫,秋庭里香,AkibaRika,扫图">
		<meta name="author" content="Rika Akiba">
		<script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
		<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/all.js"></script>
		<script src="<?php bloginfo('template_url'); ?>/comments-ajax.js" type="text/javascript"></script>
		<!-- style file -->
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
		<div id="menu-mobile">
			<span class="bt-menu">Menu</span>
			<div class="wrapper-menu">
				<ul class="menu right">
					<li>
						<a href="http://moe.akibarika.org/"><i class="fa-home fa-2x"></i><span>Home</span></a>
					</li>				
					<li>
						<a href="/about"><i class="fa-user fa-2x"></i><span>About</span></a>
					</li>
					<li>
						<a href="/links"><i class="fa-link fa-2x"></i><span>Links</span></a>
					</li>
					<li>
						<a href="/pixiv-daily-ranking/"><i class="fa-bookmark fa-2x"></i><span>Pixiv Ranking</span></a>
					</li>					
					<li>
						<a href="#"><i class="fa-comment fa-2x"></i><span>Contact</span></a>
					</li>
				</ul>
				<div class="search-text">
		            <span>SEARCH</span>
		            <?php get_search_form(); ?>
		        </div>
		        <li class="others dropdown">
	
		        </li>
			</div>

		</div>
		<header id="header">
			<nav class="top">
				<h1 class="hitokoto"><script src="http://api.hitokoto.us/rand?encode=js&charset=utf-8" ></script><script>hitokoto()</script></h1>
				<ul class="right">
					<li class="login">
						<?php
						if ( is_user_logged_in() ) {
							echo '御主人様お帰り';  
							?><a href="<?php echo $url = admin_url(); ?>" title="Admin">后宫</a><?php  
						} else {
						    echo 'お前、誰？';
						    ?><a href="<?php echo wp_login_url(); ?>" title="Login">Login</a><?php
						}
						?>	
					</li>			
					<li class="social">
						<a href="https://twitter.com/Akiba_Rika" target="_blank"><i class="fa-twitter fa-2x"></i></a>
						<a href="http://weibo.com/rikatan" target="_blank"><i class="fa-weibo fa-2x"></i></a>
						<a href="http://www.flickr.com/photos/akibarika/" target="_blank"><i class="fa-flickr fa-2x"></i></a>
						<a href="https://plus.google.com/u/0/103659577793041448146" target="_blank"><i class="fa-google-plus-square fa-2x"></i></a>
						<a href="http://instagram.com/akibarika" target="_blank"><i class="fa-instagram fa-2x"></i></a>
						<a href="https://foursquare.com/akiba_rika" target="_blank"><i class="fa-foursquare fa-2x"></i></a>						
					</li>
				</ul>
			</nav>
			<nav class="main">
		        <a id="logo" href="http://moe.akibarika.org">
					Akiba<span>Rika</span>
				</a>
				<ul class="menu right">
					<li>
						<a href="http://moe.akibarika.org/"><span>Home</span></a>
					</li>				
					<li>
						<a href="/about"><span>About</span></a>
					</li>
					<li>
						<a href="/links"><span>Links</span></a>
					</li>
					<li>
						<a href="/pixiv-daily-ranking/"><span>Pixiv Ranking</span></a>
					</li>	
					<li class="search">
			            <span class="bt-search"><i class="fa-search fa-2x"></i></span>
			        </li>			
				</ul>
			</nav>
			<nav class="search">
				<div class="right">
					<ul class="menu-2 menu-responsive">
						<li>
							<em>View By</em>
						</li>
						<li class="dropdown" data-filter="categories">
							<span>Category</span>
						</li>		
						<li class="dropdown" data-filter="tags">
							<span>Tag</span>
						</li>										
					</ul>
					<div class="search-text">
			            <?php get_search_form(); ?>
					</div>

				</div>
			</nav>
			<nav class="filters">
				<div class="inner">
					<div class="filter list-tags categories">
						<?php  wp_nav_menu( array( 'theme_location' => 'menu' ,'container'=>'','menu_id'=>'1st-menu') ); ?>
					</div>
					<div class="filter list-tags tags">
						<?php wp_tag_cloud('smallest=13&largest=13&number=50&format=list&unit=px');?>
					</div>
				</div>
			</nav>
		</header>