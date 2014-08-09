<?php
/**
 * Created by PhpStorm.
 * User: Akiba
 * Date: 14-7-21
 * Time: 下午8:58
 * A Category Template
 */
get_header(); ?>
    <div class="container">
        <section id="post">
            <div class="pageload-overlay"></div>
            <article id="cat-<?php the_category_ID(); ?> " class="item show-up kanban">
                <div class="in-cat">
                    <h2>这里是<span><?php single_cat_title(); ?></span></h2>
                    <?php echo category_description($category_id); ?>
                </div>
            </article>
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
    </div>

<?php get_footer(); ?>