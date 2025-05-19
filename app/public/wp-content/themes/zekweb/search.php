<?php get_header(); ?>

<main id="main">
    <?php get_template_part('breadcrums'); ?>
    <div class="zek_page_body">
        <div class="container">
            <div class="zek_page_title">Tìm kiếm: "<?php echo get_search_query(); ?>"</div>

            <h2 class="zek_page_title text-center mb-3 mb-lg-5">Kết quả của bài viết</h2>
            <div class="zek_list_news row row-margin">
                <?php
                $args = array(
                    'post_type'      => 'post',
                    'posts_per_page' => -1,
                    's'              => get_search_query(),
                );
                $query = new WP_Query($args);
                if ($query->have_posts()) :
                    while ($query->have_posts()) : $query->the_post();
                ?>
                        <div class="col-xl-4 col-lg-4 col-md-6 col-6 col-item">
                            <?php get_template_part('loop'); ?>
                        </div>
                <?php
                    endwhile;
                    wp_reset_postdata();
                else :
                    echo '<p>Không tìm thấy bài viết nào.</p>';
                endif;
                ?>
            </div>

            <h2 class="zek_page_title text-center mb-3 mb-lg-5" style="margin-top: 30px;">Kết quả của sản phẩm</h2>
            <div class="products zek_list_product row">
                <?php
                $args = array(
                    'post_type'      => 'product',
                    'posts_per_page' => -1,
                    's'              => get_search_query(),
                );
                $query = new WP_Query($args);
                if ($query->have_posts()) :
                    while ($query->have_posts()) : $query->the_post();
                        $product = wc_get_product(get_the_ID());
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
			
			<?php 
         $price = get_post_meta(get_the_ID(), '_price', true);
         if (!empty($price)) {
             wc_get_template('loop/price.php');
         } else {
             echo '<span class="price">Liên hệ</span>';
         } ?>
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
                <?php
                    endwhile;
                    wp_reset_postdata();
                else :
                    echo '<p>Không tìm thấy sản phẩm nào.</p>';
                endif;
                ?>
            </div>
        </div>
    </div>
</main>

<?php get_footer(); ?>