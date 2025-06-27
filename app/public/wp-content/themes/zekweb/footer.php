<footer id="footer">
  <div class="container">
    <div class="row">
      <div class="col-12 col-lg-9">
        <h3 class="footer-company-name">
          <?php the_field('company', 'option'); ?>
        </h3>
        <div class="footer-info-wrapper">
          <div class="footer-info">
            <!-- address -->
            <div class="address">
              Địa chỉ: <?php the_field('address', 'option'); ?>
            </div>
            <!-- center support -->
            <div class="center-support">
              Tổng đài hỗ trợ:
              <?php the_field('support_center', 'option'); ?>
            </div>
            <!-- hotline -->
            <div class="hotline">
              Hotline dịch vụ: <?php echo get_field('hotline_1', 'option') ?>
              - <?php echo get_field('hotline_2', 'option'); ?>
            </div>
            <!-- hotline san pham -->
            <div class="hotline-product">
              Hotline sản phẩm: <?php echo get_field('hotline_product', 'option') ?>
            </div>
            <!-- email -->
            <div class="email">
              Email: <?php the_field('email', 'option'); ?>
            </div>
            <!-- info_extra -->
            <div class="info-extra">
              <?php the_field('info_ext', 'option'); ?>
            </div>

            <div class="bct_dmca d-flex gap-4 align-items-center">
              <figure>
                <img
                  src="<?php echo get_field('bct_img', 'option'); ?>"
                  alt="Bộ công thương">
              </figure>
              <figure>
                <img
                  src="<?php echo get_field('dmca_img', 'option'); ?>"
                  alt="DMCA">
              </figure>
            </div>
          </div>

          <nav class="footer-nav">
            <?php wp_nav_menu(array('container' => '', 'theme_location' => 'footer', 'menu_class' => 'menu')); ?>
          </nav>

        </div>

      </div>
      <div class="col-12 col-lg-3">
        <div class="map-wrapper">
          <?php echo get_field('gg_map', 'option'); ?>
        </div>
        <div class="socials">
          <h3 class="social-title">Mạng xã hội</h3>
          <div class="social-list">
            <!-- facebook -->
            <a href="<?php the_field('facebook', 'option'); ?>" target="_blank" class="facebook">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M512 256C512 114.6 397.4 0 256 0S0 114.6 0 256C0 376 82.7 476.8 194.2 504.5V334.2H141.4V256h52.8V222.3c0-87.1 39.4-127.5 125-127.5c16.2 0 44.2 3.2 55.7 6.4V172c-6-.6-16.5-1-29.6-1c-42 0-58.2 15.9-58.2 57.2V256h83.6l-14.4 78.2H287V510.1C413.8 494.8 512 386.9 512 256h0z"/></svg>
            </a>
            <!-- instagram -->
            <a href="<?php the_field('instagram', 'option'); ?>" target="_blank" class="instagram">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M224.1 141c-63.6 0-114.9 51.3-114.9 114.9s51.3 114.9 114.9 114.9S339 319.5 339 255.9 287.7 141 224.1 141zm0 189.6c-41.1 0-74.7-33.5-74.7-74.7s33.5-74.7 74.7-74.7 74.7 33.5 74.7 74.7-33.6 74.7-74.7 74.7zm146.4-194.3c0 14.9-12 26.8-26.8 26.8-14.9 0-26.8-12-26.8-26.8s12-26.8 26.8-26.8 26.8 12 26.8 26.8zm76.1 27.2c-1.7-35.9-9.9-67.7-36.2-93.9-26.2-26.2-58-34.4-93.9-36.2-37-2.1-147.9-2.1-184.9 0-35.8 1.7-67.6 9.9-93.9 36.1s-34.4 58-36.2 93.9c-2.1 37-2.1 147.9 0 184.9 1.7 35.9 9.9 67.7 36.2 93.9s58 34.4 93.9 36.2c37 2.1 147.9 2.1 184.9 0 35.9-1.7 67.7-9.9 93.9-36.2 26.2-26.2 34.4-58 36.2-93.9 2.1-37 2.1-147.8 0-184.8zM398.8 388c-7.8 19.6-22.9 34.7-42.6 42.6-29.5 11.7-99.5 9-132.1 9s-102.7 2.6-132.1-9c-19.6-7.8-34.7-22.9-42.6-42.6-11.7-29.5-9-99.5-9-132.1s-2.6-102.7 9-132.1c7.8-19.6 22.9-34.7 42.6-42.6 29.5-11.7 99.5-9 132.1-9s102.7-2.6 132.1 9c19.6 7.8 34.7 22.9 42.6 42.6 11.7 29.5 9 99.5 9 132.1s2.7 102.7-9 132.1z"/></svg>
            </a>
            <!-- youtube -->
            <a href="<?php the_field('youtube', 'option'); ?>" target="_blank" class="youtube">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M549.7 124.1c-6.3-23.7-24.8-42.3-48.3-48.6C458.8 64 288 64 288 64S117.2 64 74.6 75.5c-23.5 6.3-42 24.9-48.3 48.6-11.4 42.9-11.4 132.3-11.4 132.3s0 89.4 11.4 132.3c6.3 23.7 24.8 41.5 48.3 47.8C117.2 448 288 448 288 448s170.8 0 213.4-11.5c23.5-6.3 42-24.2 48.3-47.8 11.4-42.9 11.4-132.3 11.4-132.3s0-89.4-11.4-132.3zm-317.5 213.5V175.2l142.7 81.2-142.7 81.2z"/></svg>
            </a>
            <!-- x -->
            <a href="<?php the_field('x', 'option'); ?>" target="_blank" class="x">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M64 32C28.7 32 0 60.7 0 96V416c0 35.3 28.7 64 64 64H384c35.3 0 64-28.7 64-64V96c0-35.3-28.7-64-64-64H64zm297.1 84L257.3 234.6 379.4 396H283.8L209 298.1 123.3 396H75.8l111-126.9L69.7 116h98l67.7 89.5L313.6 116h47.5zM323.3 367.6L153.4 142.9H125.1L296.9 367.6h26.3z"/></svg>
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</footer>

