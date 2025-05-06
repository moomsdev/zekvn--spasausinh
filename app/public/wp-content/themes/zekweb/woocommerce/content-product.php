<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.4.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

// Check if the product is a valid WooCommerce product and ensure its visibility before proceeding.
if ( ! is_a( $product, WC_Product::class ) || ! $product->is_visible() ) {
	return;
}
?>
<div class="col-6 col-lg-3 slider-content text-center">
	<div class="product-card">
		<figure>
			<img loading="lazy" decoding="async"
					src="<?php the_post_thumbnail_url('large', array('class' => 'img-news', 'alt' => trim(strip_tags($post->post_title)), 'title' => trim(strip_tags($post->post_title)))) ?>"
					alt="<?php the_title() ?>">
		</figure>
		<div class="product-info-box">
			<div class="product-name"><a href="<?php the_permalink() ?>"><?php the_title() ?></a></div>
			
			<?php wc_get_template('loop/price.php'); ?>
		</div>
	</div>
	<!-- Add to cart -->
	<?php
	global $product;
	$product_id = $product->get_id();
	$product_sku = $product->get_sku();
	?>
	<a href="?add-to-cart=<?php echo $product_id; ?>" 
	data-quantity="1" 
	class="button product_type_simple add_to_cart_button ajax_add_to_cart custom-add-to-cart" 
	data-product_id="<?php echo $product_id; ?>" 
	data-product_sku="<?php echo $product_sku; ?>" 
	aria-label="Thêm sản phẩm vào giỏ hàng" 
	rel="nofollow">
	Thêm vào giỏ hàng
	</a>
</div>