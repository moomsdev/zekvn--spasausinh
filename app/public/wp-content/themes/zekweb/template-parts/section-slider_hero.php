<?php
$banners_pc = get_field('banners', 'option');
$banners_mb = get_field('banners_mb', 'option');
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
        <div class="swiper-wrapper d-none d-md-flex">
            <?php foreach ($banners_pc as $banner) : ?>
            <div class="swiper-slide">
              <a href="<?php echo $banner['url']; ?>">
                <img class="img-desktop" src="<?php echo $banner['img']; ?>" alt="slider-hero-<?php echo $i; ?>" loading="lazy">
              </a>
            </div>
            <?php $i++; endforeach; ?>
        </div>
        <div class="swiper-wrapper d-md-none">
            <?php foreach ($banners_mb as $banner) : ?>
            <div class="swiper-slide">
              <a href="<?php echo $banner['url']; ?>">
                <img class="img-mobile" src="<?php echo $banner['img']; ?>" alt="slider-hero-<?php echo $i; ?>" loading="lazy">
              </a>
            </div>
            <?php $i++; endforeach; ?>
        </div>
        <div class="swiper-pagination"></div>
    </div>
  </div>
</div>
