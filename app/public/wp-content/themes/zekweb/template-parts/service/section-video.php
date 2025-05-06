<?php
$title = isset($args['title']) ? $args['title'] : 'Tiêu đề mặc định';
$video = isset($args['video']) ? $args['video'] : '';
$videoID = getYoutubeVideoId($video);
?>

<section class="section-video">
    <div class="container">
        <?php if ($title) : ?>
            <div class="heading-wrapper" data-aos="fade-in" data-aos-duration="1000">
                <h2 class="section-heading fs-48"><?php echo $title; ?></h2>
                <figure class="icon-image">
                    <img src="<?php bloginfo('template_url'); ?>/assets/images/heading-icon.png" alt="">
                </figure>
            </div>
        <?php endif; ?>
    </div>
    
    <div class="video-wrapper">
        <iframe src="https://www.youtube.com/embed/<?php echo $videoID; ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
    </div>
</section>
