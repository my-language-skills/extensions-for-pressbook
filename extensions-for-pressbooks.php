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
 * Version:           1.2.8
 * Pressbooks tested up to: 5.10
 * Author:            My Language Skills team
 * Author URI:        https://github.com/my-language-skills/
 * License:           GPL 3.0
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.txt
 * Text Domain:       extensions-for-pressbooks
 * Domain Path:       /languages
 * Network: 					True
 */


defined ("ABSPATH") or die ("No script assholes!");

// !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
include_once(ABSPATH.'wp-admin/includes/plugin.php'); // bad aproach, we have to modify to something else or to delete, i do not know what´s that

  if(is_plugin_active('pressbooks/pressbooks.php')){
		include_once plugin_dir_path( __FILE__ ) . "default/efpb-default-theme.php";
    include_once plugin_dir_path( __FILE__ ) . "default/efpb-default-settings.php";
    include_once plugin_dir_path( __FILE__ ) . "default/efpb-default-permalinks.php";
		include_once plugin_dir_path( __FILE__ ) . "original-mark/efpb-original-mark.php";
		include_once plugin_dir_path( __FILE__ ) . "admin/efpb-theme-customizations.php";
		include_once plugin_dir_path( __FILE__ ) . "admin/efpb-admin-settings.php";
		
    include_once plugin_dir_path( __FILE__ ) . "groupByLanguage/efpb-groupByLanguage.php";
    include_once plugin_dir_path( __FILE__ ) . "post/efpb-post.php";
    include_once plugin_dir_path( __FILE__ ) . "canonical/efpb-canonical.php";
	  include_once plugin_dir_path( __FILE__ ) . "reading_time/reading_time.php";

	  


		//loading network settings only for multisite installation
		if (is_multisite()){
			include_once plugin_dir_path( __FILE__ ) . "network-admin/efpb-network-admin.php";
			include_once plugin_dir_path( __FILE__ ) . "post-metabox-pb_is_based_on/efpb-post-metabox-pb_is_based_on.php";
		}

	}
