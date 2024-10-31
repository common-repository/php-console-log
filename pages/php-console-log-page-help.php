<?php

// If this file is called directly, abort.
if ( !defined( 'WPINC' ) ) {
	die;
}

/**
 * @func php_console_log_get_active_plugins()
 *
 * Retrieve list of active plugins from active_plugins row in the options table
 * of the database. Evaluate if any plugins load before PHP Console Log.
 *
 * @since 1.0.0
 *
 * @return string HTML ordered list of active plugins that load before PHP
 * Console Log plugin or string stating PHP Console Log is the first plugin
 * loaded.
 */
function php_console_log_get_active_plugins() {
	$plugin_list = array();
	$plugins = get_option( 'active_plugins' );

	// get key of PHP Console Log plugin
	$key = array_search( PHP_CONSOLE_LOG_PLUGIN_BASENAME, $plugins );

	// if PHP Console Log is not the first plugin in the array
	if ( $key > 0 ) {

		// add every plugin that loads before PHP Console Log to $plugin_list array
		for ( $i = 0; $i < $key; $i++ ) {
			$plugin_list[] = $plugins[$i];
		}

	}

	// set default response
	// $return_html = '<p>None. PHP Console Log loads first.</p>';
	$return_html = '<p>' . esc_html__( 'None.', 'php-console-log' ) . ' PHP Console Log ' . esc_html__( 'loads first.', 'php-console-log' ) . '</p>';

	// build HTML ordered list of all plugins that load before PHP Console Log
	if ( count( $plugin_list ) ) {
		$return_html = '<ol>';
		foreach ( $plugin_list as $this_key => $plugin_path ) {
			// return PHP_CONSOLE_LOG_WP_PLUGIN_DIR_PATH . $plugin_path;
			$this_plugin_data = get_plugin_data( PHP_CONSOLE_LOG_WP_PLUGIN_DIR_PATH . $plugin_path, false, true );
			$return_html .= '<li>' . $this_plugin_data['Name'] . '</li>';
		}
		$return_html .= '</ol>';

	}

	echo $return_html;

	// printf( esc_html__( '%s', 'php-console-log' ), $return_html );

}

/**
 * @func php_console_log_page_help()
 *
 * Build and output help page.
 *
 * @since 1.0.0
 *
 */
