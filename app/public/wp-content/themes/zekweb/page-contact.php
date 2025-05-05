<?php
/*
Template Name: Liên hệ
 */
?>
<?php get_header(); ?>

<main id="main">
    <?php get_template_part('template-parts/section', 'contact'); ?>
    <div class="container">
        <div class="google-map">
            <?php echo get_field('gg_map', 'option'); ?>
        </div>
    </div>
</main>

<?php get_footer(); ?>
