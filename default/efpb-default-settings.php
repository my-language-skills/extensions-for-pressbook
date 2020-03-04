<?php

/**
 * Default theme
 *
 * New websites will use default options.
 *
 * @link URL
 *
 * @package extensions-for-pressbooks
 * @subpackage Functionality/Defatult options
 * @since 1.2.5 (when the file was introduced)
 */

/**
 * Force new websites to use default blog description
 *
 * @since 1.2.5
 *
 */

 function efpb_set_default_tagline($blog_id){
	
	switch_to_blog($blog_id);
	//modification to sanitize the value before updating to the option.
	//this may not be needed but it's good practise to use for later. Sanitize everything before updating to the database.
	update_option( 'blogdescription', sanitize_option('blogdescription','by Books for Languages'));

 	restore_current_blog();
 }
 add_action('wp_insert_site','efpb_set_default_tagline');
 //add_action('wpmu_new_blog', 'efpb_set_default_tagline' );
//possible fix to a deprecated hook -> insert_new_site