<?php
$background = get_field('sec2_bg', 'option');
$backgroundLeft = get_field('sec2_bg_left', 'option');
$bgImg = get_field('sec2_bg_img', 'option');
$img = get_field('sec2_img', 'option');
$title = get_field('sec2_title', 'option');
$title_mb = get_field('sec2_title_mb', 'option');
$description = get_field('sec2_desc', 'option');
$btn = get_field('sec2_btn', 'option');
?>

<section class="section-story full-width">
  <div class="story-main">
    <div class="section-story__bg">
      <figure class="bg-left">
        <img src="<?php echo $backgroundLeft; ?>" alt="story-image-bg" loading="lazy">
      </figure>
      <figure class="bg-right">
        <img src="<?php echo $background; ?>" alt="story-image-bg" loading="lazy">
      </figure>
    </div>

    <div class="container">
      <div class="row">
        <div class="story-image col-12 col-lg-5" data-aos="fade-right" data-aos-duration="1000">
          <figure class="story-image__bg">
            <img src="<?php echo $bgImg; ?>" alt="story-image-bg" loading="lazy">
          </figure>

          <figure class="story-image__img">
              <img src="<?php echo $img; ?>" alt="story-image" loading="lazy">
          </figure>
        </div>

        <div class="story-content col-12 col-lg-7" data-aos="fade-left" data-aos-duration="1000">
          <?php
          if ($title) :
              echo '<h3 class="d-none d-lg-block story-title mb-1 mb-md-4">' . $title . '</h3>';
          endif; 
          ?>

          <?php
          if ($title_mb) :
              echo '<h3 class="d-block d-lg-none story-title mb-3">' . $title_mb . '</h3>';
          endif; 
          ?>

          <?php
          if ($description) :
              echo '<div class="story-description">' . $description . '</div>';
          endif;
          ?>

          <?php
          if ($btn) :
              echo '<div class="d-flex justify-content-center justify-content-md-start"><a href="' . $btn[0]['url'] . '" class="btn-hightlight bora-1 mt-1 mt-md-5">' . $btn[0]['text'] . '</a></div>';
          endif;
          ?>
        </div>
      </div>
    </div>
  </div>
</section>