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
   __('Extensions Network Settings','extensions-for-pressbooks'),
   __('EFP settings','extensions-for-pressbooks'),
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
  if ($_POST['submit'])
  {//if sumbited the button for save settings
    //sanitize key from POST request data
    $tfp_uninstall_save_value = intval(sanitize_key($_POST['tfp_uninstall_save']));
    //save button was clicked so update value of option.
    update_option('tfp_uninstall_save',sanitize_option('tfp_uninstall_save',$tfp_uninstall_save_value));
  }
 
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

      </form>
    </div>
 <?php  }
