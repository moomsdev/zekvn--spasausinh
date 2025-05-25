<?php
$background = get_field('sec3_bg_video', 'option');
$title = get_field('sec3_title', 'option');
$title_mb = get_field('sec3_title_mb', 'option');
$video = get_field('sec3_video', 'option');
$videoID = getYoutubeVideoId($video);
?>

<section class="section-video">
  <div class="container">
    <?php get_template_part('loop_template/loop', 'heading_section', ['title' => $title, 'title_mb' => $title_mb]) ?>
    
    <div class="video-wrapper">
        <iframe src="https://www.youtube.com/embed/<?php echo $videoID; ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
    </div>
  </div>
</section>
