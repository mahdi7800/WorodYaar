<?php

class Email {
	public  function wp_wy_recovery_send_mail($phpmailer) {
        $smtp_data = get_option('_wy_settings_plugin_worodyaar_smtp');
		$phpmailer->isSMTP();
		$phpmailer->Host     = $smtp_data['host'];
		$phpmailer->SMTPAuth = true;
		$phpmailer->Port     = $smtp_data['port'];
		$phpmailer->Username = $smtp_data['username'];
		$phpmailer->Password = $smtp_data['password'];
		// Sender and recipient settings
		$phpmailer->From     = $smtp_data['from'];
		$phpmailer->FormName = $smtp_data['FormName'];
	}
}
$email_smtp = new Email();
add_action( 'phpmailer_init', [$email_smtp , 'wp_wy_recovery_send_mail']);
