<?php
/**
 * Edit-post page options.
 *
 * This file is responsible for generating metaboxes or any other option in public posts.
 *
 *  @since 1.2.5 (when the file was introduced)
 *  @package extensions-for-pressbooks
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

/**
* Disabling edit permalinks to non administrators
*
*
* @link https://wordpress.stackexchange.com/questions/329457/set-post-title-to-read-only-and-disable-permalink-slug-editor-in-gutenberg
* @link https://wordpress.stackexchange.com/questions/211300/remove-permalink-from-admin-edit-post
* @link https://wordpress.stackexchange.com/questions/110427/remove-post-title-input-from-edit-page
* @link https://wordpress.stackexchange.com/questions/91037/disable-permalink-on-custom-post-type
*
* @since 1.2.8
*
*/

add_action('admin_init', 'wpse_110427_hide_title');

function hide_permalink() {
  return '';
}

function wpse_110427_hide_title() {
  if (! current_user_can( 'manage_options' ) )
  add_filter( 'get_sample_permalink_html', 'hide_permalink' );
}
