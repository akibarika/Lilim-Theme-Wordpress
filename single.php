<?php get_header(); ?>	
			<div id="page-wrap">		
				<div class="right-toolbar">
					<span class="hint--left" data-hint="分享"><div class="tool-icon icon-share"></div></span>
					<span class="hint--left" data-hint="回复"><div class="tool-icon icon-bubbles"></div></span>
					<span class="hint--left" data-hint="滚动"><div class="tool-icon tool-goto tool-down icon-angle-down"></div></span>
				</div>
				<section id="single" class="wrap-single">
					<?php while ( have_posts() ) : the_post(); ?>
					<article class="single-post">
						<h1 class="ribbon">
							<strong class="ribbon-content"><?php the_title(); ?></strong>
						</h1>
						<time class="post-time">
							<?php the_time('F j, Y') ?>
						</time>
						<div class="post-detail">
							<?php the_content(); ?>
						</div>
						<div class="single-meta">
							<div class="category">
								<span><i class="icon-folder-open"></i> <?php the_category('、') ?></span>
							</div>
							<div class="meta">
								<span><i class="icon-tags"></i> <?php the_tags((' '), ', '); ?></span>
							</div>
							<div class="meta">
                                <span><i class="icon-info"></i> This work is licensed under a <a class="cc" href="http://creativecommons.org/licenses/by-nc-sa/4.0/" target="_blank">cc by-nc-sa 4.0</a>. </span>
							</div>
						</div>
						<?php echo wp_sns_share();?>
					</article>
					<?php comments_template(); ?>
					<?php endwhile; ?>
				</section>
			</div>
			
      
<?php get_footer(); ?>