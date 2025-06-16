<?php get_header();
$a = get_query_var('cat'); ?>
<?php $term = get_queried_object(); ?>
<?php $category = get_field('category', "option"); ?>
<main id="main">
    <div class="page-body">
      <?php get_template_part('loop_template/breadcrums'); ?>
        <div class="container">
            <?php
            // $all_categories = get_terms([
            //     'taxonomy' => 'category',
            //     'hide_empty' => false, // true nếu chỉ muốn hiển thị danh mục có sản phẩm
            // ]);
            // if (!empty($all_categories) && !is_wp_error($all_categories)) : ?>
                <ul class="all-categories">
                    <?php 
                    $current_cat_id = get_queried_object_id();
                    foreach ($category as $i => $cat_id):
                        $term = get_term($cat_id, 'category');
                        if (!is_wp_error($term) && $term):
                    ?>
                        <li class="all-categories__item <?php echo ($term->term_id == $current_cat_id) ? 'active' : ''; ?>">
                            <a href="<?php echo get_term_link($term); ?>">
                                <?php echo esc_html($term->name); ?>
                            </a>
                        </li>
                    <?php 
                        endif;
                    endforeach; 
                    ?>
                </ul>
            <?php //endif; ?>
            <div class="row">
                <div class="col-lg-8 col-md-12 mb-4">
    <?php 
    if (have_posts()) {
        $post_count = 0;
        while (have_posts()) : the_post(); 
            $post_count++;
            setPostViews(get_the_ID());

            if ($post_count === 1) : ?>
                <div class="momneadknow-banner mb-4">
                    <div class="momneadknow-banner__image">
                        <figure>
                            <a href="<?php the_permalink(); ?>">
                                <?php the_post_thumbnail('large', ['alt' => get_the_title()]); ?>
                            </a>
                        </figure>
                    </div>
                    <a class="momneadknow-banner__title" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    <p class="momneadknow-banner__description">
                        <?php echo get_the_excerpt(); ?>
                    </p>
                </div>

                <div class="row g-3 g-md-5 row-archive-blog">
            <?php else : ?>
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
            <?php endif;
        endwhile; 
        ?>
                </div> <!-- .row-archive-blog -->

        <!-- Pagination -->
        <div class="pagination-container mt-5">
            <?php wp_pagenavi(); ?>
        </div>
        <!-- End Pagination -->

    <?php } ?>
</div> <!-- .col-lg-8 -->
                
                <div class="col-lg-4 col-md-12 d-none d-lg-block">
                    <?php
                    $current_cat_id = get_queried_object_id();
                    $other_cats = get_terms([
                        'taxonomy' => 'category',
                        'exclude' => [$current_cat_id],
                        'number' => 2,
                        'hide_empty' => false,
                    ]);
                    if (!empty($other_cats) && !is_wp_error($other_cats)) :
                        foreach ($other_cats as $cat) :
                    ?>
                        <div class="momneadknow-sidebar mb-5">
                            <div class="momneadknow-sidebar__header">
                                <?php echo esc_html($cat->name); ?>
                            </div>
                            <div class="momneadknow-sidebar__body">
                                <?php
                                $posts = get_posts([
                                    'category' => $cat->term_id,
                                    'posts_per_page' => 4,
                                ]);
                                foreach ($posts as $post) :
                                    setup_postdata($post);
                                ?>
                                    <div class="momneadknow-item__item">
                                        <figure>
                                            <a href="<?php the_permalink(); ?>">
                                                <img src="<?php the_post_thumbnail_url('large', ['alt' => get_the_title()]); ?>" alt="<?php echo get_the_title(); ?>">
                                            </a>
                                        </figure>
                                        <div>
                                            <a class="momneadknow-sidebar__title" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                            <p class="momneadknow-sidebar__description">
                                                <?php echo get_the_excerpt(); ?>
                                            </p>
                                        </div>
                                    </div>
                                <?php
                                endforeach;
                                wp_reset_postdata();
                                ?>
                            </div>
                        </div>
                    <?php
                        endforeach;
                    endif;
                    ?>
                    
                </div>
            </div>
        </div>
    </div>
</main>

<?php get_footer(); ?>