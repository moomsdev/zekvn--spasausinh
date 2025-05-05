<?php get_header();wp_reset_query();  $format = get_post_format();?>

<?php while (have_posts()) : the_post();?>
<main id="main">
    <div class="page-body">
        <div class="service-banner">
            <figure class="icon-image">
                <img src="<?php bloginfo('template_url'); ?>/assets/images/Asset 3.png" alt="">
            </figure>
        </div>
        <?php
        get_template_part('template-parts/service/section', 'content_media');
        get_template_part('template-parts/service/section', 'content');
        get_template_part('template-parts/section', 'video');
        get_template_part('template-parts/section', 'contact');
        get_template_part('template-parts/section', 'faqs');
        ?>
    </div>
</main>
<?php endwhile; ?>
<?php get_footer(); ?>
