<?php

add_action('woocommerce_thankyou_bacs', function($order_id){
    $bacs_info = get_option('woocommerce_bacs_accounts');
    if(!empty($bacs_info) && count($bacs_info) > 0):
        $order = wc_get_order( $order_id );
        $content = 'Don hang ' . $order->get_order_number(); // Nội dung chuyển khoản
    ?>
        <div class="vdh_qr_code">
        <?php foreach($bacs_info as $item): ?>
        <span class="vdh_bank_item">
            <img class="img_qr_code" src="https://img.vietqr.io/image/<?php echo $item['bank_name']?>-<?php echo $item['account_number']?>-print.jpg?amount=<?php echo $order->get_total() ?>&addInfo=<?php echo $content ?>&accountName=<?php echo $item['account_name']?>" alt="QR Code">
        </span>
        <?php endforeach; ?>

            <div id="modal_qr_code" class="modal">
            <img class="modal-content" id="img01">
        </div>
        </div>

    <style>
        .vdh_qr_code{justify-content:space-between;display:flex}.vdh_qr_code .vdh_bank_item{width:260px;display:inline-block}.vdh_qr_code .vdh_bank_item img{width:100%}.vdh_qr_code .img_qr_code{border-radius:5px;cursor:pointer;transition:.3s;display:block;margin-left:auto;margin-right:auto}.vdh_qr_code .img_qr_code:hover{opacity:.7}.vdh_qr_code .modal{display:none;position:fixed;z-index:999999;left:0;top:0;width:100%;height:100%;background-color:rgba(0,0,0,.9)}.vdh_qr_code .modal-content{margin:auto;display:block;height:100%}.vdh_qr_code #caption{margin:auto;display:block;width:80%;max-width:700px;text-align:center;color:#ccc;padding:10px 0;height:150px}.vdh_qr_code #caption,.vdh_qr_code .modal-content{-webkit-animation-name:zoom;-webkit-animation-duration:.6s;animation-name:zoom;animation-duration:.6s}.vdh_qr_code .out{animation-name:zoom-out;animation-duration:.6s}@-webkit-keyframes zoom{from{-webkit-transform:scale(1)}to{-webkit-transform:scale(2)}}@keyframes zoom{from{transform:scale(.4)}to{transform:scale(1)}}@keyframes zoom-out{from{transform:scale(1)}to{transform:scale(0)}}.vdh_qr_code .close{position:absolute;top:15px;right:35px;color:#f1f1f1;font-size:40px;font-weight:700;transition:.3s}.vdh_qr_code .close:focus,.vdh_qr_code .close:hover{color:#bbb;text-decoration:none;cursor:pointer}@media only screen and (max-width:768px){.vdh_qr_code .modal-content{height:auto}}
    </style>

    <script>
        const modal = document.getElementById('modal_qr_code');
        const modalImg = document.getElementById("img01");
        var img = document.querySelectorAll('.img_qr_code');
        for (var i=0; i<img.length; i++){
            img[i].onclick = function(){
            modal.style.display = "block";
            modalImg.src = this.src;
            modalImg.alt = this.alt;
        }
        }
        modal.onclick = function() {
            img01.className += " out";
        setTimeout(function() {
            modal.style.display = "none";
            img01.className = "modal-content";
        }, 400);
        }
    </script>
    <?php
    endif;
});

