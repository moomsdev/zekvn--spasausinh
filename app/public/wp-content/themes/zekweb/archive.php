<?php get_header();
$a = get_query_var('cat'); ?>
<?php $term = get_queried_object(); ?>
<main id="main">
    <div class="page-body">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-12 mb-4">
                    <div class="momneadknow-banner mb-4">
                        <div class="momneadknow-banner__image">
                            <figure>
                                <img src="<?php bloginfo('template_url'); ?>/assets/images/mom1.png" alt="Mom banner">
                            </figure>
                        </div>
                        <a class="momneadknow-banner__title" href="#">Mẹ bầu có được dùng mỹ phẩm không? Hướng dẫn chi tiết và đầy đủ nhất</a>
                        <p class="momneadknow-banner__description">
                            Mang thai là một giai đoạn đặc biệt và nhạy cảm trong cuộc đời người phụ nữ.
                            Trong thời gian này, cơ thể mẹ bầu trải qua hàng loạt thay đổi...
                        </p>
                    </div>
                    <div class="row g-3 g-md-5">
                        <?php get_template_part('loop_template/loop', 'item_momblog') ?>
                        <?php get_template_part('loop_template/loop', 'item_momblog') ?>
                        <?php get_template_part('loop_template/loop', 'item_momblog') ?>
                        <?php get_template_part('loop_template/loop', 'item_momblog') ?>
                        <?php get_template_part('loop_template/loop', 'item_momblog') ?>
                        <?php get_template_part('loop_template/loop', 'item_momblog') ?>
                    </div>
                </div>
                <div class="col-lg-4 col-md-12 d-none d-lg-block">
                    <div class="momneadknow-sidebar mb-5">
                        <div class="momneadknow-sidebar__header">
                            Mẹ cần biết
                        </div>
                        <div class="momneadknow-sidebar__body">
                            <div class="momneadknow-item__item">
                                <figure>
                                    <a href="#">
                                        <img src="<?php bloginfo('template_url'); ?>/assets/images/mom-blog1.png" alt="Mom banner">
                                    </a>
                                </figure>
                                <div>
                                    <a class="momneadknow-sidebar__title" href="#">Muối tắm Bon Bon Home Care: Chăm sóc làn da nhạy cảm của bé từ thiên nhiên</a>
                                    <p class="momneadknow-sidebar__description">Trong hành trình chăm sóc bé yêu, việc lựa chọn sản phẩm an toàn và hiệu quả luôn là ưu tiên hàng đầu</p>
                                </div>
                            </div>
                            <div class="momneadknow-item__item">
                                <figure>
                                    <img src="<?php bloginfo('template_url'); ?>/assets/images/mom-blog1.png" alt="Mom banner">
                                </figure>
                                <div>
                                    <a class="momneadknow-sidebar__title" href="#">Muối tắm Bon Bon Home Care: Chăm sóc làn da nhạy cảm của bé từ thiên nhiên</a>
                                    <p class="momneadknow-sidebar__description">Trong hành trình chăm sóc bé yêu, việc lựa chọn sản phẩm an toàn và hiệu quả luôn là ưu tiên hàng đầu</p>
                                </div>
                            </div>
                            <div class="momneadknow-item__item">
                                <figure>
                                    <img src="<?php bloginfo('template_url'); ?>/assets/images/mom-blog1.png" alt="Mom banner">
                                </figure>
                                <div>
                                    <a class="momneadknow-sidebar__title" href="#">Muối tắm Bon Bon Home Care: Chăm sóc làn da nhạy cảm của bé từ thiên nhiên</a>
                                    <p class="momneadknow-sidebar__description">Trong hành trình chăm sóc bé yêu, việc lựa chọn sản phẩm an toàn và hiệu quả luôn là ưu tiên hàng đầu</p>
                                </div>
                            </div>
                            <div class="momneadknow-item__item">
                                <figure>
                                    <img src="<?php bloginfo('template_url'); ?>/assets/images/mom-blog1.png" alt="Mom banner">
                                </figure>
                                <div>
                                    <a class="momneadknow-sidebar__title" href="#">Muối tắm Bon Bon Home Care: Chăm sóc làn da nhạy cảm của bé từ thiên nhiên</a>
                                    <p class="momneadknow-sidebar__description">Trong hành trình chăm sóc bé yêu, việc lựa chọn sản phẩm an toàn và hiệu quả luôn là ưu tiên hàng đầu</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="momneadknow-sidebar">
                        <div class="momneadknow-sidebar__header">
                            Tin tức
                        </div>
                        <div class="momneadknow-sidebar__body">
                            <div class="momneadknow-item__item">
                                <figure>
                                    <a href="#">
                                        <img src="<?php bloginfo('template_url'); ?>/assets/images/mom-blog1.png" alt="Mom banner">
                                    </a>
                                </figure>
                                <div>
                                    <a class="momneadknow-sidebar__title" href="#">Muối tắm Bon Bon Home Care: Chăm sóc làn da nhạy cảm của bé từ thiên nhiên</a>
                                    <p class="momneadknow-sidebar__description">Trong hành trình chăm sóc bé yêu, việc lựa chọn sản phẩm an toàn và hiệu quả luôn là ưu tiên hàng đầu</p>
                                </div>
                            </div>
                            <div class="momneadknow-item__item">
                                <figure>
                                    <img src="<?php bloginfo('template_url'); ?>/assets/images/mom-blog1.png" alt="Mom banner">
                                </figure>
                                <div>
                                    <a class="momneadknow-sidebar__title" href="#">Muối tắm Bon Bon Home Care: Chăm sóc làn da nhạy cảm của bé từ thiên nhiên</a>
                                    <p class="momneadknow-sidebar__description">Trong hành trình chăm sóc bé yêu, việc lựa chọn sản phẩm an toàn và hiệu quả luôn là ưu tiên hàng đầu</p>
                                </div>
                            </div>
                            <div class="momneadknow-item__item">
                                <figure>
                                    <img src="<?php bloginfo('template_url'); ?>/assets/images/mom-blog1.png" alt="Mom banner">
                                </figure>
                                <div>
                                    <a class="momneadknow-sidebar__title" href="#">Muối tắm Bon Bon Home Care: Chăm sóc làn da nhạy cảm của bé từ thiên nhiên</a>
                                    <p class="momneadknow-sidebar__description">Trong hành trình chăm sóc bé yêu, việc lựa chọn sản phẩm an toàn và hiệu quả luôn là ưu tiên hàng đầu</p>
                                </div>
                            </div>
                            <div class="momneadknow-item__item">
                                <figure>
                                    <img src="<?php bloginfo('template_url'); ?>/assets/images/mom-blog1.png" alt="Mom banner">
                                </figure>
                                <div>
                                    <a class="momneadknow-sidebar__title" href="#">Muối tắm Bon Bon Home Care: Chăm sóc làn da nhạy cảm của bé từ thiên nhiên</a>
                                    <p class="momneadknow-sidebar__description">Trong hành trình chăm sóc bé yêu, việc lựa chọn sản phẩm an toàn và hiệu quả luôn là ưu tiên hàng đầu</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<?php get_footer(); ?>