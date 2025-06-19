<?php
/**
 * Plugin Name: Homecare Coupon Generator
 * Description: Generate bulk coupons with customizable options, including free shipping, promo combinations, a prefix, and the ability to delete all coupons.
 * Version: 1.6
 * Author: Duong Kim
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Add admin menu
add_action('admin_menu', 'bca_add_admin_menu');
function bca_add_admin_menu() {
    add_menu_page(
        'BCA Coupon Generator',
        'BCA Coupons',
        'manage_options',
        'bca-coupon-generator',
        'bca_coupon_generator_page',
        'dashicons-tickets',
        26
    );
}

// Admin page content
function bca_coupon_generator_page() {
    if (!current_user_can('manage_options')) {
        return;
    }

    // Handle form submission
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['bca_generate_coupons'])) {
            check_admin_referer('bca_generate_coupons_nonce');

            $count = intval($_POST['bca_coupon_count']);
            $prefix = sanitize_text_field($_POST['bca_coupon_prefix']);
            $type = sanitize_text_field($_POST['bca_coupon_type']);
            $amount = floatval($_POST['bca_coupon_amount']);
            $minimum = floatval($_POST['bca_minimum_amount']);
            $usage_limit = intval($_POST['bca_usage_limit']);
            $usage_limit_per_user = intval($_POST['bca_usage_limit_per_user']);
            $expiry_date = sanitize_text_field($_POST['bca_expiry_date']);
            $free_shipping = sanitize_text_field($_POST['bca_free_shipping']);
            $apply_other_discounts = sanitize_text_field($_POST['bca_apply_other_discounts']);

            if ($count < 1 || $amount <= 0) {
                echo '<div class="notice notice-error"><p>Invalid input. Please check your values and try again.</p></div>';
            } else {
                bca_generate_bulk_coupons($count, $prefix, $type, $amount, $minimum, $usage_limit, $usage_limit_per_user, $expiry_date, $free_shipping, $apply_other_discounts);
            }
        } elseif (isset($_POST['bca_delete_all_coupons'])) {
            check_admin_referer('bca_delete_coupons_nonce');
            bca_delete_all_coupons();
        }
    }

    // Display form
    ?>
    <div class="wrap">
        <h1>BCA Coupon Generator</h1>

        <!-- Generate Coupons Form -->
        <form method="post" action="">
            <?php wp_nonce_field('bca_generate_coupons_nonce'); ?>

            <label for="bca_coupon_count">Number of Coupons to Generate:</label>
            <input type="number" id="bca_coupon_count" name="bca_coupon_count" min="1" required><br><br>

            <label for="bca_coupon_prefix">Coupon Prefix:</label>
            <input type="text" id="bca_coupon_prefix" name="bca_coupon_prefix" value="bca" maxlength="10" required><br><br>

            <label for="bca_coupon_type">Discount Type:</label>
            <select id="bca_coupon_type" name="bca_coupon_type">
                <option value="fixed_cart">Fixed Discount</option>
                <option value="percent">Percentage Discount</option>
            </select><br><br>

            <label for="bca_coupon_amount">Discount Amount:</label>
            <input type="number" id="bca_coupon_amount" name="bca_coupon_amount" min="1" required><br><br>

            <label for="bca_minimum_amount">Minimum Order Amount:</label>
            <input type="number" id="bca_minimum_amount" name="bca_minimum_amount" min="0" step="0.01"><br><br>

            <label for="bca_usage_limit">Usage Limit per Coupon:</label>
            <input type="number" id="bca_usage_limit" name="bca_usage_limit" min="1" required><br><br>

            <label for="bca_usage_limit_per_user">Usage Limit per User:</label>
            <input type="number" id="bca_usage_limit_per_user" name="bca_usage_limit_per_user" min="1" required><br><br>

            <label for="bca_expiry_date">Expiry Date:</label>
            <input type="date" id="bca_expiry_date" name="bca_expiry_date" required><br><br>

            <label for="bca_free_shipping">Free Shipping:</label>
            <select id="bca_free_shipping" name="bca_free_shipping">
                <option value="no">No</option>
                <option value="yes">Yes</option>
            </select><br><br>

            <label for="bca_apply_other_discounts">Allow Other Discounts:</label>
            <select id="bca_apply_other_discounts" name="bca_apply_other_discounts">
                <option value="yes">Yes</option>
                <option value="no">No</option>
            </select><br><br>

            <input type="submit" name="bca_generate_coupons" class="button button-primary" value="Generate Coupons">
        </form>

        <hr>

        <!-- Delete All Coupons Form -->
        <form method="post" action="">
            <?php wp_nonce_field('bca_delete_coupons_nonce'); ?>
            <h2>Delete All Coupons</h2>
            <p>Warning: This will permanently delete all coupons in the system.</p>
            <input type="submit" name="bca_delete_all_coupons" class="button button-secondary" value="Delete All Coupons" onclick="return confirm('Are you sure you want to delete all coupons? This action cannot be undone.');">
        </form>
    </div>
    <?php
}

// Generate bulk coupons
function bca_generate_bulk_coupons($count, $prefix, $type, $amount, $minimum, $usage_limit, $usage_limit_per_user, $expiry_date, $free_shipping, $apply_other_discounts) {
    $success_count = 0;

    for ($i = 0; $i < $count; $i++) {
        $coupon_code = bca_generate_unique_code($prefix);
        $coupon = array(
            'post_title'    => $coupon_code,
            'post_content'  => '',
            'post_status'   => 'publish',
            'post_author'   => get_current_user_id(),
            'post_type'     => 'shop_coupon'
        );

        $new_coupon_id = wp_insert_post($coupon);

        if ($new_coupon_id) {
            $success_count++;
            update_post_meta($new_coupon_id, 'discount_type', $type);
            update_post_meta($new_coupon_id, 'coupon_amount', $amount);
            update_post_meta($new_coupon_id, 'minimum_amount', $minimum);
            update_post_meta($new_coupon_id, 'individual_use', $apply_other_discounts === 'no' ? 'yes' : 'no');
            update_post_meta($new_coupon_id, 'usage_limit', $usage_limit);
            update_post_meta($new_coupon_id, 'usage_limit_per_user', $usage_limit_per_user);
            update_post_meta($new_coupon_id, 'expiry_date', $expiry_date);
            update_post_meta($new_coupon_id, 'free_shipping', $free_shipping === 'yes' ? 'yes' : 'no');
        }
    }

    echo '<div class="notice notice-success"><p>' . $success_count . ' coupons generated successfully!</p></div>';
}

// Generate unique coupon code
function bca_generate_unique_code($prefix) {
    do {
        $random_number = wp_rand(10000, 99999);
        $coupon_code = $prefix . $random_number;
    } while (wc_get_coupon_id_by_code($coupon_code));

    return $coupon_code;
}

// Delete all coupons
function bca_delete_all_coupons() {
    $coupons = get_posts(array(
        'post_type' => 'shop_coupon',
        'post_status' => 'publish',
        'numberposts' => -1
    ));

    if (!empty($coupons)) {
        foreach ($coupons as $coupon) {
            wp_delete_post($coupon->ID, true);
        }
        echo '<div class="notice notice-success"><p>All coupons have been deleted successfully!</p></div>';
    } else {
        echo '<div class="notice notice-warning"><p>No coupons found to delete.</p></div>';
    }
}
