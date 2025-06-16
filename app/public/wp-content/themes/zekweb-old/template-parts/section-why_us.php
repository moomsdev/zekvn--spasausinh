<?php
$title = get_field('sec6_title', 'option');
$reasons = get_field('sec6_why_us', 'option');
?>

<section class="section-service frame-shadow">
    <div class="container">
        <?php get_template_part('loop_template/loop', 'heading_section', ['title' => $title]) ?>
        <div class="row justify-content-center">
            <?php
            $i = 0;
            foreach ($reasons as $post) :
            ?>
                <div class="col-6 col-md-4 loop-post mb-md-0">
                    <div class="post-item h-100 d-flex flex-column">
                        <figure class="post-image">
                            <img src="<?php echo $post['img']; ?>" alt="image-<?php echo $i; ?>" loading="lazy">
                        </figure>

                        <div class="post-content flex-grow-1">
                            <h3 class="post-title color-primary">
                              <?php echo $post['desc']; ?>
                            </h3>
                        </div>
                    </div>
                </div>
            <?php
            $i++;
            endforeach;
            ?>
        </div>
    </div>
</section>
