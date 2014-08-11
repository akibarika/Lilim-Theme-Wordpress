<?php /* 
	  	Template Name: Links(友情链接) 
	  */ ?>
<?php get_header(); ?>		
    <div id="page-wrap">
        <?php while ( have_posts() ) : the_post(); ?>
        <div class="bookmarks">
            <?php
                $bookmarks = get_bookmarks('title_li=&orderby=rand'); //全部链接随机输出
                if ( !empty($bookmarks) ) {
                    foreach ($bookmarks as $bookmark) {
                        echo '<a href="' , $bookmark->link_url , '" title="' , $bookmark->link_description ,'" target="_blank">' , $bookmark->link_name , '</a>';
                        }
                    }
            ?>
        </div>
        <?php endwhile; ?>
    </div>
<?php get_footer(); ?>