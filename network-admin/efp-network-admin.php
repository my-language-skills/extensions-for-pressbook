<?php

/**
 * Network admin interface
 *
 * This file is responsible for generating EFP Settings menu slug on Network level. It creates blank page where other plugins can place their settings.
 * In order to add section for another plugin it is necessary to add code to efp_render_network_settings() and efp_save_settings() too.
 *
 * @link URL
 *
 * @package extensions-for-pressbooks
 * @since 1.2.4
 */

defined ("ABSPATH") or die ("Action denied!");

add_action( 'network_admin_menu', 'efp_add_network_settings');

 function efp_add_network_settings() {
/*

  !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! use specifical prefix
  example: efpm_add_network_settings OR or something more specific than efp so it will be more secure ---> no conflicts with other plugin


*/
 	  add_submenu_page( 'settings.php',
   'Extensions Network Settings',
   'EFP settings',
   'manage_network_options',
   'efp-network-settings-page',
   'efp_render_network_settings');
 }

/**
 * Render page sections.
 *
 * @since 1.2.4 MODIFIED 1.2.5
 *
 */
 function efp_render_network_settings() {
 ?>
   <div class="wrap">
       <h1>Extensions for Pressbooks network settings</h1>

       <div class="wrap">
         <?php if (isset($_GET['setting-updated']) && $_GET['setting-updated']) { ?>
         <div class="notice notice-success is-dismissible">
            <p><strong> <?php esc_html_e('Settings saved.', 'extensions-for-pressbooks'); ?></strong></p>
          </div>
          <?php }  ?>
       </div>

       <form method="post" action="edit.php?action=efp-update">
         <?php
          wp_nonce_field( 'efp-network-validate' );

          // Display TRANSLATIONS section on the page
          do_settings_sections("tfp-network-settings-page");

          submit_button();
          ?>
       </form>
    </div>
 <?php }

add_action( 'network_admin_edit_efp-update', 'efp_save_settings');

/**
 * Save network form settings
 *
 * @since 1.2.4
 *
 */
 function efp_save_settings(){
   check_admin_referer( 'efp-network-validate' );

   //Following two rows are responsible for saving form data of the TRANSLATIONS plugin.

   //Added sanitize control
   sanitize_option( 'tfp_uninstall_save', $_POST['tfp_uninstall_save']);

   //Added validate control
   if(isset($_POST['tfp_uninstall_save'])){
      update_site_option( 'tfp_uninstall_save', $_POST['tfp_uninstall_save'] );
   }
   /*      miss the escape control
   PROBLEM: SANITIZE ESCAPE VALIDATE ---> use esc_html() if the function print something
   */
   wp_redirect(add_query_arg(array('page' => 'efp-network-settings-page', 'setting-updated' => 'true'), network_admin_url('settings.php')));

   exit();
 }
