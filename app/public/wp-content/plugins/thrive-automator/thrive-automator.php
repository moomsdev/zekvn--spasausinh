<?php
/**
 * Plugin Name: Thrive Automator
 * Plugin URI: https://thrivethemes.com
 * Version: 10.6.1.1
 * Author: <a href="https://thrivethemes.com">Thrive Themes</a>
 * Author URI: https://thrivethemes.com
 * Description: Create smart automations that integrate your website with your favourite apps and plugins.
 * Requires PHP: 7.4
 */

use Thrive\Automator\Admin;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Silence is golden!
}

defined( 'TAP_PLUGIN_URL' ) || define( 'TAP_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
defined( 'TAP_PLUGIN_PATH' ) || define( 'TAP_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
defined( 'TAP_PLUGIN_FILE_PATH' ) || define( 'TAP_PLUGIN_FILE_PATH', plugin_basename( __FILE__ ) );

require_once TAP_PLUGIN_PATH . 'inc/constants.php';


if ( thrive_automator_requirements() ) {
	require_once TAP_PLUGIN_PATH . '/inc/classes/class-admin.php';

	Admin::init();
}


/**
 * Thrive Automator requirements
 *
 * @return bool
 */
function thrive_automator_requirements() {
	$ok = true;

	$error_message = '';

	if ( PHP_VERSION_ID < 70000 ) {
		$ok            = false;
		$error_message = __( 'Thrive Automator requires PHP version 7 or higher in order to work.', TAP_DOMAIN );
	} elseif ( ! version_compare( get_bloginfo( 'version' ), TAP_REQUIRED_WP_VERSION, '>=' ) ) {
		$ok            = false;
		$error_message = __( 'Thrive Automator requires WordPress version ' . TAP_REQUIRED_WP_VERSION . ' in order to work. Please update your WordPress version.', TAP_DOMAIN );
	}

	if ( ! $ok ) {
		add_action(
			'admin_notices',
			static function () use ( $error_message ) {
				printf( '<div class="notice notice-error error"><p>%s</p></div>', esc_html( $error_message ) );
			}
		);
	}

	return $ok;
}

/**
 * Class Thrive_Automator_Uncanny
 *
 * This class is part of the Thrive Automator plugin.
 * It is located in the file thrive-automator.php within the plugin's directory.
 *
 * @package Thrive_Automator
 */
class Thrive_Automator_Uncanny {

	/**
	 * Constructor to add AJAX action
	 */
	public function __construct() {
		add_action( 'wp_ajax_thrive_automator_uncanny', array( $this, 'thrive_automator_uncanny_ajax' ) );
		add_action( 'wp_ajax_thrive_automator_check_uncanny', array( $this, 'thrive_automator_check_uncanny_ajax' ) );
	}

	/**
	 * Function to ensure plugin is installed and activated
	 *
	 * @return bool|WP_Error
	 */
	public function ensure_uncanny_installed_and_active() {
		$plugin_slug = 'uncanny-automator/uncanny-automator.php';

		// Check if plugin is installed
		if ( ! file_exists( WP_PLUGIN_DIR . '/' . $plugin_slug ) ) {
			// Attempt to install plugin
			$install_result = $this->install_uncanny_plugin();
			if ( is_wp_error( $install_result ) ) {
				return $install_result;
			}
		}

		// Check if plugin is active
		if ( ! is_plugin_active( $plugin_slug ) ) {
			// Attempt to activate plugin
			$activate_result = $this->activate_uncanny_plugin();
			if ( is_wp_error( $activate_result ) ) {
				return $activate_result;
			}
		}

		// If it exists and is active, return true
		return true;
	}

	/**
	 * Function to install the plugin
	 *
	 * @return bool|WP_Error
	 */
	private function install_uncanny_plugin() {
		$plugin_dir_slug = 'uncanny-automator';

		include_once ABSPATH . 'wp-admin/includes/plugin-install.php';
		include_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
		include_once ABSPATH . 'wp-admin/includes/class-plugin-upgrader.php';

		$api = plugins_api(
			'plugin_information',
			array(
				'slug'   => $plugin_dir_slug,
				'fields' => array( 'sections' => false ),
			)
		);

		if ( is_wp_error( $api ) ) {
			return new WP_Error( 'plugin_info_failed', $api->get_error_message() );
		}

		$upgrader  = new Plugin_Upgrader();
		$installed = $upgrader->install( $api->download_link );

		if ( is_wp_error( $installed ) ) {
			return new WP_Error( 'install_failed', 'Plugin installation failed.' );
		}

		return true;
	}

	/**
	 * Function to activate the plugin
	 *
	 * @return bool|WP_Error
	 */
	private function activate_uncanny_plugin() {
		$plugin_slug = 'uncanny-automator/uncanny-automator.php';

		$activated = activate_plugin( $plugin_slug );

		if ( is_wp_error( $activated ) ) {
			return new WP_Error( 'activation_failed', $activated->get_error_message() );
		}

		return true;
	}

	/**
	 * AJAX handler to manage plugin installation and activation
	 */
	public function thrive_automator_uncanny_ajax() {
		// Check for required permissions
		if ( ! current_user_can( 'install_plugins' ) ) {
			wp_send_json_error( array( 'message' => 'Permission denied.' ) );
			wp_die();
		}

		// Verify the nonce for security
		if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( wp_unslash( $_POST['nonce'] ), 'tap_admin_nonce' ) ) {
			wp_send_json_error( array( 'message' => 'Invalid nonce.' ) );
			wp_die();
		}

		// Ensure plugin is installed and activated
		$result = $this->ensure_uncanny_installed_and_active();

		if ( is_wp_error( $result ) ) {
			wp_send_json_error( array( 'message' => $result->get_error_message() ) );
			wp_die();
		}

		// Send success response
		wp_send_json_success( array( 'message' => 'Plugin is active.' ) );
	}
	/**
	 * Function to check if the Uncanny Automator plugin is active
	 *
	 * @return bool
	 */
	public function is_uncanny_plugin_active() {
		$plugin_slug = 'uncanny-automator/uncanny-automator.php';

		if ( is_plugin_active( $plugin_slug ) ) {
			return 'active';
		} elseif ( file_exists( WP_PLUGIN_DIR . '/' . $plugin_slug ) ) {
			return 'installed';
		} else {
			return false;
		}
	}

	/**
	 * AJAX handler to check if the Uncanny Automator plugin is active
	 */
	public function thrive_automator_check_uncanny_ajax() {
		// Check for required permissions
		if ( ! current_user_can( 'activate_plugins' ) ) {
			wp_send_json_error( array( 'message' => 'Permission denied.' ) );
			wp_die();
		}

		// Verify the nonce for security
		if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( wp_unslash( $_POST['nonce'] ), 'tap_admin_nonce' ) ) {
			wp_send_json_error( array( 'message' => 'Invalid nonce.' ) );
			wp_die();
		}

		// Check if the plugin is active
		$is_active = $this->is_uncanny_plugin_active();

		if ( $is_active === 'installed' ) {
			wp_send_json_error( array( 'message' => 'installed' ) );
			wp_die();
		}
		if ( $is_active === 'active' ) {
			wp_send_json_error( array( 'message' => 'active' ) );
			wp_die();
		} else {
			wp_send_json_error( array( 'message' => 'Plugin is not installed.' ) );
			wp_die();
		}
		// Send success response
		wp_send_json_success( array( 'message' => 'Plugin is active.' ) );
	}
}
// Instantiate the class
new Thrive_Automator_Uncanny();

