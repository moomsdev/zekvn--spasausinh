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
<div <?php wc_product_class( 'item-product', $product ); ?>>
	<div class="img">
		<a href="<?php the_permalink()?>" title="<?php the_title(); ?>"><?php the_post_thumbnail('large', array('alt'   => trim(strip_tags( $post->post_title )),'title' => trim(strip_tags( $post->post_title )),)); ?></a>
	</div>
	<div class="info">
		<h3 class="name"><a href="<?php the_permalink()?>"><?php the_title(); ?></a></h3>
		<?php wc_get_template( 'loop/price.php' ); ?>
	</div>
</div>