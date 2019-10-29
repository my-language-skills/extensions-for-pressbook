<?php
/**
 * Generate metabox in which is possible to midify pb_is_based_on value (URL) from the edit-post page for the currently post
 *
 * This file is responsible for generating metabox in edit post page of post_types. (pbibo = pb_is_based_on)
 *
 * @package extensions-for-pressbooks
 * @subpackage Functionality/post-metabox_pb_is_based_on
 * @since 1.2.5 (when the file was introduced)
 */

defined ("ABSPATH") or die ("Action denied!");

add_action( 'add_meta_boxes', 'efp_init_pbibo_metabox');
add_action( 'save_post', 'efp_pbibo_url_field_save', 10, 2 );

/**
 * Initialize generation of the metabox.
 *
 * @since 1.2.5
 *
 */
function efp_init_pbibo_metabox(){
  global $post;

  $pbibo_url = get_post_meta($post->ID, 'pb_is_based_on');
  $pbibo_enabled = get_option('efp_pbibo_metabox_enable' );
  $pbibo_url = reset($pbibo_url);

  // initialize the metabox only IF current post 'pb_is_based_on' meta_key is not empty AND 'efp_pbibo_metabox_enable' is set to 1
  if (!empty($pbibo_url) && 1 == $pbibo_enabled){
        $post_types = ['metadata','front-matter','chapter','part', 'back-matter'];
        add_meta_box( 'efp_pbibo_metabox', 'Change pb_is_based_on value', 'efp_render_pbibo_metabox', $post_types, 'side', 'low');
    }
  }

/**
 * Render initialized metabox in post-edit page.
 *
 * @since 1.2.5
 *
 */
function efp_render_pbibo_metabox(){
    global $post;

    $pbibo_url = get_post_meta($post->ID, 'pb_is_based_on');
    $pbibo_url = reset($pbibo_url);

    $pbibo_url_parse = parse_url($pbibo_url);                   // parse url
    $pbibo_url_parse_host = $pbibo_url_parse["host"];           // get 'host' of the url
    $pbibo_url_parse_path = $pbibo_url_parse["path"];           // get 'path' of the url

    $site_url = get_site_url();                                 // get current site URL
    $site_url_parse = parse_url($site_url);                     // parse this URL
    $site_url_parse_host = $site_url_parse["host"];             // get 'host' of the url

    // compare URLs of pb_is_based_on meta_key AND site URL
    if ($site_url_parse_host == $pbibo_url_parse_host){
      $url_to_print = $pbibo_url_parse_path;                    // If they are the same, print only URL path
    } else {
      $url_to_print = $pbibo_url;                               // If not, print full URL
    }

    // generate HTML do be printed inside the metabox
    $html = '';
    $html .= '<b>Current URL:</b>';
    $html .= '<p style="word-wrap:break-word;">'. $url_to_print .'</p><hr>' ;
    $html .= '<b>Insert new URL:</b>';
    $html .= '<input name="pb_is_based_on" id="efp_pbibo_metabox" type="url"  placeholder="example.com" size="25" />';
    echo $html;
}

/**
 * Save input URL to the database under pb_is_based_on meta_key
 *
 * @since 1.2.5
 *
 */
function efp_pbibo_url_field_save($pid, $post){
  $url = filter_input( INPUT_POST,  'pb_is_based_on', FILTER_VALIDATE_URL );
    if ( !empty( $url ) ) {
		update_post_meta( $pid, 'pb_is_based_on', esc_url($url), false);
  }
}
