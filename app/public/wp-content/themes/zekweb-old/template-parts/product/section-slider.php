<?php
$banners = get_field('slider_product_page', 'option');
$i = 0;
?>
<div class="banner-section">
    <div class="section-banner-slide">
        <div class="swiper slider-hero">
            <div class="swiper-wrapper">
                <?php foreach ($banners as $banner) : ?>
                <div class="swiper-slide">
                    <figure class="image-banner">
                        <img src="<?php echo $banner['img']; ?>" alt="slider-hero-<?php echo $i; ?>" loading="lazy">
                    </figure>
                </div>
                <?php $i++; endforeach; ?>
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </div>
</div>
