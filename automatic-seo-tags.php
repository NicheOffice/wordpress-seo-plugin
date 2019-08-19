<?php
/*
   Plugin Name: Automatic SEO Tags
   Plugin URI: 
   Version: 1.0
   Author: <a href="https://codecanyon.net/user/AhmetHakan">Ahmet Hakan</a>
   Description: This lightweight script automatically creates SEO tags for posts.
   Text Domain: 
   License: Attribution-NonCommercial-NoDerivatives 4.0 International (CC BY-NC-ND 4.0)
 */
$AST_minimalRequiredPhpVersion = '5.0';
function AST_noticePhpVersionWrong()
  {
    global $AST_minimalRequiredPhpVersion;
    echo '<div class="updated fade">' . __('Error: plugin "Automatic SEO Tags" requires a newer version of PHP to be running.', '') . '<br/>' . __('Minimal version of PHP required: ', '') . '<strong>' . $AST_minimalRequiredPhpVersion . '</strong>' . '<br/>' . __('Your server\'s PHP version: ', '') . '<strong>' . phpversion() . '</strong>' . '</div>';
  }
function AST_PhpVersionCheck()
  {
    global $AST_minimalRequiredPhpVersion;
    if (version_compare(phpversion(), $AST_minimalRequiredPhpVersion) < 0)
      {
        add_action('admin_notices', 'AST_noticePhpVersionWrong');
        return false;
      }
    return true;
  }
function AST_i18n_init()
  {
    $pluginDir = dirname(plugin_basename(__FILE__));
    load_plugin_textdomain('', false, $pluginDir . '/languages/');
  }
add_action('plugins_loadedi', 'AST_i18n_init');
if (AST_PhpVersionCheck())
  {
    include_once('automatic-seo-tags_init.php');
    AST_init(__FILE__);
  }