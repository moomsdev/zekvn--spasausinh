<?php
/*
Template Name: Showroom
 */
?>
<?php get_header(); ?>

<main id="main">
    <div class="page-showroom">
        <div class="banner-shoroom">

        </div>
        <?php get_template_part('template-parts/section','branch') ?>
        <div class="row g-4 justify-content-center">
            <?php get_template_part('loop_template/loop', 'item_highlights') ?>
            <?php get_template_part('loop_template/loop', 'item_highlights') ?>
            <?php get_template_part('loop_template/loop', 'item_highlights') ?>
            <?php get_template_part('loop_template/loop', 'item_highlights') ?>
        </div>
        <?php get_template_part('template-parts/section','contact') ?>
    </div>
</main>

<?php get_footer(); ?>
