<?php
$title = get_field('sec10_title', 'option');
$articles = get_field('sec10_articles', 'option');
$main_article = $articles[0] ?? null;
$other_articles = array_slice($articles, 1);
?>

<section class="section-video-library">
    <?php get_template_part('loop_template/loop', 'heading_section', ['title' => $title]) ?>

    <div class="container">
        <div class="row g-5">
            <?php if ($main_article): 
                $video_url = get_field('video_featured', $main_article);
                $videoID = getYoutubeVideoId($video_url);
            ?>
                <div class="col-12 col-lg-6 video-library-main">
                    <div class="video-library-main-video">
                        <div class="video-thumbnail mb-3">
                          <?php if ($videoID): ?>
                            <iframe src="https://www.youtube.com/embed/<?php echo $videoID; ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                          <?php else: ?>
                            <img src="<?php echo get_the_post_thumbnail_url($main_article, 'full'); ?>" alt="<?php echo get_the_title($main_article); ?>" loading="lazy">
                          <?php endif; ?>
                        </div>
                        <div class="video-caption">
                            <div class="video-date"><?php echo get_the_date('d/m/Y', $main_article); ?></div>
                            <a href="<?php echo get_the_permalink($main_article); ?>" class="video-title"><?php echo get_the_title($main_article); ?></a>
                            <div class="video-description">
                                <?php echo get_the_excerpt($main_article); ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

          
            <div class="col-12 col-lg-6 video-library-list">
                <?php 
                foreach ($other_articles as $article):
                  $video_url = get_field('video_featured', $article);
                  $videoID = getYoutubeVideoId($video_url);
                ?>
                <div class="row video-library-list-item mb-4">
                    <div class="col-12 col-lg-6">
                        <div class="video-thumbnail">
                          <?php if ($videoID): ?>
                            <iframe src="https://www.youtube.com/embed/<?php echo $videoID; ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                          <?php else: ?>
                            <img src="<?php echo get_the_post_thumbnail_url($article, 'full'); ?>" alt="<?php echo get_the_title($article); ?>" loading="lazy">
                          <?php endif; ?>
                        </div>
                    </div>
                    <div class="col-12 col-lg-6">
                        <div class="video-caption">
                            <div class="video-date"><?php echo get_the_date('d/m/Y', $article); ?></div>
                            <a href="<?php echo get_the_permalink($article); ?>" class="video-title"><?php echo get_the_title($article); ?></a>
                            <div class="video-description">
                                <?php echo get_the_excerpt($article); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="mt-5 d-flex justify-content-center">
            <a href="/blog" class="btn-hightlight rounded-4">XEM TẤT CẢ</a>
        </div>
    </div>
</section>
