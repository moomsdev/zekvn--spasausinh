<div class="col-6 col-lg-3 loop-service">
    <div class="loop-inner h-100 d-flex flex-column">
        <figure class="loop-image">
            <a href="<?php the_permalink(); ?>">
                <img src="<?php echo get_the_post_thumbnail_url(); ?>" alt="<?php the_title(); ?>" loading="lazy">
            </a>
        </figure>
        <div class="heading-wrapper flex-grow-1 d-flex align-items-center">
            <h4 class="loop-heading mb-0">
                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
            </h4>
        </div>
    </div>
</div>
