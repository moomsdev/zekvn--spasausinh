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
								<button class="btn btn-outline-secondary dropdown-toggle filter-btn" type="button" id="sortDropdown" data-bs-toggle="dropdown" aria-expanded="false" data-filter-type="orderby" data-default-text="Sắp xếp">
									Sắp xếp
								</button>
								<ul class="dropdown-menu" aria-labelledby="sortDropdown">
									<li><a class="dropdown-item filter-item" href="#" data-value="" data-text="Sắp xếp">Tất cả</a></li>
									<?php foreach($catalog_orderby_options as $id => $name): ?>
										<li><a class="dropdown-item filter-item" href="#" data-value="<?php echo esc_attr($id); ?>" data-text="<?php echo esc_html($name); ?>"><?php echo esc_html($name); ?></a></li>
									<?php endforeach; ?>
								</ul>
							</div>
							<div class="dropdown">
								<button class="btn btn-outline-secondary dropdown-toggle filter-btn" type="button" id="categoryDropdown" data-bs-toggle="dropdown" aria-expanded="false" data-filter-type="product_cat" data-default-text="Danh mục">
									Danh mục
								</button>
								<ul class="dropdown-menu" aria-labelledby="categoryDropdown">
									<li><a class="dropdown-item filter-item" href="#" data-value="" data-text="Danh mục">Tất cả</a></li>
									<?php foreach($categories as $cat): ?>
										<li><a class="dropdown-item filter-item" href="#" data-value="<?php echo esc_attr($cat->slug); ?>" data-text="<?php echo esc_html($cat->name); ?>"><?php echo esc_html($cat->name); ?></a></li>
									<?php endforeach; ?>
								</ul>
							</div>
							<div class="dropdown">
								<button class="btn btn-outline-secondary dropdown-toggle filter-btn" type="button" id="brandDropdown" data-bs-toggle="dropdown" aria-expanded="false" data-filter-type="product_brand" data-default-text="Thương hiệu">
									Thương hiệu
								</button>
								<ul class="dropdown-menu" aria-labelledby="brandDropdown">
									<li><a class="dropdown-item filter-item" href="#" data-value="" data-text="Thương hiệu">Tất cả</a></li>
									<?php foreach($brands as $brand): ?>
										<li><a class="dropdown-item filter-item" href="#" data-value="<?php echo esc_attr($brand->slug); ?>" data-text="<?php echo esc_html($brand->name); ?>"><?php echo esc_html($brand->name); ?></a></li>
									<?php endforeach; ?>
								</ul>
							</div>
							<button class="btn btn-warning clear-filters" style="display: none;">
								<i class="fas fa-times"></i> Xóa bộ lọc
							</button>
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
				<div id="loading-overlay" style="display: none; text-align: center; padding: 20px;">
					<div class="spinner-border" role="status">
						<span class="visually-hidden">Đang tải...</span>
					</div>
				</div>
				<div id="products-container">
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

<style>
.dropdown {
    position: relative;
}

.dropdown-menu {
    position: absolute;
    top: 100%;
    left: 0;
    z-index: 1000;
    display: none;
    min-width: 200px;
    padding: 0;
    margin: 2px 0 0;
    background-color: #fff;
    border: 1px solid rgba(0,0,0,.15);
    border-radius: 4px;
    box-shadow: 0 6px 12px rgba(0,0,0,.175);
}

.dropdown-menu .container {
    padding: 10px 15px;
    max-height: 300px;
    overflow-y: auto;
}

.dropdown-menu.show {
    display: block;
}

.dropdown-item {
    display: block;
    width: 100%;
    padding: 3px 20px;
    clear: both;
    font-weight: normal;
    line-height: 1.42857143;
    color: #333;
    white-space: nowrap;
    text-decoration: none;
}