function php_console_log_page_help() {

	// Double check user capabilities
	if ( !current_user_can( 'manage_options' ) ) {
		return;
	}
	?>
<div id="php-console-log-help" class="wrap">
  <h1><?php esc_html_e( get_admin_page_title() );?></h1>

  <h3><?php esc_html_e( 'Important:', 'php-console-log' );?></h3>
  <p><?php esc_html_e( 'For security and performance on a production site, make sure to deactivate this plugin and remove all calls to', 'php-console-log' );?> <strong>do_action( 'php_console_log', '<?php esc_html_e( 'My String or Array', 'php-console-log' );?>' );</strong> <?php esc_html_e( 'from your PHP code before going live to avoid exposing your PHP variables to the public.', 'php-console-log' );?></p>

  <h3><?php esc_html_e( 'Plugins That Load Before PHP Console Log', 'php-console-log' );?></h3>
  <p><?php esc_html_e( 'PHP Console Log\'s functions are not accessible to any plugins that load before PHP Console Log is loaded. Therefore, Any plugins listed here will not be able to use PHP Console Log features.', 'php-console-log' );?></p>
  <code><?php php_console_log_get_active_plugins();?></code>

  <h3><?php esc_html_e( 'Examples:', 'php-console-log' );?></h3>
  <p><?php esc_html_e( 'Place the', 'php-console-log' );?> <strong>do_action( 'php_console_log', '<?php esc_html_e( 'My String or Array', 'php-console-log' );?>' );</strong> <?php esc_html_e( 'function anywhere in your WordPress plugin PHP code. The value(s) you pass into', 'php-console-log' );?> <strong>do_action( 'php_console_log', '<?php esc_html_e( 'My String or Array', 'php-console-log' );?>' );</strong> <?php esc_html_e( 'will be logged to the web console in your browser.', 'php-console-log' );?></p>

  <p>
    <strong><?php esc_html_e( 'Pass in a string:', 'php-console-log' );?></strong>
  </p>
  <p>
    <code>
      <span>$my_string = 'My String';</span>
      <span>do_action( 'php_console_log', $my_string );</span>
    </code>
  </p>

  <p>
    <strong><?php esc_html_e( 'Pass in an array:', 'php-console-log' );?></strong>
  </p>
  <p>
    <code>
      <span>$my_array = array(</span>
      <span class="tab2">'elm 1',</span>
      <span class="tab2">'elm 2',</span>
      <span class="tab1">);</span>
      <span>do_action( 'php_console_log', $my_array );</span>
    </code>
  </p>

  <p>
    <strong><?php esc_html_e( 'Pass in an associative array:', 'php-console-log' );?></strong>
  </p>
  <p>
    <code>
      <span>$my_array = array(</span>
      <span class="tab2">'key 1'=>'elm 1',</span>
      <span class="tab2">'key 2'=>'elm 2',</span>
      <span class="tab1">);</span>
      <span>do_action( 'php_console_log', $my_array);</span>
    </code>
  </p>

  <p>
    <strong><?php esc_html_e( 'Pass in an unlimited number of arguments nested to an unlimited depth (multi-dimensional array):', 'php-console-log' );?></strong>
  </p>
  <p>
    <code>
      <span>$my_array = array(</span>
      <span class="tab2">'My String 1',</span>
      <span class="tab2">'My String 2',</span>
      <span class="tab2">array(</span>
      <span class="tab3">'elm 1',</span>
      <span class="tab3">'elm 2',</span>
      <span class="tab2">),</span>
      <span class="tab2">'My String 3',</span>
      <span class="tab2">array(</span>
      <span class="tab3">'key 1'=>'elm 1',</span>
      <span class="tab3">'key 2'=>'elm 2',</span>
      <span class="tab3">'key 3' => array(</span>
      <span class="tab4">'key 3a' => 'elm 3a',</span>
      <span class="tab4">'key 3b' => 'elm 3b',</span>
      <span class="tab3">),</span>
      <span class="tab2">),</span>
      <span class="tab2">'My String 4'</span>
      <span class="tab1">);</span>
      <span>do_action( 'php_console_log', $my_array);</span>
    </code>
  </p>

  <h3><?php esc_html_e( 'Opening Web Console in your browser:', 'php-console-log' );?></h3>
  <div class="troubleshooting">
    <ul>
      <li>
        <p>
          <strong>Chrome:</strong><br>
          <?php esc_html_e( 'Press Command + Option + J (Mac) or Control + Shift + J (Windows, Linux, Chrome OS) to jump straight into the Console panel.', 'php-console-log' );?>
        </p>
        <p><?php esc_html_e( 'source', 'php-console-log' );?>: <a href="https://developers.google.com/web/tools/chrome-devtools/open#console">https://developers.google.com/web/tools/chrome-devtools/open#console</a></p>
      </li>
      <li>
        <p>
          <strong>Firefox:</strong><br>
          <?php esc_html_e( 'Select Web Console from the Web Developer submenu in the Firefox Menu (or Tools menu if you display the menu bar or are on Mac OS X).', 'php-console-log' );?>
        </p>
        <p><strong><?php esc_html_e( 'OR', 'php-console-log' );?></strong></p>
        <p><?php esc_html_e( 'Press the Ctrl + Shift + K (Command + Option + K on OS X) keyboard shortcut.', 'php-console-log' );?></p>
        <p><?php esc_html_e( 'source', 'php-console-log' );?>: <a href="https://developer.mozilla.org/en-US/docs/Tools/Web_Console/Opening_the_Web_Console">https://developer.mozilla.org/en-US/docs/Tools/Web_Console/Opening_the_Web_Console</a></p>
      </li>
      <li>
        <p>
          <strong>Safari:</strong><br>
          <?php esc_html_e( 'Select Develop menu in the menu bar, choose Show JavaScript Console.', 'php-console-log' );?>
        </p>
        <p><?php esc_html_e( 'If you don\'t see the Develop menu in the menu bar, choose Safari > Preferences, click Advanced, then select "Show Develop menu in menu bar".', 'php-console-log' );?></p>
        <p><?php esc_html_e( 'source', 'php-console-log' );?>: <a href="https://support.apple.com/guide/safari-developer/develop-menu-dev39df999c1/mac">https://support.apple.com/guide/safari-developer/develop-menu-dev39df999c1/mac</a></p>
      </li>
    </ul>
  </div>

  <h3><?php esc_html_e( 'Troubleshooting:', 'php-console-log' );?></h3>
  <p><?php esc_html_e( 'The most common reasons that cause PHP Console Log to fail when logging your information to the web console are:', 'php-console-log' );?></p>
  <div class="troubleshooting">
    <ol>
      <li>
        <p>
          <strong><?php esc_html_e( 'Cause:', 'php-console-log' );?></strong><br>
          <?php esc_html_e( 'The PHP Console log plugin is not activated.', 'php-console-log' );?>
        </p>
        <p>
          <strong><?php esc_html_e( 'Solution:', 'php-console-log' );?></strong><br>
          <?php esc_html_e( 'Activate the PHP Console Log Plugin.', 'php-console-log' );?>
        </p>
      </li>
      <li>
        <p>
          <strong><?php esc_html_e( 'Cause:', 'php-console-log' );?></strong><br>
          <?php esc_html_e( 'Another plugin has changed the order in which your plugins load. Making the PHP Console Log functions not available yet.', 'php-console-log' );?>
        </p>
        <p>
          <strong><?php esc_html_e( 'Solution:', 'php-console-log' );?></strong><br>
          <?php esc_html_e( 'PHP Console Log updates the order in which plugins are loaded any time a plugin is activated or deactivated. However, it is still possible for other plugins to change the order in which plugins load afterwards. Deactivate any plugins that change the order in which your plugins load.', 'php-console-log' );?>
        </p>
      </li>
      <li>
        <p>
          <strong><?php esc_html_e( 'Cause:', 'php-console-log' );?></strong><br>
          <strong>do_action( 'php_console_log', '<?php esc_html_e( 'My String or Array', 'php-console-log' );?>' );</strong> <?php esc_html_e( 'was called inside a block of code that was not run.', 'php-console-log' );?>
        </p>
        <p>
          <strong><?php esc_html_e( 'Solution:', 'php-console-log' );?></strong><br>
          <?php esc_html_e( 'Make sure the function you called', 'php-console-log' );?> <strong>do_action( 'php_console_log', '<?php esc_html_e( 'My String or Array', 'php-console-log' );?>' );</strong> <?php esc_html_e( 'in is run via an action or filter hook such as:', 'php-console-log' );?> <strong>add_action( 'init', 'my_function' );</strong> <?php esc_html_e( 'Or call', 'php-console-log' );?> <strong>do_action( 'php_console_log', '<?php esc_html_e( 'My String or Array', 'php-console-log' );?>' );</strong> <?php esc_html_e( 'outside of any other functions in a file that you know is run.', 'php-console-log' );?>
        </p>
      </li>
      <li>
        <p>
          <strong><?php esc_html_e( 'Cause:', 'php-console-log' );?></strong><br>
          <?php esc_html_e( 'PHP throws errors.', 'php-console-log' );?> <strong><?php esc_html_e( 'Side Note:', 'php-console-log' );?></strong> <?php esc_html_e( 'Make sure you are using', 'php-console-log' );?> <strong>define( 'WP_DEBUG', true );</strong> <?php esc_html_e( 'in your wp-config.php file so you can see PHP errors.', 'php-console-log' );?>
        </p>
        <p>
          <strong><?php esc_html_e( 'Solution:', 'php-console-log' );?></strong><br>
          <?php esc_html_e( 'Fix the error that PHP is showing you. Then try again.', 'php-console-log' );?>
        </p>
      </li>
    </ol>
  </div>

</div>
<?php
}