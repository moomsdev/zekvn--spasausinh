<?php 
get_header();

while (have_posts()):
    the_post();
    setPostViews($post->ID);
?>

    <main id="main">
        <?php get_template_part('loop_template/breadcrums'); ?>
        <div class="page-body">
            <div class="container">
                <h1 class="page-title"><?php the_title(); ?></h1>
                <div class="page-content">
                    <div class="content-post clearfix">
                        <?php the_content(); ?>
                    </div>
                </div>
            </div>
        </div>
    </main>

<?php
endwhile; 
get_footer();
?>