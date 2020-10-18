<?php

/**
 * h5p exercises integration
 *
 * This file is responsible for generating all the required elements with h5p exercises integration
 *
 *
 * @link worksheed.books4languages.com
 *
 * @since xxxx
 * @package extensions-for-pressbooks
 */

defined ("ABSPATH") or die ("Action denied!");


// /**
//  * Create the metabox 'h5p' for Chapter
//  *
//  * @since    X.0
//  */

add_action( 'custom_metadata_manager_init_metadata', 'x_init_custom_fields' );

function x_init_custom_fields() {

// adds a new group to the test post type
x_add_metadata_group( 'efp_exercises_metabox', 'chapter', array(
  'label' => 'Exercises'
) );

// adds a number field in the first group (with no min/max)
// h5p id
x_add_metadata_field( 'efp_h5p_id_field', 'chapter', array(
    'group' => 'efp_exercises_metabox',
    'description' => 'This field It\'s the id of the h5p exercise.', // description for the field
    'field_type' => 'number',
    'required_cap' => 'remove_users',
    'label' => 'h5p Exercise ID',
  ) );
}
