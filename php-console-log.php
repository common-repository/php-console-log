<?php
/*
Plugin Name: PHP Console Log
Plugin URI: https://marcusviar.com/php-console-log
Description: Log PHP variables and arrays to the web console in your browser via JavaScript's console.log(). No browser extensions required.
Version: 1.0.1
Contributors: marcusviar
Author: Marcus Viar
Author URI: https://profiles.wordpress.org/marcusviar/
License: GPLv2 or later
License URI:  https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: php-console-log
Domain Path: /languages/
*/

// If this file is called directly, abort.
if ( !defined( 'WPINC' ) ) {
	die;
}

/**
 * @info Define constants for use throughout the plugin.
 *
 * @since 1.0.0
 *
 * @var string PHP_CONSOLE_LOG_PLUGIN_BASENAME Plugin folder and file name.
 * @var string PHP_CONSOLE_LOG_PLUGIN_DIR_PATH Absolute path to plugin directory.
 * @var string PHP_CONSOLE_LOG_PLUGIN_DIR_NAME This plugins directory name.
 * @var string PHP_CONSOLE_LOG_WP_PLUGIN_DIR_PATH Absolute path to WP plugin directory.
 * @var string PHP_CONSOLE_LOG_PLUGINS_URL URL to WordPress plugins directory.
 * @var string PHP_CONSOLE_LOG_PLUGIN_DIR_URL Url to PHP_CONSOLE_LOG plugin directory.
 * @var string PHP_CONSOLE_LOG_PLUGIN_PAGE_LINK_FILTER Builds filter name for links on plugin page.
 * @var string PHP_CONSOLE_LOG_VERSION The version number for this plugin.
 */
define( 'PHP_CONSOLE_LOG_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );
define( 'PHP_CONSOLE_LOG_PLUGIN_DIR_PATH', plugin_dir_path( __FILE__ ) );
define( 'PHP_CONSOLE_LOG_PLUGIN_DIR_NAME', dirname( PHP_CONSOLE_LOG_PLUGIN_BASENAME ) );
define( 'PHP_CONSOLE_LOG_WP_PLUGIN_DIR_PATH', plugin_dir_path( __DIR__ ) );
define( 'PHP_CONSOLE_LOG_PLUGINS_URL', plugins_url( __FILE__ ) );
define( 'PHP_CONSOLE_LOG_PLUGIN_DIR_URL', plugin_dir_url( __FILE__ ) );
define( 'PHP_CONSOLE_LOG_PLUGIN_PAGE_LINK_FILTER', "plugin_action_links_" . PHP_CONSOLE_LOG_PLUGIN_BASENAME );
define( 'PHP_CONSOLE_LOG_VERSION', '1.0.1' );

/**
 * @info Build menu.
 * @since 1.0.0
 */
include 'includes/php-console-log-menu.php';

/**
 * @info Load styles.
 * @since 1.0.0
 */
include 'includes/php-console-log-styles.php';

/**
 * @info Load scripts.
 * @since 1.0.0
 */
include 'includes/php-console-log-scripts.php';

/**
 * @info Build pages.
 * @since 1.0.0
 */
include 'pages/php-console-log-page-help.php';

/**
 * @info Global array that will be logged to the web Console.
 * @since 1.0.0
 */
$php_console_log_array = array();

/**
 * @func php_console_log_load_plugin_textdomain()
 *
 * Load textdomain to allow translations for this plugin.
 *
 * @since 1.0.0
 *
 */
function php_console_log_load_plugin_textdomain() {
	load_plugin_textdomain( 'php-console-log', false, PHP_CONSOLE_LOG_PLUGIN_DIR_NAME . '/languages/' );
}
add_action( 'plugins_loaded', 'php_console_log_load_plugin_textdomain' );

/**
 * @func php_console_log()
 *
 * Function the end user places in any plugin PHP file. Accepts any
 * number of arguments that will be logged to the web Console (your browser's
 * console) via JavaScript's console.log().
 *
 * @since 1.0.0
 *
 * @param string/array PHP strings or arrays to be logged to web console via
 * php-console-log.js.
 */
function php_console_log() {
	// uses global so php_console_log() can be used multiple times and not
	// overwrite itself
	global $php_console_log_array;
	// number of arguments passed to this function
	$num_args = func_num_args();
	if ( $num_args > 0 ) {
		// array of arguments passed to this function
		$arg_list = func_get_args();

		// set backtrace key based on WordPress version number
		global $wp_version;
		$backtrack_key = 3;
		if ( $wp_version < 4.7 ) {
			$backtrack_key = 1;
		}
		// backtrace args key is always 0
		$backtrack_args_key = 0;

		foreach ( $arg_list as $arg_value ) {
			// build backtrace info
			$backtrace = debug_backtrace();

			// path to file do_action( 'php_console_log' ) was used in
			$backtrace_array['file'] = $backtrace[$backtrack_key]['file'];

			// line number do_action( 'php_console_log' ) was used on
			$backtrace_array['line'] = $backtrace[$backtrack_key]['line'];

			// args passed in with do_action( 'php_console_log' )
			$backtrace_array['args'] = $backtrace[$backtrack_args_key]['args'];

			// add each argument to the global $php_console_log_array
			$php_console_log_array[] = $backtrace_array;

		}

	}
}

/**
 * @info Custom action that is called by end user to log info to web console.
 * @since 1.0.0
 */
add_action( 'php_console_log', 'php_console_log' );

/**
 * @func php_console_log_load_first()
 *
 * Make sure PHP Console Log plugin is loaded first so
 * do_action('php_console_log' ) can be used in other plugins. Runs when a
 * plugin is activated and deactivated. Option "active_plugins" order in the
 * options table of the database can be changed by other plugins after this
 * runs. Any plugin that loads before PHP Console Log will not be able to use
 * this plugin's features.
 *
 * @since 1.0.0
 *
 */
function php_console_log_load_first() {

	// get active_plugins row from options table
	if ( $plugins = get_option( 'active_plugins' ) ) {

		// if PHP Console Log plugin is not the first element in active_plugins array
		if ( $key = array_search( PHP_CONSOLE_LOG_PLUGIN_BASENAME, $plugins ) ) {

			// make PHP Console Log plugin first in active_plugins array
			array_splice( $plugins, $key, 1 );
			array_unshift( $plugins, PHP_CONSOLE_LOG_PLUGIN_BASENAME );

			// update active_plugins row in options table
			update_option( 'active_plugins', $plugins );

		}
	}
}

/**
 * @info Set PHP Console Log as first plugin to load when any plugin is
 * activated or deactivated.
 * @since 1.0.0
 */
add_action( 'activated_plugin', 'php_console_log_load_first' );
add_action( 'deactivated_plugin', 'php_console_log_load_first' );