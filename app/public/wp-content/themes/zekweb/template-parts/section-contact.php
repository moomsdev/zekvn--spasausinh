<?php
$title = get_field('title', 'option');
$image = get_field('image', 'option');
?>

<section class="section-contact">
    <div class="container">
        <div class="heading-wrapper">
            <h2 class="section-heading fs-48">dấu ấn home care</h2>
            <figure class="icon-image">
                <img src="<?php bloginfo('template_url'); ?>/assets/images/heading-icon.png" alt="heading-icon">
            </figure>
        </div>
        <div class="row d-flex align-items-stretch">
            <div class="col-md-12 col-lg-4">
                <figure class="contact-image">
                    <img src="<?php bloginfo('template_url'); ?>/assets/images/sidebar-img-form.png" alt="heading-icon">
                </figure>
            </div>
            <div class="col-md-12 col-lg-8">
                <div class="contact-form">
                    <?php echo do_shortcode('[contact-form-7 id="d4e589b" title="Liên hệ"]'); ?>
                </div>
            </div>
        </div>
    </div>
</section>
