<?php
$banner_featured = get_field('banner_featured', 'option');
?>

<section class="banner-section">
    <div class="container">
        <div class="banner-content">
            <figure class="banner-image">
                <img src="<?php echo $banner_featured; ?>" alt="Banner-featured">
            </figure>
        </div>
    </div>
</section>