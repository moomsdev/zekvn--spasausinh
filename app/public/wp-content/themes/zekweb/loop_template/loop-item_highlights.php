<?php
$article = $args['article'];
$aos_delay = isset($args['aos_delay']) ? (int)$args['aos_delay'] : 0;
?>
<div class="col-6 col-lg-3 loop-highlight box" data-aos="fade-up" data-aos-duration="1500" data-aos-delay="<?= $aos_delay ?>">
    <div class="loop-inner">
        <figure class="loop-image">
            <a href="<?php the_permalink($article); ?>">
                <img src="<?php echo get_the_post_thumbnail_url($article, 'full'); ?>" alt="<?php echo get_the_title($article); ?>" loading="lazy">
            </a>
        </figure>

        <div class="loop-heading-wrapper">
            <h4 class="loop-heading fs-16"><a href="<?php the_permalink($article); ?>"><?php echo get_the_title($article); ?></a></h4>
        </div>

        <a href="<?php the_permalink($article); ?>" class="btn-hightlight bora-1">xem thêm</a>
    </div>
</div>
