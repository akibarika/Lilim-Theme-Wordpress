<?php
/**
 * Created by PhpStorm.
 * User: Akiba
 * Date: 14-8-6
 * Time: 下午5:48
 */
?>
<?php if( has_post_format( 'aside' )) { ?>
    <article id="post-<?php the_ID(); ?>" class="item show-up">
        <div class="wrap-content format-aside clearfix">
            <div class="heading">
                <div class="avatar-icon">
                    <a href="<?php the_permalink(); ?>" title="永久链接：<?php the_title(); ?>"><?php echo get_avatar( 'lxclxc89816@gmail.com', 46 ); ?></a>
                    <span class="back"><a href="<?php the_permalink() ?>" title="永久链接：<?php the_title(); ?>">吐槽</a></span>
                </div>
                <div class="post-title">
                    <div class="title-wrap">
                        <div class="title">
                            <a href="<?php the_permalink() ?>" title="永久链接：<?php the_title(); ?>"><?php the_author(); ?> </a>
                        </div>
                        <time>
                            <?php the_time('F j, Y') ?>
                        </time>
                    </div>
                </div>
                <div class="tag">
                    <?php the_tags('<ul><li><div class="tag-bar"></div>','</li><li><div class="tag-bar"></div>','</li></ul>'); ?>
                </div>
            </div>
            <div class="post-content">
                <div class="excerpt">
                    <?php if(has_excerpt()) : ?>
                        <?php the_excerpt(); ?>
                    <?php else : ?>
                        <?php echo cut_str(strip_tags(apply_filters('the_content',$post->post_content)),180); ?>
                    <?php endif; ?>
                </div>
            </div>
            <div class="post-meta">
                <div class="post-comment">
                    <?php comments_popup_link( ' 0', ' 1', ' %', 'fa-share'); ?>
                </div>
                <div class="post-read">
                    <a class="read-more fa-plus-square-o" href="<?php the_permalink(); ?>" title="继续阅读：<?php the_title(); ?>"> <span>更多</span></a>
                </div>
            </div>
        </div>
    </article>
<?php }elseif( has_post_format( 'link' )) { ?>
    <article id="post-<?php the_ID(); ?>" class="item show-up">
        <?php $url = get_post_meta($post->ID,'format-link',true); ?>
        <div class="wrap-content format-link clearfix">
            <div class="heading">
                <div class="avatar-icon">
                    <a href="<?php the_permalink(); ?>" title="永久链接：<?php the_title(); ?>"><?php echo get_avatar( 'lxclxc89816@gmail.com', 46 ); ?></a>
                    <span class="back"><a href="<?php the_permalink() ?>" title="永久链接：<?php the_title(); ?>">趣链</a></span>
                </div>
                <div class="post-title">
                    <div class="title-wrap">
                        <div class="title">
                            <a href="<?php the_permalink() ?>" title="永久链接：<?php the_title(); ?>"><?php the_title(); ?></a>
                        </div>
                        <time>
                            <?php the_time('F j, Y') ?>
                        </time>
                    </div>
                </div>
                <div class="tag">
                    <?php the_tags('<ul><li><div class="tag-bar"></div>','</li><li><div class="tag-bar"></div>','</li></ul>'); ?>
                </div>
            </div>
            <div class="post-content">
                <div class="excerpt">
                    <?php if(has_excerpt()) : ?>
                        <?php the_excerpt(); ?>
                    <?php else : ?>
                        <?php echo cut_str(strip_tags(apply_filters('the_content',$post->post_content)),180); ?>
                    <?php endif; ?>
                </div>
            </div>
            <div class="post-thumb">
                <?php if ( has_post_thumbnail() ) { ?>
                    <?php if ( has_post_thumbnail() ){ the_post_thumbnail('home-thumbnail', array('class'=>'thumb')); } ?>
                <?php } else { ?>
                    <img src="<?php bloginfo( 'template_url' ); ?>/images/no-picture.jpg" class="thumb"/>
                <?php } ?>
            </div>
            <div class="post-meta">
                <div class="post-comment">
                    <?php comments_popup_link( ' 0', ' 1', ' %', 'fa-share'); ?>
                </div>
                <div class="post-read">
                    <a class="read-more fa-plus-square-o" href="<?php the_permalink(); ?>" title="继续阅读：<?php the_title(); ?>"> <span>更多</span></a>
                </div>
                <div class="post-link">
                    <a href="<?php echo $url ?>"class="fa-link" target="_blank"> 外部链接</a>
                </div>
            </div>
        </div>
    </article>
<?php }elseif( has_post_format( 'quote' )) { ?>
    <article id="post-<?php the_ID(); ?>" class="item show-up">
        <?php $quote = get_post_meta($post->ID,'format-quote',true); ?>
        <?php $source = get_post_meta($post->ID,'quote-source',true); ?>
        <div class="wrap-content format-quote clearfix">
            <div class="heading">
                <div class="avatar-icon">
                    <a href="<?php the_permalink(); ?>" title="永久链接：<?php the_title(); ?>"><?php echo get_avatar( 'lxclxc89816@gmail.com', 46 ); ?></a>
                    <span class="back"><a href="<?php the_permalink() ?>" title="永久链接：<?php the_title(); ?>">趣闻</a></span>
                </div>
                <div class="post-title">
                    <div class="title-wrap">
                        <div class="title">
                            <a href="<?php the_permalink() ?>" title="永久链接：<?php the_title(); ?>"><?php the_title(); ?></a>
                        </div>
                        <time>
                            <?php the_time('F j, Y') ?>
                        </time>
                    </div>
                </div>
                <div class="tag">
                    <?php the_tags('<ul><li><div class="tag-bar"></div>','</li><li><div class="tag-bar"></div>','</li></ul>'); ?>
                </div>
            </div>
            <div class="post-content">
                <div class="excerpt">
                    <?php if(has_excerpt()) : ?>
                        <?php the_excerpt(); ?>
                    <?php else : ?>
                        <?php echo cut_str(strip_tags(apply_filters('the_content',$post->post_content)),180); ?>
                    <?php endif; ?>
                </div>
            </div>
            <div class="post-quote">
                <p><?php echo $quote ?></p>
                <span><a href="<?php echo $source ?>" target="_blank">来源</a></span>
            </div>
            <div class="post-meta">
                <div class="post-comment">
                    <?php comments_popup_link( ' 0', ' 1', ' %', 'fa-share'); ?>
                </div>
                <div class="post-read">
                    <a class="read-more fa-plus-square-o" href="<?php the_permalink(); ?>" title="继续阅读：<?php the_title(); ?>"> <span>更多</span></a>
                </div>
                <div class="post-cat">
                    <i class="fa-folder-open"></i> <?php the_category(' '); ?>
                </div>
            </div>
        </div>
    </article>
<?php } else{ ?>
    <article id="post-<?php the_ID(); ?>" class="item show-up">
        <div class="wrap-content clearfix">
            <div class="heading">
                <div class="avatar-icon">
                    <a href="<?php the_permalink(); ?>" title="永久链接：<?php the_title(); ?>"><?php echo get_avatar( 'lxclxc89816@gmail.com', 46 ); ?></a>
                    <span class="back"><a href="<?php the_permalink() ?>" title="永久链接：<?php the_title(); ?>">更多</a></span>
                </div>
                <div class="post-title">
                    <div class="title-wrap">
                        <div class="title">
                            <a href="<?php the_permalink() ?>" title="永久链接：<?php the_title(); ?>"><?php the_title(); ?></a>
                        </div>
                        <time>
                            <?php the_time('F j, Y') ?>
                        </time>
                    </div>
                </div>
                <div class="tag">
                    <?php the_tags('<ul><li><div class="tag-bar"></div>','</li><li><div class="tag-bar"></div>','</li></ul>'); ?>
                </div>
            </div>
            <div class="post-content">
                <div class="excerpt">
                    <?php if(has_excerpt()) : ?>
                        <?php the_excerpt(); ?>
                    <?php else : ?>
                        <?php echo cut_str(strip_tags(apply_filters('the_content',$post->post_content)),180); ?>
                    <?php endif; ?>
                </div>
            </div>
            <div class="post-thumb">
                <?php if ( has_post_thumbnail() ) { ?>
                    <?php if ( has_post_thumbnail() ){ the_post_thumbnail('home-thumbnail', array('class'=>'thumb')); } ?>
                <?php } else { ?>
                    <img src="<?php bloginfo( 'template_url' ); ?>/images/no-picture.jpg" class="thumb"/>
                <?php } ?>
            </div>
            <div class="post-meta">
                <div class="post-comment">
                    <?php comments_popup_link( ' 0', ' 1', ' %', 'fa-share'); ?>
                </div>
                <div class="post-read">
                    <a class="read-more fa-plus-square-o" href="<?php the_permalink(); ?>" title="继续阅读：<?php the_title(); ?>"> <span>更多</span></a>
                </div>
                <div class="post-cat">
                    <i class="fa-folder-open"></i> <?php the_category(' '); ?>
                </div>
            </div>
        </div>
    </article>
<?php } // 文章样式结束 ?>