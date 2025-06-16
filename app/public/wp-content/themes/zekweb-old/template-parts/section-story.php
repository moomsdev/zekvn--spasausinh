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

<section class="section-story" >
  <div class="section-story__bg">
    <figure>
      <img src="<?php echo $backgroundLeft; ?>" alt="" loading="lazy">
    </figure>
    <figure>
      <img src="<?php echo $background; ?>" alt="" loading="lazy">
    </figure>
  </div>
  <div class="story-main">
<!-- <section class="section-story" style="background-image: url(<?php echo $background; ?>); background-repeat: no-repeat; background-size: cover;"> -->
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="story-image col-12 col-lg-5" style="background-image: url(<?php echo $bgImg; ?>);"  data-aos="fade-right" data-aos-duration="1000">
                <img src="<?php echo $img; ?>" alt="Story Image">
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
                    echo '<a href="' . $btn[0]['url'] . '" class="btn-hightlight bora-1 mt-1 mt-md-5">' . $btn[0]['text'] . '</a>';
                endif;
                ?>
            </div>
        </div>
      </div>
    </div>
</section>