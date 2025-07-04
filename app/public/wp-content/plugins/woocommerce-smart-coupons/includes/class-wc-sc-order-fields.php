<?php
/**
 * Smart Coupons fields in orders
 *
 * @author      StoreApps
 * @since       3.3.0
 * @version     2.1.0
 *
 * @package     woocommerce-smart-coupons/includes/
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists( 'WC_SC_Order_Fields' ) ) {

	/**
	 * Class for handling Smart Coupons' field in orders
	 */
	class WC_SC_Order_Fields {

		/**
		 * Variable to hold instance of WC_SC_Order_Fields
		 *
		 * @var $instance
		 */
		private static $instance = null;

		/**
		 * Constructor
		 */
		private function __construct() {

			add_action( 'woocommerce_admin_order_totals_after_discount', array( $this, 'admin_order_totals_add_smart_coupons_discount_details' ) );
			add_filter( 'woocommerce_get_order_item_totals', array( $this, 'add_smart_coupons_discount_details' ), 10, 3 );

			add_action( 'wp_loaded', array( $this, 'order_fields_hooks' ) );

			add_filter( 'woocommerce_cart_totals_coupon_label', array( $this, 'cart_totals_smart_coupons_label' ), 10, 2 );
			add_filter( 'woocommerce_cart_totals_order_total_html', array( $this, 'cart_totals_order_total_html' ), 99 );
			add_filter( 'woocommerce_get_formatted_order_total', array( $this, 'get_formatted_order_total' ), 99, 2 );
			add_action( 'woocommerce_email_after_order_table', array( $this, 'show_store_credit_balance' ), 10, 3 );

			add_filter( 'woocommerce_get_coupon_id_from_code', array( $this, 'get_coupon_id_from_code' ), 1000, 3 );

			add_filter( 'woocommerce_order_item_get_discount', array( $this, 'smart_coupon_get_discount' ), 99, 2 );

		}

		/**
		 * Get single instance of WC_SC_Order_Fields
		 *
		 * @return WC_SC_Order_Fields Singleton object of WC_SC_Order_Fields
		 */
		public static function get_instance() {
			// Check if instance is already exists.
			if ( is_null( self::$instance ) ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		/**
		 * Handle call to functions which is not available in this class
		 *
		 * @param string $function_name The function name.
		 * @param array  $arguments Array of arguments passed while calling $function_name.
		 * @return result of function call
		 */
		public function __call( $function_name, $arguments = array() ) {

			global $woocommerce_smart_coupon;

			if ( ! is_callable( array( $woocommerce_smart_coupon, $function_name ) ) ) {
				return;
			}

			if ( ! empty( $arguments ) ) {
				return call_user_func_array( array( $woocommerce_smart_coupon, $function_name ), $arguments );
			} else {
				return call_user_func( array( $woocommerce_smart_coupon, $function_name ) );
			}

		}

		/**
		 * Function to show store credit used in order admin panel
		 *
		 * @param int $order_id The order id.
		 */
		public function admin_order_totals_add_smart_coupons_discount_details( $order_id = 0 ) {
			global $store_credit_label, $woocommerce_smart_coupon;

			if ( empty( $order_id ) ) {
				return;
			}

			$order = wc_get_order( $order_id );

			$total_credit_used = $woocommerce_smart_coupon->get_total_credit_used_in_order( $order, true );

			if ( empty( $total_credit_used ) ) {
				return;
			}

			?>

			<tr>
				<td class="label">
					<?php
						/* translators: %s: singular name for store credit */
						echo ! empty( $store_credit_label['singular'] ) ? sprintf( esc_html__( '%s Used', 'woocommerce-smart-coupons' ), esc_html( ucwords( $store_credit_label['singular'] ) ) ) : esc_html__( 'Store Credit Used', 'woocommerce-smart-coupons' );
					?>
					<span class="tips" data-tip="<?php echo esc_attr__( 'This is the total credit used.', 'woocommerce-smart-coupons' ); ?>">[?]</span>:</td>
				<td width="1%"></td>
				<td class="total">
					<?php
					if ( $this->is_wc_gte_30() ) {
						echo '-' . wc_price( $total_credit_used, array( 'currency' => $order->get_currency() ) ); // phpcs:ignore
					} else {
						echo '-' . wc_price( $total_credit_used, array( 'currency' => $order->get_order_currency() ) ); // phpcs:ignore
					}
					?>
				</td>
			</tr>

			<?php

		}

		/**
		 * Function to add hooks based on conditions
		 */
		public function order_fields_hooks() {

			if ( $this->is_wc_gte_30() ) {
				add_filter( 'woocommerce_order_get_total_discount', array( $this, 'smart_coupons_order_amount_total_discount' ), 10, 2 );
			} else {
				add_filter( 'woocommerce_order_amount_total_discount', array( $this, 'smart_coupons_order_amount_total_discount' ), 10, 2 );
			}

		}

		/**
		 * Function to add details of discount coming from Smart Coupons
		 *
		 * @param array    $total_rows All rows.
		 * @param WC_Order $order The order object.
		 * @param string   $tax_display Tax to display.
		 * @return array $total_rows
		 */
		public function add_smart_coupons_discount_details( $total_rows = array(), $order = null, $tax_display = '' ) {
			global $store_credit_label, $woocommerce_smart_coupon;

			if ( empty( $order ) || empty( $total_rows ) ) {
				return $total_rows;
			}

			$credit_used       = $woocommerce_smart_coupon->get_credit_used_in_order( $order );
			$total_credit_used = $credit_used['discount'] + $credit_used['discount_tax'];

			$offset = array_search( 'order_total', array_keys( $total_rows ), true );

			if ( false === $offset || empty( $total_credit_used ) ) {
				return $total_rows;
			}

			// Add smart coupon row.
			$total_rows = array_merge(
				array_slice( $total_rows, 0, $offset ),
				array(
					'smart_coupon' => array(
						/* translators: %s: singular name for store credit */
						'label' => ! empty( $store_credit_label['singular'] ) ? sprintf( __( '%s Used:', 'woocommerce-smart-coupons' ), ucwords( $store_credit_label['singular'] ) ) : __( 'Store Credit Used:', 'woocommerce-smart-coupons' ),
						'value' => '-' . wc_price( $total_credit_used ),
					),
				),
				array_slice( $total_rows, $offset, null )
			);

			return $total_rows;

		}

		/**
		 * Function to include discounts from Smart Coupons in total discount of order
		 *
		 * @param float    $total_discount Total discount.
		 * @param WC_Order $order The order object.
		 * @return float $total_discount
		 */
		public function smart_coupons_order_amount_total_discount( $total_discount, $order = null ) {
			global $woocommerce_smart_coupon;

			if ( ! $this->is_callable( $order, 'get_id' ) ) {
				return $total_discount;
			}
			$credit_used       = $woocommerce_smart_coupon->get_credit_used_in_order( $order );
			$total_credit_used = $credit_used['discount'] + $credit_used['discount_tax'];
			if ( $total_credit_used > 0 ) {
				$total_discount = $total_discount - $total_credit_used;
				if ( ! $order->get_prices_include_tax() ) {
					$total_discount += $credit_used['discount_tax'];
				}
			}

			return $total_discount;
		}

		/**
		 * Function to add label for smart_coupons in cart total
		 *
		 * @param string    $default_label Default label.
		 * @param WC_Coupon $coupon The coupon object.
		 * @return string $new_label
		 */
		public function cart_totals_smart_coupons_label( $default_label = '', $coupon = null ) {
			global $store_credit_label;

			if ( empty( $coupon ) ) {
				return $default_label;
			}

			if ( $this->is_wc_gte_30() ) {
				$discount_type = ( ! empty( $coupon ) && is_callable( array( $coupon, 'get_discount_type' ) ) ) ? $coupon->get_discount_type() : '';
				$coupon_code   = ( ! empty( $coupon ) && is_callable( array( $coupon, 'get_code' ) ) ) ? $coupon->get_code() : '';
			} else {
				$discount_type = ( ! empty( $coupon->discount_type ) ) ? $coupon->discount_type : '';
				$coupon_code   = ( ! empty( $coupon->code ) ) ? $coupon->code : '';
			}

			if ( ! empty( $discount_type ) && 'smart_coupon' === $discount_type ) {
				$credit_label = ! empty( $store_credit_label['singular'] ) ? ucwords( $store_credit_label['singular'] ) . ':' : __( 'Store Credit:', 'woocommerce-smart-coupons' );
				return $credit_label . ' ' . $coupon_code;
			}

			return $default_label;

		}

		/**
		 * Modify Tax detail HTML if store credit is applied, in cart
		 *
		 * @param string $html The total html.
		 * @return string $html
		 */
		public function cart_totals_order_total_html( $html = null ) {

			if ( empty( $html ) ) {
				return $html;
			}

			if ( ! class_exists( 'WCS_SC_Compatibility' ) ) {
				include_once 'class-wcs-compatibility.php';
			}

			$is_display_price_incl_tax = ( $this->is_wc_gte_33() ) ? WC()->cart->display_prices_including_tax() : ( 'incl' === WC()->cart->tax_display_cart );

			if ( wc_tax_enabled() && true === $is_display_price_incl_tax ) {

				$applied_coupons = ( is_object( WC()->cart ) && is_callable( array( WC()->cart, 'get_applied_coupons' ) ) ) ? WC()->cart->get_applied_coupons() : array();

				if ( empty( $applied_coupons ) ) {
					return $html;
				}

				foreach ( $applied_coupons as $code ) {
					$coupon = new WC_Coupon( $code );
					if ( $this->is_wc_gte_30() ) {
						$discount_type = $coupon->get_discount_type();
					} else {
						$discount_type = ( ! empty( $coupon->discount_type ) ) ? $coupon->discount_type : '';
					}
					if ( ! is_a( $coupon, 'WC_Coupon' ) || 'smart_coupon' !== $discount_type ) {
						continue;
					}
					if ( WC()->cart->get_total() === 0 || WC()->cart->get_total() <= WC()->cart->get_taxes_total() ) {
						$cart_contains_subscription = WCS_SC_Compatibility::is_cart_contains_subscription();
						$calculation_type           = '';
						if ( $cart_contains_subscription ) {
							$calculation_type = WC_Subscriptions_Cart::get_calculation_type();
							if ( 'recurring_total' !== $calculation_type ) {
								return '<strong>' . WC()->cart->get_total() . '</strong> ';
							} else {
								return $html;
							}
						} else {
							return '<strong>' . WC()->cart->get_total() . '</strong> ';
						}
					}
				}
			}

			return $html;
		}


		/**
		 * Modify Tax detail HTML if store credit is applied, in order
		 *
		 * @param string   $html The order total html.
		 * @param WC_Order $order The order object (optional).
		 * @return string $html
		 */
		public function get_formatted_order_total( $html = null, $order = null ) {

			if ( empty( $html ) || empty( $order ) ) {
				return $html;
			}

			if ( $this->is_wc_gte_30() ) {
				$tax_display = get_option( 'woocommerce_tax_display_cart' );
			} else {
				$tax_display = ( ! empty( $order->tax_display_cart ) ) ? $order->tax_display_cart : '';
			}

			if ( wc_tax_enabled() && 'incl' === $tax_display ) {

				$applied_coupons = $this->get_coupon_codes( $order );

				if ( empty( $applied_coupons ) ) {
					return $html;
				}

				foreach ( $applied_coupons as $code ) {
					$coupon = new WC_Coupon( $code );
					if ( $this->is_wc_gte_30() ) {
						$discount_type = $coupon->get_discount_type();
					} else {
						$discount_type = ( ! empty( $coupon->discount_type ) ) ? $coupon->discount_type : '';
					}
					if ( ! is_a( $coupon, 'WC_Coupon' ) || 'smart_coupon' !== $discount_type ) {
						continue;
					}
					if ( $order->get_total() === 0 || $order->get_total() <= $order->get_total_tax() ) {
						return wc_price( $order->get_total() );
					}
				}
			}

			return $html;
		}

		/**
		 * Function to notify user about remaining balance in Store Credit in "Order Complete" email
		 *
		 * @param WC_Order $order The order object.
		 * @param boolean  $send_to_admin Is send to admin.
		 * @param boolean  $plain_text Is plain text email.
		 */
		public function show_store_credit_balance( $order = false, $send_to_admin = false, $plain_text = false ) {
			global $store_credit_label;

			if ( $send_to_admin ) {
				return;
			}

			if ( $this->is_wc_gte_30() ) {
				$order_refunds = ( ! empty( $order ) && is_callable( array( $order, 'get_refunds' ) ) ) ? $order->get_refunds() : array();
			} else {
				$order_refunds = ( ! empty( $order->refunds ) ) ? $order->refunds : array();
			}

			if ( ! empty( $order_refunds ) ) {
				return;
			}

			$used_coupons = $this->get_coupon_codes( $order );
			if ( count( $used_coupons ) > 0 ) {
				$store_credit_balance = '';
				foreach ( $used_coupons as $code ) {
					if ( ! $code ) {
						continue;
					}
					$coupon = new WC_Coupon( $code );
					if ( $this->is_wc_gte_30() ) {
						$discount_type = $coupon->get_discount_type();
						$coupon_code   = $coupon->get_code();
					} else {
						$discount_type = ( ! empty( $coupon->discount_type ) ) ? $coupon->discount_type : '';
						$coupon_code   = ( ! empty( $coupon->code ) ) ? $coupon->code : '';
					}

					$coupon_amount = $this->get_amount( $coupon, true, $order );

					if ( 'smart_coupon' === $discount_type && $coupon_amount > 0 ) {
						$store_credit_balance .= '<li><strong>' . $coupon_code . '</strong> &mdash; ' . wc_price( $coupon_amount ) . '</li>';
					}
				}

				if ( ! empty( $store_credit_balance ) ) {
					/* translators: %s: singular name for store credit */
					$balance_left_txt = ! empty( $store_credit_label['singular'] ) ? sprintf( __( '%s Balance ', 'woocommerce-smart-coupons' ), esc_html( ucwords( $store_credit_label['singular'] ) ) ) : __( 'Store Credit / Gift Card Balance', 'woocommerce-smart-coupons' );
					echo '<br /><h3>' . esc_html( $balance_left_txt ) . ': </h3>';
					echo '<ul>' . wp_kses_post( $store_credit_balance ) . '</ul><br />'; // phpcs:ignore
				}
			}
		}

		/**
		 * Force try to find the coupon's id by code
		 * in some cases like when coupon is trashed
		 *
		 * @param integer $id The coupon's id.
		 * @param string  $code The coupon code.
		 * @param integer $exclude_id Exclude coupon's id.
		 * @return integer
		 */
		public function get_coupon_id_from_code( $id = 0, $code = '', $exclude_id = 0 ) {
			if ( empty( $id ) ) {
				$backtrace           = debug_backtrace( DEBUG_BACKTRACE_IGNORE_ARGS );  // phpcs:ignore
				$backtrace_functions = wp_list_pluck( $backtrace, 'function' );
				if ( in_array( 'get_total_credit_used_in_order', $backtrace_functions, true ) ) {
					$index  = array_search( 'get_total_credit_used_in_order', $backtrace_functions, true );
					$traced = ( ! empty( $backtrace[ $index ] ) && 'WC_Smart_Coupons' === $backtrace[ $index ]['class'] && 'get_total_credit_used_in_order' === $backtrace[ $index ]['function'] );
					if ( true === $traced ) {
						global $wpdb;
						$post_id = $wpdb->get_var( // phpcs:ignore
							$wpdb->prepare(
								"
									SELECT ID
									FROM $wpdb->posts
									WHERE post_title = %s
									AND post_type = 'shop_coupon'
									ORDER BY ID DESC
								",
								$code
							)
						);
						if ( ! empty( $post_id ) ) {
							return absint( $post_id );
						}
					}
				}
			}
			return $id;
		}

		/**
		 * Function to get total discount applied by store credit.
		 *
		 * @param float                $discount The original discount.
		 * @param WC_Order_Item_Coupon $order_item The coupon order item.
		 * @return float
		 */
		public function smart_coupon_get_discount( $discount = 0, $order_item = null ) {
			if ( ( function_exists( 'wc_tax_enabled' ) && false === wc_tax_enabled() ) || ( get_option( 'woocommerce_calc_taxes' ) === 'no' ) ) {
				return $discount;
			}
			$discount_tax = $this->is_callable( $order_item, 'get_discount_tax' ) ? $order_item->get_discount_tax() : 0;
			if ( empty( $discount_tax ) ) {
				return $discount;
			}
			$order_id = ( $this->is_callable( $order_item, 'get_order_id' ) ) ? $order_item->get_order_id() : 0;
			if ( $this->is_old_sc_order( $order_id ) ) {
				return $discount;
			}
			if ( is_admin() && $order_item->is_type( 'coupon' ) ) {
				if ( $this->is_wc_gte_87() ) {
					$coupon_data   = json_decode( $order_item->get_meta( 'coupon_info' ), true );
					$discount_type = isset( $coupon_data[2] ) && ! empty( $coupon_data[2] ) ? $coupon_data[2] : '';
				} else {
					$coupon_data   = $order_item->get_meta( 'coupon_data' );
					$discount_type = isset( $coupon_data['discount_type'] ) && ! empty( $coupon_data['discount_type'] ) ? $coupon_data['discount_type'] : '';
				}
				if ( ! empty( $discount_type ) && 'smart_coupon' === $discount_type ) {
					$backtrace = debug_backtrace( DEBUG_BACKTRACE_IGNORE_ARGS ); // phpcs:ignore
					if ( ! empty( $backtrace ) && is_array( $backtrace ) ) {
						$args = array();
						foreach ( $backtrace as $trace ) {
							if ( array_key_exists( 'args', $trace ) ) {
								$args = array_merge( $args, array_values( $trace['args'] ) );
							}
						}
						$args = array_filter( array_unique( $args ) );
						if ( ! empty( $args ) && is_array( $args ) ) {
							foreach ( $args as $path ) {
								if ( stripos( $path, 'admin/meta-boxes/views/html-order-items.php' ) !== false ) {
									$discount += $discount_tax;
									break;
								}
							}
						}
					}
				}
			}
			return $discount;
		}

	}

}

WC_SC_Order_Fields::get_instance();
