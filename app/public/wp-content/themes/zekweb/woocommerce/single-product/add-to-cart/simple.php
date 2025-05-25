<?php
/**
 * Simple product add to cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/add-to-cart/simple.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.0.1
 */

defined( 'ABSPATH' ) || exit;

global $product;

if ( ! $product->is_purchasable() ) {
	return;
}

echo wc_get_stock_html( $product ); // WPCS: XSS ok.

if ( $product->is_in_stock() ) : ?>

	<?php do_action( 'woocommerce_before_add_to_cart_form' ); ?>
	

	<form class="cart" action="<?php echo esc_url( apply_filters( 'woocommerce_add_to_cart_form_action', $product->get_permalink() ) ); ?>" method="post" enctype='multipart/form-data'>
	<?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>
		
		<?php
		do_action( 'woocommerce_before_add_to_cart_quantity' );

		woocommerce_quantity_input(
			array(
				'min_value'   => apply_filters( 'woocommerce_quantity_input_min', $product->get_min_purchase_quantity(), $product ),
				'max_value'   => apply_filters( 'woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product ),
				'input_value' => isset( $_POST['quantity'] ) ? wc_stock_amount( wp_unslash( $_POST['quantity'] ) ) : $product->get_min_purchase_quantity(), // WPCS: CSRF ok, input var ok.
			)
		);

		do_action( 'woocommerce_after_add_to_cart_quantity' );
		?>


	
		<!-- <button type="submit" name="add-to-cart" value="<?php echo esc_attr( $product->get_id() ); ?>" class="single_add_to_cart_button button alt<?php echo esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ); ?>"><?php echo esc_html( $product->single_add_to_cart_text() ); ?></button> -->

		<?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>
	
	</form>

	<?php do_action( 'woocommerce_after_add_to_cart_form' ); ?>
	<?php
	$cart_url = wc_get_cart_url();
	$add_to_cart_url = esc_url( add_query_arg( array(
		'add-to-cart' => $product->get_id()
	), $cart_url ) );
	?>
	<div class="button-buy-now d-block d-md-none">
		<a href="<?php echo $add_to_cart_url; ?>" class="btn-buy-now">Mua ngay</a>
	</div>

	<!-- ajax add to cart -->
	<div class="button-add-to-cart-mobile d-block d-md-none">
		<?php
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

	<?php
	$product_offers = get_field('product_offers', 'option');
	$i = 0;
	?>
	<div class="section-product-offers detail-product-offers">
			<div class="row">
					<?php foreach ($product_offers as $product_offer) : ?>
							<div class="col-6 col-lg-3">
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
<?php endif; ?>

	<!-- button buy now add to cart redirect to cart -->
	
	<div class="button-buy-now d-none d-md-block">
		<a href="<?php echo $add_to_cart_url; ?>" class="btn-buy-now">Mua ngay</a>
	</div>


