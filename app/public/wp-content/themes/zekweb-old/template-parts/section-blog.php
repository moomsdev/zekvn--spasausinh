<?php
$title = get_field('sec4_title', 'option');
$title_mb = get_field('sec4_title_mb', 'option');
$postFeatured = get_field('sec4_post_featured', 'option');
$btn = get_field('sec4_btn', 'option');
?>

<section class="section-blog text-center">
    <div class="container">
        <?php get_template_part('loop_template/loop', 'heading_section', ['title' => $title, 'title_mb' => $title_mb]) ?>

        <div class="row justify-content-center">
            <!-- loop post -->
            <?php foreach ($postFeatured as $post) : ?>
            <div class="col-6 col-md-4 loop-post">
                <div class="post-item h-100 d-flex flex-column">
                    <figure class="post-image">
                        <img src="<?php echo get_the_post_thumbnail_url($post, 'full'); ?>" alt="<?php the_title(); ?>" loading="lazy">
                    </figure>
                    <div class="post-content flex-grow-1">
                        <h3 class="post-title">
                            <a href="<?php echo get_the_permalink($post); ?>"><?php echo get_the_title($post); ?></a>
                        </h3>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

         <?php
        if ($btn) :
            echo '
            <div class="text-center">
                <a href="' . $btn[0]['url'] . '" class="btn-hightlight bora-1 mt-5">' . $btn[0]['text'] . '</a>
            </div>
            ';
        endif;
        ?>
    </div>

</section>
   