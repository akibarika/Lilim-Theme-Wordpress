<?php

get_header();

$cat = get_the_category();
?>
    <div class="container">
        <section id="post" class="grid--view">
            <div class="pageload-overlay"></div>
            <div class="column--one column--post show--up"></div>
            <div class="column--two column--post show--up"></div>
            <div class="column--three column--post show--up"></div>
            <div class="column--invisible">
                <article id="cat-<?php echo $cat[0]->term_id; ?> " class="item show-up kanban list--post">
                    <div class="in-cat">
                        <h2>这里是<span><?php single_cat_title(); ?></span></h2>
                        <?php echo category_description(); ?>
                    </div>
                </article>
                <?php if (have_posts()) :
                    while (have_posts()) :
                        the_post();
                        get_template_part('content');
                    endwhile;
                endif; ?>
            </div>
        </section>
        <?php wpbeginner_numeric_posts_nav(); ?>
    </div>

<?php get_footer(); ?>