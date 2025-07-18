<?php
/*
Template Name: Showroom
 */
?>
<?php get_header(); ?>

<main id="main">
  <?php
  // Slider hero
  get_template_part('template-parts/section', 'slider_showroom');
  
  //Branch
  get_template_part('template-parts/section', 'branch');

  //highlights
  get_template_part('template-parts/section', 'article_showroom');

  //contact
  get_template_part('template-parts/section', 'contact');
  
  //faqs
  // get_template_part('template-parts/section', 'faqs');
  ?>
</main>

<?php get_footer(); ?>