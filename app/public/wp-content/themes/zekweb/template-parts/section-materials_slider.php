<?php
$title = get_field('title', 'option');
$image = get_field('image', 'option');
?>

<section class="section-materials">
    <div class="heading-wrapper">
        <h2 class="section-heading fs-48">100% Minh bạch nguyên liệu</h2>
        <figure class="icon-image">
            <img src="<?php bloginfo('template_url'); ?>/assets/images/heading-icon.png" alt="heading-icon">
        </figure>
    </div>
    <div class="container materials-slider swiper" data-aos="fade-up">
        <div class="section-description">
            100% sản phẩm Home Care có số công bố chất lượng và kiểm nghiệm theo tiêu chuẩn Bộ Y Tế trước khi lưu hành trên thị trường. Bộ dữ liệu minh bạch là nơi Home Care trung thực công khai mọi thành phần nguyên liệu trong sản phẩm cùng với nguồn gốc, vai trò, công dụng và tỷ lệ an toàn kèm theo.
        </div>
        <div class="materials-lists swiper-wrapper">
            <div class="col-12 col-md-6 col-lg-3 materials-item swiper-slide">
                <?php get_template_part('loop_template/loop', 'item_materials') ?>
            </div>
            <div class="col-12 col-md-6 col-lg-3 materials-item swiper-slide">
                <?php get_template_part('loop_template/loop', 'item_materials') ?>
            </div>
            <div class="col-12 col-md-6 col-lg-3 materials-item swiper-slide">
                <?php get_template_part('loop_template/loop', 'item_materials') ?>
            </div>
            <div class="col-12 col-md-6 col-lg-3 materials-item swiper-slide">
                <?php get_template_part('loop_template/loop', 'item_materials') ?>
            </div>
            <div class="col-12 col-md-6 col-lg-3 materials-item swiper-slide">
                <?php get_template_part('loop_template/loop', 'item_materials') ?>
            </div>
            <div class="col-12 col-md-6 col-lg-3 materials-item swiper-slide">
                <?php get_template_part('loop_template/loop', 'item_materials') ?>
            </div>
            <div class="col-12 col-md-6 col-lg-3 materials-item swiper-slide">
                <?php get_template_part('loop_template/loop', 'item_materials') ?>
            </div>
            <div class="col-12 col-md-6 col-lg-3 materials-item swiper-slide">
                <?php get_template_part('loop_template/loop', 'item_materials') ?>
            </div>
        </div>
        <div class="swiper-pagination"></div>
    </div>
</section>
