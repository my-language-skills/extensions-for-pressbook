<?php

/**
 * Default theme
 *
 * New websites will use a selected default theme.
 *
 * @link URL
 *
 * @package extensions-for-pressbooks
 * @subpackage Functionality/Defatult theme
 * @since 0.1
 */

/**
 * Force new websites to use a specifical theme
 *
 * @since 0.1
 *
 */

function efpb_exp_set_default_theme () {
	$def_theme = wp_get_theme('books4languages-book-child-theme-for-pressbooks');
	if ($def_theme->exists()){
		switch_theme('books4languages-book-child-theme-for-pressbooks');
	}

}

add_action('pressbooks_new_blog', 'efpb_exp_set_default_theme');



/**
 * Force websites to change the current theme
 *
 * @since 1.2.6
 *
 * @link http://hookr.io/functions/get_sites/
 * @link https://hotexamples.com/examples/-/-/get_sites/php-get_sites-function-examples.html
 * @link https://wordpress.stackexchange.com/questions/54543/changing-multisite-themes-on-mass/329959#329959
 *
 * Error:
 * ty of non-object in /var/www/vhosts/books4languages.com/open.books4languages.com/wp-content/plugins/extensions-for-pressbooks/default/efpb-default-theme.php on line 48
 * Warning: Cannot modify header information - headers already sent by (output started at /var/www/vhosts/books4languages.com/open.books4languages.com/wp-content/plugins/extensions-for-pressbooks/default/efpb-default-theme.php:48) in /var/www/vhosts/books4languages.com/open.books4languages.com/wp-includes/functions.php on line 6029
 * Warning: Cannot modify header information - headers already sent by (output started at /var/www/vhosts/books4languages.com/open.books4languages.com/wp-content/plugins/extensions-for-pressbooks/default/efpb-default-theme.php:48) in /var/www/vhosts/books4languages.com/open.books4languages.com/wp-admin/includes/misc.php on line 1252
 * Warning: Cannot modify header information - headers already sent by (output started at /var/www/vhosts/books4languages.com/open.books4languages.com/wp-content/plugins/extensions-for-pressbooks/default/efpb-default-theme.php:48) in /var/www/vhosts/books4languages.com/open.books4languages.com/wp-admin/admin-header.php on line 9
 * Notice: Undefined variable: _SESSION in /var/www/vhosts/books4languages.com/open.books4languages.com/wp-content/plugins/pressbooks/inc/namespace.php on line 177
 * Notice: Undefined variable: _SESSION in /var/www/vhosts/books4languages.com/open.books4languages.com/wp-content/plugins/pressbooks/inc/namespace.php on line 177
 *
 **/


// function switch_all_multisite_themes()
// 	{
//     foreach ( get_sites(array('fields' => 'ids', 'number' => 369)) as $site ) // Number of sites in the network
// 				{
//         switch_to_blog( $site->blog_id );
//
//         switch_theme( 'books4languages-book-child-theme-for-pressbooks' );// pressbooks-book / books4languages-book-child-theme-for-pressbooks
//
//
//         restore_current_blog();
//     }
// }
// switch_all_multisite_themes();  // run this function only once
