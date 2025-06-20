<?php
$title = get_field('sec5_title', 'option');
$services = get_field('sec5_post_service', 'option');
?>
<?php if ($services) : ?>

<section class="section-service frame-shadow">
    <div class="container">
        <?php get_template_part('loop_template/loop', 'heading_section', ['title' => $title]) ?>
        
        <div class="row justify-content-center">
            <?php
            $i = 0;
            foreach ($services as $post) :
            ?>
              <div class="col-6 col-lg-3 loop-service">
                <div class="loop-inner h-100 d-flex flex-column">
                    <figure class="loop-image">
                      <a href="<?php echo get_the_permalink($post); ?>">  
                        <img src="<?php echo get_the_post_thumbnail_url($post); ?>" alt="<?php echo get_the_title($post); ?>" loading="lazy">
                      </a>
                  </figure>
                  <div class="heading-wrapper flex-grow-1 d-flex align-items-center">
                      <h4 class="loop-heading mb-0">
                          <a href="<?php echo get_the_permalink($post); ?>"><?php echo get_the_title($post); ?></a>
                      </h4>
                  </div>
                </div>
              </div>
            <?php
            $i++;
            endforeach;
            ?>
        </div>
    </div>
</section>
<?php endif; ?>