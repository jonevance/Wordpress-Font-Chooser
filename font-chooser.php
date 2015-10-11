<?php 

/*
Plugin Name: Font-Chooser
Plugin URI: https://github.com/jonevance/WPFontChooser
Description: A simple plugin to allow easier alternate font usage
Version: 1.0
Author: Jon Vance
License: MIT
Usage: Wrap content in [FONT <content> ] tags (i.e. [Arial Some text])
*/

// root file path to the plugin folder
define('FC_ROOT', plugin_dir_path( __FILE__ ).'/');

// hook a function to the content filter action
add_filter('the_content', 'fontChooser');

/**
 * Main plugin entry point
 * 
 * @param string $sContent   the content of the page being displayed
 * @return string            the (possibly modified) content
 */
function fontChooser($sContent)
{
  // checking if on post page.
  if (is_single()) 
  {
    require_once(FC_ROOT."font-chooser-parser.php");
    
    $oParser = new FontChooserParser();
    
    return $oParser->parse($sContent);
  }
  
  else 
  {
    // else on blog page / home page etc, just return content as usual.
    return $sContent;
  }
}
