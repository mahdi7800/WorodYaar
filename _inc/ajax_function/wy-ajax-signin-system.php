<?php
add_action('wp_ajax_nopriv_wy_ajax_SignIn_system', 'wy_ajax_SignIn_system');

function wy_ajax_SignIn_system() {
    if (isset($_POST['nonce']) && !wp_verify_nonce($_POST['nonce'])) {
        die('access denied');
    }
    $username = sanitize_text_field($_POST['username']);
    $password = sanitize_text_field($_POST['password']);
    $remember_me = isset($_POST['remember_me']) && $_POST['remember_me'] === 'true';
     ValidateParameter::wy_validate_SignIn_system($username, $password);
     $cred = [
         'user_login'    => $username,
         'user_password' => $password ,
         'remember'      => $remember_me
     ];
     $login = wp_signon($cred);
     if ( !is_wp_error( $login ) ) {
         wp_send_json(  ['success'=>true,'redirect_url' => site_url(),'message' => 'ورود شما موفقیت آمیز بود. در حال انتقال...'], 200 );
     }else{
         wp_send_json( [ 'error' => true, 'message' => 'نام کاربری یا کلمه عبور اشتباه است!' ], 403 );
     }

}
