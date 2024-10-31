var phpConsoleLogIndentNum = 3,
  phpConsoleLogSeparator = '\n\n',
  phpConsoleLogHeader = '\n<<<<<<<<<<< PHP Console Log <<<<<<<<<<<\n\n',
  phpConsoleLogBody = '',
  phpConsoleLogFooter = '>>>>>>>>>>> PHP Console Log >>>>>>>>>>>\n\n';

/**
 * @func phpConsoleLogIndent(()
 *
 * Add indentation to single line in global phpConsoleLogBody.
 *
 * @since 1.0.0
 *
 * @param number indent The number of spaces to intent current line.
 * @return string String of spaces.
 */
function phpConsoleLogIndent(indent) {
  var curIndent = '';
  for (var i = 0; i <= indent; i++) {
    curIndent += ' ';
  }
  return curIndent;
}

/**
 * @func phpConsoleLogRecursiveParseObject()
 *
 * Recursively parse objects passed in. Adds string to global phpConsoleLogBody.
 *
 * @since 1.0.0
 *
 * @param object argVal The object to parse.
 * @param number indent The number of spaces to intent current line.
 */
function phpConsoleLogRecursiveParseObject(argVal, indent) {

  jQuery.each(argVal, function (objKey, objValue) {

    if (typeof objValue == 'object') {

      // add key for this object to global phpConsoleLogBody
      phpConsoleLogBody += phpConsoleLogIndent(indent) + objKey + ':\n';

      // parse the object
      phpConsoleLogRecursiveParseObject(objValue, indent + 3);

    } else {

      // add value of object as string to global phpConsoleLogBody
      phpConsoleLogBody += phpConsoleLogIndent(indent) + objKey + ': ' + objValue + '\n';

    }

    // add 1 extra line break after each top level arg passed in
    if (indent == phpConsoleLogIndentNum * 3) {
      phpConsoleLogBody += '\n';
    }

  });

}

/**
 * @info Run code only after document is ready. Make $ = jQuery inside this
 * function.
 * @since 1.0.0
 */
jQuery(document).ready(function ($) {

  var phpConsoleLogNum = 0;

  /**
   * @info Recursively loop through every php_console_log_array passed from
   * php_console_log() function in php-console-log.php
   * @since 1.0.0
   */
  $.each(phpConsoleLogI18n.phpConsoleLogArray, function (key, phpConsoleLogArray) {

    // separate and number instances of do_action( 'php_console_log' )
    phpConsoleLogBody += phpConsoleLogIndent(phpConsoleLogIndentNum) + '----------- ' + phpConsoleLogNum + ' -----------\n\n'

    // path to file do_action( 'php_console_log' ) was used in
    phpConsoleLogBody += phpConsoleLogIndent(phpConsoleLogIndentNum) + phpConsoleLogI18n.File + ': ' + phpConsoleLogArray.file + '\n';

    // line number do_action( 'php_console_log' ) was used on
    phpConsoleLogBody += phpConsoleLogIndent(phpConsoleLogIndentNum) + phpConsoleLogI18n.Line + ': ' + phpConsoleLogArray.line + '\n';

    /**
     * @info Loop through every top level arg passed in
     * @since 1.0.0
     */
    $.each(phpConsoleLogArray.args, function (argKey, argVal) {

      if (typeof argVal === 'object') {

        /**
         * @info If an array is passed in.
         * @since 1.0.0
         */

        phpConsoleLogBody += phpConsoleLogIndent(phpConsoleLogIndentNum) + phpConsoleLogI18n.Args + ': ' + '\n\n';

        phpConsoleLogRecursiveParseObject(argVal, phpConsoleLogIndentNum * 3);

      } else {

        /**
         * @info If a non-array (string, boolean, null...) is passed in.
         * @since 1.0.0
         */

        phpConsoleLogBody += phpConsoleLogIndent(phpConsoleLogIndentNum) + phpConsoleLogI18n.Args + ': ' + ' ' + argVal + '\n\n';

      }

    });

    phpConsoleLogNum++;

  });

  /**
   * @info Log to web console only if args are passed in.
   * @since 1.0.0
   */
  if (phpConsoleLogNum > 0) {

    // build string to log
    var phpConsoleLogOutput = phpConsoleLogHeader + phpConsoleLogBody + phpConsoleLogFooter;

  } else {

    // build string to log
    phpConsoleLogBody = phpConsoleLogI18n.clDefaultOutput;
    var phpConsoleLogOutput = phpConsoleLogHeader + phpConsoleLogBody + phpConsoleLogFooter;

  }

  // log to web console
  console.log(phpConsoleLogOutput);

});