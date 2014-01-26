<?php get_header(); ?>		
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