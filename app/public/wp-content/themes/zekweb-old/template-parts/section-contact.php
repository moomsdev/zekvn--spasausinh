<?php
$title = get_field('sec13_title', 'option');
$image = get_field('sec13_img_sidebar', 'option');
?>

<section class="section-contact">
    <div class="container">
        <?php get_template_part('loop_template/loop', 'heading_section', ['title' => $title]) ?>

        <div class="row">
            <div class="col-12 d-none d-lg-block col-lg-3">
                <figure class="contact-image">
                    <img src="<?php echo $image; ?>" alt="image-sidebar">
                </figure>
            </div>
            <div class="col-12 col-lg-9">
                <div class="contact-form">
                    <?php echo do_shortcode('[contact-form-7 id="88bb70b" title="Liên hệ"]'); ?>
                </div>
            </div>
        </div>
    </div>
</section>
