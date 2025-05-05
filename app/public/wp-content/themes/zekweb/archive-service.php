<?php get_header();
$a = get_query_var('cat'); ?>
<?php $term = get_queried_object(); ?>
<main id="main">
    <div class="service-page">
        <?php get_template_part('template-parts/section', 'slider_hero'); ?>
        <?php get_template_part('template-parts/section', 'service'); ?>
    </div>
</main>
<?php get_footer(); ?>