<?php
$title = get_field('sec10_title', 'option');
$library_mom = get_field('sec10_library_mom', 'option');
?>

<section class="section-video-library">
    <?php get_template_part('loop_template/loop', 'heading_section', ['title' => $title]) ?>

    <div class="container">
        <div class="row g-5">
            <?php
            $category = get_term($library_mom, 'category');
            $args = array(
                'post_type' => 'post',
                'tax_query' => array(
                    array(
                        'taxonomy' => 'category',
                        'field' => 'term_id',
                        'terms' => $category,
                    ),
                ),
                'posts_per_page' => 1,
            );
            $posts = new WP_Query($args);
            if ($posts->have_posts()) :
                while ($posts->have_posts()) : $posts->the_post();
                    $video_url = get_field('video_featured', get_the_ID());
                    $videoID = getYoutubeVideoId($video_url);
                    $video_title = get_the_title(get_the_ID());
            ?>
                    <div class="col-12 col-lg-6 video-library-main">
                        <div class="video-library-main-video">
                            <div class="video-thumbnail mb-3">
                                <iframe src="https://www.youtube.com/embed/<?php echo $videoID; ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                            </div>
                            <div class="video-caption">
                                <div class="video-date"><?php echo get_the_date('d/m/Y', get_the_ID()); ?></div>
                                <a href="<?php echo get_the_permalink(get_the_ID()); ?>" class="video-title"><?php echo get_the_title(get_the_ID()); ?></a>
                                <div class="video-description">
                                    <?php echo get_the_excerpt(get_the_ID()); ?>
                                </div>
                            </div>
                        </div>
                    </div>
            <?php
                endwhile;
                wp_reset_postdata();
            endif;
            ?>

            <?php
            $args = array(
                'post_type' => 'post',
                'tax_query' => array(
                    array(
                        'taxonomy' => 'category',
                        'field' => 'term_id',
                        'terms' => $category,
                    ),
                ),
                'posts_per_page' => 2,
                'offset' => 1,
            );
            $posts = new WP_Query($args);

            ?>
            <div class="col-12 col-lg-6 video-library-list">
                <?php
                if ($posts->have_posts()) :
                    while ($posts->have_posts()) : $posts->the_post();
                        $video_url = get_field('video_featured', get_the_ID());
                        $videoID = getYoutubeVideoId($video_url);
                        $video_title = get_the_title(get_the_ID());
                ?>
                        <div class="row video-library-list-item mb-4">
                            <div class="col-12 col-lg-6">
                                <div class="video-thumbnail">
                                    <iframe src="https://www.youtube.com/embed/<?php echo $videoID; ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                                </div>
                            </div>
                            <div class="col-12 col-lg-6">
                                <div class="video-caption">
                                    <div class="video-date"><?php echo get_the_date('d/m/Y', get_the_ID()); ?></div>
                                    <a href="<?php echo get_the_permalink(get_the_ID()); ?>" class="video-title"><?php echo get_the_title(get_the_ID()); ?></a>
                                    <div class="video-description">
                                        <?php echo get_the_excerpt(get_the_ID()); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                <?php
                    endwhile;
                    wp_reset_postdata();
                endif;
                ?>

            </div>
        </div>
        <div class="mt-5 d-flex justify-content-center">
            <a href="<?php echo get_term_link($library_mom, 'category'); ?>" class="btn-hightlight rounded-4">XEM TẤT CẢ</a>
        </div>
    </div>

</section>