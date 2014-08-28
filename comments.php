<?php if ( post_password_required() ) : ?>
<?php _e( 'Enter your password to view comments.' ); ?>
<?php return; endif; ?>
<div id="comments">
	<div class="commentscount"><h3><span><?php comments_number( '0', '1', '%' ); ?></span> 吐槽</h3></div>
	<?php if ( have_comments() ) :?>
        <ol class="commentlist"><?php wp_list_comments('type=comment&callback=otakism_comment&max_depth=10000'); ?></ol>
		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) { ?>
			<div class="pagination">	
    	    	<div class="clearfix"><?php paginate_comments_links( array('prev_text' => '&laquo;', 'next_text' => '&raquo;') ); ?></div>
            </div>
		<?php } ?>
    <?php else : ?>
    	<?php if ('open' == $post->comment_status) { ?>
    	<div class="nocomments">居然没有人吐槽？！</div>
        <?php } ?>
    <?php endif; ?>
    	<?php if ('open' == $post->comment_status) : ?>
    <div id="respond">
    	<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">
        	<?php if ( $user_ID ) : ?>
             <div class="comtool cf">
           <div class="smiley left">
				<a href="javascript:grin(':em01:')"><img src="<?php bloginfo('template_url'); ?>/smilies/01.gif" class="wp-smiley"/></a>
				<a href="javascript:grin(':em02:')"><img src="<?php bloginfo('template_url'); ?>/smilies/02.gif" class="wp-smiley"/></a>
				<a href="javascript:grin(':em03:')"><img src="<?php bloginfo('template_url'); ?>/smilies/03.gif" class="wp-smiley"/></a>
				<a href="javascript:grin(':em04:')"><img src="<?php bloginfo('template_url'); ?>/smilies/04.gif" class="wp-smiley"/></a>
				<a href="javascript:grin(':em05:')"><img src="<?php bloginfo('template_url'); ?>/smilies/05.gif" class="wp-smiley"/></a>
				<a href="javascript:grin(':em06:')"><img src="<?php bloginfo('template_url'); ?>/smilies/06.gif" class="wp-smiley"/></a>
				<a href="javascript:grin(':em07:')"><img src="<?php bloginfo('template_url'); ?>/smilies/07.gif" class="wp-smiley"/></a>
				<a href="javascript:grin(':em08:')"><img src="<?php bloginfo('template_url'); ?>/smilies/08.gif" class="wp-smiley"/></a>
				<a href="javascript:grin(':em09:')"><img src="<?php bloginfo('template_url'); ?>/smilies/09.gif" class="wp-smiley"/></a>
				<a href="javascript:grin(':em10:')"><img src="<?php bloginfo('template_url'); ?>/smilies/10.gif" class="wp-smiley"/></a>
			</div>
            <div class="cancel_comment_reply right">
				<?php
					if ( is_singular() )
							wp_enqueue_script( "comment-reply" ); 
					cancel_comment_reply_link() 
				?>
			</div>
            </div>
            <textarea name="comment" id="comment" rows="10" cols="100%" tabindex="4" onkeydown="if(event.ctrlKey&&event.keyCode==13){document.getElementById('submit').click();return false};"></textarea>
            <div class="author_info cf" id="author_info">
            	<div class="user_logged left">
        			<?php	printf(__(' <a href="%1$s">%2$s</a> '), get_option('siteurl') . '/wp-admin/profile.php', $user_identity); ?>
					<a href="<?php echo wp_logout_url(get_permalink()); ?>" title="<?php _e('Log out of this account'); ?>" class="user_logout">
						<?php _e('Log out &raquo;'); ?>
					</a>
                </div>
				<input type="submit" name="submit" id="submit" value="吐槽！" tabindex="5" >
				<?php comment_id_fields(); ?> 
				<?php do_action('comment_form', $post->ID); ?>
				<input type="hidden" id="name_key" name="name_key" value="<?php echo wp_create_nonce('otakism_key'.get_the_ID());  ?>">
				<input type="hidden" name="action" value="article">
            </div>
           	<?php else :?>
           		<?php	$otakism_author = $comment_author;
						$otakism_email = $comment_author_email;
						$otakism_url = $comment_author_url;
						if(!$otakism_author){
							$otakism_author ='Name :';
							$otakism_email ='Email :';
							$otakism_url = 'Website :';
						}
					?>
           <div class="comtool cf">
           <div class="smiley left">
				<a href="javascript:grin(':em01:')"><img src="<?php bloginfo('template_url'); ?>/smilies/01.gif" class="wp-smiley"/></a>
				<a href="javascript:grin(':em02:')"><img src="<?php bloginfo('template_url'); ?>/smilies/02.gif" class="wp-smiley"/></a>
				<a href="javascript:grin(':em03:')"><img src="<?php bloginfo('template_url'); ?>/smilies/03.gif" class="wp-smiley"/></a>
				<a href="javascript:grin(':em04:')"><img src="<?php bloginfo('template_url'); ?>/smilies/04.gif" class="wp-smiley"/></a>
				<a href="javascript:grin(':em05:')"><img src="<?php bloginfo('template_url'); ?>/smilies/05.gif" class="wp-smiley"/></a>
				<a href="javascript:grin(':em06:')"><img src="<?php bloginfo('template_url'); ?>/smilies/06.gif" class="wp-smiley"/></a>
				<a href="javascript:grin(':em07:')"><img src="<?php bloginfo('template_url'); ?>/smilies/07.gif" class="wp-smiley"/></a>
				<a href="javascript:grin(':em08:')"><img src="<?php bloginfo('template_url'); ?>/smilies/08.gif" class="wp-smiley"/></a>
				<a href="javascript:grin(':em09:')"><img src="<?php bloginfo('template_url'); ?>/smilies/09.gif" class="wp-smiley"/></a>
				<a href="javascript:grin(':em10:')"><img src="<?php bloginfo('template_url'); ?>/smilies/10.gif" class="wp-smiley"/></a>
			</div>
            <div class="cancel_comment_reply right">
				<?php
					if ( is_singular() )
							wp_enqueue_script( "comment-reply" ); 
					cancel_comment_reply_link() 
				?>
			</div>
            </div>
            <textarea name="comment" id="comment" rows="10" cols="100%" tabindex="4" onkeydown="if(event.ctrlKey&&event.keyCode==13){document.getElementById('submit').click();return false};"></textarea>
              <div class="author_info cf" id="author_info">
				<label class="author"><input placeholder="昵称" type="text" name="author" id="author" value="" tabindex="1"></label>
				<label class="email"><input placeholder="电子邮箱" type="text" name="email" id="email" value="" tabindex="2"></label>
				<label class="url"><input placeholder="主页" type="text" name="url" id="url" value="" tabindex="3"></label>
                <input type="submit" name="submit" id="submit" value="吐槽！" tabindex="5" >
                <?php comment_id_fields(); ?> 
				<?php do_action('comment_form', $post->ID); ?>
				<input type="hidden" id="name_key" name="name_key" value="<?php echo wp_create_nonce('otakism_key'.get_the_ID());  ?>">
				<input type="hidden" name="action" value="article">
              </div>	
			<?php endif; ?>
        </form>
	</div>
		<?php else : ?>
    		<div class="commentclosed"><?php _e( 'Comments are closed.' ); ?></div>
        <?php endif; ?>
</div>