<?php get_header();wp_reset_query();  $format = get_post_format();?>
<?php $term_list = wp_get_post_terms($post->ID, 'category', array("fields" => "ids"));$a=$post->ID; ?>
<?php while (have_posts()) : the_post(); setPostViews($post->ID);?>
<main id="main">
    <?php get_template_part('breadcrums'); ?>
    <div class="page-body single-blog">
        <div class="container">
            <div class="row row-margin">
                <div class="col-lg-12 col-md-12">
                    <div class="category text-center mt-5 mb-3 text-uppercase"><?php echo get_the_category(get_the_ID())[0]->name; ?></div>
                    <h1 class="page-title text-center mb-5"><?php the_title();?></h1>
                    <div class="date text-center mb-5"><strong><?php echo get_the_date('M d, Y'); ?></strong></div>
                    
                    <figure class="post-image">
                        <?php the_post_thumbnail('full'); ?>
                    </figure>

                    <div class="page-content">
                        <div class="content-post clearfix">
                            <?php the_content(); ?>
                        </div>
                    </div>

                    <!-- <?php
                    $categories = get_the_category(get_the_ID());
                    if ($categories){
                    
                        $category_ids = array();
                        foreach($categories as $individual_category) {
                            $category_ids[] = $individual_category->term_id;
                        }
                        $args=array(
                            'category__in' => $category_ids,
                            'post__not_in' => array(get_the_ID()),
                            'posts_per_page' => 4,
                        );
                        $my_query = new wp_query($args);
                        if( $my_query->have_posts() ): 
                    ?>
                            <div class="single-related">
                                <div class="section-title">Bài viết liên quan</div>
                                <div class="row">
                                    <?php while ($my_query->have_posts()):$my_query->the_post(); ?>
                                    
                                    <?php endwhile; ?>
                                </div>  
                            </div>
                    <?php
                        endif; 
                        wp_reset_query();
                    } 
                    ?> -->
                </div>
            </div>
        </div>
    </div>
</main>
<?php endwhile; ?>
<?php get_footer(); ?>