<?php get_header(); ?>	
				<ul>
					<li><?php next_post_link('%link','<i class="fa-chevron-right fa-3x"></i><span class="pagenav">下一篇</span>',TRUE); ?></li>
					<li><?php previous_post_link('%link','<i class="fa-chevron-left fa-3x"></i><span class="pagenav">上一篇</span>',TRUE); ?></li>
				</ul>	
				<ul>
					<li><a href="#"><i class="fa-archive fa-3x"></i><span>Archive</span></a></li>
					<li><a href="http://moe.akibarika.org/wp-admin/"><i class="fa-dashboard fa-3x"></i><span>Backyard</span></a></li>
					<li><a class="closer"><i class="fa-remove-sign"></i> Close</a></li>					
				</ul>								
			</aside>	
			<div id="page-wrap">		
				<div class="right-toolbar">
					<div class="tool-icon tool-up fa-angle-up fa-3x">
						
					</div>
					<div class="tool-icon tool-comment fa-comment-o fa-3x">
						
					</div>
					<div class="tool-icon tool-down fa-angle-down fa-3x">
					</div>
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
								<span><i class="fa-folder-open"></i> <?php the_category('、') ?></span>
							</div>
							<div class="meta">
								<span><i class="fa-tags"></i> <?php the_tags((' '), ', '); ?></span>
							</div>
							<div class="meta">
							</div>
						</div>
					</article>
					<?php comments_template(); ?>
					<?php endwhile; ?>
				</section>
			</div>
			
      
<?php get_footer(); ?>