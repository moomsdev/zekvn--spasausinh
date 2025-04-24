<footer id="footer">
    <div class="container">

    </div>
</footer>

<div class="copyright">
    <span>© <?php echo date('Y'); ?> Designed by zek.vn. All Rights Reserved.</span>
</div>

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