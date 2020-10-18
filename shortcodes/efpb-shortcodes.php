<?php
/**
 * Extensions for PressBooks / Shortcodes
 *
 * This file create new shortcodes.
 *
 *  @link     URL
 *  @since    1.2.8
 *  @package  extensions-for-pressbooks
 *
 **/


 /**
  * Shortcode list of all sites of the multisite for a specific user.
  * @link https://www.rupokify.com/tech/wordpress/list-blogs-subsites-wordpress-multisite-user/
  *
  */

function show_blog_list() {

    $user_id = get_current_user_id();
    if ($user_id == 0) {
        echo 'You are not logged in.';
    } else {
        echo '<h2>Here is your Book list</h2>';
        $user_blogs = get_blogs_of_user( $user_id );
        foreach ($user_blogs AS $user_blog) {
            echo '<li><a href="'.$user_blog->siteurl.'">'.$user_blog->blogname.'</a></li>';
        }
        echo '</ul>';
    }
}
add_shortcode( 'bloglist', 'show_blog_list' );
