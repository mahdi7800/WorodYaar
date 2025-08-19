<?php
add_action('wp_ajax_nopriv_wy_ajax_change_password','wy_ajax_change_password');

function wy_ajax_change_password(){
    if (!isset($_POST['nonce']) && !wp_verify_nonce($_POST['nonce'])) {
        die('access denied');
    }
    $password_new = sanitize_text_field($_POST['password_new']);
    $password_repeat = sanitize_text_field($_POST['password_repeat']);
    $token = sanitize_text_field($_POST['token']);
    ValidateParameter::wy_validate_password_change($password_new,$password_repeat);
    $user_db = new TokenUrlDB();
    $UserId = $user_db->wy_check_token_get_user_ID($token);
    if (!$UserId) {
        wp_send_json(['error' => true, 'message' => 'توکن نامعتبر است یا کاربر یافت نشد!'], 403);
        exit;
    }
    wp_set_password($password_new ,$UserId);

    $user_db->wy_delete_token($token);
    wp_send_json(['success' => true, 'message' => 'کلمه عبور با موفقیت تغییر کرد!'], 200);
    exit;
}