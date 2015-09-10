<?php /* 
	  	Template Name: Links(友情链接) 
	  */ ?>
<?php get_header(); ?>
	<div id="page-wrap">
		<div class="bookmarks">
			<?php
			echo get_link_items();
			?>
		</div>
	</div>
<?php get_footer(); ?>