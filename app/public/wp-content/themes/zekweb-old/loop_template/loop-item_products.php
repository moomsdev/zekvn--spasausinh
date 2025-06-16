<?php
$product_image = get_the_post_thumbnail_url(get_the_ID(), 'full');
$product_link = get_the_permalink(get_the_ID());
$product_price
?>
<div class="product-card">
    <figure>
        <img src="<?php echo $product_image ?>" alt="<?php the_title() ?>" class="img-fluid">
    </figure>
    <div class="product-info-box">
        <div class="product-name"><?php the_title() ?></div>
        
        <?php 
         $price = get_post_meta(get_the_ID(), '_price', true);
         if (!empty($price)) {
             wc_get_template('loop/price.php');
         } else {
             echo '<span class="price">Liên hệ</span>';
         } ?>
    </div>
</div>