<?php
add_action('wp_ajax_nopriv_wp_wy_verification_code','wp_wy_verification_code');
function wp_wy_verification_code() {
    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'])){
        die('access denied');
    }
    $number_code = sanitize_text_field($_POST['verify_code']);
    ValidateParameter::wy_validate_verification_code($number_code);
}