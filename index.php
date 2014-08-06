<?php get_header(); ?>			
			<section id="post">
				<?php if (have_posts()) : 
				while (have_posts()) : 
					the_post();
                    get_template_part('content');
				endwhile;else : ?>
				<article class="item i-404">
					<div class="wrap-content clearfix">
						<div class="not-found">
							<img src="<?php bloginfo('template_directory'); ?>/images/404-not-found.jpg" />
						</div>
					</div>
				</article> 
				<?php endif; ?>  
			</section>
			<?php wpbeginner_numeric_posts_nav(); ?>
<?php get_footer(); ?>