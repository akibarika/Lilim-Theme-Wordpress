<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title><?php wp_title('|', true, 'right'); ?></title>
    <meta name="viewport"
          content="width=device-width, height=device-height, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
    <!--[if lt IE 9]>
    <script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
    <![endif]-->
    <meta name="author" content="Rika Akiba">
    <link rel="profile" href="http://gmpg.org/xfn/11"/>
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>"/>
    <!-- style file -->
    <link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/style.css">
    <link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/css/styles.css">
    <link rel="Shortcut Icon" href="<?php bloginfo('template_directory'); ?>/favicon.ico">
    <?php wp_head(); ?>
</head>
<body>
<div style="height: 0; width: 0; position: absolute; visibility: hidden">
    <?php echo file_get_contents(get_template_directory() . '/images/svg.svg'); ?>
</div>
<div class="wrapper">
    <nav class="nav-main">
        <div class="nav-main__top">
            <div class="nav-main__header">
                <div class="pull-right">
                    <div class="bt-close js-nav-main">CLOSE</div>
                </div>
            </div>
            <?php wp_nav_menu(array(
                'theme_location' => 'page-menu',
                'container' => '',
                'menu_class' => 'nav-main__menu'
            )); ?>
        </div>
        <div class="nav-main__bottom"></div>
    </nav>
    <header class="header">
        <div class="header__left">
            <div class="header__item header__menu js-nav-main">
                <svg class="icon icon-dehaze">
                    <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#dehaze"></use>
                </svg>
                <span>menu</span>
            </div>
        </div>
        <div class="header__right">
            <div class="header__item header__item--search js-search">
                <svg class="icon icon-magnifying-glass">
                    <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#magnifying-glass"></use>
                </svg>
                <span class="text">Looking for Something?</span>
            </div>
            <div class="header__item header__item--login">
                <?php
                if (is_user_logged_in()) {
                    ?><a href="<?php echo $url = admin_url(); ?>" title="Admin"><span>Harem</span></a><?php
                } else {
                    ?><a href="<?php echo wp_login_url(); ?>" title="Login"><span>Entrance</span></a><?php
                }
                ?>
                <div class="header__item--login__wrapper">
                    <svg class="icon icon-dashboard">
                        <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#dashboard"></use>
                    </svg>
                </div>
            </div>
        </div>
        <div class="header__logo">
            <a id="logo" href="<?php echo home_url() ?>">
                <?php if (is_home()): ?>
                    <h1>Akiba<span>Rika</span></h1>
                <?php else: ?>
                    Akiba<span>Rika</span>
                <?php endif ?>
            </a>
        </div>
        <div class="header__search">
            <div class="header__search__left">
                <?php get_search_form() ?>
            </div>
            <div class="header__search__right">
                <div class="header__search__close bt-close js-search-close"></div>
            </div>
        </div>
    </header>