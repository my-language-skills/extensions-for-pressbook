<?php

/**
 * h5p exercises integration
 *
 * This file is responsible for generating all the required elements with h5p exercises integration
 *
 *
 *  @link worksheed.books4languages.com
 *  @since 1.2.9
 *  @package extensions-for-pressbooks
 */

defined ("ABSPATH") or die ("Action denied!");


/**
  * Create the metabox 'h5p' for Chapter
  *
  * @since    1.2.9
  */

add_action( 'custom_metadata_manager_init_metadata', 'x_init_custom_fields' );

function x_init_custom_fields() {

// adds a new group to the test post type
x_add_metadata_group( 'efp_exercises_metabox', 'chapter', array(
  'label' => 'h5p Exercises'
) );

	/**
  * Create the h5p metafield
  *
  * @since    1.2.9
  */

// adds a number field in the first group (with no min/max)
// h5p id
x_add_metadata_field( 'efp_h5p_id_field', 'chapter', array(
    'group' => 'efp_exercises_metabox',
    'description' => 'This field It\'s the id of the h5p exercise.', // description for the field
    'field_type' => 'number',
    'required_cap' => 'remove_users',
    'label' => 'Exercise ID',
  ) );

/**
  * Create the USE and FORM metafields
  *
  * @since    1.2.10
  */
  // x_add_metadata_field( 'efp_h5p_form_id_field', 'chapter', array(
  //     'group' => 'efp_exercises_metabox',
  //     'description' => 'This field It\'s the id of the h5p Form exercise.', // description for the field
  //     'field_type' => 'number',
  //     'required_cap' => 'remove_users',
  //     'label' => 'FORM Exercise ID',
  //   ) );
  //
  //   x_add_metadata_field( 'efp_h5p_use_id_field', 'chapter', array(
  //       'group' => 'efp_exercises_metabox',
  //       'description' => 'This field It\'s the id of the h5p Use exercise.', // description for the field
  //       'field_type' => 'number',
  //       'required_cap' => 'remove_users',
  //       'label' => 'USE Exercise ID',
  //     ) );
}
