<?php
/**
 * Extensions for PressBooks / Canonical
 *
 * This file create a functionality of Extensions for PressBooks Plugin.
 * It works only with "The SEO Framework" plugin active.
 * If in Appearance -> EFP Customization the canonical checkbox is turned ON
 * the canonical link will be the father's URL.
 * Otherwise "The SEO Framework" works normally.
 *
 * @link              URL
 * @since             1.2.8
 * @package           extensions-for-pressbooks
 *
 **/

 //If the plugin "The SEO Framework" is not active nothing happens
 if (is_plugin_active('autodescription/autodescription.php')){
   //Get value from option DB
   $result_canonical_metabox = get_blog_option(null,'efpb_canonical_metabox_enable');
   //If checkbox is turned ON and if current book is featured
   if ( $result_canonical_metabox == 1  && book_is_a_featured2()){
     //Canonical URL = father's URL
     add_filter( 'the_seo_framework_rel_canonical_output', 'get_canonical_url' );
   }

  /**
  * Function: return father's canonical URL
  *
  * It takes the URL from '_transient_pb_book_source_url' value
  *
  * @since             1.2.8
  *
  **/
   function get_canonical_url(){
     $result_is_original = get_blog_option(null, '_transient_pb_book_source_url');
     return $result_is_original;
   }
 }

 /**
 *  Function: return true if book is featured else return false
 *
 * @since             1.2.8
 *
 **/
 function book_is_a_featured2 (){
   //Book is not main site
   if(get_current_blog_id() != 1){
     //Get value from option DB
     $result_is_original = get_blog_option(null,'efp_publisher_is_original');
     //If value = 1 the book is featured
     if ( $result_is_original == 1 ){
       return true;
     }
   }
   return false;
 }
