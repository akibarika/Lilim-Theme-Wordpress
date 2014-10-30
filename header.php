<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title><?php wp_title( '|', true, 'right' ); ?></title>
		<meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"> 
		<!--[if lt IE 9]>  
		    <script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>  
		<![endif]-->
		<meta name="author" content="Rika Akiba">
        <link rel="profile" href="http://gmpg.org/xfn/11" />
        <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
		<!-- style file -->
		<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/style.css">
		<link rel="stylesheet/less" type="text/css" href="<?php bloginfo('template_directory'); ?>/css/styles.less">
        <script src="<?php bloginfo('template_directory'); ?>/js/less.min.js?ver=2.0.0" type="text/javascript"></script>
		<link rel="Shortcut Icon" href="<?php bloginfo('template_directory'); ?>/favicon.ico">
		<?php wp_head(); ?> 
	</head>
	<body>
		<section id="menu-mobile">
			<span class="bt-menu">Menu</span>
			<div class="wrapper-menu">
                <?php  wp_nav_menu( array( 'theme_location' => 'page-menu' ,'container'=>'','menu_class'=>'menu right') ); ?>
				<div class="search-text">
		            <span>SEARCH</span>
		            <?php get_search_form(); ?>
		        </div>
		        <li class="others dropdown">
		        </li>
			</div>
		</section>
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
						<a href="https://twitter.com/Akiba_Rika" target="_blank"><i class="icon-twitter"></i></a>
						<a href="http://weibo.com/rikatan" target="_blank"><i class="icon-weibo"></i></a>
						<a href="http://www.flickr.com/photos/akibarika/" target="_blank"><i class="icon-flickr"></i></a>
						<a href="https://plus.google.com/u/0/103659577793041448146" target="_blank"><i class="icon-googleplus"></i></a>
						<a href="http://instagram.com/akibarika" target="_blank"><i class="icon-instagram"></i></a>
						<a href="https://foursquare.com/akiba_rika" target="_blank"><i class="icon-foursquare"></i></a>
					</li>
				</ul>
			</nav>
			<nav class="main">
		        <a id="logo" href="http://moe.akibarika.org">
					Akiba<span>Rika</span>
				</a>
                <?php  wp_nav_menu( array( 'theme_location' => 'page-menu' ,'container'=>'','menu_class'=>'menu right','items_wrap' => '<ul id="%1$s" class="%2$s">%3$s<li class="search"><span class="bt-search"><i class="icon-search"></i></span></li></ul>') ); ?>
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
						<?php  wp_nav_menu( array( 'theme_location' => 'cat-menu' ,'container'=>'') ); ?>
					</div>
					<div class="filter list-tags tags">
						<?php wp_tag_cloud('smallest=13&largest=13&number=50&format=list&unit=px');?>
					</div>
				</div>
			</nav>
		</header>