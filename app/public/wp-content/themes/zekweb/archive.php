<?php get_header(); $a=get_query_var('cat' );?>
<?php $term = get_queried_object(); ?>
<main id="main">
    <?php get_template_part('loop_template/breadcrums'); ?>
    <div class="page-body">
        <div class="container">
            
        </div>
    </div>
</main>
<?php get_footer(); ?>
