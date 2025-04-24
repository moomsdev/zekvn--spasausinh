<?php get_header();wp_reset_query();  $format = get_post_format();?>
<?php $term_list = wp_get_post_terms($post->ID, 'category', array("fields" => "ids"));$a=$post->ID; ?>
<?php while (have_posts()) : the_post(); setPostViews($post->ID);?>
<main id="main">
    <?php get_template_part('loop_template/breadcrums'); ?>
    <div class="page-body">
        <div class="container">
            
        </div>
    </div>
</main>
<?php endwhile; ?>
<?php get_footer(); ?>
