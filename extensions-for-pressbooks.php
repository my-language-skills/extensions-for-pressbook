<?php
/*

Plugin Name:  Extensions for PressBooks
Plugin URI:   https://developer.wordpress.org/plugins/the-basics/
Description:  Small enhancement for Pressbooks main plugin
Version:      1.2.2
Author:       @huguespages (My Language Skills)
Author URI:   https://developer.wordpress.org/
License:      GPL 3.0
License URI:  https://www.gnu.org/licenses/gpl-3.0.html
Text Domain:  extensions-for-pressbooks
Domain Path:  /languages
*/

defined ("ABSPATH") or die ("No script assholes!");


include_once plugin_dir_path( __FILE__ ) . "default-theme/default-theme.php";
include_once plugin_dir_path( __FILE__ ) . "media/automatically-set-the-wordpress-image-title-alt-text-other-meta.php";
include_once plugin_dir_path( __FILE__ ) . "original-mark/original-mark.php";



/*
* Auto update from github
*
* @since 1.2.1
*/
require 'vendor/plugin-update-checker/plugin-update-checker.php';
$myUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
    'https://github.com/my-language-skills/extensions-for-pressbooks/',
    __FILE__,
    'extensions-for-pressbooks'
);
