<?php get_header(); ?>		
    <div id="page-wrap">
        <div class="right-toolbar">
            <span class="tooltip-left" data-tooltip="分享"><div class="tool-icon icon-share"></div></span>
            <span class="tooltip-left" data-tooltip="滚动"><div class="tool-icon tool-goto tool-down icon-angle-down"></div></span>
        </div>
        <section id="single" class="wrap-single page">
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
                    <div class="meta">
                        <span><i class="icon-cc"></i> This work is licensed under a <a class="cc" href="http://creativecommons.org/licenses/by-nc-sa/4.0/" target="_blank">cc by-nc-sa 4.0</a>. </span>
                    </div>
                </div>
	            <?php get_template_part( 'share' ); ?>
            </article>
            <?php comments_template(); ?>
            <?php endwhile; ?>
        </section>
    </div>
<?php get_footer(); ?>