<?php get_header(); ?>		
			<div id="page-wrap">	
				<div class="right-toolbar">
					<span class="hint--left" data-hint="分享"><div class="tool-icon fa-share-alt fa-3x"></div></span>
					<span class="hint--left" data-hint="滚动"><div class="tool-icon tool-goto tool-down fa-angle-down fa-3x"></div></span>
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
					</article>
					<?php comments_template(); ?>
					<?php endwhile; ?>
				</section>
			</div>  
<?php get_footer(); ?>