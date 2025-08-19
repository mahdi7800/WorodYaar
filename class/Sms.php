<?php

class Sms {

	protected static $username;
	protected static $password;
	protected static $args;
	protected static $to;
	protected static $bodyId;

	public static function send_sms() {
		$data = array('username' =>self::$username,
		              'password' => self::$password,
		              'text' =>self::$args,
		              'to' =>self::$to ,
		              'bodyId'=>self::$bodyId,
		);
		$post_data = http_build_query($data);
		$handle = curl_init('https://rest.payamak-panel.com/api/SendSMS/BaseServiceNumber');
		curl_setopt($handle, CURLOPT_HTTPHEADER, array(
			'content-type' => 'application/x-www-form-urlencoded'
		));
		curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($handle, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($handle, CURLOPT_POST, true);
		curl_setopt($handle, CURLOPT_POSTFIELDS, $post_data);
		$response = curl_exec($handle);
		$response = json_decode($response);
		return $response;
	}

	public static function setter($args , $to ,$bodyId ) {
        $sms_options = get_option('_wy_settings_plugin_worodyaar_sms');
		self::$args = $args;
		self::$to = $to;
		self::$bodyId = $bodyId;
		self::$username = $sms_options['username'];
		self::$password = $sms_options['password'];
	}

}