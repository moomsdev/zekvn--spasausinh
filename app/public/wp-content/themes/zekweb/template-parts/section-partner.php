<?php
$title = get_field('sec12_title', 'option');
$partnerList = get_field('sec12_partner', 'option');
?>

<section class="section-partner">
    <?php get_template_part('loop_template/loop', 'heading_section', ['title' => $title]) ?>
    <div class="row g-3">
      <?php 
      foreach ($partnerList as $partner) :
          $partner_logo = $partner['logo'];
          $partner_url = $partner['url'];
      ?>
          <div class="col-6 col-md-3 d-flex justify-content-center align-items-center">
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
</section>