// Sửa số lượng hiển thị ở mỗi chuyên mục
add_filter( 'loop_shop_per_page', function($cols) { return 9; }, 20 );
// Thay đổi số lượng sản phẩm liên quan
function woo_related_products_limit() {
global $product;
$args['posts_per_page'] = 4;
return $args;
}
add_filter( 'woocommerce_output_related_products_args', 'jk_related_products_args' );
function jk_related_products_args( $args ) {
$args['posts_per_page'] = 4; // 4 related products
$args['columns'] = 4; // arranged in 4 columns
return $args;
}
add_filter('woocommerce_sale_flash','devvn_woocommerce_sale_flash', 10, 3);
function devvn_woocommerce_sale_flash($text, $post, $product){
ob_start();
$sale_price = get_post_meta( $product->get_id(), '_price', true);
$regular_price = get_post_meta( $product->get_id(), '_regular_price', true);
if (empty($regular_price) && $product->is_type( 'variable' )){
$available_variations = $product->get_available_variations();
$variation_id = $available_variations[0]['variation_id'];
$variation = new WC_Product_Variation( $variation_id );
$regular_price = $variation ->regular_price;
$sale_price = $variation ->sale_price;
}
$sale = ceil(( ($regular_price - $sale_price) / $regular_price ) * 100);
if ( !empty( $regular_price ) && !empty( $sale_price ) && $regular_price > $sale_price ) :
$R = floor((255*$sale)/100);
$G = floor((255*(100-$sale))/100);
echo apply_filters( 'devvn_woocommerce_sale_flash', '<span class="sale-flash">-' . $sale . '%</span>', $post, $product );
endif;
return ob_get_clean();
}
add_filter( 'woocommerce_checkout_fields' , 'devvn_custom_override_checkout_fields', 9999 );
function devvn_custom_override_checkout_fields( $fields ) {
$fields['billing']['billing_email']['required'] = false;
return $fields;
}
remove_action( 'woocommerce_before_shop_loop' , 'woocommerce_result_count', 20 );
add_action( 'woocommerce_before_shop_loop' , 'woocommerce_result_count', 20 );
remove_action('woocommerce_pagination', 'woocommerce_pagination', 10);
function hocwp_theme_custom_woocommerce_is_purchasable_filter( $can, $product ) {
if ( '' == $product->get_price() ) {
$can = $product->exists() && ( 'publish' === $product->get_status() || current_user_can( 'edit_post', $product->get_id() ) );
}
return $can;
}
add_filter( 'woocommerce_is_purchasable', 'hocwp_theme_custom_woocommerce_is_purchasable_filter', 10, 2 );
function hocwp_theme_wc_product_data_filter( $value, $data ) {
if ( empty( $value ) ) {
$value = 0;
}
return $value;
}

