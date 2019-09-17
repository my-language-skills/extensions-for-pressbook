<?php

/**
 * Extensions for PressBooks
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://github.com/my-language-skills/extensions-for-pressbooks
 * @since             1.0
 * @package           extensions-for-pressbooks
 *
 * @wordpress-plugin
 * Plugin Name:       Extensions for PressBooks
 * Plugin URI:        https://github.com/my-language-skills/extensions-for-pressbooks
 * Description:       Small enhancement for Pressbooks main plugin
 * Version:           1.2.3
 * Author:            My Language Skills team
 * Author URI:        https://github.com/my-language-skills/
 * License:           GPL 3.0
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.txt
 * Text Domain:       extensions-for-pressbooks
 * Domain Path:       /languages
 * Network: 					True
 */




defined ("ABSPATH") or die ("No script assholes!");


include_once plugin_dir_path( __FILE__ ) . "default-theme/default-theme.php";
include_once plugin_dir_path( __FILE__ ) . "original-mark/original-mark.php";
