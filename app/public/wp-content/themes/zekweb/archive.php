<?php get_header();
$a = get_query_var('cat'); ?>
<?php $term = get_queried_object(); ?>
<main id="main">
    <div class="page-body">
      <?php get_template_part('loop_template/breadcrums'); ?>
        <div class="container">
            <?php
            $all_categories = get_terms([
                'taxonomy' => 'category',
                'hide_empty' => false, // true nếu chỉ muốn hiển thị danh mục có sản phẩm
            ]);
            if (!empty($all_categories) && !is_wp_error($all_categories)) : ?>
                <ul class="all-categories">
                    <?php foreach ($all_categories as $cat) : ?>
                        <li class="all-categories__item <?php echo $cat->term_id == $a ? 'active' : ''; ?>">
                            <a href="<?php echo get_term_link($cat); ?>">
                                <?php echo esc_html($cat->name); ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
            <div class="row">
                <div class="col-lg-8 col-md-12 mb-4">
                    <?php
                    $cat_id = get_queried_object_id();
                    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
                    $args = [
                        'cat' => $cat_id,
                        'posts_per_page' => 7, // Hiển thị 7 bài trên mỗi trang
                        'paged' => $paged,
                    ];
                    $query = new WP_Query($args);
                    if ($query->have_posts()) :
                        $query->the_post();
                    ?>
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
                            <?php while ($query->have_posts()) : $query->the_post(); ?>
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

                        <!-- Pagination -->
                        <div class="pagination-container mt-5">
                            <?php
                            // Calculating total pages based on found posts and posts per page
                            $total_pages = ceil($query->found_posts / $args['posts_per_page']);
                            
                            if ($total_pages > 1) :
                            ?>
                                <div class="pagination-wrapper">
                                    <?php
                                    // Previous page arrow
                                    if (get_query_var('paged') > 1) :
                                        echo '<a href="' . get_pagenum_link(get_query_var('paged') - 1) . '" class="pagination-item pagination-prev">' . __('<<', 'zekweb') . '</a>';
                                    endif;
                                    
                                    // Page numbers
                                    for ($i = 1; $i <= $total_pages; $i++) :
                                        $current_class = (get_query_var('paged', 1) == $i || (get_query_var('paged', 1) == 0 && $i == 1)) ? 'active' : '';
                                        echo '<a href="' . get_pagenum_link($i) . '" class="pagination-item ' . $current_class . '">' . $i . '</a>';
                                    endfor;
                                    
                                    // Next page arrow
                                    if (get_query_var('paged', 1) < $total_pages) :
                                        echo '<a href="' . get_pagenum_link(get_query_var('paged', 1) + 1) . '" class="pagination-item pagination-next">' . __('>>', 'zekweb') . '</a>';
                                    endif;
                                    ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        <!-- End Pagination -->
                    <?php
                        wp_reset_postdata();
                    endif;
                    ?>
                </div>
                
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