<?php
/**
 *
 * File responsible for adding edition field in Book Info
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
