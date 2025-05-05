<?php 
$background = get_field('sec2_bg', 'option');
$bgImg = get_field('sec2_bg_img', 'option');
$img = get_field('sec2_img', 'option');
$title = get_field('sec2_title', 'option');
$description = get_field('sec2_desc', 'option');
$btn = get_field('sec2_btn', 'option');

?>
<section class="section-story" style="background-image: url(<?php echo $background; ?>); background-repeat: no-repeat; background-size: cover;">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="story-image col-12 col-lg-5" style="background-image: url(<?php echo $bgImg; ?>);">
                <img src="<?php echo $img; ?>" alt="Story Image">
            </div>
            <div class="story-content col-12 col-lg-7">
                <h3 class="story-title mb-4"><?php echo $title; ?></h3>
                <div class="story-description">
                    <?php echo $description; ?>
                </div>
                <?php if ($btn) : ?>
                    <a href="<?php echo $btn[0]['url']; ?>" class="btn-common story-btn mt-5"><?php echo $btn[0]['text']; ?></a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
