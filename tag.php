<?php
/**
 * Created by PhpStorm.
 * User: Akiba
 * Date: 14-8-2
 * Time: 下午9:28
 * A Tag Template
 */
get_header(); ?>
	<div class="container">
		<section id="post">
			<div class="pageload-overlay"></div>
			<div class="column--one column--post show--up"></div>
			<div class="column--two column--post show--up"></div>
			<div class="column--three column--post show--up"></div>
			<div class="column--none">
				<article id="tag-" class="item show-up kanban hiding--post">
					<div class="in-tag">
						<h2>Tag:<span> <?php single_tag_title(); ?></span></h2>
						<?php echo tag_description( $tag_id ); ?>
					</div>
				</article>
				<?php if ( have_posts() ) :
					while ( have_posts() ) :
						the_post();
						get_template_part( 'content' );
					endwhile;
				endif; ?>
			</div>
		</section>
		<?php wpbeginner_numeric_posts_nav(); ?>
	</div>

<?php get_footer(); ?>