<?php

/**
 * Example for adding a custom select field to the
 * Restrict Content Pro registration form and profile editors.
 */

/**
 * Adds a custom select field to the registration form and profile editor.
 */
function ag_rcp_add_select_field() {

    $level = get_user_meta( get_current_user_id(), 'rcp_level', true );
    ?>
    <p>
        <label for="rcp_level"><?php _e( 'Which is your current level in the learning language?', 'rcp' ); ?></label>
        <select id="rcp_level" name="rcp_level">
            <option value="a1" <?php selected( $level, 'a1'); ?>><?php _e( 'A1 level', 'rcp' ); ?></option>
            <option value="a2" <?php selected( $level, 'a2'); ?>><?php _e( 'A2 level', 'rcp' ); ?></option>
            <option value="b1" <?php selected( $level, 'b1'); ?>><?php _e( 'B1 level', 'rcp' ); ?></option>
            <option value="b2" <?php selected( $level, 'b2'); ?>><?php _e( 'B2 level', 'rcp' ); ?></option>
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

    $level = get_user_meta( $user_id, 'rcp_level', true );
    ?>
    <tr valign="top">
        <th scope="row" valign="top">
            <label for="rcp_level"><?php _e( 'Referred By', 'rcp' ); ?></label>
        </th>
        <td>
            <select id="rcp_level" name="rcp_level">
                <option value="a1" <?php selected( $level, 'a1'); ?>><?php _e( 'a1', 'rcp' ); ?></option>
                <option value="a2" <?php selected( $level, 'a2'); ?>><?php _e( 'a2', 'rcp' ); ?></option>
                <option value="b1" <?php selected( $level, 'b1'); ?>><?php _e( 'b1', 'rcp' ); ?></option>
                <option value="b2" <?php selected( $level, 'b2'); ?>><?php _e( 'b2', 'rcp' ); ?></option>
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
        'a1',
        'a2',
        'b1',
        'b2'
    );

    // Add an error message if the submitted option isn't one of our valid choices.
    if ( ! in_array( $posted['rcp_level'], $available_choices ) ) {
        rcp_errors()->add( 'invalid_level', __( 'Please select a valid level', 'rcp' ), 'register' );
    }

}

add_action( 'rcp_form_errors', 'ag_rcp_validate_select_on_register', 10 );

/**
 * Stores the information submitted during registration.
 */
function ag_rcp_save_select_field_on_register( $posted, $user_id ) {

    if ( ! empty( $posted['rcp_level'] ) ) {
        update_user_meta( $user_id, 'rcp_level', sanitize_text_field( $posted['rcp_level'] ) );
    }

}

add_action( 'rcp_form_processing', 'ag_rcp_save_select_field_on_register', 10, 2 );





//////////////////////////////////////////////////////////////////////////////////////////////





/**
 * Stores the information submitted during profile update.
 */
function ag_rcp_save_select_field_on_profile_save( $user_id ) {

    // List all the available options that can be selected.
    $available_choices = array(
        'a1',
        'a2',
        'b1',
        'b2'
    );

    if ( isset( $_POST['rcp_level'] ) && in_array( $_POST['rcp_level'], $available_choices ) ) {
        update_user_meta( $user_id, 'rcp_level', sanitize_text_field( $_POST['rcp_level'] ) );
    }

}

add_action( 'rcp_user_profile_updated', 'ag_rcp_save_select_field_on_profile_save', 10 );
add_action( 'rcp_edit_member', 'ag_rcp_save_select_field_on_profile_save', 10 );


//////////////////////////////////////////////////////////////////////////////////////////




/**
 * Adds the custom fields to the registration form and profile editor
 *
 */