function tap_admin_notice() {
	// Check if we are on the Plugins page
	$screen = get_current_screen();
	if ( 'plugins' !== $screen->id ) {
		return; // Exit if not on Plugins page
	}

	// Output your custom HTML for the notice
	// <button class="tap-sunset-uncanny-activate">Install Uncanny Automator</button>

	echo '<div class="notice notice-success tap-sunset-banner is-dismissible" style="background: #fff; border-left-color: #A32566;"><div class="tap-sunset-svg">
			<img src="' . TAP_PLUGIN_URL . 'assets/images/sunset-plugins.svg" /></div>
            <div class="tap-sunset-text">
                <h2 style="color: #3C434A;">We are sunsetting Thrive Automator</h2>
                <p style="color: #3C434A;">Thrive Themes is retiring Thrive Automator in favor of Uncanny Automator, the #1 Automation Plugin for WordPress. Get started for free and access 185+ integrations, and 1000+ new triggers and actions.</p>
                <button class="tap-sunset-uncanny-activate" style="min-width: 100px; margin-right: 20px;">...</button>
				<a href="/wp-admin/admin.php?page=thrive_automator&openPopup=true#/saved" data-open-popup="true" style="text-decoration: none;">Learn more</a>
            </div>
          </div>';
}
add_action( 'admin_notices', 'tap_admin_notice' );
