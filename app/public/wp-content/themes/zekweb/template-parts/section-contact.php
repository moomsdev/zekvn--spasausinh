<?php
$title = get_field('title', 'option');
$image = get_field('image', 'option');
?>

<section class="section-contact">
    <div class="container">
        z<?php get_template_part('loop_template/loop', 'heading_section') ?>
        <div class="row">
            <div class="col-12 col-lg-4">
                <figure class="contact-image">
                <img src="<?php bloginfo('template_url'); ?>/assets/images/sidebar-img-form.png" alt="heading-icon">
                </figure>
            </div>
            <div class="col-12 col-lg-8">
                <div class="contact-form">
                    <?php echo do_shortcode('[contact-form-7 id="d4e589b" title="Liên hệ"]'); ?>
                </div>
            </div>
        </div>
    </div>
</section>
