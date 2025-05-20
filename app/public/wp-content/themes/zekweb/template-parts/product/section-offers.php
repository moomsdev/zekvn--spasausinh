<?php
$product_offers = get_field('product_offers', 'option');
$i = 0;
?>
<div class="section-product-offers">
    <div class="container">
        <div class="inner-product-offers">
            <div class="row">
                <?php foreach ($product_offers as $product_offer) : ?>
                    <div class="col-6 col-lg-3 d-flex align-items-center justify-content-md-center justify-content-start">
                        <div class="product-item">
                            <figure class="product-image">
                                <img src="<?php echo $product_offer['icon']; ?>" alt="<?php echo $product_offer['title']; ?>" loading="lazy">
                            </figure>
                            <div class="content-item">
                                <h3 class="product-name"><?php echo $product_offer['title']; ?></h3>
                                <p class="product-desc"><?php echo $product_offer['desc']; ?></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