<!-- Backtop -->
<div class="backtop">
  <a href="#top" id="back-top" title="Back To Top">
    <img src="<?php bloginfo('template_url'); ?>/images/backtop.png" alt="icon">
  </a>
</div>

<div id="gom-all-in-one"><!-- v3 -->
  <!-- map -->
  <div id="map-vr" class="button-contact">
    <div class="phone-vr">
      <div class="phone-vr-circle-fill"></div>
      <div class="phone-vr-img-circle">
        <a target="_blank" href="https://maps.app.goo.gl/qjhcR4bp3fUX1W6D8">
          <img alt="google map" src="https://homecareshop.net.vn/wp-content/plugins/button-contact-vr/legacy/img/showroom4.png">
        </a>
      </div>
    </div>
  </div>
  <!-- end map -->

  <!-- messenger -->
  <div id="messenger-vr" class="button-contact">
    <div class="phone-vr">
      <div class="phone-vr-circle-fill"></div>
      <div class="phone-vr-img-circle">
        <a target="_blank" href="https://m.me/myphamtinhhoacocay">
          <img alt="messenger" src="https://homecareshop.net.vn/wp-content/plugins/button-contact-vr/legacy/img/messenger.png">
        </a>
      </div>
    </div>
  </div>
  <!-- end messenger -->

  <!-- zalo -->
  <div id="zalo-vr" class="button-contact">
    <div class="phone-vr">
      <div class="phone-vr-circle-fill"></div>
      <div class="phone-vr-img-circle">
        <a target="_blank" href="https://zalo.me/2721014332181762934">
          <img alt="Zalo" src="https://homecareshop.net.vn/wp-content/plugins/button-contact-vr/legacy/img/zalo.png">
        </a>
      </div>
    </div>
  </div>
  <!-- end zalo -->

  <!-- Phone -->
  <div id="phone-vr" class="button-contact">
    <div class="phone-vr">
      <div class="phone-vr-circle-fill"></div>
      <div class="phone-vr-img-circle">
        <a href="tel:0888595602">
          <img alt="Phone" src="https://homecareshop.net.vn/wp-content/plugins/button-contact-vr/legacy/img/phone.png">
        </a>
      </div>
    </div>
  </div>
  <!-- end phone -->
</div>

<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/swiper-bundle.min.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/fancybox.umd.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/select2.min.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/qty.js"></script>
<!-- <script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/aos.js"></script> -->
<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/custom.js?v=<?php echo time(); ?>"></script>
<?php
$value = get_field('code_footer', 'option');
echo $value;
?>
<?php wp_footer(); ?>
</div>
</body>

</html>