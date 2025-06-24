<?php get_header();
wp_reset_query();
$format = get_post_format(); ?>
<?php $term_list = wp_get_post_terms($post->ID, 'category', array("fields" => "ids"));
$a = $post->ID; ?>
<?php while (have_posts()):
  the_post();
  setPostViews($post->ID); ?>
  <?php global $product; ?>
  <main id="main">
    <?php get_template_part('loop_template/breadcrums'); ?>
    <div class="page-body single-blog">
      <div class="container">
        <div class="main-content">
          <div class="row">
            <div
              class="col-12 d-none d-lg-block col-lg-3 single-related">
              <?php
              $products_related = get_field('products_related', get_the_ID());
              $banner_qc = get_field('banner_qc', 'option');
              $url_qc = get_field('url_qc', 'option');
              if ($products_related || $banner_qc): ?>
                <div class="single-related-box">
                  <?php if ($products_related): ?>
                    <h2 class="section-title">Sản phẩm liên quan</h2>
                    <div class="post-related mb-5">
                      <?php foreach ($products_related as $product_related): ?>
                        <div class="item">
                          <figure>
                            <a
                              href="<?php echo get_the_permalink($product_related); ?>">
                              <img
                                src="<?php echo get_the_post_thumbnail_url($product_related, 'full'); ?>"
                                alt="<?php the_title(); ?>" loading="lazy">
                            </a>
                          </figure>
                          <div class="body">
                            <h3><a class="title"
                                href="<?php echo get_the_permalink($product_related); ?>"><?php echo get_the_title($product_related); ?></a>
                            </h3>
                            <?php
                            $product_obj = wc_get_product($product_related);
                            if ($product_obj) {
                              echo $product_obj->get_price_html();
                            } else {
                              echo 'Liên hệ';
                            }
                            ?>
                          </div>
                        </div>
                      <?php endforeach; ?>
                    </div>
                  <?php endif; ?>

                  <?php if ($banner_qc): ?>
                    <?php if ($url_qc): ?>
                      <a class="banner-qc" href="<?php echo $url_qc; ?>"
                        target="_blank" rel="noopener noreferrer">
                        <img src="<?php echo $banner_qc; ?>" alt="banner-qc">
                      </a>
                    <?php else: ?>
                      <div class="banner-qc">
                        <img src="<?php echo $banner_qc; ?>" alt="banner-qc">
                      </div>
                    <?php endif; ?>
                  <?php endif; ?>
                </div>
              <?php endif; ?>


            </div>
            <div class="col-12 col-lg-6">
              <!-- <div class="category text-center mt-2 mt-lg-4 text-uppercase"><?php //echo get_the_category(get_the_ID())[0]->name; ?></div> -->
              <h1 class="page-title text-uppercase"><?php the_title(); ?>
              </h1>
              <div class="info-post mt-1 mt-lg-2 mb-3">
                <div class="info-post-inner">
                  <div class="author">
                    <figure>
                      <?php echo get_avatar(get_the_author_meta('ID'), 50); ?>
                    </figure>
                    <div>
                      <span
                        class="author-name"><?php echo get_the_author(); ?></span>
                      <div class="date">
                        <?php echo get_the_date('d/m/Y'); ?></div>
                    </div>
                  </div>
                  <div class="social-share">
                    <div class="social-icons">
                      <a href="https://www.facebook.com/sharer/sharer.php?u=<?php the_permalink(); ?>"
                        target="_blank" rel="noopener noreferrer">
                        <svg xmlns="http://www.w3.org/2000/svg"
                          viewBox="0 0 512 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                          <path
                            d="M512 256C512 114.6 397.4 0 256 0S0 114.6 0 256C0 376 82.7 476.8 194.2 504.5V334.2H141.4V256h52.8V222.3c0-87.1 39.4-127.5 125-127.5c16.2 0 44.2 3.2 55.7 6.4V172c-6-.6-16.5-1-29.6-1c-42 0-58.2 15.9-58.2 57.2V256h83.6l-14.4 78.2H287V510.1C413.8 494.8 512 386.9 512 256h0z" />
                        </svg>
                      </a>
                      <a href="https://twitter.com/intent/tweet?text=<?php the_title(); ?>&url=<?php the_permalink(); ?>"
                        target="_blank" rel="noopener noreferrer">
                        <svg xmlns="http://www.w3.org/2000/svg"
                          viewBox="0 0 448 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                          <path
                            d="M64 32C28.7 32 0 60.7 0 96V416c0 35.3 28.7 64 64 64H384c35.3 0 64-28.7 64-64V96c0-35.3-28.7-64-64-64H64zm297.1 84L257.3 234.6 379.4 396H283.8L209 298.1 123.3 396H75.8l111-126.9L69.7 116h98l67.7 89.5L313.6 116h47.5zM323.3 367.6L153.4 142.9H125.1L296.9 367.6h26.3z" />
                        </svg>
                      </a>
                      <a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php the_permalink(); ?>&title=<?php the_title(); ?>"
                        target="_blank" rel="noopener noreferrer">
                        <svg xmlns="http://www.w3.org/2000/svg"
                          viewBox="0 0 448 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                          <path
                            d="M416 32H31.9C14.3 32 0 46.5 0 64.3v383.4C0 465.5 14.3 480 31.9 480H416c17.6 0 32-14.5 32-32.3V64.3c0-17.8-14.4-32.3-32-32.3zM135.4 416H69V202.2h66.5V416zm-33.2-243c-21.3 0-38.5-17.3-38.5-38.5S80.9 96 102.2 96c21.2 0 38.5 17.3 38.5 38.5 0 21.3-17.2 38.5-38.5 38.5zm282.1 243h-66.4V312c0-24.8-.5-56.7-34.5-56.7-34.6 0-39.9 27-39.9 54.9V416h-66.4V202.2h63.7v29.2h.9c8.9-16.8 30.6-34.5 62.9-34.5 67.2 0 79.7 44.3 79.7 101.9V416z" />
                        </svg>
                      </a>
                      <a href="https://pinterest.com/pin/create/button/?url=<?php the_permalink(); ?>&media=<?php echo get_the_post_thumbnail_url(get_the_ID(), 'full'); ?>&description=<?php the_title(); ?>"
                        target="_blank" rel="noopener noreferrer">
                        <svg xmlns="http://www.w3.org/2000/svg"
                          viewBox="0 0 496 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                          <path
                            d="M496 256c0 137-111 248-248 248-25.6 0-50.2-3.9-73.4-11.1 10.1-16.5 25.2-43.5 30.8-65 3-11.6 15.4-59 15.4-59 8.1 15.4 31.7 28.5 56.8 28.5 74.8 0 128.7-68.8 128.7-154.3 0-81.9-66.9-143.2-152.9-143.2-107 0-163.9 71.8-163.9 150.1 0 36.4 19.4 81.7 50.3 96.1 4.7 2.2 7.2 1.2 8.3-3.3 .8-3.4 5-20.3 6.9-28.1 .6-2.5 .3-4.7-1.7-7.1-10.1-12.5-18.3-35.3-18.3-56.6 0-54.7 41.4-107.6 112-107.6 60.9 0 103.6 41.5 103.6 100.9 0 67.1-33.9 113.6-78 113.6-24.3 0-42.6-20.1-36.7-44.8 7-29.5 20.5-61.3 20.5-82.6 0-19-10.2-34.9-31.4-34.9-24.9 0-44.9 25.7-44.9 60.2 0 22 7.4 36.8 7.4 36.8s-24.5 103.8-29 123.2c-5 21.4-3 51.6-.9 71.2C65.4 450.9 0 361.1 0 256 0 119 111 8 248 8s248 111 248 248z" />
                        </svg>
                      </a>
                    </div>
                  </div>
                </div>
              </div>

              <!-- <figure class="post-image mt-2 mt-lg-4">
                                <?php //the_post_thumbnail('full'); ?>
                            </figure> -->

              <div class="page-content mt-2 mt-lg-4">
                <div class="content-post clearfix">
                  <?php the_content(); ?>
                </div>
              </div>
            </div>
            <!-- post related -->
            <div class="col-12 col-lg-3 single-related">
              <div class="single-related-box">
                <h2 class="section-title">Bài viết liên quan</h2>
                <?php
                $categories = get_the_category(get_the_ID());
                if ($categories) {

                  $category_ids = array();
                  foreach ($categories as $individual_category) {
                    $category_ids[] = $individual_category->term_id;
                  }
                  $posts_per_page = wp_is_mobile() ? 5 : 5;
                  $args = array(
                    'category__in' => $category_ids,
                    'post__not_in' => array(get_the_ID()),
                    'posts_per_page' => $posts_per_page,
                  );
                  $my_query = new wp_query($args);
                  if ($my_query->have_posts()):
                    ?>
                    <div class="post-related">
                      <?php while ($my_query->have_posts()):
                        $my_query->the_post(); ?>
                        <div class="item">
                          <figure>
                            <a href="<?php the_permalink(); ?>">
                              <?php the_post_thumbnail('large', ['alt' => get_the_title()]); ?>
                            </a>
                          </figure>
                          <!-- <div class="body"> -->
                          <a class="title"
                            href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                          <!-- <p class="description">
                                                    <?php //echo get_the_excerpt(); ?>
                                                </p> -->
                          <!-- </div> -->
                        </div>
                      <?php endwhile; ?>
                    </div>
                    <?php
                  endif;
                  wp_reset_query();
                }
                ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    </div>
  </main>
<?php endwhile; ?>
<?php get_footer(); ?>