add_shortcode( 'stock_status', 'display_product_stock_status' );
function display_product_stock_status( $atts) {
$atts = shortcode_atts(
array('id'  => get_the_ID() ),
$atts, 'stock_status'
);

if( intval( $atts['id'] ) > 0 && function_exists( 'wc_get_product' ) ){
$product = wc_get_product( $atts['id'] );

$stock_status = $product->get_stock_status();

if ( 'instock' == $stock_status) {
$html = '<span class="stock in-stock">Còn hàng</span>';
} else {
$html = '<span class="stock out-of-stock">Hết hàng</span>';
}
}
return $html;
}
add_filter( 'woocommerce_product_tabs', 'woo_remove_product_tabs', 98 );
function woo_remove_product_tabs( $tabs ) {
unset( $tabs['description'] );          // Remove the description tab
unset( $tabs['reviews'] );          // Remove the reviews tab
unset( $tabs['additional_information'] );   // Remove the additional information tab
return $tabs;
}
function mytheme_add_woocommerce_support() {
add_theme_support( 'woocommerce' );
}
add_action( 'after_setup_theme', 'mytheme_add_woocommerce_support' );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
function devvn_wc_custom_get_price_html( $price, $product ) {
if ( $product->get_price() == 0 ) {
if ( $product->is_on_sale() && $product->get_regular_price() ) {
$regular_price = wc_get_price_to_display( $product, array( 'qty' => 1, 'price' => $product->get_regular_price() ) );

$price = wc_format_price_range( $regular_price, __( 'Free!', 'woocommerce' ) );
} else {
$price = '<span class="amount">' . __( 'Liên hệ', 'woocommerce' ) . '</span>';
}
}
return $price;
}
add_filter( 'woocommerce_get_price_html', 'devvn_wc_custom_get_price_html', 10, 2 );
// Gỡ bỏ breadcrumbs woocommerce
add_action( 'init', 'jk_remove_wc_breadcrumbs' );
function jk_remove_wc_breadcrumbs() {
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );
}
add_action( 'woocommerce_before_single_product', 'check_variable' ); function check_variable(){ if ( is_product() ) { global $post; $product = wc_get_product( $post->ID ); if ( $product->is_type( 'variable' ) ) { remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
add_action( 'woocommerce_single_product_summary', 'custom_wc_template_single_price', 10 );
function custom_wc_template_single_price(){
global $product;
if($product->is_type('variable')):
// Main Price
$prices = array( $product->get_variation_price( 'min', true ), $product->get_variation_price( 'max', true ) );
$price = $prices[0] !== $prices[1] ? sprintf( __( '%1$s', 'woocommerce' ), wc_price( $prices[0] ) ) : wc_price( $prices[0] );
// Sale Price
$prices = array( $product->get_variation_regular_price( 'min', true ), $product->get_variation_regular_price( 'max', true ) );
sort( $prices );
$saleprice = $prices[0] !== $prices[1] ? sprintf( __( '%1$s', 'woocommerce' ), wc_price( $prices[0] ) ) : wc_price( $prices[0] );
if ( $price !== $saleprice && $product->is_on_sale() ) {
$price = '<del>' . $saleprice . $product->get_price_suffix() . '</del> <ins>' . $price . $product->get_price_suffix() . '</ins>';
}
?>
<style>
div.woocommerce-variation-price,
div.woocommerce-variation-availability,
div.hidden-variable-price {
height: 0px !important;
overflow:hidden;
position:relative;
line-height: 0px !important;
font-size: 0% !important;
}
</style>
<script>
jQuery(document).ready(function($) {
$('input.variation_id').change( function(){
//Correct bug, I put 0
if( 0 != $('input.variation_id').val()){
$('p.price').html($('div.woocommerce-variation-price > span.price').html()).append('<p class="availability">'+$('div.woocommerce-variation-availability').html()+'</p>');
console.log($('input.variation_id').val());
} else {
$('p.price').html($('div.hidden-variable-price').html());
if($('p.availability'))
$('p.availability').remove();
console.log('NULL');
}
});
});
</script>
<?php
echo '<p class="price">'.$price.'</p>
<div class="hidden-variable-price" >'.$price.'</div>';
endif;
}
}
}
}
add_filter( 'woocommerce_variation_is_active', 'desactivar_variaciones_sin_stock', 10, 2 );
function desactivar_variaciones_sin_stock( $is_active, $variation ) {
if ( ! $variation->is_in_stock() ) return false;
return $is_active;
}
add_filter('woocommerce_variable_price_html', 'custom_variation_price', 10, 2);

function custom_variation_price( $price, $product ) {

$price = '';


$price .= woocommerce_price($product->get_price());

return $price;
}
add_shortcode('product_img_with_hover', 'obe_hover_shortcode');
function obe_hover_shortcode() {
global $product;
$post_thumbnail_id = $product->get_image_id();
$attachment_ids = $product->get_gallery_image_ids();
$class = ($attachment_ids) ? 'hover' : '';
if ( $post_thumbnail_id ) {
$html = wp_get_attachment_image( $post_thumbnail_id, true,false,array('class'=>$class) );
} else {
$html = sprintf( '<img src="%s" alt="%s" class="wp-post-image" />', esc_url( wc_placeholder_img_src( 'woocommerce_single' ) ), esc_html__( 'Awaiting product image', 'woocommerce' ) );
}


if ($attachment_ids) {
$html .= '<div class="img-2">';
    $html .= wp_get_attachment_image( $attachment_ids[0],true );
$html .= '</div>';
}
return $html;
}



