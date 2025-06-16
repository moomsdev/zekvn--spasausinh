<?php 
function my_custom_login()
{
echo '<link rel="stylesheet" type="text/css" href="' . get_bloginfo('stylesheet_directory') . '/admin/style.css" />';
echo '<link rel="stylesheet" type="text/css" href="' . get_bloginfo('stylesheet_directory') . '/fonts/font-awesome.min.css" />';
}
add_action('login_head', 'my_custom_login');


function the_url( $url ) {
    return get_bloginfo( 'url' );
}
add_filter( 'login_headerurl', 'the_url' );

function my_url_login_hover(){
     return 'Tiêu đề';
}
add_filter('login_headertitle', 'my_url_login_hover');


function custom_login_message($message)
{
    $action = $_REQUEST['action'];
    if($action == 'register')
    {
        $message = '<p class="message register">Đăng ký làm thành viên.</p>';
    }
    elseif($action == 'lostpassword')
    {
        $message = '<p class="message">Hãy điền vào địa chỉ email của bạn để lấy lại mật khẩu.</p>';
    }
    return $message;
}
add_filter('login_message', 'custom_login_message');
 
function custom_login_error($error)
{
    if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'lostpassword')
    {
        $error = '<strong>Lỗi:</strong> Xin vui lòng nhập chính xác địa chỉ email.';
    }
    elseif(isset($_REQUEST['registration']) && $_REQUEST['registration'] == 'disabled')
    {
        $error = '<strong>Lỗi:</strong> Hệ thống không cho phép đăng ký tài khoản.';
    }
    else
    {
        $error = '<strong>Đăng nhập thất bại:</strong> Xin vui lòng nhập đúng tên tài khoản và mật khẩu của bạn.';
    }
    return $error;
}
add_filter( 'login_errors', 'custom_login_error' );
 
function change_form_text( $translation, $text )
{
    if ( 'Username' == $text ) { return 'Tài khoản'; }
    if ( 'Password' == $text ) { return 'Mật khẩu'; }
    if ( 'Remember Me' == $text ) { return 'Nhớ mật khẩu'; }
    if ( 'Log In' == $text || 'Log in' == $text ) { return 'Tiếp tục'; }
    if ( 'Lost your password?' == $text ) { return 'Quên mật khẩu?'; }
    if ( '&larr; Back to %s' == $text ) { return 'Quay lại trang chủ'; }
    if ( 'Register' == $text ) { return 'Đăng ký'; }
    if ( 'E-mail' == $text ) { return 'Địa chỉ email'; }
    if ( 'A password will be e-mailed to you.' == $text ) { return 'Mật khẩu sẽ được chuyển đến email của bạn.'; }
    if ( 'Username or E-mail:' == $text ) { return 'User hoặc email'; }
    if ( 'Get New Password' == $text ) { return 'Nhận mật khẩu mới'; }
    if ( 'You are now logged out.' == $text ) { return 'Bạn đã đăng xuất khỏi hệ thống.'; }
    return $translation;
}
add_filter( 'gettext', 'change_form_text', 10, 2 );


add_action('login_footer', 'my_addition_to_login_footer');
function my_addition_to_login_footer() {
     echo '<div class="reseller-infos">
                                <p>
                                    Hỗ trợ kỹ thuật : <a target="_blank" href="tel:0812119111"><strong> 0812.119.111</strong></a>
                                </p>
                                <p>Hỗ trợ tư vấn và phát triển web: <a target="_blank" href="tel:0812119111"><strong> 0812.119.111</strong></a>
                                <p>
                                    Website : <a target="_blank" href="https://zek.vn/">Zek.vn</a>
                                </p>
                                <p>
                                    Email : <a target="_blank" href="mailto:hotro.zekvn@gmail.com">hotro.zekvn@gmail.com</a> 
                                </p>
                                
                                <p>
                                    Hỗ trợ khách hàng các ngày trong tuần từ Thứ Hai đến Chủ nhật <br> <span style="font-style:italic">(từ 8h00 – 22h00 hàng ngày)</span>
                                </p>

                            </div>';
}

function disable_password_reset() {
              return false;
              }


?>