<?php
/**
 * Extensions for PressBooks / RCP Registration fields
 *
 * This file create new registration fields in the user profile.
 * It works only with "Restric Content Pro" plugin active.
 * https://docs.restrictcontentpro.com/article/1720-creating-custom-registration-fields
 *
 *  @link     URL
 *  @since    1.2.8
 *  @package  extensions-for-pressbooks
 *
 **/

/**
* Example for adding a custom number field to the
* Restrict Content Pro registration form and profile editors.
*/

/**
* Adds a custom number field to the registration form and profile editor.
*/
function ag_rcp_add_number_field() {

   $age = get_user_meta( get_current_user_id(), 'rcp_age', true );
   ?>
   <p>
       <label for="rcp_age"><?php _e( 'Your Age', 'rcp' ); ?></label>
       <input type="number" id="rcp_age" name="rcp_age" value="<?php echo esc_attr( $age ); ?>"/>
   </p>

   <?php
}

 add_action( 'rcp_after_password_registration_field', 'ag_rcp_add_number_field' );
 add_action( 'rcp_profile_editor_after', 'ag_rcp_add_number_field' );

/**
* Adds the custom number field to the member edit screen.
*/
function ag_rcp_add_number_member_edit_field( $user_id = 0 ) {

   $age = get_user_meta( $user_id, 'rcp_age', true );
   ?>
   <tr valign="top">
       <th scope="row" valign="top">
           <label for="rcp_age"><?php _e( 'Age', 'rcp' ); ?></label>
       </th>
       <td>
           <input type="number" id="rcp_age" name="rcp_age" value="<?php echo esc_attr( $age ); ?>"/>
       </td>
   </tr>
   <?php
}

 add_action( 'rcp_edit_member_after', 'ag_rcp_add_number_member_edit_field' );

/**
* Determines if there are problems with the registration data submitted.
*/
function ag_rcp_validate_number_on_register( $posted ) {
   if ( is_user_logged_in() ) {
       return;
   }

   // Remove this segment if you don't want the number field to be required.
   if ( empty( $posted['rcp_age'] ) ) {
       rcp_errors()->add( 'missing_age', __( 'Please enter your age', 'rcp' ), 'register' );
       return;
   }

   // This throws an error if the value is not an number.
   if ( ! is_numeric( $posted['rcp_age'] ) ) {
       rcp_errors()->add( 'invalid_age', __( 'Please enter a valid age', 'rcp' ), 'register' );
   }
}

 add_action( 'rcp_form_errors', 'ag_rcp_validate_number_on_register', 10 );

/**
* Stores the information submitted during registration.
* We're using `absint()` to make sure the number is a positive integer. If you want
* to allow for negative numbers too, you can use `intval()` instead.
*/
function ag_rcp_save_number_field_on_register( $posted, $user_id ) {
  if ( ! empty( $posted['rcp_age'] ) ) {
     update_user_meta( $user_id, 'rcp_age', absint( $posted['rcp_age'] ) );
   }
}

add_action( 'rcp_form_processing', 'ag_rcp_save_number_field_on_register', 10, 2 );

/**
* Stores the information submitted during profile update.
* We're using `absint()` to make sure the number is a positive integer. If you want
* to allow for negative numbers too, you can use `intval()` instead.
*/
function ag_rcp_save_number_field_on_profile_save( $user_id ) {
  if ( ! empty( $_POST['rcp_age'] ) ) {
     update_user_meta( $user_id, 'rcp_age', absint( $_POST['rcp_age'] ) );
  }
}

 add_action( 'rcp_user_profile_updated', 'ag_rcp_save_number_field_on_profile_save', 10 );
 add_action( 'rcp_edit_member', 'ag_rcp_save_number_field_on_profile_save', 10 );


 ////////////////////////////////////////////////////////////////////////////////





/**
* Example for adding a custom select field to the
* Restrict Content Pro registration form and profile editors.
*/

/**
* Adds a custom select field to the registration form and profile editor.
*/
function ag_rcp_add_select_field() {
  $siteuse = get_user_meta( get_current_user_id(), 'rcp_siteuse', true );
  ?>
  <p>
     <label for="rcp_siteuse"><?php _e( 'Which is your use of the site?', 'rcp' ); ?></label>
     <select id="rcp_siteuse" name="rcp_siteuse">
         <option value="student" <?php selected( $siteuse, 'student'); ?>><?php _e( 'As student', 'rcp' ); ?></option>
         <option value="teacher" <?php selected( $siteuse, 'teacher'); ?>><?php _e( 'As teacher', 'rcp' ); ?></option>
     </select>
  </p>
  <?php
 }

add_action( 'rcp_after_password_registration_field', 'ag_rcp_add_select_field' );
add_action( 'rcp_profile_editor_after', 'ag_rcp_add_select_field' );

 /**
  * Adds the custom select field to the member edit screen.
  */
function ag_rcp_add_select_member_edit_field( $user_id = 0 ) {
 $siteuse = get_user_meta( $user_id, 'rcp_siteuse', true );
 ?>
 <tr valign="top">
     <th scope="row" valign="top">
         <label for="rcp_siteuse"><?php _e( 'Use of the site as', 'rcp' ); ?></label>
     </th>
     <td>
         <select id="rcp_siteuse" name="rcp_siteuse">
             <option value="student" <?php selected( $siteuse, 'student'); ?>><?php _e( 'Student', 'rcp' ); ?></option>
             <option value="teacher" <?php selected( $siteuse, 'teacher'); ?>><?php _e( 'Teacher', 'rcp' ); ?></option>
         </select>
     </td>
 </tr>
 <?php
}

add_action( 'rcp_edit_member_after', 'ag_rcp_add_select_member_edit_field' );

 /**
  * Determines if there are problems with the registration data submitted.
  */
function ag_rcp_validate_select_on_register( $posted ) {
   if ( is_user_logged_in() ) {
     return;
   }

   // List all the available options that can be selected.
   $available_choices = array(
       'student',
       'teacher'
   );

   // Add an error message if the submitted option isn't one of our valid choices.
   if ( ! in_array( $posted['rcp_siteuse'], $available_choices ) ) {
       rcp_errors()->add( 'invalid_siteuse', __( 'Please select a valid use of the site', 'rcp' ), 'register' );
   }
}

add_action( 'rcp_form_errors', 'ag_rcp_validate_select_on_register', 10 );

/**
* Stores the information submitted during registration.
*/
function ag_rcp_save_select_field_on_register( $posted, $user_id ) {
  if ( ! empty( $posted['rcp_siteuse'] ) ) {
       update_user_meta( $user_id, 'rcp_siteuse', sanitize_text_field( $posted['rcp_siteuse'] ) );
  }
}

add_action( 'rcp_form_processing', 'ag_rcp_save_select_field_on_register', 10, 2 );

/**
* Stores the information submitted during profile update.
*/
function ag_rcp_save_select_field_on_profile_save( $user_id ) {
  // List all the available options that can be selected.
  $available_choices = array(
     'student',
     'teacher'
  );
  if ( isset( $_POST['rcp_siteuse'] ) && in_array( $_POST['rcp_siteuse'], $available_choices ) ) {
     update_user_meta( $user_id, 'rcp_siteuse', sanitize_text_field( $_POST['rcp_siteuse'] ) );
  }
}

add_action( 'rcp_user_profile_updated', 'ag_rcp_save_select_field_on_profile_save', 10 );
add_action( 'rcp_edit_member', 'ag_rcp_save_select_field_on_profile_save', 10 );