class Home_style_2 extends WP_Widget {
function __construct(){
parent::__construct('Home_style_2',
'Sản phẩm sidebar',
array('description' => ''));
}
function widget( $args, $instance ) {
extract($args);
$title = apply_filters( 'widget_title',
empty($instance['title']) ? '' : $instance['title'],
$instance, $this->id_base);
$sp = apply_filters( 'widget_text', $instance['sp'], $instance );
echo $before_widget;
?>
<?php $term=get_term_by('id', $sp, 'product_cat') ?>
<div class="widget-product">
    <div class="widget-title"><?php echo $term->name; ?></div>
    <div class="list">
        <?php
        $args = array( 'showposts'=>5,'orderby' => 'ID',
        'order' => 'DESC',
        'tax_query' => array(
        'relation'  => 'AND',
        array(
        'taxonomy'         => 'product_cat',
        'field'            => 'id',
        'terms'            => array( $sp ),
        )
        ),
        );
        $query = new WP_Query( $args );while($query->have_posts()) : $query->the_post();global $product;?>
        <div class="item">
            <div class="img">
                <a href="<?php the_permalink()?>" title="<?php the_title(); ?>"><?php the_post_thumbnail('medium', array('alt'   => trim(strip_tags( $post->post_title )),'title' => trim(strip_tags( $post->post_title )),)); ?></a>
            </div>
            <div class="info">
                <h3 class="name"><a href="<?php the_permalink();?>"><?php the_title();?></a></h3>
                <?php woocommerce_get_template( 'loop/price.php' ); ?>
            </div>
        </div>
        <?php endwhile;
        ?>
    </div>
</div>
<?php
echo $after_widget;
}
function update( $new_instance, $old_instance ) {
$instance = $old_instance;
$instance['title'] = strip_tags($new_instance['title']);
$instance['sp'] =  $new_instance['sp'];
return $instance;
}
function form( $instance ) {
$instance = wp_parse_args( (array) $instance,
array( 'title' => '', 'sp' => '' ) );
$title = strip_tags($instance['title']);
$sp = ($instance['sp']);
?>
<p>
    <label for="<?php echo $this->get_field_id('title'); ?>">
    <?php _e('Tiêu đề :'); ?> </label>
    <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>"
    name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo  ($title);?>" />
</p>
<p>
    <label for="<?php echo $this->get_field_id('sp'); ?>">
    <?php _e('Chọn Chuyên Mục.'); ?> </label>
    <select name="<?php echo $this->get_field_name('sp'); ?>" id="">
        <?php
        $args = array(
        'orderby' => 'name',
        'hide_empty' => 0 ,'taxonomy'=>'product_cat'
        );
        $categories = get_categories( $args );
        foreach ( $categories as $category ) {?>
        <option value="<?php echo $category->cat_ID ?>" <?php if($category->cat_ID==$sp){echo 'selected="selected"';} ?>> <?php echo $category->name; ?></option>
        <?php }
        ?>
    </select>
</p>
<?php
}
}
register_widget('Home_style_2');
function evergreen_product_schema ($data) {
global $product;

$data['brand'] = get_bloginfo() ? get_bloginfo() : null;
$data['gtin13'] = zeroise($product->get_id(),13) ? zeroise($product->get_id(),13) : null;

return $data;
}
add_filter( 'woocommerce_structured_data_product', 'evergreen_product_schema' );


add_filter( 'woocommerce_variable_sale_price_html', 'wpglorify_variation_price_format', 10, 2 );
add_filter( 'woocommerce_variable_price_html', 'wpglorify_variation_price_format', 10, 2 );
 
