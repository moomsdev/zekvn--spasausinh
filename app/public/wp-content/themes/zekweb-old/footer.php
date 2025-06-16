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
                            Tổng đài hỗ trợ: <?php the_field('support_center', 'option'); ?>
                        </div>
                        <!-- hotline -->
                        <div class="hotline">
                            Hotline: <?php echo get_field('hotline_1', 'option') ?> - <?php echo get_field('hotline_2', 'option'); ?>
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
                                <img src="<?php echo get_field('bct_img', 'option'); ?>" alt="Bộ công thương">
                            </figure>
                            <figure>
                                <img src="<?php echo get_field('dmca_img', 'option'); ?>" alt="DMCA">
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
                    <h3 class="social-title">Kết nối</h3>
                    <div class="social-list">
                        <!-- facebook -->
                        <a href="<?php the_field('facebook', 'option'); ?>" target="_blank" class="facebook">
                            <i class="fa-brands fa-facebook"></i>
                        </a>
                        <!-- instagram -->
                        <a href="<?php the_field('instagram', 'option'); ?>" target="_blank" class="instagram">
                            <i class="fa-brands fa-instagram"></i>
                        </a>
                        <!-- youtube -->
                        <a href="<?php the_field('youtube', 'option'); ?>" target="_blank" class="youtube">
                        <i class="fa-brands fa-youtube"></i>
                        </a>
                        <!-- x -->
                        <a href="<?php the_field('x', 'option'); ?>" target="_blank" class="x">
                            <i class="fa-brands fa-x-twitter"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

<!-- Support -->
<div class="supports">
    <!-- Hotline -->
    <div class="item">
        <a href="tel:<?php the_field('hotline', 'option'); ?>" class="hotline" title="Gọi ngay">
            <img src="<?php bloginfo('template_url'); ?>/assets/images/support-hotline.png" alt="icon">
        </a>
    </div>
    <!-- Messenger -->
    <div class="item">
        <a href="http://zalo.me/<?php the_field('zalo', 'option') ?>" target="_blank" class="zalo" title="Chat Zalo">
            <img src="<?php bloginfo('template_url'); ?>/assets/images/support-zalo.png" alt="icon">
        </a>
    </div>
    <!-- Messenger -->
    <div class="item">
        <a href="https://m.me/<?php the_field('messenger', 'option') ?>" target="_blank" class="messenger"
            title="Chat Facebook">
            <img decoding="async" src="<?php bloginfo('template_url'); ?>/assets/images/support-messenger.png"
                alt="icon">
        </a>
    </div>
</div>
<!-- Backtop -->
<div class="backtop">
    <a href="#top" id="back-top" title="Back To Top">
        <img src="<?php bloginfo('template_url'); ?>/assets/images/backtop.png" alt="icon">
    </a>
</div>

<?php
$value = get_field('code_footer', 'option');
echo $value;
?>
<?php wp_footer(); ?>
</div>
</body>
</html>