<?php
$banners_pc = get_field('banners', 'option');
$banners_mb = get_field('banners_mb', 'option');

if (wp_is_mobile()) {
    $banners = $banners_mb;
} else {
    $banners = $banners_pc; 
}

$i = 0;

// Determine if margin style should be applied
$margin_style = '';
if (!(is_home() || is_front_page())) {
    $margin_style = ' style="margin-bottom: 5rem;"';
}
?>
<div class="banner-section"<?php echo $margin_style; ?>>
  <div class="swiper-container">
    <div class="swiper slider-hero">
        <div class="swiper-wrapper">
            <?php foreach ($banners as $banner) : ?>
            <div class="swiper-slide">
                <img class="img-desktop d-none d-md-block" src="<?php echo $banner['img']; ?>" alt="slider-hero-<?php echo $i; ?>" loading="lazy">
                <img class="img-mobile d-md-none" src="<?php echo $banner['img']; ?>" alt="slider-hero-<?php echo $i; ?>" loading="lazy">
            </div>
            <?php $i++; endforeach; ?>
        </div>
        <div class="swiper-pagination"></div>
    </div>
  </div>
</div>
