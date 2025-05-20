<?php get_header();wp_reset_query();  $format = get_post_format();?>
<?php $term_list = wp_get_post_terms($post->ID, 'category', array("fields" => "ids"));$a=$post->ID; ?>
<?php while (have_posts()) : the_post(); setPostViews($post->ID);?>
<main id="main">
  <?php get_template_part('loop_template/breadcrums'); ?>
    <div class="page-body single-blog">
        <div class="container">
                <div class="main-content">
                    <div class="category text-center mt-2 mt-lg-4 text-uppercase"><?php echo get_the_category(get_the_ID())[0]->name; ?></div>
                    <h1 class="page-title text-center mt-2 mt-lg-4"><?php the_title();?></h1>
                    <div class="date text-center mt-2 mt-lg-4"><strong><?php echo get_the_date('M d, Y'); ?></strong></div>
                    
                    <figure class="post-image mt-2 mt-lg-4">
                        <?php the_post_thumbnail('full'); ?>
                    </figure>

                    <div class="page-content mt-5">
                        <div class="content-post clearfix">
                            <?php the_content(); ?>
                        </div>
                    </div>

                    <?php
                    $categories = get_the_category(get_the_ID());
                    if ($categories){
                    
                        $category_ids = array();
                        foreach($categories as $individual_category) {
                            $category_ids[] = $individual_category->term_id;
                        }
                        $posts_per_page = wp_is_mobile() ? 4 : 3;
                        $args=array(
                            'category__in' => $category_ids,
                            'post__not_in' => array(get_the_ID()),
                            'posts_per_page' => $posts_per_page,
                        );
                        $my_query = new wp_query($args);
                        if( $my_query->have_posts() ): 
                    ?>
                            <div class="single-related mt-3 mt-lg-5 mb-3 mb-lg-5">
                                <div class="section-title">Bài viết liên quan</div>
                                <div class="row">
                                    <?php while ($my_query->have_posts()):$my_query->the_post(); ?>
                                    <div class="col-lg-4 col-6">
                                    <div class="momneadknow-blog">
                                        <figure>
                                            <a href="<?php the_permalink(); ?>">
                                            <?php the_post_thumbnail('large', ['alt' => get_the_title()]); ?>
                                            </a>
                                        </figure>
                                        <div class="momneadknow-blog__body">
                                            <a class="momneadknow-blog__title" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                            <p class="momneadknow-blog__description">
                                                <?php echo get_the_excerpt(); ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                    <?php endwhile; ?>
                                </div>  
                            </div>
                    <?php
                        endif; 
                        wp_reset_query();
                    } 
                    ?>
                </div>
            </div>
        </div>
    </div>
</main>
<?php endwhile; ?>
<?php get_footer(); ?>