function pw_rcp_add_user_fields() {

 $profession = get_user_meta( get_current_user_id(), 'rcp_profession', true );
 $location   = get_user_meta( get_current_user_id(), 'rcp_location', true );

 ?>
 <p>
   <label for="rcp_profession"><?php _e( 'Your Profession', 'rcp' ); ?></label>
   <input name="rcp_profession" id="rcp_profession" type="text" value="<?php echo esc_attr( $profession ); ?>"/>
 </p>
 <p>
   <label for="rcp_location"><?php _e( 'Your Location', 'rcp' ); ?></label>
   <input name="rcp_location" id="rcp_location" type="text" value="<?php echo esc_attr( $location ); ?>"/>
 </p>
 <?php
}
add_action( 'rcp_after_password_registration_field', 'pw_rcp_add_user_fields' );
add_action( 'rcp_profile_editor_after', 'pw_rcp_add_user_fields' );




/**
* Adds the custom fields to the member edit screen
*
*/
function pw_rcp_add_member_edit_fields( $user_id = 0 ) {

$profession = get_user_meta( $user_id, 'rcp_profession', true );
$location   = get_user_meta( $user_id, 'rcp_location', true );

?>
<tr valign="top">
  <th scope="row" valign="top">
    <label for="rcp_profession"><?php _e( 'Profession', 'rcp' ); ?></label>
  </th>
  <td>
    <input name="rcp_profession" id="rcp_profession" type="text" value="<?php echo esc_attr( $profession ); ?>"/>
    <p class="description"><?php _e( 'The member\'s profession', 'rcp' ); ?></p>
  </td>
</tr>
<tr valign="top">
  <th scope="row" valign="top">
    <label for="rcp_location"><?php _e( 'Location', 'rcp' ); ?></label>
  </th>
  <td>
    <input name="rcp_location" id="rcp_location" type="text" value="<?php echo esc_attr( $location ); ?>"/>
    <p class="description"><?php _e( 'The member\'s location', 'rcp' ); ?></p>
  </td>
</tr>
<?php
}
add_action( 'rcp_edit_member_after', 'pw_rcp_add_member_edit_fields' );


/**
* Determines if there are problems with the registration data submitted
*
*/
function pw_rcp_validate_user_fields_on_register( $posted ) {

 if ( is_user_logged_in() ) {
    return;
     }

 if( empty( $posted['rcp_profession'] ) ) {
   rcp_errors()->add( 'invalid_profession', __( 'Please enter your profession', 'rcp' ), 'register' );
 }

 if( empty( $posted['rcp_location'] ) ) {
   rcp_errors()->add( 'invalid_location', __( 'Please enter your location', 'rcp' ), 'register' );
 }

}
add_action( 'rcp_form_errors', 'pw_rcp_validate_user_fields_on_register', 10 );


/**
* Stores the information submitted during registration
*
*/
function pw_rcp_save_user_fields_on_register( $posted, $user_id ) {

 if( ! empty( $posted['rcp_profession'] ) ) {
   update_user_meta( $user_id, 'rcp_profession', sanitize_text_field( $posted['rcp_profession'] ) );
 }

 if( ! empty( $posted['rcp_location'] ) ) {
   update_user_meta( $user_id, 'rcp_location', sanitize_text_field( $posted['rcp_location'] ) );
 }

}
add_action( 'rcp_form_processing', 'pw_rcp_save_user_fields_on_register', 10, 2 );


/**
* Stores the information submitted profile update
*
*/
function pw_rcp_save_user_fields_on_profile_save( $user_id ) {

 if( ! empty( $_POST['rcp_profession'] ) ) {
   update_user_meta( $user_id, 'rcp_profession', sanitize_text_field( $_POST['rcp_profession'] ) );
 }

 if( ! empty( $_POST['rcp_location'] ) ) {
   update_user_meta( $user_id, 'rcp_location', sanitize_text_field( $_POST['rcp_location'] ) );
 }

}
add_action( 'rcp_user_profile_updated', 'pw_rcp_save_user_fields_on_profile_save', 10 );
add_action( 'rcp_edit_member', 'pw_rcp_save_user_fields_on_profile_save', 10 );
