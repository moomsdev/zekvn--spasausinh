<?php
$title = isset($args['title']) ? $args['title'] : 'Tiêu đề mặc định';
?>

<?php if ($title) : ?>
<div class="heading-wrapper" data-aos="fade-in" data-aos-duration="1000">
    <h2 class="section-heading fs-48"><?php echo $title; ?></h2>
    <figure class="icon-image">
        <img src="<?php bloginfo('template_url'); ?>/assets/images/heading-icon.png" alt="">
    </figure>
</div>
<?php endif; ?>