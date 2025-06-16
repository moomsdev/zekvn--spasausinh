<div class="single-meta">
	<span class="author"><?php the_author();?></span>
	<span class="date"><?php the_time('d M, Y'); ?></span>
	<?php   $categories = get_the_category(); if ( ! empty( $categories ) ) {echo '<a class="cat" href="' . esc_url( get_category_link( $categories[0]->term_id ) ) . '">' . esc_html( $categories[0]->name ) . '</a>';}?>
</div>