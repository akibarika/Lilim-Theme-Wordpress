<?php /* 
	  	Template Name: Pixiv (P站排名) 
	  */ ?>
<?php get_header(); ?>
<div id="page-wrap">
	<div class="right-toolbar">
		<span class="tooltip-left" data-tooltip="分享">
			<svg class="icon tool-icon icon-bubble_chart">
				<use xlink:href="#bubble_chart"></use>
			</svg>
		</span>
		<span class="tooltip-left tooltip-goto" data-tooltip="滚动">
			<svg class="icon tool-icon icon-vertical_align_bottom">
				<use xlink:href="#vertical_align_bottom"></use>
			</svg>
			<svg class="icon tool-icon icon-vertical_align_top">
				<use xlink:href="#vertical_align_top"></use>
			</svg>
		</span>
	</div>
	<section id="single" class="pixiv-wrapper page">
		<div id="pixiv">
			<?php
			$rss = simplexml_load_file( 'http://feed43.com/pixiv_daily.xml' );
			?>
			<h1 class="ribbon">
				<strong class="ribbon-content"><?php echo $rss->channel->title; ?></strong>
			</h1>
			<time class="post-time">
				<?php echo $rss->channel->lastBuildDate; ?>
			</time>
			<?php
			$i = 0;
			foreach ( $rss->channel->item as $chan ) {
				if ( $i == 50 ) {
					break;
				}
				else {
					$i ++;
					echo "<section id=\"rank-" . $i . "\" class=\"rank-item\" >";
					echo $chan->description;
					echo "</section>";
				}
			}
			?>
<!--			--><?php //get_template_part( 'share' ); ?>
		</div>
	</section>
</div>

<?php get_footer(); ?>		
