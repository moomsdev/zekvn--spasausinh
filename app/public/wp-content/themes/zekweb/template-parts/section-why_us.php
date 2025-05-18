<?php
$title = get_field('sec6_title', 'option');
$reasons = get_field('sec6_why_us', 'option');
?>

<section class="section-service frame-shadow">
    <div class="container">
        <?php get_template_part('loop_template/loop', 'heading_section', ['title' => $title]) ?>
        <div class="row justify-content-center">
            <?php
            foreach ($reasons as $post) :
            ?>
                <div class="col-6 col-md-4 loop-post mb-md-0">
                    <div class="post-item h-100 d-flex flex-column">
                        <figure class="post-image">
                            <img src="<?php echo get_the_post_thumbnail_url($post, 'full'); ?>" alt="<?php the_title(); ?>" loading="lazy">
                        </figure>

                        <div class="post-content flex-grow-1">
                            <h3 class="post-title color-primary">
                                <a href="<?php echo get_the_permalink($post); ?>"><?php echo get_the_title($post); ?></a>
                            </h3>
                        </div>
                    </div>
                </div>
            <?php
            endforeach;
            ?>
        </div>
    </div>
</section>
