<?php
$title = get_field('brand_title', 'option');
$brand_slider = get_field('exclusive_brand', 'option');
?>
<div class="brand-section mt-5 mt-lg-0">
    <div class="container">
        <?php get_template_part('loop_template/loop', 'heading_section', array('title' => $title)) ?>
        <div class="swiper logo-slider">
            <div class="swiper-wrapper">
                <?php foreach ($brand_slider as $brand) : ?>
                    <div class="swiper-slide">
                        <div class="slider-content">
                        <figure class="loop-image">
                            <a href="<?php echo $brand['url'] ?>" target="_blank">
                              <img src="<?php echo $brand['logo'] ?>" alt="<?php echo $brand['brand_name'] ?>">
                            </a>
                        </figure>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </div>
</div>