function wpglorify_variation_price_format( $price, $product ) {
 
// Main Price
$prices = array( $product->get_variation_price( 'max', true ), $product->get_variation_price( 'min', true ) );
$price = $prices[0] !== $prices[1] ? sprintf( __( '%1$s', 'woocommerce' ), wc_price( $prices[0] ) ) : wc_price( $prices[0] );
 
// Sale Price
$prices = array( $product->get_variation_regular_price( 'max', true ), $product->get_variation_regular_price( 'min', true ) );
sort( $prices );
$saleprice = $prices[0] !== $prices[1] ? sprintf( __( '%1$s', 'woocommerce' ), wc_price( $prices[0] ) ) : wc_price( $prices[0] );
 
if ( $price !== $saleprice ) {
$price = '<del>' . $saleprice . $product->get_price_suffix() . '</del> <ins>' . $price . $product->get_price_suffix() . '</ins>';
}
return $price;
}
// End
// Thêm sp vào giỏ hàng update số lượng
add_filter('woocommerce_add_to_cart_fragments', 'woocommerce_header_add_to_cart_fragment');
function woocommerce_header_add_to_cart_fragment( $fragments ) {
    global $woocommerce;
    ob_start();
    ?>
    <span class="cout"><?php $cart_count = WC()->cart->get_cart_contents_count(); echo $cart_count; ?></span>
    <?php
    $fragments['.cout'] = ob_get_clean();
    return $fragments;
}
// End
// Tra cứu đơn hàng bởi sđt
/*
* Code theo dõi đơn hàng bằng SĐT
* Author levantoan.com
* 
*/
add_action('init', function (){
    remove_shortcode('woocommerce_order_tracking');
    add_shortcode('woocommerce_order_tracking', function ($atts){
    global $post;
    // Check cart class is loaded or abort.
    if ( is_null( WC()->cart ) ) {
        return;
    }
    ob_start();
    $atts        = shortcode_atts( array(), $atts, 'woocommerce_order_tracking' );
    $nonce_value = wc_get_var( $_REQUEST['woocommerce-order-tracking-nonce'], wc_get_var( $_REQUEST['_wpnonce'], '' ) ); // @codingStandardsIgnoreLine.
    if ( isset( $_REQUEST['orderid'] ) && wp_verify_nonce( $nonce_value, 'woocommerce-order_tracking' ) ) { // WPCS: input var ok.
        $order_id    = empty( $_REQUEST['orderid'] ) ? 0 : ltrim( wc_clean( wp_unslash( $_REQUEST['orderid'] ) ), '#' ); // WPCS: input var ok.
        $order_phone = empty( $_REQUEST['order_phone'] ) ? '' : sanitize_text_field( wp_unslash( $_REQUEST['order_phone'] ) ); // WPCS: input var ok.
        if ( ! $order_id ) {
            wc_print_notice( __( 'Vui lòng nhập ID đơn hàng', 'devvn' ), 'error' );
        } elseif ( ! $order_phone ) {
            wc_print_notice( __( 'Vui lòng nhập số điện thoại', 'devvn' ), 'error' );
        } else {
            $order = wc_get_order( apply_filters( 'woocommerce_shortcode_order_tracking_order_id', $order_id ) );
            if ( $order && $order->get_id() && is_a( $order, 'WC_Order' ) && strtolower( $order->get_billing_phone() ) === strtolower( $order_phone ) ) {
                do_action( 'woocommerce_track_order', $order->get_id() );
                wc_get_template(
                    'order/tracking.php',
                    array(
                        'order' => $order,
                    )
                );
                return ob_get_clean();
            } else {
                wc_print_notice( __( 'Xin lỗi, Chúng tôi không tìm thấy thông tin đơn hàng của bạn. Vui lòng liên hệ với chúng tôi để biết thông tin chi tiết!', 'devvn' ), 'error' );
            }
        }
    }
    wc_print_notices();
    ?>
    <form action="<?php echo esc_url( get_permalink( $post->ID ) ); ?>" method="post" class="woocommerce-form woocommerce-form-track-order track_order">
        <?php
        do_action( 'woocommerce_order_tracking_form_start' );
        ?>
        <p><?php esc_html_e( 'Để theo dõi đơn hàng của bạn xin vui lòng nhập ID đơn hàng và số điện thoại của bạn vào ô dưới đây và nhấn nút "Theo dõi".', 'devvn' ); ?></p>
        <p class="form-row form-row-first"><label for="orderid"><?php esc_html_e( 'ID Đơn hàng', 'devvn' ); ?></label> <input class="input-text" type="text" name="orderid" id="orderid" value="<?php echo isset( $_REQUEST['orderid'] ) ? esc_attr( wp_unslash( $_REQUEST['orderid'] ) ) : ''; ?>" placeholder="<?php esc_attr_e( 'Nhập ID Đơn hàng của bạn', 'devvn' ); ?>" /></p><?php // @codingStandardsIgnoreLine ?>
        <p class="form-row form-row-last"><label for="order_phone"><?php esc_html_e( 'Số điện thoại', 'devvn' ); ?></label> <input class="input-text" type="text" name="order_phone" id="order_phone" value="<?php echo isset( $_REQUEST['order_phone'] ) ? esc_attr( wp_unslash( $_REQUEST['order_phone'] ) ) : ''; ?>" placeholder="<?php esc_attr_e( 'Nhập số điện thoại của bạn', 'devvn' ); ?>" /></p><?php // @codingStandardsIgnoreLine ?>
        <div class="clear"></div>
        <?php
        do_action( 'woocommerce_order_tracking_form' );
        ?>
        <p class="form-row"><button type="submit" class="button<?php echo esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ); ?>" name="track" value="<?php esc_attr_e( 'Theo dõi', 'devvn' ); ?>"><?php esc_html_e( 'Theo dõi', 'devvn' ); ?></button></p>
        <?php wp_nonce_field( 'woocommerce-order_tracking', 'woocommerce-order-tracking-nonce' ); ?>
        <?php
        do_action( 'woocommerce_order_tracking_form_end' );
        ?>
    </form>
    <?php
    return ob_get_clean();
    });
}, 20);
// End
// Sửa HTML thông tin người nhận hàng ở trang Thankyou
add_filter('woocommerce_order_formatted_billing_address', 'custom_remove_billing_name', 10, 2);
function custom_remove_billing_name($address, $order) {
    // Loại bỏ tên người mua hàng
    $address['first_name'] = '';
    $address['last_name'] = '';

    return $address;
}
add_action('woocommerce_thankyou', 'get_order_details', 10, 1);
function get_order_details($order_id) {
    // Get an instance of the WC_Order object
    $order = wc_get_order($order_id);
    
    // Get the customer details
    $customer_name = $order->get_billing_first_name() . ' ' . $order->get_billing_last_name();
    $billing_address = $order->get_formatted_billing_address( esc_html__( 'N/A', 'woocommerce' ) );
    $phone_number = $order->get_billing_phone();
    $email_address = $order->get_billing_email();
    
    // Output the customer details (for testing purposes)
    echo '<div class="customnew">';
    echo '<h2>Thông tin nhận hàng</h2>';
    echo '<p><b>Tên:</b> ' . $customer_name . '</p>';
    echo '<p><b>Địa chỉ:</b> ' . $billing_address . '</p>';
    echo '<p><b>Số điện thoại:</b> ' . $phone_number . '</p>';
    echo '<p><b>Email:</b> ' . $email_address . '</p>';
    echo '</div>';
    
    // You can also use these details for other purposes, like sending an email or saving to a database
}
function my_custom_scripts() {
    // Đăng ký jQuery nếu chưa được đăng ký
    wp_enqueue_script('jquery');
    
    // Viết mã jQuery trực tiếp
    $custom_js = "
        jQuery(document).ready(function($) {
            $('.customnew').each(function() {
                // Thay thế tất cả các thẻ <br> bằng dấu ,
                $(this).html($(this).html().replace(/<br\\s*\\/?>/gi, ', '));
            });
        });
    ";

    // Thêm mã jQuery vào trang
    wp_add_inline_script('jquery', $custom_js);
}
add_action('wp_enqueue_scripts', 'my_custom_scripts');
// End
// thêm ảnh đại diện sản phẩm ở trang thanh toán
add_filter( 'woocommerce_cart_item_name', 'bbloomer_product_image_review_order_checkout', 9999, 3 );
function bbloomer_product_image_review_order_checkout( $name, $cart_item, $cart_item_key ) {
if ( ! is_checkout() ) return $name;
$product = $cart_item['data'];
$thumbnail = $product->get_image( array( '50', '50' ), array( 'class' => 'alignleft' ) );
return $thumbnail . $name;
}
// End

?>