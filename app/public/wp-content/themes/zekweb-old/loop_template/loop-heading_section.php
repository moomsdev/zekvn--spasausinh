<?php
$title = isset($args['title']) ? $args['title'] : 'Tiêu đề mặc định';
$title_mb = $args['title_mb'];
?>

<?php if ($title || $title_mb) : ?>
<div class="heading-wrapper" data-aos="fade-in" data-aos-duration="1000">
    <h2 class="section-heading fs-48 <?php echo isset($args['title_mb']) ? 'd-none d-lg-block' : 'd-block'; ?>"><?php echo $title; ?></h2>
    <h2 class="section-heading fs-48 <?php echo isset($args['title_mb']) ? 'd-block d-lg-none' : 'd-none'; ?>"><?php echo $title_mb; ?></h2>

    <figure class="icon-image">
        <img src="<?php bloginfo('template_url'); ?>/assets/images/heading-icon.png" alt="">
    </figure>
</div>
<?php endif; ?>