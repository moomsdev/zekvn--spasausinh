<?php
/*
Template Name: Trang chủ
 */
?>
<?php get_header(); ?>

<main id="main">
  <?php
  // Slider hero
  get_template_part('template-parts/section', 'slider_hero');

  //overview
  get_template_part('template-parts/section','overview');

  //story
  get_template_part('template-parts/section', 'story');
  
  //video
  get_template_part('template-parts/section', 'video');

  //blog
  get_template_part('template-parts/section', 'blog');

  //service
  get_template_part('template-parts/section', 'service');

  //why us
  get_template_part('template-parts/section', 'why_us');

  //testimonials
  get_template_part('template-parts/section', 'testimonials');

  //products
 //  get_template_part('template-parts/section', 'products');

  //highlights
  get_template_part('template-parts/section', 'highlights');

  //video library
  get_template_part('template-parts/section', 'video_library');
  
  //Branch
  get_template_part('template-parts/section', 'branch');

  //partner
  get_template_part('template-parts/section', 'partner');

  //  //products slider
  //  get_template_part('template-parts/section','products_slider');
  //  //logo slider
  //  get_template_part('template-parts/section','logo_slider');
  //  //materials slider
  //  get_template_part('template-parts/section','materials_slider');
   ?>
</main>

<?php get_footer(); ?>