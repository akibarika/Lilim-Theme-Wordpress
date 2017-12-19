<?php get_header(); ?>
	<div id="page-wrap">
		<div class="right-toolbar">
			<span class="tooltip-left" data-tooltip="分享">
				<svg class="icon tool-icon icon-bubble_chart">
					<use xlink:href="#bubble_chart"></use>
				</svg>
			</span>
			<span class="tooltip-left" data-tooltip="回复">
				<svg class="icon tool-icon icon-question_answer">
					<use xlink:href="#question_answer"></use>
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
		<section id="single" class="wrap-single">
			<?php while ( have_posts() ) : the_post(); ?>
				<article class="single-post">
					<h1 class="ribbon">
						<strong class="ribbon-content"><?php the_title(); ?></strong>
					</h1>
					<time class="post-time">
						<?php the_time( 'F j, Y' ) ?>
					</time>
					<div class="post-detail">
						<?php the_content(); ?>
					</div>
					<div class="single-meta">
						<div class="category">
							<span><svg class="icon icon-folder_open"><use
										xlink:href="#folder_open"></use></svg> <?php the_category( '、' ) ?></span>
						</div>
						<div class="meta">
							<span><svg class="icon icon-local_offer"><use
										xlink:href="#local_offer"></use></svg> <?php the_tags( ( ' ' ), ', ' ); ?></span>
						</div>
						<div class="meta">
							<span><svg class="icon icon-closed_caption"><use xlink:href="#closed_caption"></use></svg> This work is licensed under a <a
									class="cc"
									href="http://creativecommons.org/licenses/by-nc-sa/4.0/"
									target="_blank">cc by-nc-sa
									4.0</a>. </span>
						</div>
					</div>
<!--					--><?php //get_template_part( 'share' ); ?>
				</article>
				<?php comments_template(); ?>
			<?php endwhile; ?>
		</section>
	</div>


<?php get_footer(); ?>