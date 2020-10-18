<?php
/**
 * Extensions for PressBooks / Roles
 *
 * This file create new options to roles.
 * It works with new roles created with User Role Editor pro.
 * https://wordpress.stackexchange.com/questions/188863/how-to-allow-an-user-role-to-create-a-new-user-under-a-role-which-lower-than-hise
 *
 *  @link     URL
 *  @since    1.2.8
 *  @package  extensions-for-pressbooks
 *
 **/

 /*
 * With User Role Editor we have to create the new roles: SuperEditor, Collaborator, Translator.
 *
 */


/**
* Helper function get getting roles that the user is allowed to create/edit/delete.
*
* @param   WP_User $user
* @return  array
*/
 function wpse_188863_get_allowed_roles( $user ) {
     $allowed = array();

     if ( in_array( 'administrator', $user->roles ) ) { // Admin can edit all roles
         $allowed = array_keys( $GLOBALS['wp_roles']->roles );

   // } elseif ( in_array( 'supereditor', $user->roles ) ) { // Admin can edit all roles
   //     $allowed = array_keys( $GLOBALS['wp_roles']->roles );

     } elseif ( in_array( 'supereditor', $user->roles ) ) {
         $allowed[] = 'creator';
         $allowed[] = 'editor';
         $allowed[] = 'collaborator';
         $allowed[] = 'translator';

     } elseif ( in_array( 'creator', $user->roles ) ) {
         $allowed[] = 'editor';
         $allowed[] = 'collaborator';
         $allowed[] = 'translator';
     }

     return $allowed;
 }


/**
 * Remove roles that are not allowed for the current user role.
 */
function wpse_188863_editable_roles( $roles ) {
    if ( $user = wp_get_current_user() ) {
        $allowed = wpse_188863_get_allowed_roles( $user );

        foreach ( $roles as $role => $caps ) {
            if ( ! in_array( $role, $allowed ) )
                unset( $roles[ $role ] );
        }
    }

    return $roles;
}

add_filter( 'editable_roles', 'wpse_188863_editable_roles' );

/**
 * Prevent users deleting/editing users with a role outside their allowance.
 */
function wpse_188863_map_meta_cap( $caps, $cap, $user_ID, $args ) {
    if ( ( $cap === 'edit_user' || $cap === 'delete_user' ) && $args ) {
        $the_user = get_userdata( $user_ID ); // The user performing the task
        $user     = get_userdata( $args[0] ); // The user being edited/deleted

        if ( $the_user && $user && $the_user->ID != $user->ID /* User can always edit self */ ) {
            $allowed = wpse_188863_get_allowed_roles( $the_user );

            if ( array_diff( $user->roles, $allowed ) ) {
                // Target user has roles outside of our limits
                $caps[] = 'not_allowed';
            }
        }
    }

    return $caps;
}

add_filter( 'map_meta_cap', 'wpse_188863_map_meta_cap', 10, 4 );
