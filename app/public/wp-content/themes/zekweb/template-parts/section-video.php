<?php
$title = get_field('title', 'option');
$image = get_field('image', 'option');
?>

<section class="section-video">
    <div class="heading-wrapper">
        <h2 class="section-heading fs-48">2 phút để hình dung về home care</h2>
        <figure class="icon-image">
            <img src="<?php bloginfo('template_url'); ?>/assets/images/heading-icon.png" alt="heading-icon">
        </figure>
    </div>
    <div class="video-wrapper">
        <div class="container-fluid">
            <iframe src="https://www.youtube.com/embed/ItRExComFJ4?si=gJfbFf52rKwQqYUy" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
        </div>
    </div>
</section>
