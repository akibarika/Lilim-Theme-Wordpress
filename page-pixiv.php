<?php /* 
	  	Template Name: Pixiv (P站排名) 
	  */ ?>
<?php get_header(); ?>		
			<div id="page-wrap">
				<section id="single" class="wrap-pixiv">
					<div id="pixiv">

					<?php
					$rss = simplexml_load_file('http://www.feed43.com/5103823232446385.xml');
					?>
					
					<h1 class="ribbon">
						<strong class="ribbon-content"><?php echo $rss->channel->title; ?></strong>
					</h1>
					<time class="post-time">
						<?php echo $rss->channel->lastBuildDate; ?>
					</time>
					<?php
					$i = 0;
					foreach($rss->channel->item as $chan) { 
							if ($i == 50){
						        break;
					        }else{
						        $i++;
								echo "<section id=\"rank-".$i."\" class=\"rank-item\" >";
						        echo $chan->description;   
						        echo "</section>";
					        }
					        
					        
					}  
					
					?>  
					</div>
				</section>			
			</div>
	      
<?php get_footer(); ?>		
			