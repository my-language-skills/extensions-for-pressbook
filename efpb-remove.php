<?php
/**
 * Extensions for PressBooks / Remove
 *
 * This file remove default functionalities that decrease the speed.
 *
 * @link              URL
 * @since             1.X
 * @package           extensions-for-pressbooks
 *
 **/



/**
 * Remove External Google Fonts
 *
 * @since 1.
 * @internal fonts.gstatic.com / fonts.googleapis.com
 */

if ( !is_user_logged_in() ) {
	 add_filter( 'style_loader_src', function($href){
  	 if(strpos($href, "//fonts.googleapis.com/") === false) {
  	 return $href;
  	 }
	 return false;
	 });
}
/*
function remove_google_fonts_stylesheet() {
		wp_dequeue_style('Inconsolata');
		wp_deregister_style('Inconsolata');
}
add_action( 'wp_enqueue_scripts', 'remove_google_fonts_stylesheet', 100 );
*/

/** End of functionality*/


/**
 * Remove JQuery migrate
 *
 * @link https://www.narga.net/how-to-remove-jquery-migrate/
 * @since 1.
 *
 */

function remove_jquery_migrate($scripts) {
  if (!is_admin() && isset($scripts->registered['jquery'])) { $script = $scripts->registered['jquery'];
    if ($script->deps) { // Check whether the script has any dependencies
      $script->deps = array_diff($script->deps, array( 'jquery-migrate' ));
    }
  }
}

add_action('wp_default_scripts', 'remove_jquery_migrate');




/**
 * Remove dashicons in frontend for unauthenticated users
 *
 * @since 1.X
 *
 */

 add_action( 'wp_enqueue_scripts', 'bs_dequeue_dashicons' );
 function bs_dequeue_dashicons() {
		 if ( ! is_user_logged_in() ) {
				 wp_deregister_style( 'dashicons' );
		 }
 }

 // Deregister los dashicons si no se muestra la barra de admin
 // add_action( 'wp_print_styles', function() {
 //     if (!is_admin_bar_showing()) wp_deregister_style( 'dashicons' );
 // }, 100);

/** End of functionality*/
