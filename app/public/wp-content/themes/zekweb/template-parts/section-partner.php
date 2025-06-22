<?php
$title = get_field('sec12_title', 'option');
$partnerList = get_field('sec12_partner', 'option');
?>

<section class="section-partner">
  <div class="container">
    <?php get_template_part('loop_template/loop', 'heading_section', ['title' => $title]) ?>
    <div class="swiper partner-slider">
      <div class="swiper-wrapper">
        <?php
        foreach ($partnerList as $partner) :
          $partner_logo = $partner['logo'];
          $partner_url = $partner['url'];
        ?>
          <div class="swiper-slide">
            <figure class="partner-logo">
              <?php
              if ($partner_url) :
              ?>
                  <a href="<?php echo $partner_url; ?>" target="_blank">
                      <img src="<?php echo $partner_logo; ?>" alt="partner-logo" loading="lazy">
                  </a>
              <?php else : ?>
                  <img src="<?php echo $partner_logo; ?>" alt="partner-logo" loading="lazy">
              <?php endif; ?>
            </figure>
          </div>
          <?php endforeach; ?>
        </div>
        <div class="partner-next swiper-button-next"></div>
        <div class="partner-prev swiper-button-prev"></div>
      </div>
    </div>
  </div>
</section>
