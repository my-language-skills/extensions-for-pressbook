<?php
/**
 * Extensions for PressBooks / Heartbeat
 *
 * This file create modify the Heartbeat API frequency.
 *
 * https://alvaroarrarte.com/todo-sobre-el-heartbeat-de-wordpress.
 * https://alvarofontela.com/api-heartbeat-admin-ajax-php-wordpress.
 *
 *  @link     URL
 *  @since    1.2.8
 *  @package  extensions-for-pressbooks
 *
 **/

/*
 * The following code can choose the interval between calls to the heartbeat.
 */

function modificar_heartbeat( $settings ) {
  $settings['interval'] = 120; //Cambia a un valor que sea entre 15 - 60
  return $settings;
 }
 add_filter( 'heartbeat_settings', 'modificar_heartbeat' );


 /*
  * The following code can fully deactivate the heartbeat (front-end como en el back-end).
  */

 // add_action( 'init', 'stop_heartbeat', 1 );
 // function stop_heartbeat() {
 //  wp_deregister_script('heartbeat');
 // }

 /*
  * The following code can deactivate the heartbeat at dashboart, that means at index.php (back-end).
  */

  // add_action( 'init', 'stop_heartbeat', 1 );
  // function stop_heartbeat() {
  // global $pagenow;
  // if ( $pagenow == 'index.php' )
  // wp_deregister_script('heartbeat');
  //  }

  /*
   * The following code can deactivate the heartbeat at dashboart, but post and pages will keep it in order to be able to have backups and revisions (back-end).
   */

   // add_action( 'init', 'stop_heartbeat', 1 );
   // function stop_heartbeat() {
   // global $pagenow;
   // if ( $pagenow != 'post.php' && $pagenow != 'post-new.php' )
   // wp_deregister_script('heartbeat');
   //  }
