<?php
$title = isset($args['title']) ? $args['title'] : 'Tiêu đề mặc định';
?>
<div class="heading-wrapper" data-aos="fade-in" data-aos-duration="1000">
    <h2 class="section-heading fs-48"><?= esc_html($title) ?></h2>
    <figure class="icon-image">
        <img src="<?php bloginfo('template_url'); ?>/assets/images/heading-icon.png" alt="">
    </figure>
</div>