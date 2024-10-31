=== PHP Console Log ===
Contributors: marcusviar
Donate link: https://paypal.me/marcusviar
Tags: console log, debug, browser, development, php, web console, console, log, debugging, errors, dev, javascript
Requires at least: 4.4
Tested up to: 5.3.2
Stable tag: 1.0.1
Requires PHP: 5.6.20
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Log PHP variables and arrays to the web console in your browser via JavaScript's console.log(). No browser extensions required.

== Description ==

= Examples =

Place the **do_action( 'php_console_log', 'My String or Array' );** function anywhere in your WordPress plugin PHP code. The value(s) you pass into **do_action( 'php_console_log', 'My String or Array' );** will be logged to the web console in your browser.

= Pass in a string =

`$my_string = 'My String';
do_action( 'php_console_log', $my_string );`

= Pass in an array =

`$my_array = array(
    'elm 1'
    'elm 2',
);
do_action( 'php_console_log', $my_array );`

= Pass in an associative array =

`$my_array = array(
    'key 1'=>'elm 1',
    'key 2'=>'elm 2',
);
do_action( 'php_console_log', $my_array);`

=  Pass in an unlimited number of arguments nested to an unlimited depth (multi-dimensional array) =

`$my_array = array(
    'My String 1',
    'My String 2',
    array(
        'elm 1',
        'elm 2',
    ),
    'My String 3',
    array(
        'key 1'=>'elm 1',
        'key 2'=>'elm 2',
        'key 3' => array(
            'key 3a' => 'elm 3a',
            'key 3b' => 'elm 3b',
        ),
    ),
    'My String 4'
);
do_action( 'php_console_log', $my_array);`

== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/php-console-log` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress.
3. You can find the help page in Plugins->PHP Console Log->Help for usage instructions.

== Frequently Asked Questions ==

= How do I know PHP Console Log is working? =

If PHP Console Log is working and you have not called **do_action( 'php_console_log', 'My String or Array' );** you will see a message similar to this in your browsers web console:

> ----------- PHP Console Log -----------
>
>   Place the do_action( 'php_console_log', 'My String or Array' ); function anywhere in your WordPress plugin PHP code.
>   The value(s) you pass into do_action( 'php_console_log', 'My String or Array' ); will be logged to the web console in your browser.
>   See "Help" link found on plugins page in your WordPress Admin for more information.
>
> ----------- PHP Console Log -----------

= Why is PHP Console Log not working? =

The most common reasons that cause PHP Console Log to fail when logging your information to the web console are:

1. **Cause:**
The PHP Console log plugin is not activated.

 **Solution:**
Activate the PHP Console Log Plugin.

2. **Cause:**
Another plugin has changed the order in which your plugins load. Making the PHP Console Log functions not available yet.

 **Solution:**
PHP Console Log updates the order in which plugins are loaded any time a plugin is activated or deactivated. However, it is still possible for other plugins to change the order in which plugins load afterwards. Deactivate any plugins that change the order in which your plugins load.

3. **Cause:**
do_action( 'php_console_log', 'My String or Array' ); was called inside a block of code that was not run.

 **Solution:**
Make sure the function you called do_action( 'php_console_log', 'My String or Array' ); in is run via an action or filter hook such as: add_action( 'init', 'my_function' ); Or call do_action( 'php_console_log', 'My String or Array' ); outside of any other functions in a file that you know is run.

4. **Cause:**
PHP throws errors. Side Note: Make sure you are using define( 'WP_DEBUG', true ); in your wp-config.php file so you can see PHP errors.

 **Solution:**
Fix the error that PHP is showing you. Then try again.

= How do I open the web console in Chrome? =

Press Command+Option+J (Mac) or Control+Shift+J (Windows, Linux, Chrome OS) to jump straight into the Console panel.

source: (https://developers.google.com/web/tools/chrome-devtools/open#console)

= How do I open the web console in Firefox? =

* Select **Web Console** from the Web Developer submenu in the Firefox Menu (or Tools menu if you display the menu bar or are on Mac OS X).

 **OR**

* Press the Ctrl + Shift + K (Command + Option + K on OS X) keyboard shortcut.

source: (https://developer.mozilla.org/en-US/docs/Tools/Web_Console/Opening_the_Web_Console)

= How do I open the web console in Safari? =

Select **Develop menu** in the menu bar, choose **Show JavaScript Console**

If you don’t see the Develop menu in the menu bar, choose Safari > Preferences, click Advanced, then select "Show Develop menu in menu bar".

source: (https://support.apple.com/guide/safari-developer/develop-menu-dev39df999c1/mac)

== Screenshots ==

1. If PHP Console Log is working and you have not called **do_action( 'php_console_log', 'My String or Array' );** you will see a message similar to this in your browsers web console.

== Changelog ==

= 1.0.0 =
Initial release.

== Upgrade Notice ==

= 1.0.0 =
Initial release.

= 1.0.1 =
* Removed (unneeded) assets folder
* Bumped WP compatibility to 5.3.2