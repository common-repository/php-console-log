<?php

// If this file is called directly, abort.
if ( !defined( 'WPINC' ) ) {
	die;
}

/**
 * @func php_console_log_admin_styles()
 *
 * Load stylesheet for PHP Console Log pages.
 *
 * @since 1.0.0
 */
function php_console_log_admin_styles() {

	wp_enqueue_style(
		'php-console-log-style',
		PHP_CONSOLE_LOG_PLUGIN_DIR_URL . 'admin/css/php-console-log-style.css',
		[],
		PHP_CONSOLE_LOG_VERSION
	);

}
add_action( 'admin_enqueue_scripts', 'php_console_log_admin_styles', 10 );