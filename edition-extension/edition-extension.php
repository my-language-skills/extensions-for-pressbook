<?php
/*
Plugin Name:  Edition Field Extension
Plugin URI:   https://developer.wordpress.org/plugins/the-basics/
Description:  Small enhancement vor Pressbooks main plugin 
Version:      0.1
Author:       Daniil Zhitnitskii (My Language Skills)
Author URI:   https://developer.wordpress.org/
License:      GPL 3.0
License URI:  https://www.gnu.org/licenses/gpl-3.0.html
Text Domain:  edition-extension
Domain Path:  /languages
*/

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

function add_edition_field(){

	x_add_metadata_field( 'pb_edition', 'metadata', array(
						'group'       => 'general-book-information',
						'label'       => 'Edition',
						'description' => 'Book edition',
						'display_callback' => null
					) );
}

add_action ('custom_metadata_manager_init_metadata', 'add_edition_field');
