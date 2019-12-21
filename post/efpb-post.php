<?php
/**
 * Edit-post page options.
 *
 * This file is responsible for generating metaboxes or any other option in public posts.
 *
 * @package extensions-for-pressbooks
 * @subpackage Functionality/post-metabox_pb_is_based_on
 * @since 1.2.5 (when the file was introduced)
 */


   /**
    * add support for excerpt to chapter post type
    *
    * @since 1.2.5
    *
    */
   function efpb_wpcodex_add_excerpt_support_for_post() {
         add_post_type_support( 'chapter', 'excerpt' );
     }
     add_action( 'init', 'efpb_wpcodex_add_excerpt_support_for_post' );
