<?php

class ValidateParameter
{
    public static function wy_validate_phone_number($phone_number)
    {
        if (empty($phone_number)) {
            wp_send_json(['error'=>true,'message'=>'لطفا شماره موبایل خود را وارد کنید!'],403);
        }
        if (!preg_match('/^(0|09|\+)[0-9]{8,10}$/',$phone_number)) {
            wp_send_json(['error'=>true , 'message'=>'لطفا شماره موبایل معتبر خود را وارد کنید!'],403);
        }
        $args = [
            'meta_key' => '_wy_user_phone_number',
            'meta_value' => $phone_number,
            'compare' => '='
        ];
        $user_phone = new WP_User_Query($args);

        if ($user_phone->get_total()) {
            wp_send_json(['error' => true, 'message' => 'قبلا با این شماره موبایل ثبت نام صورت گرفته است!'], 403);
        }
    }

    public static function wy_validate_verification_code($verification_code)
    {
        if (empty($verification_code)) {
            wp_send_json(['error'=>true,'message'=>'لطفا کد تایید خود را وارد کنید!'],403);
        }
        if (strlen($verification_code) != 6) {
            wp_send_json(['error'=>true,'message'=>'کد تایید نمی تواند کمتر و بیشتر از 6 رقم باشد'],403);
        }
        if (!is_numeric($verification_code)){
            wp_send_json(['error' => true, 'message' => 'کد امنیتی حتما باید عدد باشد!!'], 403);
        }
        $number_code = new VerifyCodeDB();
        $number_code->wy_select_verification_code_check($verification_code);
    }

    public static function wy_validate_registration_system($full_name , $email , $password)
    {
        if ( empty( $full_name ) && empty( $email ) && empty( $password ) ) {
            wp_send_json( [ 'error' => true, 'message' => 'پر کردن تمام فیلد ها الزامی است!' ], 403 );
        }

       if (empty($full_name)) {
           wp_send_json(['error'=>true,'message'=>'لطفا نام خود را وارد کنید!'],403);
       }elseif ( ! substr_count( $full_name, ' ' ) ) {
           wp_send_json( [ 'error' => true, 'message' => 'بیین نام و نام خانوادگی  یک فاصله قرار دهید' ], 403 );
       }
       if (empty($email)) {
           wp_send_json(['error'=>true,'message'=>'لطفا ایمیل خود را وارد کنید!'],403);
       }elseif( ! is_email($email)){
           wp_send_json(['error'=>true,'message'=>'یک ایمیل معتبر وارد کنید!'],403);
       }elseif (email_exists( $email )) {
           wp_send_json(['error'=>true,'message'=>'شما قبلا با این ایمیل ثبت نام کرده اید!'],403);
       }
       if (empty($password)) {
           wp_send_json(['error'=>true,'message'=>'لطفا پسورد خود را وارد کنید!'],403);
       }elseif ( ! preg_match( '/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/', $password ) ) {
           wp_send_json( [ 'error'   => true,
               'message' => 'پسورد شما باید شامل حداقل 8 کارکتر و یک حرف بزرگ یک کارکتر ویژه باید باشد!'
           ], 403 );
       }
    }

    public static function wy_validate_SignIn_system($username , $password)
    {
        if ( empty( $username ) && empty( $password ) ) {
            wp_send_json(['error'=>true , 'message'=>'پر کردن فیلد های زیر الزامی است!']);
        }
        if (empty($username)) {
            wp_send_json( [ 'error' => true, 'message' => 'لطفا نام کاربری خود را وارد کنید!' ], 403 );
        }
        if ( empty( $password ) ) {
            wp_send_json( [ 'error' => true, 'message' => 'لطفا پسورد خود را وارد کنید!' ], 403 );
        }
        $user = get_user_by('login', $username);
        if (!$user) {
            wp_send_json(['error'=>true,'message' => 'کاربری با این ایمیل یافت نشد.'], 403);
        }
    }

    public static function wy_validate_password_recovery($email)
    {
        if ( empty( $email ) ) {
            wp_send_json(['error'=>true,'message'=>'لطفا ایمیل خود را وارد کنید!'],403);
        }
        if ( ! is_email( $email ) ) {
            wp_send_json(['error'=>true,'message'=>'یک ایمیل معتبر وارد کنید!'],403);
        }
        if (!email_exists( $email )) {
            wp_send_json(['error'=>true,'message'=>'این ایمیل وجود ندارد!'],403);
        }
    }

    public static function wy_validate_password_change($PasswordNew , $PasswordRepeat)
    {
        if ( empty( $PasswordNew ) && empty( $PasswordRepeat ) ) {
            wp_send_json(['error'=>true,'message'=>'پر کردن تمامی فیلد ها الزامی است!'],403);
        }
        if ( empty( $PasswordNew ) ) {
            wp_send_json(['error'=>true,'message'=>'لطفا پسورد جدید خود را وارد کنید!'],403);
        }
        if ( ! preg_match( '/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/', $PasswordNew ) ) {
            wp_send_json( [ 'error'   => true,'message' => 'پسورد شما باید شامل حداقل 8 کارکتر و یک حرف بزرگ یک کارکتر ویژه باید باشد!'],403 );
        }
        if (empty($PasswordRepeat)){
            wp_send_json(['error'=>true,'message'=>'لطفا تکرار پسورد جدید الزمی است!'],403);
        }
        if ( $PasswordNew !== $PasswordRepeat ) {
            wp_send_json(['error'=>true,'message'=>'پسورد های که وارد کردید مطابقت ندارد!'],403);
        }
    }

}