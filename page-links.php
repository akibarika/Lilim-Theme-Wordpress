<?php /* 
	  	Template Name: Links(友情链接) 
	  */ ?>
<?php get_header(); ?>
				<ul>
					<li><a href="#"><i class="icon-archive icon-3x"></i><span>Archive</span></a></li>
					<li><a href="http://moe.akibarika.org/wp-admin/"><i class="icon-dashboard icon-3x"></i><span>Backyard</span></a></li>
					<li><a class="closer"><i class="icon-remove-sign"></i> Close</a></li>				
				</ul>								
			</aside>			
			<div id="page-wrap">
					<?php while ( have_posts() ) : the_post(); ?>
					<div class="bookmarks">
							<?php
/* 									$default_ico = get_template_directory_uri().'/images/links_default.png'; //默认 ico 图片位置 */
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