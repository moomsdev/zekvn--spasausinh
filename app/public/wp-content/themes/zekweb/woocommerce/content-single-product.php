<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woo.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

/**
 * Hook: woocommerce_before_single_product.
 *
 * @hooked woocommerce_output_all_notices - 10
 */
do_action( 'woocommerce_before_single_product' );

if ( post_password_required() ) {
	echo get_the_password_form(); // WPCS: XSS ok.
	return;
}
?>
<div id="product-<?php the_ID(); ?>" <?php wc_product_class( '', $product ); ?>>
	<div class="detail-head">
		<div class="row row-margin">
			<div class="col-12 col-md-5">
				<?php
				/**
				 * Hook: woocommerce_before_single_product_summary.
				 *
				 * @hooked woocommerce_show_product_sale_flash - 10
				 * @hooked woocommerce_show_product_images - 20
				 */
				do_action( 'woocommerce_before_single_product_summary' );
				?>
			</div>
			<div class="col-12 col-md-7">
				<?php
				/**
				 * Hook: woocommerce_single_product_summary.
				 *
				 * @hooked woocommerce_template_single_title - 5
				 * @hooked woocommerce_template_single_rating - 10
				 * @hooked woocommerce_template_single_price - 10
				 * @hooked woocommerce_template_single_excerpt - 20
				 * @hooked woocommerce_template_single_add_to_cart - 30
				 * @hooked woocommerce_template_single_meta - 40
				 * @hooked woocommerce_template_single_sharing - 50
				 * @hooked WC_Structured_Data::generate_product_data() - 60
				 */
				do_action( 'woocommerce_single_product_summary' );
				?>
			</div>
		</div>
	</div>
	<div class="detail-body">

	<ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
		<li class="nav-item" role="presentation">
			<button class="nav-link active" id="pills-desc-tab" data-bs-toggle="pill" data-bs-target="#pills-desc" type="button" role="tab" aria-controls="pills-desc" aria-selected="true">Mô tả</button>
		</li>
		<li class="nav-item" role="presentation">
			<button class="nav-link" id="pills-uses-tab" data-bs-toggle="pill" data-bs-target="#pills-uses" type="button" role="tab" aria-controls="pills-uses" aria-selected="false">Công dụng</button>
		</li>
		<li class="nav-item" role="presentation">
			<button class="nav-link" id="pills-manual-tab" data-bs-toggle="pill" data-bs-target="#pills-manual" type="button" role="tab" aria-controls="pills-manual" aria-selected="false">Cách dùng</button>
		</li>
		<li class="nav-item" role="presentation">
			<button class="nav-link" id="pills-note-tab" data-bs-toggle="pill" data-bs-target="#pills-note" type="button" role="tab" aria-controls="pills-note" aria-selected="false">Lưu ý</button>
		</li>
	</ul>

	<div class="tab-content" id="pills-tabContent">
		<div class="tab-pane fade show active" id="pills-desc" role="tabpanel" aria-labelledby="pills-desc-tab"><?php the_content();?></div>
		<div class="tab-pane fade" id="pills-uses" role="tabpanel" aria-labelledby="pills-uses-tab"><?php echo get_field('product_uses'); ?></div>
		<div class="tab-pane fade" id="pills-manual" role="tabpanel" aria-labelledby="pills-manual-tab"><?php echo get_field('user_manual'); ?></div>
		<div class="tab-pane fade" id="pills-note" role="tabpanel" aria-labelledby="pills-note-tab"><?php echo get_field('notes_on_use'); ?></div>
	</div>
		
		<!-- <div class="block-review">
			<?php //echo do_shortcode('[cusrev_reviews]'); ?>
		</div> -->
	</div>
	<?php
	/**
	 * Hook: woocommerce_after_single_product_summary.
	 *
	 * @hooked woocommerce_output_product_data_tabs - 10
	 * @hooked woocommerce_upsell_display - 15
	 * @hooked woocommerce_output_related_products - 20
	 */
	do_action( 'woocommerce_after_single_product_summary' );
	?>
</div>
<script type="text/javascript" src="<?php bloginfo('template_url' ); ?>/js/qty.js"></script>
<?php do_action( 'woocommerce_after_single_product' ); ?>
