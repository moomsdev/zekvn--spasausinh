<div class="col-6 col-lg-4 loop-whyus">
    <div class="loop-inner">
        <figure class="loop-image">
            <a href="<?php the_permalink(); ?>">
                <img src="<?php echo get_the_post_thumbnail_url(); ?>" alt="<?php the_title(); ?>" loading="lazy">
            </a>
        </figure>
        
        <div class="heading-wrapper">
            <h4 class="loop-heading fs-24">
                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
            </h4>
        </div>
    </div>
</div>
