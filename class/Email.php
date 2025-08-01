<?php

class Email {
	public static function wp_wy_recaver_send_mail($phpmailer) {
		$phpmailer->isSMTP();
		$phpmailer->Host     = 'sandbox.smtp.mailtrap.io'; /// set smtp
		$phpmailer->SMTPAuth = true;
		$phpmailer->Port     = 587; /// set smtp
		$phpmailer->Username = '830b7d9c4162ef';/// set smtp
		$phpmailer->Password = '2a7f1eed7f3e6f'; /// set smtp
		// Sender and recipient settings
		$phpmailer->From     = 'info@technoavar.ir';
		$phpmailer->FormName = 'TechnoAvar';
	}
}
add_action( 'phpmailer_init', 'wp_wy_recaver_send_mail');
