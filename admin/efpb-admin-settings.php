<?php
/**
 * Generate settings section for this plugin in EFP theme customizatioin section
 *
 * Page EFP Customization is generated in and managed by this plugin by efp-theme-customization.php.
 * But settings section is generated in this separated file to keep consistency across other plugins using EFP Customization page.
 *
 * @package extensions-for-pressbooks
 * @subpackage Functionality/EFP-customization-page
 * @since 1.2.5 (when the file was introduced)
 */

//  pbibo = pb_is_based_on

defined ("ABSPATH") or die ("Action denied!");
include_once(ABSPATH.'wp-admin/includes/plugin.php');

if ((1 != get_current_blog_id()	|| !is_multisite()) && is_plugin_active('pressbooks/pressbooks.php')){
			add_action('admin_init','efpb_init_settings_section');
  }

function efpb_init_settings_section (){

  add_settings_section( 'extensions_section',
                        'Extensions section',
                        'theme-customizations');

  add_option('efp_pbibo_metabox_enable', 0);

  add_settings_field(	'efp_pbibo_metabox_enable',
                      'Source and cloned books',
                      'efp_settings_callback',
                      'theme-customizations',
                      'extensions_section'); //add settings field to the translations_section

  register_setting( 'theme-customizations-grp',
                    'efp_pbibo_metabox_enable');
}



function efp_settings_callback(){
      	$option = get_option( 'efp_pbibo_metabox_enable' );
        echo '<input name="efp_pbibo_metabox_enable" id="efp_pbibo_metabox_enable" type="checkbox" value="1" class="code" ' . checked( 1, $option, false ) . ' /> '. _('Enable pb_is_based_on metabox in post edit page') .'';
  }

/**
 * Function for determining if current site is a clone or not.
 *
 * @since 1.2.5
 *
 */
function efp_is_site_clone(){
  	global $wpdb;

    $table_name = $wpdb->prefix . 'posts'; //set prefix of the table
    $book_info_id = $wpdb->get_row("SELECT ID FROM $table_name WHERE post_name = 'book-information';"); //get ID of the book_info post

    if ($book_info_id){
      $book_info_id = get_object_vars($book_info_id); //extract content of the object
      $book_info_id = reset($book_info_id);           // get first value of the object
      $bookinfo_basedon_url = get_post_meta( $book_info_id, 'pb_is_based_on', true ); //based on this ID find book_info post_meta

      // if it has 'pb_is_post_meta' meta_key return true
      if (!empty($bookinfo_basedon_url)){
          return true;
      }
    }
}
