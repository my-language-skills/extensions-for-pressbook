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

add_action( 'network_admin_menu', 'efpb_add_network_settings');

 function efpb_add_network_settings() {

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
 * @since 1.2.4
 * MODIFIED 1.2.5
 * MODIFIED 1.2.8
 *
 */
 function efp_render_network_settings() {
 ?>
   <div class="wrap">
       <h1>Extensions for Pressbooks network settings</h1>
       <!-- form with $unistall_checkbox for tfp -->
       <form method="post" action="" >
         <?php
         //add section
        do_settings_sections("tfp-network-settings-page");
            settings_fields("tfp-network-settings-page-grp");
            submit_button();
          ?>

       <div class="wrap">
         <!-- setting saved message -->
         <?php if (isset($_POST['tfp_uninstall_save']) ) { ?>
         <div class="notice notice-success is-dismissible">
            <p><strong> <?php esc_html_e('Settings saved.', 'extensions-for-pressbooks'); ?></strong></p>
          </div>
          <?php }
          // update db -> if checkbox is checked tfp_uninstall_save = 1
          if( $_POST['tfp_uninstall_save'] == 1) {
            update_option( 'tfp_uninstall_save', 1 );
          }
          // update db -> if checkbox is not checked tfp_uninstall_save = 0
          if( $_POST['tfp_uninstall_save'] == 0 ){
            update_option( 'tfp_uninstall_save', 0);
          }
          ?>
      </form>
    </div>
 <?php  }
