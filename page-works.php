<?php /* 
	  	Template Name: works(我的作品)
	  */ ?>
<?php get_header(); ?>
    <div id="page-wrap">
        <section id="single" class="wrap-work page">
            <div class="title left"><h2>#MY WORKS</h2></div>
            <div class="work-content right">
                <div class="work-container">
                    <div class="content-title"><h2>#website</h2></div>
                    <?php
                        $args = array('post_type'=>'website','posts_per_page' => -1);
                        query_posts($args);
                        if( have_posts() ) :
                    ?>
                    <div class="content-list">
                        <?php while( have_posts() ) : the_post();
                            $pic_url = get_post_meta($post->ID,'pic',true);
                            $link_url = get_post_meta($post->ID,'link',true);
                            $detail = get_post_meta($post->ID,'des',true);
                        ?>
                        <article id="post-<?php the_ID(); ?>" class="work-here">
                            <div class="wrap">
                                <div class="work-thumb">
                                    <div class="thumb-image">
                                        <img src="<?php echo $pic_url; ?>">
                                    </div>
                                    <div class="caption">
                                        <a class="button web" href="<?php echo $link_url; ?>" target="_blank" ><span>visit</span></a>
                                    </div>
                                </div>
                                <div class="work-info">
                                    <div class="work-title"><a href="<?php echo $link_url; ?>" target="_blank"><span><?php the_title(); ?></span></a> </div>
                                    <div class="sub"><?php echo $detail; ?></div>
                                </div>
                            </div>
                        </article>
                        <?php endwhile; ?>
                    </div>
                    <?php endif; wp_reset_query(); ?>
                </div>
                <div class="work-container">
                    <div class="content-title"><h2>#theme</h2></div>
                        <?php
                            $args = array('post_type'=>'theme','posts_per_page' => -1);
                            query_posts($args);
                            if( have_posts() ) :
                        ?>
                    <div class="content-list">
                        <?php while( have_posts() ) : the_post();
                            $pic_url = get_post_meta($post->ID,'pic',true);
                            $link_url = get_post_meta($post->ID,'link',true);
                            $detail = get_post_meta($post->ID,'des',true);
                        ?>
                        <article id="post-<?php the_ID(); ?>" class="work-here">
                            <div class="wrap">
                                <div class="work-thumb">
                                    <div class="thumb-image">
                                        <img src="<?php echo $pic_url; ?>" >
                                    </div>
                                    <div class="caption">
                                        <a class="button theme" href="<?php echo $link_url; ?>" target="_blank" ><span>View</span></a>
                                    </div>
                                </div>
                                <div class="work-info">
                                    <div class="work-title"><a href="<?php echo $link_url; ?>" target="_blank"><span><?php the_title(); ?></span></a> </div>
                                    <div class="sub"><?php echo $detail; ?></div>
                                </div>
                            </div>
                        </article>
                        <?php endwhile; ?>
                    </div>
                    <?php endif; wp_reset_query(); ?>
                </div>
                <div class="work-container">
                    <div class="content-title"><h2>#illustration</h2></div>
                    <?php
                        $args = array('post_type'=>'illustration','posts_per_page' => -1);
                        query_posts($args);
                        if( have_posts() ) :
                    ?>
                    <div class="content-list">
                        <?php while( have_posts() ) : the_post();
                            $pic_url = get_post_meta($post->ID,'pic',true);
                            $link_url = get_post_meta($post->ID,'link',true);
                            $detail = get_post_meta($post->ID,'des',true);
                        ?>
                        <article id="post-<?php the_ID(); ?>" class="work-here">
                            <div class="wrap">
                                <div class="work-thumb">
                                    <div class="thumb-image">
                                        <img src="<?php echo $pic_url; ?>" >
                                    </div>
                                    <div class="caption">
                                        <a class="button drawing" href="<?php echo $link_url; ?>" target="_blank" ><span>browse</span></a>
                                    </div>
                                </div>
                                <div class="work-info">
                                    <div class="work-title"><a href="<?php echo $link_url; ?>" target="_blank"><span><?php the_title(); ?></span></a> </div>
                                    <div class="sub"><?php echo $detail; ?></div>
                                </div>
                            </div>
                        </article>
                        <?php endwhile; ?>
                    </div>
                    <?php endif; wp_reset_query(); ?>
                </div>
            </div>
        </section>
    </div>


<?php get_footer(); ?>