<?php get_header();wp_reset_query();  $format = get_post_format();?>
<?php $term_list = wp_get_post_terms($post->ID, 'category', array("fields" => "ids"));$a=$post->ID; ?>
<?php while (have_posts()) : the_post(); setPostViews($post->ID);?>
<?php global $product; ?>
<main id="main">
  <?php get_template_part('loop_template/breadcrums'); ?>
    <div class="page-body single-blog">
        <div class="container">
                <div class="main-content">
                    <div class="row">
                        <div class="col-12 d-none d-lg-block col-lg-3 single-related">
                            <?php 
                            $products_related = get_field('products_related', get_the_ID());
                            if($products_related) : ?>
                                <div class="single-related-box">
                                    <h2 class="section-title">Sản phẩm liên quan</h2>
                                    <div class="post-related">
                                        <?php foreach($products_related as $product_related) : ?>
                                            <div class="item">
                                                <figure>
                                                    <a href="<?php echo get_the_permalink($product_related); ?>">
                                                    <img src="<?php echo get_the_post_thumbnail_url($product_related, 'full'); ?>" alt="<?php the_title(); ?>" loading="lazy">
                                                    </a>
                                                </figure>
                                                <div class="body">
                                                    <h3><a class="title" href="<?php echo get_the_permalink($product_related); ?>"><?php echo get_the_title($product_related); ?></a></h3>
                                                        <?php 
                                                        $product_obj = wc_get_product($product_related);
                                                        if($product_obj) {
                                                            echo $product_obj->get_price_html();
                                                        } else {
                                                            echo 'Liên hệ';
                                                        }
                                                        ?>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="col-12 col-lg-6">
                            <!-- <div class="category text-center mt-2 mt-lg-4 text-uppercase"><?php //echo get_the_category(get_the_ID())[0]->name; ?></div> -->
                            <h1 class="page-title mt-2 mt-lg-4 text-uppercase"><?php the_title();?></h1>
                            <div class="date mt-1 mt-lg-2">Ngày đăng: <?php echo get_the_date('d/m/Y'); ?></div>
                            
                            <!-- <figure class="post-image mt-2 mt-lg-4">
                                <?php //the_post_thumbnail('full'); ?>
                            </figure> -->

                            <div class="page-content mt-2 mt-lg-4">
                                <div class="content-post clearfix">
                                    <?php the_content(); ?>
                                </div>
                            </div>
                        </div>
                        <!-- post related -->
                        <div class="col-12 col-lg-3 single-related">
                            <div class="single-related-box">
                                <h2 class="section-title">Bài viết liên quan</h2>
                                <?php
                                $categories = get_the_category(get_the_ID());
                                if ($categories){
                            
                                $category_ids = array();
                                foreach($categories as $individual_category) {
                                    $category_ids[] = $individual_category->term_id;
                                }
                                $posts_per_page = wp_is_mobile() ? 5 : 5;
                                $args=array(
                                    'category__in' => $category_ids,
                                    'post__not_in' => array(get_the_ID()),
                                    'posts_per_page' => $posts_per_page,
                                );
                                $my_query = new wp_query($args);
                                if( $my_query->have_posts() ): 
                                ?>
                                <div class="post-related">
                                    <?php while ($my_query->have_posts()):$my_query->the_post(); ?>
                                        <div class="item">
                                            <figure>
                                                <a href="<?php the_permalink(); ?>">
                                                <?php the_post_thumbnail('large', ['alt' => get_the_title()]); ?>
                                                </a>
                                            </figure>
                                            <!-- <div class="body"> -->
                                                <a class="title" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                                <!-- <p class="description">
                                                    <?php //echo get_the_excerpt(); ?>
                                                </p> -->
                                            <!-- </div> -->
                                        </div>
                                    <?php endwhile; ?>
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
            </div>
        </div>
    </div>
</main>
<?php endwhile; ?>
<?php get_footer(); ?>