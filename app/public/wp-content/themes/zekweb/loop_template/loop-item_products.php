<?php
$product_image = get_the_post_thumbnail_url(get_the_ID(), 'full');
$product_link = get_the_permalink(get_the_ID());
$product_price
?>
<div class="product-card">
    <figure>
        <img src="<?php echo $product_image ?>" alt="Product 1" class="img-fluid">
    </figure>
    <div class="product-info-box">
        <div class="product-name"><?php the_title() ?></div>
        
        <?php wc_get_template('loop/price.php'); ?>
    </div>
</div>