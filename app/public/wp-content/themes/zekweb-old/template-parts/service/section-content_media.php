<?php
$title = isset($args['title']) ? $args['title'] : 'Tiêu đề mặc định';
$short_description = $args['short_description'];
$content_media = $args['content_media'];
?>

<section class="content-media">
    <div class="container">
        <?php if ($title) : ?>
            <div class="heading-wrapper" data-aos="fade-in" data-aos-duration="1000">
                <h2 class="section-heading fs-48"><?php echo $title; ?></h2>
                <figure class="icon-image">
                    <img src="<?php bloginfo('template_url'); ?>/assets/images/heading-icon.png" alt="">
                </figure>
            </div>
        <?php endif; ?>

        <?php if ($short_description) : ?>
            <div class="description">
                <?php echo $short_description; ?>
            </div>
        <?php endif; ?>
    </div>
    
    <?php
    if ($content_media) :
        foreach ($content_media as $item) :
    ?>
    <div class="main-content bg-content">
        <div class="container">
            <div class="row">
                <div class="col-lg-7 col-12 mb-3">
                    <h4 class="section-title"><?php echo $item['title']; ?></h4>
                    <div class="content">
                        <?php echo $item['content']; ?>
                    </div>
                </div>
                
                <div class="col-lg-5 col-12 text-center">
                    <figure class="icon-image">
                        <img src="<?php echo $item['img'] ?>" alt="">
                    </figure>
                </div>
            </div>
            </div>
        </div>
    <?php 
    endforeach;
    endif;
    ?>
</section>