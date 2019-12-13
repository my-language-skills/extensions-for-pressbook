<?php

/**
 * Extensions for Pressbooks Theme customization settings
 *
 * This file is responsible for generating EFP Customization menu slug in Apperance menu.
 * It creates blank page where other plugins can place their settings.
 *
 * @package extensions-for-pressbooks
 * @subpackage Functionality/Theme-custommizations-page
 * @since 1.2.4 (when the file was introduced)
 */

add_action("admin_menu", "add_theme_menu_item");

 function add_theme_menu_item() {
   if(current_user_can('manage_options')){

     add_theme_page("EFP Customization",
     "EFP Customization",
     "manage_options",
     "theme-customizations",
     "render_theme_option_page", null, 9);
   }
  return;
}

/**
 * Render theme_option_page.
 *
 * @since 1.2.4 MODIFIED 1.2.5
 *
 */
 function render_theme_option_page() {
 ?>
 	<div class="wrap">
 			<h1>Extensions for Pressbooks Theme customization settings</h1>

 			<form method="post" action="options.php">
 <?php
  // display all sections for theme-customizations page
  do_settings_sections("theme-customizations");

  // display settings field on theme-option page
  settings_fields("theme-customizations-grp");

 	submit_button();
?>
  <div class="wrap">
    <?php if (isset($_GET['settings-updated']) && $_GET['settings-updated']) { ?>
    <div class="notice notice-success is-dismissible">
  <p><strong> <?php esc_html_e('Settings saved.', 'extensions-for-pressbooks'); ?></strong></p>
</div>
<?php } ?>

 			</form>
 </div>
 <?php }
