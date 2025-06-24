<?php
/*
Template Name: Giới Thiệu
 */
?>
<?php get_header(); ?>
<main id="main">
  <section class="page-introduce"
    style="background-image: url(<?php echo get_the_post_thumbnail_url(get_the_ID(), 'full'); ?>);">
    <div class="overlay">
      <div class="heading-wrapper">
        <h2 class="section-heading fs-48 text-white">
          <?php echo get_the_title(); ?></h2>
        <?php echo wpautop(get_field('short_desc')); ?>
      </div>
    </div>
  </section>

  <?php get_template_part('template-parts/section', 'overview') ?>

  <section class="intro-section full-width">
    <div class="intro-content">
      <figure class="background-intro d-none d-lg-block">
        <img src="<?php echo get_field('background') ?>" alt="background-image">
      </figure>
      <figure class="background-intro d-lg-none">
        <img src="<?php echo get_field('background_mb') ?>" alt="background-image">
      </figure>

      <div class="container">
        <div class="heading-wrapper">
          <h2 class="section-heading fs-48">
            <?php echo get_field('title_story') ?>
          </h2>
          <?php echo wpautop(get_field('story_content')); ?>
        </div>
      </div>
    </div>
  </section>

  <?php get_template_part('template-parts/section', 'video') ?>

  <div class="container py-5 intro-story">
    <?php
    $content_media = get_field('content_media');
    foreach ($content_media as $index => $item):
      $img = $item['img'];
      $img_mb = $item['img_mb'];
      ?>
      <div
        class="row mb-5 align-items-center <?php echo ($index + 1) % 2 === 0 ? 'd-lg-flex flex-lg-row-reverse flex-row' : ''; ?>">
        <div class="col-lg-7 col-12 content-item">
          <h4 class="section-title"><?php echo $item['title'] ?></h4>
          <?php echo wpautop($item['content']) ?>
        </div>
        <div
          class="col-lg-5 col-12 mt-4 mt-lg-0 mb-4 mb-lg-0 <?php echo ($index + 1) % 2 === 0 ? 'text-center text-lg-start' : 'text-center text-lg-end'; ?>">
          <figure class="icon-image d-none d-md-block">
            <?php if ($img): ?>
            <img src="<?php echo $item['img'] ?>"
              alt="<?php echo $item['title'] ?>">
            <?php endif; ?>
          </figure>

          <figure class="icon-image d-block d-md-none">
            <?php if ($img_mb): ?>
            <img src="<?php echo $img_mb ?>"
              alt="<?php echo $item['title'] ?>">
            <?php else: ?>
              <img src="<?php echo $img ?>"
                alt="<?php echo $item['title'] ?>">
            <?php endif; ?>
          </figure>
        </div>
      </div>
      <?php
    endforeach;
    ?>

  </div>
</main>
<?php get_footer(); ?>