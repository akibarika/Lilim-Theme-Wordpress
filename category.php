<?php
/**
 * Created by PhpStorm.
 * User: Akiba
 * Date: 14-7-21
 * Time: 下午8:58
 * A Category Template
 */
get_header(); ?>
    <section id="post">
        <article id="cat-<?php the_category_ID(); ?> " class="item show-up kanban">
            <div class="in-cat">
                <h2>这里是<span><?php single_cat_title(); ?></span></h2>
                <?php echo category_description($category_id); ?>
            </div>
        </article>
        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <article id="post-<?php the_ID(); ?>" class="item show-up">
            <div class="warp-content clearfix">
                <div class="pic left">
                    <?php if ( has_post_thumbnail() ) { ?>
                        <a class="entry-image" href="<?php the_permalink() ?>" title="永久链接：<?php the_title(); ?>">
                            <span class="entry-image-overlay"></span>
                            <?php if ( has_post_thumbnail() ){ the_post_thumbnail('home-thumbnail', array('class'=>'thumb')); } ?>
                        </a>
                    <?php } else { ?>
                        <a class="entry-image" href="<?php the_permalink() ?>" title="永久链接：<?php the_title(); ?>">
                            <span class="entry-image-overlay"></span>
                            <img src="<?php bloginfo( 'template_url' ); ?>/images/no-picture.jpg" class="thumb"/>
                        </a>
                    <?php } ?>
                </div>
                <div class="post-content left">
                    <div class="here-is-title">
                        <div class="title-bar"></div>
                        <h2 class="post-title">
                            <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
                        </h2>
                    </div>
                    <div class="excerpt">
                        <?php if(has_excerpt()) : ?>
                            <?php the_excerpt(); ?>
                        <?php else : ?>
                            <?php echo cut_str(strip_tags(apply_filters('the_content',$post->post_content)),180); ?>
                        <?php endif; ?>
                    </div>
                    <div class="post-meta left">
                        <?php comments_popup_link('暂无吐槽', '被吐槽1次', '被吐槽%次'); ?> |
                        <time><?php the_time('m/d') ?></time> |
                        <?php the_category('、') ?>
                    </div>
                    <a class="read-more right" href="<?php the_permalink(); ?>">Read More</a>
                </div>
            </div>
        </article>
        <?php endwhile; ?>
        <?php else : ?>
            <article class="item i-404">
                <div class="warp-content clearfix">
                    <div class="not-found">
                        <img src="<?php bloginfo('template_directory'); ?>/images/404-not-found.jpg" />
                    </div>
                </div>
            </article>
        <?php endif; ?>
    </section>
<?php wpbeginner_numeric_posts_nav(); ?>

<?php get_footer(); ?>