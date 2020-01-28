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
   $result_canonical_metabox = get_blog_option(null,'efpb_canonical_metabox_enable');
   if ( $result_canonical_metabox == 1  && book_is_a_featured2()){
     add_filter( 'the_seo_framework_rel_canonical_output', 'get_canonical_url' );
   }

  /**
  *  Function: return father's canonical URL
  * @since             1.2.8
  *
  **/
   function get_canonical_url(){
     $result_is_original = get_blog_option(null, '_transient_pb_book_source_url');
     return $result_is_original;
   }
 }

 function book_is_a_featured2 (){
   if(get_current_blog_id() != 1){
     $result_is_original = get_blog_option(null,'efp_publisher_is_original');
     if ( $result_is_original == 1 ){
       //book is featured
       return true;
     }
   }
   return false;
 }
