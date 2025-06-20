<?php get_header(); ?>

<main id="main">
  <?php get_template_part('breadcrums'); ?>
  <div class="zek_page_body">
    <div class="container">
      <div class="zek_page_title">Tìm kiếm:
        "<?php echo get_search_query(); ?>"</div>

      <h2 class="zek_page_title text-center mb-3 mb-lg-5"> KẾT QUẢ CỦA BÀI VIẾT</h2>
      <div class="zek_list_news row row-cols-1 row-cols-md-2 row-cols-lg-4 g-3 align-items-stretch">
        <?php
        $args = array(
          'post_type' => 'post',
          'posts_per_page' => -1,
          's' => get_search_query(),
        );
        $query = new WP_Query($args);
        if ($query->have_posts()):
          while ($query->have_posts()):
            $query->the_post();
            ?>
            <div class="col-6 col-lg-3 loop-highlight box h-100 d-flex">
              <div class="loop-inner d-flex flex-column h-100">
                <div class="flex-grow-1 d-flex flex-column">
                  <figure class="loop-image">
                    <a href="<?php the_permalink()?>">
                      <img
                        src="<?php echo get_the_post_thumbnail_url(get_the_ID(), 'full'); ?>"
                        alt="<?php echo get_the_title(get_the_ID()); ?>"
                        loading="lazy">
                    </a>
                  </figure>
                  <div class="loop-heading-wrapper">
                    <h4 class="loop-heading fs-16"><a
                        href="<?php the_permalink()?>"><?php echo get_the_title(get_the_ID()); ?></a>
                    </h4>
                  </div>
                </div>
                <a href="<?php the_permalink()?>"
                  class="btn-hightlight bora-1 mt-auto">xem thêm</a>
              </div>
            </div>

            <?php
          endwhile;
          wp_reset_postdata();
        else:
          echo '<p>Không tìm thấy bài viết nào.</p>';
        endif;
        ?>
      </div>

      <h2 class="zek_page_title text-center mb-3 mb-lg-5"
        style="margin-top: 30px;">KẾT QUẢ CỦA SẢN PHẨM</h2>
      <div class="products zek_list_product row">
        <?php
        $args = array(
          'post_type' => 'product',
          'posts_per_page' => -1,
          's' => get_search_query(),
        );
        $query = new WP_Query($args);
        if ($query->have_posts()):
          while ($query->have_posts()):
            $query->the_post();
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
                  <div class="product-name"><a
                      href="<?php the_permalink() ?>"><?php the_title() ?></a>
                  </div>

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
                aria-label="Thêm sản phẩm vào giỏ hàng" rel="nofollow">
                Thêm vào giỏ hàng
              </a>
            </div>
            <?php
          endwhile;
          wp_reset_postdata();
        else:
          echo '<p>Không tìm thấy sản phẩm nào.</p>';
        endif;
        ?>
      </div>
    </div>
  </div>
</main>

<?php get_footer(); ?>