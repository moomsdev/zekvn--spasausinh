<?php
$title = get_field('material-title', 'option');
$desc = get_field('material-desc', 'option');
$materials = get_field('materials', 'option');
?>

<section class="section-materials full-width">
  <?php get_template_part('loop_template/loop', 'heading_section', array('title' => $title)) ?>
  <div class="section-description">
    <div class="container">
      <?php echo $desc ?>
    </div>
  </div>
  <div class="materials-slider swiper" data-aos="fade-up">
    <div class="materials-lists swiper-wrapper">
      <?php foreach ($materials as $material): ?>
        <div
          class="col-12 col-md-6 col-lg-3 materials-item swiper-slide">
          <div class="materials-card">
            <div class="materials-card-image">
              <figure>
                <img src="<?php echo $material['img'] ?>"
                  alt="<?php echo $material['name'] ?>"
                  class="img-fluid">
              </figure>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
    <div class="swiper-pagination"></div>
  </div>
</section>