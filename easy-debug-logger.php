<?php
/**
 * Plugin Name: Easy Debug Logger
 * Version: 0.0.1
 * Description: A lightweight, secure, and live-streaming WordPress error log viewer with real-time updates and color-coded error parsing.
 * Author: Zeeshan Yousaf
 * Author URI: https://profiles.wordpress.org/zeeshanyousaf343/
 * License: GPLv2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: easy-debug-logger
 *
 * @since 0.0.1
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

// Define core directory constants with full prefix to avoid global space collisions.
define( 'EASY_DEBUG_LOGGER_VERSION', '0.0.1' );
define( 'EASY_DEBUG_LOGGER_FILE', __FILE__ );
define( 'EASY_DEBUG_LOGGER_BASE', plugin_basename( __FILE__ ) );
define( 'EASY_DEBUG_LOGGER_DIR_PATH', plugin_dir_path( EASY_DEBUG_LOGGER_FILE ) );
define( 'EASY_DEBUG_LOGGER_DIR_URL', plugin_dir_url( EASY_DEBUG_LOGGER_FILE ) );

/**
 * Register namespace autoloader for PSR-4 style loading within classes/.
 *
 * @since 0.0.1
 */
spl_autoload_register( function ( $class ) {
	$prefix = 'Easy_Debug_Logger\\';
	$len    = strlen( $prefix );

	if ( strncmp( $prefix, $class, $len ) !== 0 ) {
		return;
	}

	$relative_class = substr( $class, $len );
	$file           = EASY_DEBUG_LOGGER_DIR_PATH . 'classes/' . str_replace( '\\', '/', $relative_class ) . '.php';

	if ( file_exists( $file ) ) {
		require_once $file;
	}
} );

/**
 * Class Easy_Debug_Logger
 *
 * Main plugin class for Easy Debug Logger.
 *
 * @since 0.0.1
 */
final class Easy_Debug_Logger {

	/**
	 * The single instance of the class.
	 *
	 * @var Easy_Debug_Logger|null
	 * @since 0.0.1
	 */
	private static $instance = null;

	/**
	 * Minimum PHP Version
	 *
	 * @var string
	 * @since 0.0.1
	 */
	private static string $minimum_php_version = '8.0';

	/**
	 * Constructor.
	 *
	 * @since 0.0.1
	 */
	public function __construct() {
		// Initialize the plugin base.
		add_action( 'plugins_loaded', array( $this, 'plugin_base' ) );
	}

	/**
	 * Initialize core features and dependent classes.
	 *
	 * @since 0.0.1
	 */
	public function plugin_base() {
		// Minimum PHP Version Check.
		if ( version_compare( PHP_VERSION, self::$minimum_php_version, '<' ) ) {
			add_action( 'admin_notices', array( $this, 'admin_notice_minimum_php_version' ) );
			return;
		}

		// Initialize base container class.
		\Easy_Debug_Logger\Base::instance();

		// Trigger core loaded hook with proper prefix.
		do_action( 'easy_debug_logger_loaded' );
	}

	/**
	 * Ensures only one instance of the class is loaded or can be loaded.
	 *
	 * @return Easy_Debug_Logger
	 * @since 0.0.1
	 */
	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Admin notice warning if server PHP is below requirement.
	 *
	 * @since 0.0.1
	 */
	public function admin_notice_minimum_php_version() {
		$message = sprintf(
			/* translators: 1: Plugin name, 2: PHP version */
			esc_html__( '%1$s requires PHP version %2$s or greater.', 'easy-debug-logger' ),
			'<strong>' . esc_html__( 'Easy Debug Logger', 'easy-debug-logger' ) . '</strong>',
			esc_html( self::$minimum_php_version )
		);

		printf(
			'<div class="notice notice-error"><p>%s</p></div>',
			wp_kses_post( $message )
		);
	}
}

// Instantiate the plugin class.
Easy_Debug_Logger::instance();
