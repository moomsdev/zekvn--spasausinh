<?php
$title = get_field('sec7_title', 'option');
$testimonials = get_field('sec7_testimanial', 'option');
?>
<section class="section-testimonials overflow-hidden" style="background-image: url(<?php bloginfo('template_url'); ?>/assets/images/testimonials-bg.png); background-repeat: no-repeat; background-size: cover;">
    <div class="container testimonials-slider swiper" data-aos="fade-down">
        <div class="swiper-wrapper">
            <?php
            foreach ($testimonials as $testimonial) :
                $video = $testimonial['video'];
                $videoID = getYoutubeVideoId($video);
                $img = $testimonial['img'];
                $name = $testimonial['name'];
                $content = $testimonial['content'];
            ?>
            <div class="swiper-slide">
                <div class="testimonials-video">
                    <iframe loading="lazy" src="https://www.youtube.com/embed/<?php echo $videoID; ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                </div>
                <div class="testimonials-content">
                    <h3 class="testimonials-title mb-4"><?php echo $title; ?></h3>
                    <div class="testimonials-description">
                        <p><?php echo $content; ?></p>
                    </div>
                    <figure class="testimonials-review">
                        <img src="<?php bloginfo('template_url'); ?>/assets/images/review-star.png" alt="review star Image">
                    </figure>
                    <div class="testimonials-profile">
                        <figure>
                            <img src="<?php echo $img; ?>" alt="<?php echo $name; ?>">
                        </figure>
                        <h3><?php echo $name; ?></h3>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <div class="swiper-pagination"></div>
    </div>
</section>