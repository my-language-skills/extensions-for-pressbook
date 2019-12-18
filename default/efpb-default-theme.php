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
 * @since x.x.x (when the file was introduced)
 */

/**
 * Force new websites to use books4languages-child-theme-for-pressbooks
 *
 * @since
 *
 */

function efpb_exp_set_default_theme () {
	$def_theme = wp_get_theme('books4languages-book-child-theme-for-pressbooks');
	if ($def_theme->exists()){
		switch_theme('books4languages-book-child-theme-for-pressbooks');
	}

}

add_action('pressbooks_new_blog', 'efpb_exp_set_default_theme');
