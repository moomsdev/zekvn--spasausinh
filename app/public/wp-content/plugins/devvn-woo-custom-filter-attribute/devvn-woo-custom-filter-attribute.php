<?php
/*
 * Plugin Name: Woocommerce Custom Filter Attribute
 * Plugin URI: https://levantoan.com/san-pham/plugin-tuy-bien-bo-loc-san-pham-theo-hinh-anh-va-mau-sac/
 * Version: 1.0.0
 * Description: Add custom filter attribute layout
 * Author: Le Van Toan
 * Author URI: http://levantoan.com
 * Text Domain: devvn-woofilter
 * Domain Path: /languages
*/
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

if (
    in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) )
) {

    register_activation_hook(__FILE__, array('DevVN_Woo_Custom_Filer_Class', 'on_activation'));
    register_deactivation_hook(__FILE__, array('DevVN_Woo_Custom_Filer_Class', 'on_deactivation'));
    register_uninstall_hook(__FILE__, array('DevVN_Woo_Custom_Filer_Class', 'on_uninstall'));

    load_textdomain('devvn-woofilter', dirname(__FILE__) . '/languages/devvn-woofilter-' . get_locale() . '.mo');

    class DevVN_Woo_Custom_Filer_Class
    {
        protected static $instance;

        protected $_version = '1.0.0';

        public static function init()
        {
            is_null(self::$instance) AND self::$instance = new self;
            return self::$instance;
        }

        public function __construct()
        {
            $this->define_constants();
            include dirname( __FILE__ ) . '/includes/abstract-wcfa-widget.php';
            require_once dirname( __FILE__ ) . '/includes/class-wcfa-widget-layered-nav.php';

            add_action( 'widgets_init', array($this, 'wcfa_register_widgets'), 25 );

            add_action( 'admin_enqueue_scripts', array($this, 'devvn_woofilter_register_scripts'), 1 );
            add_action( 'wp_ajax_wcfa_get_terms_attr', array($this, 'wcfa_get_terms_attr_func') );

            add_action( 'wp_enqueue_scripts', array($this, 'wcfa_frontend_enqueue_style') );

        }

        function wcfa_register_widgets() {
            register_widget( 'DevVN_Widget_Custom_Filter_Attribute' );
        }

        public function define_constants()
        {
            if (!defined('DEVVN_WOOFILTER_VERSION_NUM'))
                define('DEVVN_WOOFILTER_VERSION_NUM', $this->_version);
            if (!defined('DEVVN_WOOFILTER_URL'))
                define('DEVVN_WOOFILTER_URL', plugin_dir_url(__FILE__));
            if (!defined('DEVVN_WOOFILTER_BASENAME'))
                define('DEVVN_WOOFILTER_BASENAME', plugin_basename(__FILE__));
            if (!defined('DEVVN_WOOFILTER_PLUGIN_DIR'))
                define('DEVVN_WOOFILTER_PLUGIN_DIR', plugin_dir_path(__FILE__));

        }

        public static function on_activation()
        {
            if (!current_user_can('activate_plugins'))
                return false;
            $plugin = isset($_REQUEST['plugin']) ? $_REQUEST['plugin'] : '';
            check_admin_referer("activate-plugin_{$plugin}");

        }

        public static function on_deactivation()
        {
            if (!current_user_can('activate_plugins'))
                return false;
            $plugin = isset($_REQUEST['plugin']) ? $_REQUEST['plugin'] : '';
            check_admin_referer("deactivate-plugin_{$plugin}");

        }

        public static function on_uninstall()
        {
            if (!current_user_can('activate_plugins'))
                return false;
        }

        function devvn_woofilter_register_scripts() {
            $current_screen = get_current_screen();
            if(isset($current_screen->base) && $current_screen->base == 'widgets') {
                wp_enqueue_style('woofilter-css', plugins_url('assets/css/devvn-woofilter-style.css', __FILE__), array(), DEVVN_WOOFILTER_VERSION_NUM, 'all');
                wp_enqueue_script('woofilter-js', plugins_url('assets/js/devvn-woofilter-jquery.js', __FILE__), array('jquery', 'wp-color-picker'), DEVVN_WOOFILTER_VERSION_NUM, true);

                $php_array = array(
                    'homeurl' => home_url(),
                    'ajaxurl'   =>  admin_url('admin-ajax.php')
                );
                wp_localize_script('woofilter-js', 'devvn_wcfa_array', $php_array);
            }
        }

        function wcfa_frontend_enqueue_style(){
            wp_enqueue_style('wcfa-css', plugins_url('assets/css/devvn-wcfa-style.css', __FILE__), array(), DEVVN_WOOFILTER_VERSION_NUM, 'all');
        }

        function wcfa_get_terms_attr_func() {
            $tax_slug = isset($_REQUEST['tax_slug']) ? wc_clean(esc_attr($_REQUEST['tax_slug'])) : '';
            $value = isset($_REQUEST['value_default']) ? maybe_unserialize(str_replace('\"','"', $_REQUEST['value_default'])) : array();
            $key = isset($_REQUEST['key_default']) ? wc_clean(esc_attr($_REQUEST['key_default'])) : '';
            $result = array();
            if($tax_slug){
                $args = array(
                    'taxonomy' => 'pa_' . $tax_slug,
                    'hide_empty' => 0,
                );
                $all_terms = get_terms( $args );
                if($all_terms){
                    ob_start();
                    foreach ( $all_terms as $term ) :
                        $imgid = isset($value[$term->term_id]['img']) ? intval($value[$term->term_id]['img']) : '';
                        $color = isset($value[$term->term_id]['color']) ? esc_attr($value[$term->term_id]['color']) : '';
                        $text1 = isset($value[$term->term_id]['text1']) ? esc_attr($value[$term->term_id]['text1']) : '';
                        $text2 = isset($value[$term->term_id]['text2']) ? esc_attr($value[$term->term_id]['text2']) : '';
                        ?>
                        <tr>
                            <td class="wcfa_attr_title"><?php echo $term->name;?></td>
                            <td>
                                <div class="wcfa-upload-image <?php if($imgid):?>wcfa-has-image<?php endif;?>">
                                    <div class="wcfa-view-has-value">
                                        <input type="hidden" class="clone_delete" name="<?php echo $key; ?>[<?php echo $term->term_id; ?>][img]" value="<?php echo $imgid;?>"/>
                                        <img src="<?php echo wp_get_attachment_image_url($imgid,'full')?>" class="wcfa-image_view"/>
                                        <a href="#" class="wcfa-delete-image">x</a>
                                    </div>
                                    <div class="wcfa-hidden-has-value"><input type="button" class="wcfa-upload button" value="<?php _e( 'Select images', 'devvn-woofilter' )?>" /></div>
                                </div>
                            </td>
                            <td><input type="text" name="<?php echo $key; ?>[<?php echo $term->term_id; ?>][color]" value="<?php echo $color;?>" class="wcfa-color" ></td>
                            <td><input class="widefat" type="text" name="<?php echo $key; ?>[<?php echo $term->term_id; ?>][text1]" value="<?php echo $text1; ?>"></td>
                            <td><input class="widefat" type="text" name="<?php echo $key; ?>[<?php echo $term->term_id; ?>][text2]" value="<?php echo $text2; ?>"></td>
                        </tr>
                    <?php endforeach;
                    $html = ob_get_clean();
                    $result['fragments'] = array(
                        '.devvn_woo_filter tbody' =>  $html
                    );
                }else{
                    $result['mess'] = __('No attribute value to load!','devvn-woofilter');
                }
                wp_send_json_success($result);
            }
            $result['mess'] = __('Have a error to load attribute!', 'devvn-woofilter');
            wp_send_json_error($result);
            die();
        }
    }

    function devvn_cwfa()
    {
        return DevVN_Woo_Custom_Filer_Class::init();
    }

    devvn_cwfa();

}