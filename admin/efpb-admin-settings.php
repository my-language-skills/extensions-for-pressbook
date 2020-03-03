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
	
//If book is a clone add canonical section in EFP Customization else nothing happens
	if ( efp_is_site_clone()) {
		add_action('admin_init','efpb_canonical_section');
	}
}

function efpb_init_settings_section (){

	add_settings_section( 'extensions_section',
												__('Extensions section','extensions-for-pressbooks'),
												'',
												'theme-customizations');

  add_option('efp_pbibo_metabox_enable', 0);

	add_settings_field(	'efp_pbibo_metabox_enable',
											__('Source and cloned books','extensions-for-pressbooks'),
											'efp_settings_callback',
											'theme-customizations',
											'extensions_section');

  register_setting( 'theme-customizations-grp',
										'efp_pbibo_metabox_enable','sanitize');
	}
	
	/**
	 * To sanitize the input of the checkbox before updating to database
	 */
	function sanitize($input)
	{
		return sanitize_text_field($input && $input!='' ? $input : '');

	}
	
	function efp_settings_callback(){
		$option = get_option( 'efp_pbibo_metabox_enable' );
		_e('<input name="efp_pbibo_metabox_enable" id="efp_pbibo_metabox_enable" type="checkbox" value="'.esc_attr__("1").'" class="code" ' . checked( 1, $option, false ) . ' /> '. __('Enable pb_is_based_on metabox in post edit page','extensions-for-pressbooks') .'');
	}

	/**
	 *	Function: Canonical section
	 *
	 * 	@since 1.2.8
	 *
	**/
	function efpb_canonical_section (){

		add_settings_section( 'canonical_section', 										// Tag section
													__('Canonical section','extensions-for-pressbooks'), 										// Name section
													'',									 										// Function
													'theme-customizations');								// Page

		add_option('efpb_canonical_metabox_enable', 0);

		add_settings_field(	'efpb_canonical_metabox_enable', 					// Parameter
												__('Father canonical URL','extensions-for-pressbooks'),				  					// Title
												'canonical_checkbox', 										// Function
												'theme-customizations', 									// Page
												'canonical_section');

		register_setting( 'theme-customizations-grp',
											'efpb_canonical_metabox_enable','sanitize');
	}

	/**
	 *	Function: Book is featured
	 *
	 * 	Return true if the book is featured else return false
	 *
	 *	@since 1.2.8
	 *
	**/
	function book_is_a_featured (){
		//if this is no the main site
		if(get_current_blog_id() != 1){
			//get value from DB
			$result_is_original = sanitize_text_field(get_blog_option(null,'efp_publisher_is_original'));
			//if it is featured
			if ( $result_is_original == 1 ){
				return true;
			}
		}
		return false;
	}

	/**
	 *	Function: Canonical checkbox
	 *
	 *	Create the checkbox in EFP Customization
	 *	If book is featured the checkbox is available else it is not focusable
	 *
	 *	@since 1.2.8
	 *
	**/
	function canonical_checkbox(){
		//Get value from option DB
		$option = get_option( 'efpb_canonical_metabox_enable' );
		//If book is featured print canonical_checkbox focusable
		if(book_is_a_featured()){
			_e('<input name="efpb_canonical_metabox_enable" id="efpb_canonical_metabox_enable" type="checkbox" value="'.esc_attr__("1").'" class="code" ' . checked( 1, $option, false ) . ' /> '. __("Enable father's canonical URL",'extensions-for-pressbooks') .'');
		}
		//Else print canonical_checkbox not focusable (canonical functionality works like checkbox OFF) but the info keeps exist in the DB
		else{
			_e("Warning: the book is not featured!<br>");
			_e('<input name="efpb_canonical_metabox_enable" id="efpb_canonical_metabox_enable" disabled="disabled" type="checkbox" value="'.esc_attr__("1").'" class="code" ' . checked( 1, $option, false ) . ' /> '. __("Enable father's canonical URL",'extensions-for-pressbooks') .'');
		}
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
	  //$bookinfo_basedon_url = get_post_meta( $book_info_id, 'pb_is_based_on', true ); //based on this ID find book_info post_meta
	  $bookinfo_basedon_url = sanitize_meta('pb_is_based_on',get_post_meta( $book_info_id, 'pb_is_based_on', true ),'url');
      // if it has 'pb_is_post_meta' meta_key return true
      if (!empty($bookinfo_basedon_url)){
          return true;
      }
    }
}
