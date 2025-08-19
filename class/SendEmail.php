<?php

class SendEmail
{
    public static function wy_send_email_recovery($email , $token)
    {
        $subject = 'باز یابی کلمه عبور';
        $headers = array('Content-Type: text/html; charset=UTF-8');
        $send_mail = wp_mail($email,$subject,$token.'لینک باز یابی رمز عبور ارسال شد',$headers);
        if  ($send_mail){
            $validate_token = new TokenUrlDB();
            $validate_token->wy_creating_and_select_verification_token($email,$token);
            wp_send_json(['success'=>true , 'message'=>'لینک بازیابی کلمه عبور ارسال شد!'],200);
        }else{
            // اگر ارسال ایمیل کار نکند، لینک بازیابی را مستقیماً در خروجی ارسال کنید
            $validate_token =  new tokenUrlDB();
            $validate_token->wy_creating_and_select_verification_token($email,$token);
            wp_send_json([
                'success' => true,
                'message' => 'ارسال ایمیل کار نمی‌کند، اما لینک بازیابی تولید شد.',
                'recovery_link' => $token
            ], 200);
        }
    }
}