<?php
$title = get_field('sec8_title', 'option');
$catProduct = get_field('sec8_cat_product', 'option');
?>

<section class="section-products">
    <div class="container">
        <?php get_template_part('loop_template/loop', 'heading_section', ['title' => $title]) ?>

        <ul class="nav mt-5 mb-3 justify-content-center" id="products-tab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="products-home-tab" data-bs-toggle="pill" data-bs-target="#products-home" type="button" role="tab" aria-controls="products-home" aria-selected="true">Sản phẩm cho bé</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="products-profile-tab" data-bs-toggle="pill" data-bs-target="#products-profile" type="button" role="tab" aria-controls="products-profile" aria-selected="false">Sản phẩm cho mẹ</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="products-contact-tab" data-bs-toggle="pill" data-bs-target="#products-contact" type="button" role="tab" aria-controls="products-contact" aria-selected="false">Sản phẩm gia đình</button>
            </li>
        </ul>
        <div class="tab-content" id="products-tab-content">
            <div class="tab-pane fade show active" id="products-home" role="tabpanel" aria-labelledby="products-home-tab">
                <div class="row g-4 align-items-start mt-5">
                    <div class="col-md-4 col-lg-4 col-12 product-banner">
                        <figure>
                            <img src="<?php bloginfo('template_url'); ?>/assets/images/products-banner1.png" alt="Banner 1" class="img-fluid rounded">
                        </figure>
                    </div>
                    <div class="col-md-8 col-lg-8 col-12">
                        <div class="row g-5">
                            <div class="col-md-6 col-lg-4 col-6">
                                <?php get_template_part('loop_template/loop', 'item_products') ?>
                            </div>
                            <div class="col-md-6 col-lg-4 col-6">
                                <?php get_template_part('loop_template/loop', 'item_products') ?>
                            </div>
                            <div class="col-md-6 col-lg-4 col-6">
                                <?php get_template_part('loop_template/loop', 'item_products') ?>
                            </div>
                            <div class="col-md-6 col-lg-4 col-6">
                                <?php get_template_part('loop_template/loop', 'item_products') ?>

                            </div>
                            <div class="col-md-6 col-lg-4 col-6">
                                <?php get_template_part('loop_template/loop', 'item_products') ?>

                            </div>
                            <div class="col-md-6 col-lg-4 col-6">
                                <?php get_template_part('loop_template/loop', 'item_products') ?>

                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center">
                        <a href="#" class="btn-hightlight rounded-4" style="height: 3.5rem; line-height: 1.7;">XEM TẤT CẢ</a>
                    </div>
                </div>
                <div class="row mt-4 g-4 align-items-start flex-row-reverse">
                    <div class="col-md-4 col-lg-4 col-12 product-banner">
                        <figure>
                            <img src="<?php bloginfo('template_url'); ?>/assets/images/products-banner2.png" alt="Banner 2" class="img-fluid rounded">
                        </figure>
                    </div>
                    <div class="col-md-8 col-lg-8 col-12">
                        <div class="row g-5">
                            <div class="col-md-6 col-lg-4 col-6">
                                <?php get_template_part('loop_template/loop', 'item_products') ?>
                            </div>
                            <div class="col-md-6 col-lg-4 col-6">
                                <?php get_template_part('loop_template/loop', 'item_products') ?>
                            </div>
                            <div class="col-md-6 col-lg-4 col-6">
                                <?php get_template_part('loop_template/loop', 'item_products') ?>

                            </div>
                            <div class="col-md-6 col-lg-4 col-6">
                                <?php get_template_part('loop_template/loop', 'item_products') ?>

                            </div>
                            <div class="col-md-6 col-lg-4 col-6">
                                <?php get_template_part('loop_template/loop', 'item_products') ?>

                            </div>
                            <div class="col-md-6 col-lg-4 col-6">
                                <?php get_template_part('loop_template/loop', 'item_products') ?>

                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center">
                        <a href="#" class="btn-hightlight rounded-4" style="height: 3.5rem; line-height: 1.7;">XEM TẤT CẢ</a>
                    </div>
                </div>
                <div class="row mt-4 g-4 align-items-start">
                    <div class="col-md-4 col-lg-4 col-12 product-banner">
                        <figure>
                            <img src="<?php bloginfo('template_url'); ?>/assets/images/products-banner4.png" alt="Banner 4" class="img-fluid rounded">
                        </figure>
                    </div>
                    <div class="col-md-8 col-lg-8 col-12">
                        <div class="row g-5">
                            <div class="col-md-6 col-lg-4 col-6">
                                <?php get_template_part('loop_template/loop', 'item_products') ?>

                            </div>
                            <div class="col-md-6 col-lg-4 col-6">
                                <?php get_template_part('loop_template/loop', 'item_products') ?>

                            </div>
                            <div class="col-md-6 col-lg-4 col-6">
                                <?php get_template_part('loop_template/loop', 'item_products') ?>

                            </div>
                            <div class="col-md-6 col-lg-4 col-6">
                                <?php get_template_part('loop_template/loop', 'item_products') ?>

                            </div>
                            <div class="col-md-6 col-lg-4 col-6">
                                <?php get_template_part('loop_template/loop', 'item_products') ?>

                            </div>
                            <div class="col-md-6 col-lg-4 col-6">
                                <?php get_template_part('loop_template/loop', 'item_products') ?>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center">
                        <a href="#" class="btn-hightlight rounded-4" style="height: 3.5rem; line-height: 1.7;">XEM TẤT CẢ</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>