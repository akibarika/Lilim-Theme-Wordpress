<?php /* 
	  	Template Name: Music(音乐电台)
	  */ ?>
<?php get_header(); ?>		
    <div id="page-wrap">
        <?php while ( have_posts() ) : the_post(); ?>
        <div class="page-music">
	        <input class="js-search-input" placeholder="搜索虾米音乐"><div class="js-search-results"></div>
        </div>
        <?php endwhile; ?>
    </div>
<?php get_footer(); ?>