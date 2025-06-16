<?php $term = get_queried_object(); ?>
<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 8.6.0
 */

defined( 'ABSPATH' ) || exit;

get_header( 'shop' );

/**
 * Hook: woocommerce_before_main_content.
 *
 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
 * @hooked woocommerce_breadcrumb - 20
 * @hooked WC_Structured_Data::generate_website_data() - 30
 */
do_action( 'woocommerce_before_main_content' );

?>
<?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>
			<h1 class="d-none woocommerce-products-header__title page-title"><?php woocommerce_page_title(); ?></h1>
			<?php endif; ?>
<main id="main">
	<div class="page-body">
		<?php
		// Slider
		get_template_part('template-parts/product/section','slider'); 
		?>

		<div class="archive-product">
			<?php
			// Offers
			get_template_part('template-parts/product/section','offers');

			// Brand Slider
			get_template_part('template-parts/product/section','brand_slider');

			// Product Slider
			get_template_part('template-parts/product/section','product_latest');
			?>

			<?php
			/**
			 * Hook: woocommerce_archive_description.
			 *
			 * @hooked woocommerce_taxonomy_archive_description - 10
			 * @hooked woocommerce_product_archive_description - 10
			 */
			do_action( 'woocommerce_archive_description' );
			?>
			<?php
			// Ẩn hiển thị kết quả và dropdown sorting mặc định của WooCommerce
			remove_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 20);
			remove_action('woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30);

			$categories = get_terms([
				'taxonomy' => 'product_cat',
				'hide_empty' => true,
			]);
			$brands = get_terms([
				'taxonomy' => 'product_brand', // Nếu taxonomy khác, hãy thay đổi tên này
				'hide_empty' => true,
			]);
			$catalog_orderby_options = apply_filters( 'woocommerce_catalog_orderby', array(
				'menu_order' => __( 'Thứ tự mặc định', 'woocommerce' ),
				'popularity' => __( 'Phổ biến nhất', 'woocommerce' ),
				'rating'     => __( 'Đánh giá cao', 'woocommerce' ),
				'date'       => __( 'Mới nhất', 'woocommerce' ),
				'price'      => __( 'Giá thấp đến cao', 'woocommerce' ),
				'price-desc' => __( 'Giá cao đến thấp', 'woocommerce' ),
			) );
			?>
			<div class="container mb-4">
				<div class="row align-items-center">
					<div class="col-12 col-md-9 mb-3 mb-md-0">
						<div class="d-flex gap-2">
							<div class="dropdown">
								<button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
									Sắp xếp
								</button>
								<ul class="dropdown-menu">
									<?php foreach($catalog_orderby_options as $id => $name): ?>
										<li><a class="dropdown-item" href="?orderby=<?php echo esc_attr($id); ?>"><?php echo esc_html($name); ?></a></li>
									<?php endforeach; ?>
								</ul>
							</div>
							<div class="dropdown">
								<button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
									Danh mục
								</button>
								<ul class="dropdown-menu">
									<?php foreach($categories as $cat): ?>
										<li><a class="dropdown-item" href="<?php echo get_term_link($cat); ?>"><?php echo $cat->name; ?></a></li>
									<?php endforeach; ?>
								</ul>
							</div>
							<div class="dropdown">
								<button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
									Thương hiệu
								</button>
								<ul class="dropdown-menu">
									<?php foreach($brands as $brand): ?>
										<li><a class="dropdown-item" href="<?php echo get_term_link($brand); ?>"><?php echo $brand->name; ?></a></li>
									<?php endforeach; ?>
								</ul>
							</div>
						</div>
					</div>
					<div class="col-12 col-md-3">
						<form class="d-flex" role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>">
							<input class="form-control" type="search" name="s" placeholder="Tìm kiếm sản phẩm" aria-label="Search" value="<?php echo get_search_query(); ?>">
							<input type="hidden" name="post_type" value="product" />
						</form>
					</div>
				</div>
			</div>
			<div class="container">
			<?php
			if ( woocommerce_product_loop() ) {
				/**
				* Hook: woocommerce_before_shop_loop.
				*
				* @hooked woocommerce_output_all_notices - 10
				*/
				do_action( 'woocommerce_before_shop_loop' );
				woocommerce_product_loop_start();
				if ( wc_get_loop_prop( 'total' ) ) {
					while ( have_posts() ) {
						the_post();
						/**
						* Hook: woocommerce_shop_loop.
						*/
						do_action( 'woocommerce_shop_loop' );
						wc_get_template_part( 'content', 'product' );
					}
				}
				woocommerce_product_loop_end();
				/**
				* Hook: woocommerce_after_shop_loop.
				*
				* @hooked woocommerce_pagination - 10
				*/
				do_action( 'woocommerce_after_shop_loop' );
			} else {
				/**
				* Hook: woocommerce_no_products_found.
				*
				* @hooked wc_no_products_found - 10
				*/
				do_action( 'woocommerce_no_products_found' );
			}
			?>
			</div>
		</div>
		<?php
		// Banner
		get_template_part('template-parts/product/section','banner');
		?>

		<div class="container">
			<?php
			// Materials Slider
			get_template_part('template-parts/product/section','materials_slider');
			// branch
			get_template_part('template-parts/section', 'branch');
			?>
		</div>
	</div>
</main>
<?php get_footer( 'shop' );?>
