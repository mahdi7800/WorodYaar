 <?php
     add_action('wp_ajax_nopriv_wy_ajax_deactivate_sms_registration_system','wy_ajax_deactivate_sms_registration_system');

     function wy_ajax_deactivate_sms_registration_system(){
       if (isset($_POST['nonce']) && !wp_verify_nonce( $_POST['nonce'])) {
           die('access denied');
       }
         $full_name = sanitize_text_field($_POST['full_name']);
         $email = sanitize_text_field($_POST['email']);
         $password = sanitize_text_field($_POST['password']);
         ValidateParameter::wy_validate_registration_system($full_name, $email, $password);
         $user_data = [
             'user_login'   => apply_filters('pre_user_login', Helper::wy_create_user_login($email)),
             'display_name' => apply_filters('pre_user_display_name', Helper::wy_create_display_name($full_name)['display_name']),
             'first_name'   => apply_filters('pre_user_first_name', Helper::wy_create_display_name($full_name)['first_name']),
             'last_name'    => apply_filters('pre_user_last_name', Helper::wy_create_display_name($full_name)['last_name']),
             'user_email'   => apply_filters('pre_user_email', $email),
             'user_pass'    => apply_filters('pre_user_pass', $password),
         ];
         $insert_user_in = wp_insert_user($user_data);
         if ( ! is_wp_error( $insert_user_in ) ) {
             wp_set_current_user( $insert_user_in );
             wp_set_auth_cookie( $insert_user_in );
             do_action( 'wp_login', $user_data['user_login'], get_user_by('id', $insert_user_in) );
            wp_send_json(['success'=>true,'message'=>'ثبت نام شما با موفقیت انجام شد،انتفال به سایت!','redirect_url' => site_url()],200);
         } else {
             wp_send_json(['error' => true, 'message' => 'خطایی در ثبت نام لطفا دوباره تلاش کنید!'], 403);
         }
     }
