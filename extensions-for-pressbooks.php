<?php
/*

Plugin Name:  Extensions for PressBooks
Plugin URI:   https://developer.wordpress.org/plugins/the-basics/
Description:  Small enhancement for Pressbooks main plugin
Version:      1.1.1
Author:       Hugues PAGES (My Language Skills)
Author URI:   https://developer.wordpress.org/
License:      GPL 3.0
License URI:  https://www.gnu.org/licenses/gpl-3.0.html
Text Domain:  extensions-for-pressbooks
Domain Path:  /languages
*/

defined ("ABSPATH") or die ("No script assholes!");


include_once plugin_dir_path( __FILE__ ) . "original-mark/original-mark.php";
include_once plugin_dir_path( __FILE__ ) . "translations-relationships/translations-relationships.php";
include_once plugin_dir_path( __FILE__ ) . "default-theme/default-theme.php";
