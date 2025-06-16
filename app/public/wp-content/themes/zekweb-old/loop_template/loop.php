<div class="item-news">
	<div class="img">
		<a href="<?php the_permalink()?>" title="<?php the_title(); ?>"><?php the_post_thumbnail('large', array('alt'   => trim(strip_tags( $post->post_title )),'title' => trim(strip_tags( $post->post_title )),)); ?></a>
	</div>
	<div class="info">
		<h3 class="name"><a href="<?php the_permalink()?>"><?php the_title(); ?></a></h3>
		<div class="desc"><?php echo wp_trim_words( get_the_content(), 30, '...' ); ?></div>
	</div>
</div>