<?php
/**
 * Generate settings section for this plugin in EFP theme customizatioin section
 *
 * Page EFP Customization is generated in and managed by this plugin by efpb-theme-customization.php.
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

	if ( book_is_a_clone() && book_is_a_featured()){
		add_action('admin_init','efpb_canonical_section');
	}
}

function efpb_init_settings_section (){

	add_settings_section( 'extensions_section', //tag section
												'Extensions section', //name section
												'',										//function
												'theme-customizations');	//page

  add_option('efp_pbibo_metabox_enable', 0);

	add_settings_field(	'efp_pbibo_metabox_enable', 	//parameter
											'Source and cloned books',  	//Title
											'efp_settings_callback',		  //function
											'theme-customizations', 			//page
											'extensions_section'); 				//add settings field to the translations_section

  register_setting( 'theme-customizations-grp',
										'efp_pbibo_metabox_enable');
	}

	function efp_settings_callback(){

		$option = get_option( 'efp_pbibo_metabox_enable' );
		echo '<input name="efp_pbibo_metabox_enable" id="efp_pbibo_metabox_enable" type="checkbox" value="1" class="code" ' . checked( 1, $option, false ) . ' /> '. _('Enable pb_is_based_on metabox in post edit page') .'';
	}

	function efpb_canonical_section (){

		add_settings_section( 'canonical_section', //tag section
													'Canonical section', //name section
													'',									 //function
													'theme-customizations');	//page

		add_option('efpb_canonical_metabox_enable', 0);

		add_settings_field(	'efpb_canonical_metabox_enable', //parameter
												'Enable father canonical link',  //Title
												'canonical_checkbox', //function
												'theme-customizations', //page
												'canonical_section');

		register_setting( 'theme-customizations-grp',
											'efpb_canonical_metabox_enable');
	}

	/**
	 *	Function: Book is a clone
	**/
	function book_is_a_clone (){
		if ( is_plugin_active('autodescription/autodescription.php')){
			if(get_current_blog_id() != 1){
				global $wpdb;
				$blog_id =get_current_blog_id();
				$wp_blog_id_postmeta = "wp_".$blog_id."_postmeta";
				$query_is_based_on = "SELECT * FROM `$wp_blog_id_postmeta` WHERE meta_key = 'pb_is_based_on'";
				$count_is_based_on = $wpdb->get_results($query_is_based_on);
				if (sizeof($count_is_based_on) > 0){
					//book is a clone
					return true;
				}
			}
			return false;
		}
	}

	/**
	 *	Function: Book is featured
	**/
	function book_is_a_featured (){
		if(get_current_blog_id() != 1){
			global $wpdb;
			$blog_id =get_current_blog_id();
			$wp_blog_id_options = "wp_".$blog_id."_options";
			$query_is_original = "SELECT option_value FROM `$wp_blog_id_options` WHERE option_name = 'efp_publisher_is_original'";
			$result_is_original = $wpdb->get_var($query_is_original);
			if ( $result_is_original == 1 ){
				//book is featured
				return true;
			}
		}
		return false;
	}

	function canonical_checkbox(){
		$option = get_option( 'efpb_canonical_metabox_enable' );
		echo '<input name="efpb_canonical_metabox_enable" id="efpb_canonical_metabox_enable" type="checkbox" value="1" class="code" ' . checked( 1, $option, false ) . ' /> '. _("Enable father's canonical URL") .'';
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
