<?php
$title = get_field('title', 'option');
$image = get_field('image', 'option');
?>

<section class="section-highlights" data-aos="fade-up">
    <div class="container">
        <div class="heading-wrapper">
            <h2 class="section-heading fs-48">dấu ấn home care</h2>
            <figure class="icon-image">
                <img src="<?php bloginfo('template_url'); ?>/assets/images/heading-icon.png" alt="">
            </figure>
        </div>
        <div class="row g-4 justify-content-center">
            <?php get_template_part('loop_template/loop', 'item_highlights') ?>
            <?php get_template_part('loop_template/loop', 'item_highlights') ?>
            <?php get_template_part('loop_template/loop', 'item_highlights') ?>
            <?php get_template_part('loop_template/loop', 'item_highlights') ?>
        </div>
    </div>
</section>
