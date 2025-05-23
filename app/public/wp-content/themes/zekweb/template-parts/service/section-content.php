<?php
$title = isset($args['title']) ? $args['title'] : 'Tiêu đề mặc định';
$short_description = $args['short_description'];
$content_only = $args['content_only'];
?>

<section class="section-content">
    <div class="container">
        <?php if ($title) : ?>
            <div class="heading-wrapper" data-aos="fade-in" data-aos-duration="1000">
                <h2 class="section-heading fs-48"><?php echo $title; ?></h2>
                <figure class="icon-image">
                    <img src="<?php bloginfo('template_url'); ?>/assets/images/heading-icon.png" alt="">
                </figure>
            </div>
        <?php endif; ?>

        <div class="content-description">
            <div class="description mb-3">
                <?php echo $short_description; ?>
            </div>
            <div class="content-only">
                <?php echo $content_only; ?>
            </div>
        </div>
    </div>
</section>
