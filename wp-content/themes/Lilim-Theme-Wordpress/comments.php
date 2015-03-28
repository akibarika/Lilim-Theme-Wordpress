<?php

if ( post_password_required() ) : ?>
    <?php _e( 'Enter your password to view comments.' ); ?>
    <?php return; endif; ?>
<div id="comments">
    <div class="comt">
        <?php if ( have_comments() ) : ?>
            <ol class="commentlist">
                <?php wp_list_comments('type=comment&callback=lilim_comment&max_depth=4'); ?>
            </ol>
            <?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
                <div class="navigation">
                    <div class="cf"><?php paginate_comments_links( array('prev_text' => '&laquo;', 'next_text' => '&raquo;') ); ?></div>
                </div>
            <?php endif; ?>
        <?php endif; ?>
        <?php if ('open' == $post->comment_status) : ?>
            <div id="respond">
                <form id="commentform" action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" >
                <?php if ( $user_ID ) : ?>
                    <div class="comtool">
                        <?php cancel_comment_reply_link('取消回复') ?>
                    </div>
                    <div class="commenter">
                    <div id="author_info" class="author_info cf" >
                        <div class="user_logged cf">
                            <span>欢迎回来</span> <?php	printf(__(' <a href="%1$s">%2$s</a> '), get_option('siteurl') . '/wp-admin/profile.php', $user_identity); ?>
                            <a href="<?php echo wp_logout_url(get_permalink()); ?>" title="<?php _e('Log out of this account'); ?>" class="user_logout"><?php _e('不是你吗？'); ?></a>
                        </div>
                    </div>
                    </div>
                    <textarea name="comment" id="comment" rows="10" cols="100%" tabindex="4" onkeydown="if(event.ctrlKey&&event.keyCode==13){document.getElementById('submit').click();return false};"></textarea>
                    <input type="submit" name="submit" id="submit" value="POST COMMENT" tabindex="5" >
                    <?php comment_id_fields(); ?>
                    <?php do_action('comment_form', $post->ID); ?>
                    <input type="hidden" id="name_key" name="name_key" value="<?php echo wp_create_nonce(get_the_ID());  ?>">
                    <?php else :?>
                        <div class="cancel_comment_reply">
                            <?php cancel_comment_reply_link('取消回复') ?>
                        </div>
                        <div class="commenter">
                            <div id="author_info" class="author_info cf">
                                <p class="cf">
                                    <label class="author"><input placeholder="昵称" type="text" name="author" id="author" value="" tabindex="1"></label>
                                    <label class="email"><input placeholder="电子邮箱" type="text" name="email" id="email" value="" tabindex="2"></label>
                                </p>
                                <p>
                                <label class="url"><input placeholder="主页" type="text" name="url" id="url" value="" tabindex="3"></label>
                                </p>
                            </div>
                        </div>
                        <textarea name="comment" id="comment" rows="10" cols="100%" tabindex="4" onkeydown="if(event.ctrlKey&&event.keyCode==13){document.getElementById('submit').click();return false};"></textarea>
                        <input type="submit" name="submit" id="submit" value="POST COMMENT" tabindex="5" >
                        <?php comment_id_fields(); ?>
                        <?php do_action('comment_form', $post->ID); ?>
                        <input type="hidden" id="name_key" name="name_key" value="<?php echo wp_create_nonce(get_the_ID());  ?>">
                    </div>

                    <?php endif; ?>
                </form>
            <?php else : ?>
                <div class="commentclosed"><?php _e( 'Comments are closed.' ); ?></div>
            <?php endif; ?>
    </div>
</div>