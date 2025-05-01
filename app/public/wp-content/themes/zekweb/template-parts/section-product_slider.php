<div class="product-slider-section">
    <?php
        $title = isset($args['title']) ? $args['title'] : 'Sản phẩm mới ra mắt';
        ?>
    <div class="heading-wrapper" data-aos="fade-in" data-aos-duration="1000">
        <figure class="icon-image">
            <img src="<?php bloginfo('template_url'); ?>/assets/images/twinkle.png" alt="">
        </figure>
        <h2 class="section-heading fs-48"><?= esc_html($title) ?></h2>
    </div>
    <div class="blog-content">
        <div class="container">
            <div class="swiper product-slider">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <div class="slider-content">
                            <?php get_template_part('loop_template/loop', 'item_products') ?>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="slider-content">
                            <?php get_template_part('loop_template/loop', 'item_products') ?>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="slider-content">
                            <?php get_template_part('loop_template/loop', 'item_products') ?>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="slider-content">
                            <?php get_template_part('loop_template/loop', 'item_products') ?>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="slider-content">
                            <?php get_template_part('loop_template/loop', 'item_products') ?>
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="slider-content">
                            <?php get_template_part('loop_template/loop', 'item_products') ?>
                        </div>
                    </div>
                </div>
                <div class="swiper-pagination"></div>
            </div>
        </div>
    </div>
</div>
