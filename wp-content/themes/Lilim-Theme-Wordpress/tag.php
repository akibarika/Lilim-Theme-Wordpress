<?php

get_header(); ?>
    <div class="container">
        <section id="post" class="grid--view">
            <div class="pageload-overlay show"></div>
            <div class="column--one column--post show--up"></div>
            <div class="column--two column--post show--up"></div>
            <div class="column--three column--post show--up"></div>
            <div class="column--invisible">
                <?php if (have_posts()) :
                    while (have_posts()) :
                        the_post();
                        get_template_part('content');
                    endwhile;
                endif; ?>
            </div>
        </section>
    </div>

<?php get_footer(); ?>