<?php get_header(); ?>
    <div class="container">
        <section id="post" class="grid--view">
            <div class="pageload-overlay show"></div>
            <?php if (have_posts()) :
                ?>
                <div class="column--one column--post show--up"></div>
                <div class="column--two column--post show--up"></div>
                <div class="column--three column--post show--up"></div>
                <div class="column--invisible">
                    <?php
                    while (have_posts()) :
                        the_post();
                        get_template_part('content');
                    endwhile;
                    ?>
                </div>
                <?php
            else : ?>
                <article class="item i-404">
                    <div class="wrap-content clearfix">
                        <div class="not-found">
                            <img src="<?php bloginfo('template_directory'); ?>/images/404-not-found.jpg"/>
                        </div>
                    </div>
                </article>
            <?php endif; ?>
            <div class="load-more">
                <button class="button button--load-more">Load More</button>
                <button class="button button--loading" style="display: none">Loading</button>
            </div>
        </section>
    </div>
<?php get_footer(); ?>