.dropdown-item:hover,
.dropdown-item:focus {
    color: #262626;
    text-decoration: none;
    background-color: #f5f5f5;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('Initializing product filters...');
    
    // State để lưu trữ tất cả filters
    const filterState = {
        orderby: '',
        product_cat: '',
        product_brand: '',
        search: ''
    };
    
    // Elements
    const loadingOverlay = document.getElementById('loading-overlay');
    const productsContainer = document.getElementById('products-container');
    const clearFiltersBtn = document.querySelector('.clear-filters');
    
    // Lấy tất cả dropdown buttons và filter items
    const dropdownButtons = document.querySelectorAll('.dropdown-toggle');
    const filterItems = document.querySelectorAll('.filter-item');
    
    // Khởi tạo dropdowns
    initDropdowns();
    
    // Khởi tạo filter handlers
    initFilterHandlers();
    
    function initDropdowns() {
        dropdownButtons.forEach(function(button) {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                // Đóng tất cả dropdown khác
                dropdownButtons.forEach(function(otherButton) {
                    if (otherButton !== button) {
                        const otherDropdown = otherButton.nextElementSibling;
                        if (otherDropdown && otherDropdown.classList.contains('dropdown-menu')) {
                            otherDropdown.classList.remove('show');
                            otherButton.setAttribute('aria-expanded', 'false');
                        }
                    }
                });
                
                // Toggle dropdown hiện tại
                const dropdownMenu = this.nextElementSibling;
                if (dropdownMenu && dropdownMenu.classList.contains('dropdown-menu')) {
                    const isShown = dropdownMenu.classList.contains('show');
                    
                    if (isShown) {
                        dropdownMenu.classList.remove('show');
                        this.setAttribute('aria-expanded', 'false');
                    } else {
                        dropdownMenu.classList.add('show');
                        this.setAttribute('aria-expanded', 'true');
                    }
                }
            });
        });
        
        // Đóng dropdown khi click outside
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.dropdown')) {
                dropdownButtons.forEach(function(button) {
                    const dropdownMenu = button.nextElementSibling;
                    if (dropdownMenu && dropdownMenu.classList.contains('dropdown-menu')) {
                        dropdownMenu.classList.remove('show');
                        button.setAttribute('aria-expanded', 'false');
                    }
                });
            }
        });
    }
    
    function initFilterHandlers() {
        // Handle filter item clicks
        filterItems.forEach(function(item) {
            item.addEventListener('click', function(e) {
                e.preventDefault();
                
                const value = this.getAttribute('data-value');
                const text = this.getAttribute('data-text');
                const dropdown = this.closest('.dropdown');
                const button = dropdown.querySelector('.filter-btn');
                const filterType = button.getAttribute('data-filter-type');
                
                // Cập nhật filter state
                filterState[filterType] = value;
                
                // Cập nhật button text
                button.textContent = text;
                
                // Đóng dropdown
                const dropdownMenu = dropdown.querySelector('.dropdown-menu');
                dropdownMenu.classList.remove('show');
                button.setAttribute('aria-expanded', 'false');
                
                // Apply filters
                applyFilters();
                
                // Show/hide clear button
                updateClearButton();
                
                console.log('Filter applied:', filterType, value);
            });
        });
        
        // Handle clear filters
        if (clearFiltersBtn) {
            clearFiltersBtn.addEventListener('click', function() {
                clearAllFilters();
            });
        }
        
        // Handle search form
        const searchForm = document.querySelector('.woocommerce-product-search');
        if (searchForm) {
            searchForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const searchInput = this.querySelector('input[name="s"]');
                filterState.search = searchInput.value;
                applyFilters();
                updateClearButton();
            });
        }
    }
    
    function applyFilters() {
        // Show loading
        loadingOverlay.style.display = 'block';
        productsContainer.style.opacity = '0.5';
        
        // Build URL parameters
        const params = new URLSearchParams();
        
        Object.keys(filterState).forEach(function(key) {
            if (filterState[key]) {
                if (key === 'search') {
                    params.append('s', filterState[key]);
                    params.append('post_type', 'product');
                } else {
                    params.append(key, filterState[key]);
                }
            }
        });
        
        // AJAX request
        const ajaxUrl = '<?php echo admin_url('admin-ajax.php'); ?>';
        
        fetch(ajaxUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'action=filter_products&' + params.toString()
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                productsContainer.innerHTML = data.data.html;
                
                // Update URL without reloading
                const newUrl = window.location.pathname + '?' + params.toString();
                window.history.pushState({}, '', newUrl);
                
                console.log('Products filtered successfully');
            } else {
                console.error('Filter error:', data.data);
            }
        })
        .catch(error => {
            console.error('AJAX error:', error);
        })
        .finally(() => {
            // Hide loading
            loadingOverlay.style.display = 'none';
            productsContainer.style.opacity = '1';
        });
    }
    
    function clearAllFilters() {
        // Reset filter state
        Object.keys(filterState).forEach(function(key) {
            filterState[key] = '';
        });
        
        // Reset button texts
        document.querySelectorAll('.filter-btn').forEach(function(btn) {
            const defaultText = btn.getAttribute('data-default-text');
            btn.textContent = defaultText;
        });
        
        // Clear search input
        const searchInput = document.querySelector('input[name="s"]');
        if (searchInput) {
            searchInput.value = '';
        }
        
        // Apply filters (will load all products)
        applyFilters();
        
        // Hide clear button
        clearFiltersBtn.style.display = 'none';
        
        console.log('All filters cleared');
    }
    
    function updateClearButton() {
        const hasActiveFilters = Object.values(filterState).some(value => value !== '');
        clearFiltersBtn.style.display = hasActiveFilters ? 'inline-block' : 'none';
    }
    
    console.log('Product filters initialized');
});
</script>

<?php get_footer( 'shop' );?>
