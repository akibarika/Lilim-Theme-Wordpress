<?php get_header(); ?>
	<div class="container">
		<section id="post">
			<div class="pageload-overlay"></div>

			<?php if ( have_posts() ) :
				?>
				<div class="column--one column--post show--up"></div>
				<div class="column--two column--post show--up"></div>
				<div class="column--three column--post show--up"></div>
				<div class="column--none">
					<?php
					while ( have_posts() ) :
						the_post();
						?>

						<?php
						get_template_part( 'content' );
						?>

					<?php
					endwhile;
					?>
				</div>
			<?php
			else : ?>
				<article class="item i-404">
					<div class="wrap-content clearfix">
						<div class="not-found">
							<img src="<?php bloginfo( 'template_directory' ); ?>/images/404-not-found.jpg"/>
						</div>
					</div>
				</article>
			<?php endif; ?>
		</section>
		<?php wpbeginner_numeric_posts_nav(); ?>
	</div>
<?php get_footer(); ?>