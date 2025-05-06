<?php
$title = get_field('sec5_title', 'option');
?>

<section class="section-service frame-shadow">
    <div class="container">
        <?php get_template_part('loop_template/loop', 'heading_section', ['title' => $title]) ?>
        
        <div class="row g-4 justify-content-center">
            <!-- get post CPT service -->
            <?php
            $args = array(
                'post_type' => 'service',
                'posts_per_page' => -1,
            );
            $query = new WP_Query($args);
            if ($query->have_posts()) :
                while ($query->have_posts()) : $query->the_post();
                    get_template_part('loop_template/loop', 'item_service');
                endwhile;
                wp_reset_postdata();
            endif;
            ?>
        </div>
    </div>
</section>
