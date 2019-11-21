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
 * Force new websites to use books4languages-child-theme-for-pressbooks
 *
 * @since 1.2.5
 *
 */

 function set_default_tagline($blog_id){
 	switch_to_blog($blog_id);
 	update_option( 'blogdescription', 'by Books for Languages' );
 	restore_current_blog();
 }
 add_action('wpmu_new_blog', 'set_default_tagline' );
