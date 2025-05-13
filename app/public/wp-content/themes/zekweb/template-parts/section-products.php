<?php
$title = get_field('sec8_title', 'option');
$desc = get_field('sec8_desc', 'option');
$catProduct = get_field('sec8_cat_product', 'option');

$categories = [];
if ($catProduct && is_array($catProduct)) {
    foreach ($catProduct as $cat_id) {
        $cat = get_term($cat_id, 'product_cat');
        if ($cat && !is_wp_error($cat)) {
            $categories[] = $cat;
        }
    }
}
?>

<section class="section-products">
    <div class="container">
        <?php get_template_part('loop_template/loop', 'heading_section', ['title' => $title]) ?>

        <ul class="nav mt-5 mb-3 justify-content-center" id="products-tab" role="tablist">
            <?php foreach ($categories as $i => $cat): ?>
                <li class="nav-item" role="presentation">
                    <button class="nav-link <?php if($i==0) echo 'active'; ?>" id="products-tab-<?php echo $cat->term_id; ?>" data-bs-toggle="pill" data-bs-target="#products-<?php echo $cat->term_id; ?>" type="button" role="tab" aria-controls="products-<?php echo $cat->term_id; ?>" aria-selected="<?php echo $i==0 ? 'true' : 'false'; ?>">
                        <?php echo esc_html($cat->name); ?>
                    </button>
                </li>
            <?php endforeach; ?>
        </ul>

        <div class="tab-content" id="products-tab-content">
            <?php foreach ($categories as $i => $cat): ?>
                <div class="tab-pane fade <?php if($i==0) echo 'show active'; ?>" id="products-<?php echo $cat->term_id; ?>" role="tabpanel" aria-labelledby="products-tab-<?php echo $cat->term_id; ?>">
                    <?php
                    $child_cats = get_terms([
                        'taxonomy' => 'product_cat',
                        'parent' => $cat->term_id,
                        'hide_empty' => false,
                    ]);
                    ?>
                    <?php if ($child_cats && !is_wp_error($child_cats) && count($child_cats) > 0): ?>
                        <?php foreach ($child_cats as $child): ?>
                            <div class="row g-4 align-items-start mt-5 <?php echo array_search($child, $child_cats) % 2 == 1 ? 'flex-row-reverse' : ''; ?>">
                                <div class="col-md-4 col-lg-4 col-12 product-banner">
                                    <?php
                                    $thumbnail_id = get_term_meta($child->term_id, 'thumbnail_id', true);
                                    $image_url = wp_get_attachment_url($thumbnail_id);
                                    ?>
                                    <figure>
                                        <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($child->name); ?>" class="img-fluid rounded">
                                    </figure>
                                </div>
                                <div class="col-md-8 col-lg-8 col-12">
                                    <div class="row g-5">
                                        <?php
                                        $query = new WP_Query([
                                            'post_type' => 'product',
                                            'posts_per_page' => 6,
                                            'tax_query' => [
                                                [
                                                    'taxonomy' => 'product_cat',
                                                    'field' => 'term_id',
                                                    'terms' => $child->term_id,
                                                ]
                                            ]
                                        ]);
                                        if ($query->have_posts()):
                                            while ($query->have_posts()): $query->the_post(); ?>
                                                <div class="col-md-6 col-lg-4 col-6">
                                                    <div class="product-card">
                                                        <figure>
                                                            <img loading="lazy" decoding="async"
                                                                src="<?php the_post_thumbnail_url('large', array('class' => 'img-news', 'alt' => trim(strip_tags($post->post_title)), 'title' => trim(strip_tags($post->post_title)))) ?>"
                                                                alt="<?php the_title() ?>">
                                                        </figure>
                                                        <div class="product-info-box">
                                                            <h5 class="product-name"><a href="<?php the_permalink() ?>"><?php the_title() ?></a></h5>
                                                            
                                                            <?php
                                                            $price = get_post_meta(get_the_ID(), '_price', true);
                                                            if (!empty($price)) {
                                                                wc_get_template('loop/price.php');
                                                            } else {
                                                                echo '<span class="price">Liên hệ</span>';
                                                            }
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endwhile;
                                            wp_reset_postdata();
                                        else: ?>
                                            <div class="col-12">Không có sản phẩm nào.</div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-center">
                                    <a href="<?php echo get_term_link($child); ?>" class="btn-hightlight rounded-4">XEM TẤT CẢ</a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="row g-4 align-items-start mt-5">
                            <div class="col-md-4 col-lg-4 col-12 product-banner">
                                <?php
                                $thumbnail_id = get_term_meta($cat->term_id, 'thumbnail_id', true);
                                $image_url = wp_get_attachment_url($thumbnail_id);
                                ?>
                                <figure>
                                    <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($cat->name); ?>" class="img-fluid rounded">
                                </figure>
                            </div>
                            <div class="col-md-8 col-lg-8 col-12">
                                <div class="row g-5">
                                    <?php
                                    $query = new WP_Query([
                                        'post_type' => 'product',
                                        'posts_per_page' => 6,
                                        'tax_query' => [
                                            [
                                                'taxonomy' => 'product_cat',
                                                'field' => 'term_id',
                                                'terms' => $cat->term_id,
                                            ]
                                        ]
                                    ]);
                                    if ($query->have_posts()):
                                        while ($query->have_posts()): $query->the_post(); ?>
                                            <div class="col-md-6 col-lg-4 col-6">
                                                <div class="product-card">
                                                    <figure>
                                                        <img loading="lazy" decoding="async"
                                                            src="<?php the_post_thumbnail_url('large', array('class' => 'img-news', 'alt' => trim(strip_tags($post->post_title)), 'title' => trim(strip_tags($post->post_title)))) ?>"
                                                            alt="<?php the_title() ?>">
                                                    </figure>
                                                    <div class="product-info-box">
                                                        <h5 class="product-name"><a href="<?php the_permalink() ?>"><?php the_title() ?></a></h5>
                                                        
                                                        <?php
                                                        $price = get_post_meta(get_the_ID(), '_price', true);
                                                        if (!empty($price)) {
                                                            wc_get_template('loop/price.php');
                                                        } else {
                                                            echo '<span class="price">Liên hệ</span>';
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endwhile;
                                        wp_reset_postdata();
                                    else: ?>
                                        <div class="col-12">Không có sản phẩm nào.</div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="d-flex justify-content-center">
                                <a href="<?php echo get_term_link($cat); ?>" class="btn-hightlight rounded-4">XEM TẤT CẢ</a>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>