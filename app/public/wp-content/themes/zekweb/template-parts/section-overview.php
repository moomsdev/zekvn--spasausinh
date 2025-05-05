<?php 
$overview = get_field('sec1_overview', 'option');
?>

<section class="section-overview">
    <div class="container">
        <div class="row">
            <?php foreach ($overview as $item) : ?>
            <div class="col-6 col-md-3 mb-5 mb-md-0" data-aos="fade-up" data-aos-duration="1000">
                <div class="overview-item">
                    <div class="overview-icon">
                        <figure>
                            <img src="<?php echo $item['icon']; ?>" alt="<?php echo $item['numberdata']; ?>" loading="lazy">
                        </figure>
                    </div>
                    <div class="overview-content text-center">
                        <h3 class="overview-title"><?php echo $item['numberdata']; ?></h3>
                        <p class="overview-text"><?php echo $item['data']; ?></p>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
