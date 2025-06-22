<?php
$title = get_field('showroom_title', 'option');
$articles = get_field('showroom_articles', 'option');
$i = 0;
?>
<?php if ($articles) : ?>
<section class="section-showroom">
  <div class="container">
    <h2 class="title-showroom text-center"><?php echo esc_html($title); ?></h2>
    <div class="swiper-container">
      <div class="swiper slider-showroom">
          <div class="swiper-wrapper">
              <?php foreach ($articles as $article) : ?>
              <div class="swiper-slide">
                <div class="loop-highlight box">
                  <div class="loop-inner">
                      <figure class="loop-image">
                          <a href="<?php the_permalink($article); ?>">
                              <img src="<?php echo get_the_post_thumbnail_url($article, 'full'); ?>" alt="<?php echo get_the_title($article); ?>" loading="lazy">
                          </a>
                      </figure>

                      <div class="loop-heading-wrapper">
                          <h3 class="loop-heading fs-16"><a href="<?php the_permalink($article); ?>"><?php echo get_the_title($article); ?></a></h3>
                          <p class="loop-desc fs-14"><?php echo get_the_excerpt($article); ?></p>
                      </div>

                      <a href="<?php the_permalink($article); ?>" class="btn-hightlight bora-1">xem thêm</a>
                  </div>
                </div>
              </div>
              <?php $i++; endforeach; ?>
          </div>
          <div class="swiper-pagination"></div>
          <!-- <div class="swiper-button-prev"></div>
          <div class="swiper-button-next"></div> -->
        </div>
      </div>
    </div>
  </div>
</section>
<?php endif;