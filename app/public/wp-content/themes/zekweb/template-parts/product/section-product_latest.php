<?php
    $title = isset($args['title']) ? $args['title'] : 'Sản phẩm mới ra mắt';
?>
<div class="product-slider-section">
    <div class="heading-wrapper" data-aos="fade-in" data-aos-duration="1000">
        <figure class="icon-image">
            <img src="<?php bloginfo('template_url'); ?>/assets/images/twinkle.png" alt="">
        </figure>
        <h2 class="section-heading fs-48"><?= esc_html($title) ?></h2>
    </div>

    <div class="container">
        <div class="swiper products-latest">
            <div class="swiper-wrapper">
                <!-- get latest product -->
                <?php
                $args = array(
                    'post_type' => 'product',
                    'posts_per_page' => 10,
                    'orderby' => 'date',
                    'order' => 'DESC',
                    'post_status' => 'publish',
                );
                $latest_products = new WP_Query($args);
                if ($latest_products->have_posts()) :
                    while ($latest_products->have_posts()) : $latest_products->the_post();
                    ?>
                        <div class="swiper-slide">
                            <div class="slider-content">
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
                        </div>
                    <?php
                    endwhile;
                endif;
                ?>
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </div>
</div>