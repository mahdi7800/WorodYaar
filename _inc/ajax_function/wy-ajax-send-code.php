<?php
add_action('wp_ajax_nopriv_wp_wy_send_code','wp_wy_send_code');
function wp_wy_send_code() {
	if ( !isset($_POST['nonce'])  || !wp_verify_nonce($_POST['nonce']) ){
		die('access dined');
	}
	$phone_number = sanitize_text_field($_POST['phone_number']);
	ValidateParameter::wy_validate_phone_number($phone_number);
    $verify_code = Helper::wy_create_verification_code();
    $create_verify_code = new VerifyCodeDB();
    $create_verify_code->wy_creating_and_select_verification_code($phone_number,$verify_code);
    $bodyId = get_option('_wy_settings_plugin_worodyaar_sms')['verify_code'];
    $send_sms = Sms::setter($create_verify_code,$phone_number,$bodyId);
    $send_sms = Sms::send_sms();
    if (  $send_sms->StrRetStatus != 'OK'){
        wp_send_json( [ 'success' => true, 'message' => 'کد تایید ارسال شد.' ], 200 );
    } else {
        wp_send_json( [ 'error' => true, 'message' => 'ارسال پیامک با خطا مواجه شد!' ], 500 );
    }
}
