<?php

/**
 * Permalinks
 *
 * New sites will use custom format.
 *
 * @link https://wordpress.stackexchange.com/questions/271662/multisite-network-how-to-change-permalink-structure-programmatically-on-new-blo
 *
 * @package extensions-for-pressbooks
 * @subpackage Functionality/Permalinks
 * @since x.x.x (when the file was introduced)
 */


/**
 * File responsible for adding the new configuration to new sites
 */
add_action( 'wpmu_new_blog', function( $blog_id ){

switch_to_blog( $blog_id );
global $wp_rewrite;
$wp_rewrite->set_permalink_structure('/%postname%/'); // /%post_id%
$wp_rewrite->flush_rules();
restore_current_blog();

}, 10 );
