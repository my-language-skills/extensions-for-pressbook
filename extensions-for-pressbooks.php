<?php
/*
Plugin Name:  Extensions For Pressbooks
Plugin URI:   https://developer.wordpress.org/plugins/the-basics/
Description:  Additional functionality for Pressbooks plugin
Version:      0.1
Author:       Daniil Zhitnitskii (My Language Skills)
Author URI:   https://developer.wordpress.org/
License:      GPL 3.0
License URI:  https://www.gnu.org/licenses/gpl-3.0.html
Text Domain:  extensions-for-pressbooks
Domain Path:  /languages
*/

defined ("ABSPATH") or die ("No script assholes!");

include_once plugin_dir_path( dirname( __FILE__ ) ) . "extensions-for-pressbooks/edition-extension/edition-extension.php";
include_once plugin_dir_path( dirname( __FILE__ ) ) . "extensions-for-pressbooks/original-mark/original-mark.php";
