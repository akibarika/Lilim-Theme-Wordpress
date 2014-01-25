<?php get_header(); ?>		
				<ul>
					<li><a href="#"><i class="icon-archive icon-3x"></i><span>Archive</span></a></li>
					<li><a href="http://moe.akibarika.org/wp-admin/"><i class="icon-dashboard icon-3x"></i><span>Backyard</span></a></li>
					<li><a class="closer"><i class="icon-remove-sign"></i> Close</a></li>					
				</ul>								
			</aside>	
			<div id="page-wrap">		
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
					</article>
					<?php comments_template(); ?>
					<?php endwhile; ?>
				</section>
			</div>  
<?php get_footer(); ?>