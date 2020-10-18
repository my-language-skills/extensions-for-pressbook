<?php

/**
 * Default theme
 *
 * New websites will use a selected default theme.
 *
 *	@link			URL
 *	@since		0.1
 *	@package 	extensions-for-pressbooks
 */

/**
 * Force new websites to use a specifical theme
 *
 *	@since	0.1
 *
 */

function efpb_exp_set_default_theme () {
	$def_theme = wp_get_theme('books4languages-book-child-theme-for-pressbooks');
	if ($def_theme->exists()){
		switch_theme('books4languages-book-child-theme-for-pressbooks');
	}
}
add_action('pressbooks_new_blog', 'efpb_exp_set_default_theme');
