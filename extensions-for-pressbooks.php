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
 * Version:           1.2.9
 * Pressbooks tested up to: 5.16.X
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

  // include_once plugin_dir_path( __FILE__ ) . "groupByLanguage/efpb-groupByLanguage.php";
  include_once plugin_dir_path( __FILE__ ) . "post/efpb-post.php";
  include_once plugin_dir_path( __FILE__ ) . "canonical/efpb-canonical.php";
  include_once plugin_dir_path( __FILE__ ) . "reading_time/efpb-reading_time.php";
  include_once plugin_dir_path( __FILE__ ) . "heartbeat/efpb-heartbeat.php";
  include_once plugin_dir_path( __FILE__ ) . "roles/efpb-roles.php";
  include_once plugin_dir_path( __FILE__ ) . "shortcodes/efpb-shortcodes.php";
  include_once plugin_dir_path( __FILE__ ) . "h5p/efpb-h5p.php";
  include_once plugin_dir_path( __FILE__ ) . "efpb-remove.php";
	include_once plugin_dir_path( __FILE__ ) . "network-admin/efpb-network-admin.php";
	include_once plugin_dir_path( __FILE__ ) . "post-metabox-pb_is_based_on/efpb-post-metabox-pb_is_based_on.php";

    //If the plugin "Restric Content Pro" is not active nothing happens
  if (is_plugin_active('restrict-content-pro/restrict-content-pro.php')){
    include_once plugin_dir_path( __FILE__ ) . "rcp/efpb-rcp-registration-fields.php";
  }
}


// if (is_plugin_active('restrict-content-pro/restrict-content-pro.php')){
// }

// add_filter( 'the_seo_framework_sitemap_exclude_cpt', function( $excluded = array() ) {
//
// 	$excluded[] = 'part';
//
// 	return $excluded;
// }, 10 );


//
//
// function my_custom_sitemap_exclude( $excluded ) {
// 	$excluded[] = 'part';
// 	return $excluded;
// }
// add_filter( 'the_seo_framework_sitemap_exclude_cpt', 'my_custom_sitemap_exclude');
//
//
//
//
// function my_sitemap_exclusions( $exclusions = array() ) {
//
//     $exclusions[] = 'part';
//
//     return $exclusions;
// }
//
// add_filter( 'the_seo_framework_sitemap_exclude_cpt', 'my_sitemap_exclusions' );
