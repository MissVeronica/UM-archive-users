<?php

add_action( 'um_submit_account_details', 'my_submit_account_details', 9, 1 );
add_action( 'um_user_login', 'my_user_login', 9, 1 );
add_action( 'um_profile_content_main', 'my_profile_content_main', 9, 1 );
add_filter( 'um_profile_can_view_main', 'my_profile_can_view_main', 10, 2 );

function my_submit_account_details( $args ) {

    $current_tab = isset( $_POST['_um_account_tab'] ) ? $_POST['_um_account_tab']: '';
    if ( 'delete' == $current_tab && um_user( 'can_delete_profile' )) {
        UM()->mail()->send( um_user( 'user_email' ), 'deletion_email' );
        $emails = um_multi_admin_email();
        if ( ! empty( $emails ) ) {
            foreach ( $emails as $email ) {
                UM()->mail()->send( $email, 'notification_deletion', array( 'admin' => true ) );
            }
        }
        update_user_meta( um_user('ID'), 'account_status', 'archived' );
        //UM()->roles()->set_role( um_user('ID'), 'um_archived' );
        wp_update_user( array( 'ID' => um_user('ID'), 'role' => 'um_archived' ));
        delete_option( "um_cache_userdata_" . um_user('ID'));
        wp_logout();
        um_redirect_home();
    }
}

function my_user_login( $args ) {

    if( um_user( 'wp_roles' ) == 'um_archived' ) {
        wp_logout();
        um_redirect_home();
    }    
}

function my_profile_content_main( $args ) {
    
    um_fetch_user( get_current_user_id());
    $um_roles = explode( ',', um_user('wp_roles' ));
    if( in_array( 'administrator', $um_roles )) return;

    um_fetch_user( um_profile_id());
    if( um_user( 'wp_roles' ) == 'um_archived' ) {
        um_redirect_home();
    }
}

function my_profile_can_view_main( $value, $user_id ) {

    um_fetch_user( $user_id );
    if( um_user( 'wp_roles' ) == 'um_archived' ) return "This user account is archived";
    return $value;
}
