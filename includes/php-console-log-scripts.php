<?php

// If this file is called directly, abort.
if ( !defined( 'WPINC' ) ) {
	die;
}

/**
 * @func wp_set_script_translations()
 *
 * Backport wp_set_script_translations() to WP < 5.0.0. Only if another plugin
 * or theme has not already backported it.
 *
 * @since 1.0.0
 */
if ( !function_exists( 'wp_set_script_translations' ) ) {
	function wp_set_script_translations() {}
}

/**
 * @func php_console_log_script()
 *
 * Load php-console-log.js on all pages. Make php_console_log_array available as
 * javascript variable.
 *
 * @since 1.0.0
 *
 * @param string/array $php_var_to_console_log PHP string or array to be logged
 * to JavaScript console.
 */
function php_console_log_script( $php_var_to_console_log ) {
	global $php_console_log_array;

	// register php-console-log.js
	wp_register_script(
		'php-console-log',
		PHP_CONSOLE_LOG_PLUGIN_DIR_URL . 'js/php-console-log.js',
		['jquery'],
		PHP_CONSOLE_LOG_VERSION
	);

	/**
	 * @info Build default message sent to web console if PHP Console Log plugin
	 * is active but do_action( 'php_console_log', 'My String or Array' ); is not
	 * called. Built here, in PHP, for i18n backward compatibility with WP < 5.0.0
	 *
	 * @since 1.0.0
	 */
	$cl_do_action = "do_action( 'php_console_log', 'My String or Array' );";
	$cl_new_line = "\n";
	$cl_indent = '   ';
	$cl_default_output = esc_html__(
		sprintf(
			'%3$sPlace the %1$s function anywhere in your WordPress plugin PHP code.%2$s%3$sThe value(s) you pass into %1$s will be logged to the web console in your browser.%2$s%3$sSee "Help" link found on plugins page in your WordPress Admin for more information.%2$s%2$s',
			$cl_do_action,
			$cl_new_line,
			$cl_indent
		)
	);

	// make php_console_log_array available as javascript variable
	wp_localize_script( 'php-console-log', 'phpConsoleLogI18n', [
		'phpConsoleLogArray' => $php_console_log_array,
		'File' => esc_html__( 'File', 'php-console-log' ),
		'Line' => esc_html__( 'Line', 'php-console-log' ),
		'Args' => esc_html__( 'Args', 'php-console-log' ),
		'clDefaultOutput' => $cl_default_output,
	] );

	// Load php-console-log.js on all pages
	wp_enqueue_script( 'php-console-log' );

}

/**
 * @info Load php-console-log.js on all pages of site
 * @since 1.0.0
 */
add_action( 'wp_enqueue_scripts', 'php_console_log_script', 10, 1 );
add_action( 'admin_enqueue_scripts', 'php_console_log_script', 10, 1 );
add_action( 'login_enqueue_scripts', 'php_console_log_script', 10, 1 );