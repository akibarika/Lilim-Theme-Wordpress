<?php get_header(); ?>	
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