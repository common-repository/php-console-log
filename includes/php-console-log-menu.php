<?php

// If this file is called directly, abort.
if ( !defined( 'WPINC' ) ) {
	die;
}

/**
 * @func php_console_log_help_page()
 *
 * Create a menu link so PHP_CONSOLE_LOG_PLUGIN_PAGE_LINK_FILTER can add links
 * to plugin page. No menu link is actually displayed. This is just a
 * placeholder.
 *
 * @since 1.0.0
 */
function php_console_log_help_page() {
	add_submenu_page(
		'php-console-log-placeholder',
		__( 'PHP Console Log Help', 'php-console-log' ),
		__( 'PHP Console Log Help', 'php-console-log' ),
		'manage_options',
		'php-console-log-help',
		'php_console_log_page_help'
	);
}
add_action( 'admin_menu', 'php_console_log_help_page' );

/**
 * @func php_console_log_add_help_link()
 *
 * Adds a link to PHP Console Log help page on the plugins page in admin.
 *
 * @since 1.0.0
 *
 * @param array $links Array of links to show on the plugins page.
 * @return array The $links array with Console Log help page link appended to it.
 */
function php_console_log_add_help_link( $links ) {
	$help_link = '<a href="admin.php?page=php-console-log-help">' . __( 'Help', 'php-console-log' ) . '</a>';
	array_push( $links, $help_link );
	return $links;
}
add_filter( PHP_CONSOLE_LOG_PLUGIN_PAGE_LINK_FILTER, 'php_console_log_add_help_link' );