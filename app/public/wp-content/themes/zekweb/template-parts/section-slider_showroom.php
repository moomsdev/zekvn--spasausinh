<?php
$banners_pc = get_field('banners_showroom', 'option');
$banners_mb = get_field('banners_showroom_mb', 'option');
$i = 0;
?>
<div class="banner-section">
  <div class="swiper-container">
    <div class="swiper slider-hero">
        <div class="swiper-wrapper d-none d-md-flex">
            <?php foreach ($banners_pc as $banner) : ?>
            <div class="swiper-slide">
                <img class="img-desktop" src="<?php echo $banner['img']; ?>" alt="slider-hero-<?php echo $i; ?>" loading="lazy">
            </div>
            <?php $i++; endforeach; ?>
        </div>
        <div class="swiper-wrapper d-md-none">
            <?php foreach ($banners_mb as $banner) : ?>
            <div class="swiper-slide">
                <img class="img-mobile" src="<?php echo $banner['img']; ?>" alt="slider-hero-<?php echo $i; ?>" loading="lazy">
            </div>
            <?php $i++; endforeach; ?>
        </div>
        <div class="swiper-pagination"></div>
    </div>
  </div>
</div>
