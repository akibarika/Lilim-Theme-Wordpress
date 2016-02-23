<?php /* 
	  	Template Name: Music(音乐电台)
	  */ ?>
<?php get_header(); ?>
	<div id="page-wrap">
		<div class="right-toolbar">
			<span class="tooltip-left" data-tooltip="分享"><i class="tool-icon icon-share"></i></span>
			<span class="tooltip-left" data-tooltip="滚动"><i
					class="tool-icon tool-goto tool-down icon-angle-down"></i></span>
		</div>
		<?php while ( have_posts() ) : the_post(); ?>
			<section id="single" class="music-wrapper page">
				<article id="netease-music-content">
					<h1 class="ribbon">
						<strong class="ribbon-content"><?php echo _e( 'My Music' ); ?></strong>
					</h1>
					<input class="js-search-input" placeholder="搜索虾米音乐">
					<div class="js-search-results"></div>
					<?php netease_music(); ?>
				</article>
			</section>

		<?php endwhile; ?>
	</div>
<?php get_footer(); ?>