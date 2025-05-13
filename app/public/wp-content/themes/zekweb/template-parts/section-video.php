<?php
$background = get_field('sec3_bg_video', 'option');
$title = get_field('sec3_title', 'option');
$video = get_field('sec3_video', 'option');
$videoID = getYoutubeVideoId($video);
?>

<section class="section-video">
    <?php get_template_part('loop_template/loop', 'heading_section', ['title' => $title]) ?>
    
    <div class="video-wrapper">
        <iframe src="https://www.youtube.com/embed/<?php echo $videoID; ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
    </div>
</section>
