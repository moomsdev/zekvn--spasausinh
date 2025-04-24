<?php
/*
Template Name: Tài khoản
 */
?>
<?php get_header(); ?>

<main id="main">
    <div class="page-body account-body">
        <div class="zek_account_page">
            <div class="container">
                <?php if(is_user_logged_in()){  $current_user = wp_get_current_user(); ?>
                <div class="box-account">
                    <?php echo do_shortcode('[woocommerce_my_account]'); ?>
                </div>
                <?php }else{ ?>
                <div class="box-login">
                    <?php echo do_shortcode('[woocommerce_my_account]'); ?>
                    <div class="note text-center">
                        <div class="note1">Bạn không có tài khoản? <a href="javascript:void(0);">Đăng kí ngay</a></div>
                        <div class="note2">Bạn đã có tài khoản? <a href="javascript:void(0);">Đăng nhập ngay</a></div>
                    </div>
                </div>
                <?php }?>
            </div>
        </div>
    </div>
</main>

<?php get_footer(); ?>