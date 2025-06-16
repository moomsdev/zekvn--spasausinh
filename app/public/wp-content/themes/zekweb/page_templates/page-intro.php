<?php
/*
Template Name: Giới Thiệu
 */
?>
<?php get_header(); ?>

<main id="main">
    <section class="page-introduce" style="background-image: url(<?php echo get_the_post_thumbnail_url(get_the_ID(), 'full'); ?>);">
        <div class="overlay">
            <div class="heading-wrapper">
                <h2 class="section-heading fs-48 text-white"><?php echo get_the_title(); ?></h2>
                <?php echo wpautop(get_field('short_desc')); ?>
            </div>
        </div>
    </section>

    <?php get_template_part('template-parts/section','overview') ?>

    <section class="intro-section" style="background-image: url(<?php echo get_field('background'); ?>);">
        <div class="intro-content">
            <div class="heading-wrapper">
                <h2 class="section-heading fs-48 text-white"><?php echo get_field('title_story') ?></h2>
                <div class="heading-icon">
                    <figure class="icon-image">
                        <img src="<?php bloginfo('template_url'); ?>/assets/images/heading-icon-white.png" alt="">
                    </figure>
                </div>
                <?php echo wpautop(get_field('story_content')); ?>
            </div>
        </div>
    </section>

    <div class="container py-5 intro-story">
        <?php
        $content_media = get_field('content_media');
        foreach ($content_media as $index => $item) :
        ?>
            <div class="row mb-5 align-items-center <?php echo ($index + 1) % 2 === 0 ? 'd-lg-flex flex-lg-row-reverse flex-row' : ''; ?>">
                <div class="col-lg-7 col-12 content-item">
                    <h4 class="section-title"><?php echo $item['title'] ?></h4>
                    <?php echo wpautop($item['content']) ?>
                </div>
                <div class="col-lg-5 col-12 mt-4 mt-lg-0 mb-4 mb-lg-0 <?php echo ($index + 1) % 2 === 0 ? 'text-center text-lg-start' : 'text-center text-lg-end'; ?>">
                    <figure class="icon-image">
                        <img src="<?php echo $item['img'] ?>" alt="<?php echo $item['title'] ?>">
                    </figure>
                </div>
            </div>
        <?php
        endforeach;
        ?>
   
    </div>

    <?php get_template_part('template-parts/section','video') ?>
</main>

<?php get_footer(); ?>