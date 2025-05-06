<?php
/**
 * Single Product title
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/title.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see        https://woocommerce.com/document/template-structure/
 * @package    WooCommerce\Templates
 * @version    1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

the_title( '<h1 class="product_title entry-title">', '</h1>' );
?>
<div class="product-status">
	<div class="status">
			<span class="status-label">Tình trạng:</span>
			<span class="status-value">
				<!-- kiểm tra kho còn hàng hay hết hàng -->
				<?php
				$product_id = get_the_ID();
				$stock_quantity = get_post_meta($product_id, '_stock', true);
				if ($stock_quantity > 0) {
					echo 'Còn hàng';
				} else {
					echo 'Hết hàng';
				}
				?>

			</span>
	</div>

	<div class="star-review">
		<figure>
			<img src="<?php echo get_template_directory_uri(); ?>/assets/images/star-review-product.png" alt="star" loading="lazy">
		</figure>
	</div>
</div>

