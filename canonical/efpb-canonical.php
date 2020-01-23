<?php
/**
 * Extensions for PressBooks / Canonical
 *
 * This file create a functionality of Extensions for PressBooks Plugin. It works only
 * with "The SEO Framework" plugin.
 * If in Appearance -> EFP Customization the checkbox is saved as ON the canonical link is
 * the father's URL. Otherwise "The SEO Framework" works normally.
 *
 * @link              URL
 * @since             1.2.8
 * @package           extensions-for-pressbooks
 *
 **/


 if (is_plugin_active('autodescription/autodescription.php')){
   global $wpdb;
   $blog_id =get_current_blog_id();
   $wp_blog_id_options = "wp_".$blog_id."_options";
   $query_canonical_metabox = "SELECT option_value FROM `$wp_blog_id_options` WHERE option_name = 'efpb_canonical_metabox_enable'";
   $result_canonical_metabox = $wpdb->get_var($query_canonical_metabox);
   if ( $result_canonical_metabox == 1 ){
     add_filter( 'the_seo_framework_rel_canonical_output', 'get_canonical_url' );
   }

  /**
  *  Function: return father's canonical URL
  * @since             1.2.8
  *
  **/
   function get_canonical_url(){
     global $wpdb;
     $blog_id =get_current_blog_id();
     $wp_blog_id_options = "wp_".$blog_id."_options";
     $query_is_original = "SELECT option_value FROM `$wp_blog_id_options` WHERE option_name = '_transient_pb_book_source_url'";
     $result_is_original = $wpdb->get_var($query_is_original);
     return $result_is_original;
   }
 }

// /**
//  * :
// **/
// //It works only with "The SEO Framework" plugin active
//   add_action('wp_ajax_efpb_mark_canonical', 'efpb_mark_canonical', 1);
//   add_action('admin_enqueue_scripts', 'efpb_om_enqueue_scripts_canonical');
//
//   //book is not featured or is featured and canonical checkbox = ON
//   add_filter( 'the_seo_framework_rel_canonical_output', 'get_canonical_url' );
//
//
// /**
//  * FUNCTIONS:
// **/
//
//  /**
//   * Mark original link / father's link
//   * @since 1.2.8
//  **/
// function efpb_mark_canonical() {
//   if ( ! current_user_can( 'manage_network' ) || ! check_ajax_referer( 'pressbooks-aldine-admin' ) ) {
//     return;
//   }
//   $blog_id = intval($_POST['book_id']);
//   if(!$blog_id){
//     return;
//   }
//   $blog_id = sanitize_text_field ($blog_id);
//   $canonical = $_POST['canonical'];
//   $canonical = sanitize_text_field ($canonical);
//   if ( $canonical === 'true' ) {
//     delete_blog_option( $blog_id, 'efp_publisher_canonical' );
//     update_blog_option( $blog_id, 'efp_publisher_canonical', 1 );
//   } else {
//     delete_blog_option( $blog_id, 'efp_publisher_canonical' );
//     update_blog_option( $blog_id, 'efp_publisher_canonical', 0 );
//   }
// }
// 
// /**
//  * Enqueue script
//  * @since 1.2.8
// **/
// function efpb_om_enqueue_scripts_canonical () {
//   wp_enqueue_script( 'canonical-script', plugin_dir_url( __FILE__ ).'assets/scripts/canonical-admin.js');
// }
//
// /**
//  * Return father's canonical URL
//  * @since 1.2.8
// **/
// function get_canonical_url($result_is_original){
//   global $wpdb;
//   $blog_id =get_current_blog_id();
//   $wp_blog_id_options = "wp_".$blog_id."_options";
//   $query_is_original = "SELECT option_value FROM `$wp_blog_id_options` WHERE option_name = '_transient_pb_book_source_url'";
//   $result_is_original = $wpdb->get_var($query_is_original);
//   return $result_is_original;
// }
