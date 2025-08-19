<?php
add_action('wp_ajax_nopriv_wy_ajax_password_recovery','wy_ajax_password_recovery');
function wy_ajax_password_recovery(){
    if(!isset($_POST['nonce']) && !wp_verify_nonce($_POST['nonce'])){
        die('access denied');
    }
    $email = sanitize_text_field($_POST['email']);
    ValidateParameter::wy_validate_password_recovery($email);
    $create_token_url_user = Helper::wy_create_token($email);
    SendEmail::wy_send_email_recovery($email , $create_token_url_user);
}