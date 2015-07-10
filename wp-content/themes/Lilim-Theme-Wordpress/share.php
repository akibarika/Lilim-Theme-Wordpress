<?php
	$_description  = get_the_title() . ' - 作者: ' . get_the_author() . ',首发于' . get_bloginfo('name');
?>
<div class="share">
	<button class="share-toggle-button">
		<i class="icon-share"></i>
	</button>
	<ul class="share-items">
		<li class="share-item">
			<a href="http://service.weibo.com/share/share.php?url=<?php the_permalink() ?>&appkey=&title=<?php echo $_description; ?>&pic=&ralateUid=&language=zh_cn" onclick="window.open(this.href, 'weibo-share', 'width=550,height=235');return false;" class="share-button">
				<i class="icon-weibo"></i>
			</a>
		</li>
		<li class="share-item">
			<a href="https://www.facebook.com/sharer/sharer.php?u=<?php the_permalink() ?>" onclick="window.open(this.href, 'facebook-share', 'width=550,height=235');return false;" class="share-button">
				<i class="icon-facebook"></i>
			</a>
		</li>
		<li class="share-item">
			<a href="http://twitter.com/share?text=<?php echo $_description; ?>&url=<?php the_permalink() ?>" onclick="window.open(this.href, 'twitter-share', 'width=550,height=235');return false;" class="share-button">
				<i class="icon-twitter"></i>
			</a>
		</li>
		<li class="share-item">
			<a href="https://plus.google.com/share?url=<?php the_permalink() ?>" onclick="window.open(this.href, 'google-plus-share', 'width=550,height=235');return false;" class="share-button">
				<i class="icon-google-plus"></i>
			</a>
		</li>
	</ul>
</div>