<?php

/**
 * Forcing new websites to use books4languages-child-theme-for-pressbooks
 */

function exp_set_default_theme () {
	$def_theme = wp_get_theme('books4languages-child-theme-for-pressbooks');
	if ($def_theme->exists()){
		switch_theme('books4languages-child-theme-for-pressbooks');
	}

}

add_action('pressbooks_new_blog', 'exp_set_default_theme');