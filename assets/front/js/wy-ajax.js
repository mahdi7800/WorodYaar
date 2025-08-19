jQuery(document).ready(function ($) {
    // SEND_CODE
    jQuery('.phone-number-send-form').on('click', function (e) {
        e.preventDefault();
       let phone_number = jQuery('.phone_number').val();

       jQuery.ajax({
           url: wy_ajax.ajaxurl,
           type: 'POST',
           dataType: "json",
           data: {
               action: 'wp_wy_send_code',
               nonce: wy_ajax._nonce,
               phone_number: phone_number
           },
           beforeSend: function () {},
           success: function (response) {
               if (response.success && response.message) {
                   jQuery.toast({
                       text: response.message,
                       heading: 'موفق',
                       icon: 'success',
                       showHideTransition: 'fade',
                       allowToastClose: true,
                       hideAfter: 3000,
                       stack: false,
                       position: 'top-left',
                       textAlign: 'right',
                       loader: true,
                       loaderBg: '#9EC600'
                   });
                   jQuery('.phone_number_f').hide();
                   jQuery('.phone_number_v').show();
               }
           },
           error : function (error) {
               if (error && error.responseJSON && error.responseJSON.message){
                   jQuery.toast({
                       text: error.responseJSON.message,
                       heading: 'خطا',
                       icon: 'error',
                       showHideTransition: 'fade',
                       allowToastClose: true,
                       hideAfter: 3000,
                       stack: 5,
                       position: 'top-left',
                       textAlign: 'right',
                       loader: true,
                       loaderBg: '#9EC600'
                   });
               }
           },
           complete: function () {},
       })
    })
    // VERIFY CODE
    jQuery('.verify-code-send-form').on('click', function (e) {
        e.preventDefault();
        let verify_code = jQuery('.verify_code').val();
        let phone_number = jQuery('.phone_number').val();
        jQuery.ajax({
            url: wy_ajax.ajaxurl,
            type: 'POST',
            dataType: "json",
            data: {
                action: 'wp_wy_verification_code',
                nonce: wy_ajax._nonce,
                verify_code : verify_code,
                phone_number : phone_number
            },
            beforeSend: function () {},
            success: function (response) {
                if (response.success && response.message) {
                    jQuery.toast({
                        text: response.message,
                        heading: 'موفق',
                        icon: 'success',
                        showHideTransition: 'fade',
                        allowToastClose: true,
                        hideAfter: 3000,
                        stack: false,
                        position: 'top-left',
                        textAlign: 'right',
                        loader: true,
                        loaderBg: '#9EC600'
                    });
                }
                jQuery('.phone_number_v').hide();
                jQuery('.auth_form').show();
                jQuery('.wy-input-number-phone-hidden').val(phone_number);
            },
            error : function (error) {
                if (error && error.responseJSON && error.responseJSON.message){
                    jQuery.toast({
                        text: error.responseJSON.message,
                        heading: 'خطا',
                        icon: 'error',
                        showHideTransition: 'fade',
                        allowToastClose: true,
                        hideAfter: 3000,
                        stack: 5,
                        position: 'top-left',
                        textAlign: 'right',
                        loader: true,
                        loaderBg: '#9EC600'
                    });
                }
            },
            complete: function () {},
        })
    })
    // REGISTRATION SYSTEM ACTIVE SMS
    jQuery('.send-form').on('click',function (e) {
        e.preventDefault();
        let full_name = jQuery('.full_name').val();
        let email = jQuery('.email_input').val();
        let password = jQuery('.password_input').val();
        let phone_number_user = jQuery('.wy-input-number-phone-hidden').val()

        jQuery.ajax({
            url: wy_ajax.ajaxurl,
            type: 'POST',
            dataType: "json",
            data: {
                action: 'wy_ajax_registration_system',
                nonce: wy_ajax._nonce,
                full_name: full_name,
                email: email,
                password: password,
                phone_number_user : phone_number_user
            },
            beforeSend: function () {
            },
            success: function (response) {
                if (response.success && response.message) {
                    jQuery.toast({
                        text: response.message,
                        heading: 'موفق',
                        icon: 'success',
                        showHideTransition: 'fade',
                        allowToastClose: true,
                        hideAfter: 3000,
                        stack: false,
                        position: 'top-left',
                        textAlign: 'right',
                        loader: true,
                        loaderBg: '#9EC600'
                    });
                }
                if (response.redirect_url) {
                    window.location.href = response.redirect_url;
                }
            },
            error: function (error) {
                if (error && error.responseJSON && error.responseJSON.message) {
                    jQuery.toast({
                        text: error.responseJSON.message,
                        heading: 'خطا',
                        icon: 'error',
                        showHideTransition: 'fade',
                        allowToastClose: true,
                        hideAfter: 3000,
                        stack: 5,
                        position: 'top-left',
                        textAlign: 'right',
                        loader: true,
                        loaderBg: '#9EC600'
                    });
                }
            },
            complete: function () {
            },
        })
    })
    // REGISTRATION SYSTEM DeACTIVE SMS
    jQuery('.send_form_deactivate_sms').on('click', function (e) {
        e.preventDefault();
        e.preventDefault();
        let full_name = jQuery('.full_name_da_s').val();
        let email = jQuery('.email_input_da_s').val();
        let password = jQuery('.password_input_da_s').val();

        jQuery.ajax({
            url: wy_ajax.ajaxurl,
            type: 'POST',
            dataType: "json",
            data: {
                action: 'wy_ajax_deactivate_sms_registration_system',
                nonce: wy_ajax._nonce,
                full_name: full_name,
                email: email,
                password: password,
            },
            beforeSend: function () {
            },
            success: function (response) {
                if (response.success && response.message) {
                    jQuery.toast({
                        text: response.message,
                        heading: 'موفق',
                        icon: 'success',
                        showHideTransition: 'fade',
                        allowToastClose: true,
                        hideAfter: 3000,
                        stack: false,
                        position: 'top-left',
                        textAlign: 'right',
                        loader: true,
                        loaderBg: '#9EC600'
                    });
                }
                if (response.redirect_url) {
                    window.location.href = response.redirect_url;
                }
            },
            error: function (error) {
                if (error && error.responseJSON && error.responseJSON.message) {
                    jQuery.toast({
                        text: error.responseJSON.message,
                        heading: 'خطا',
                        icon: 'error',
                        showHideTransition: 'fade',
                        allowToastClose: true,
                        hideAfter: 3000,
                        stack: 5,
                        position: 'top-left',
                        textAlign: 'right',
                        loader: true,
                        loaderBg: '#9EC600'
                    });
                }
            },
            complete: function () {
            },
        })
    })
    // SignIN SYSTEM
    jQuery('.btn-SignedIn').on('click', function (e) {
        e.preventDefault();
        let  username = jQuery('#username_SignIn').val();
        let password = jQuery('#password_SignIn').val();
        let remember_me = jQuery('#StaySignedIn').is(':checked') ? 'true' : 'false';

        jQuery.ajax({
            url: wy_ajax.ajaxurl,
            type: 'POST',
            dataType: "json",
            data: {
                action: 'wy_ajax_SignIn_system',
                nonce: wy_ajax._nonce,
                username: username,
                password: password,
                remember_me : remember_me
            },
            beforeSend: function () {
            },
            success: function (response) {
                if (response.success && response.message) {
                    jQuery.toast({
                        text: response.message,
                        heading: 'موفق',
                        icon: 'success',
                        showHideTransition: 'fade',
                        allowToastClose: true,
                        hideAfter: 3000,
                        stack: false,
                        position: 'top-left',
                        textAlign: 'right',
                        loader: true,
                        loaderBg: '#9EC600'
                    });
                }
                if (response.redirect_url) {
                    window.location.href = response.redirect_url;
                }
            },
            error: function (error) {
                if (error && error.responseJSON && error.responseJSON.message) {
                    jQuery.toast({
                        text: error.responseJSON.message,
                        heading: 'خطا',
                        icon: 'error',
                        showHideTransition: 'fade',
                        allowToastClose: true,
                        hideAfter: 3000,
                        stack: 5,
                        position: 'top-left',
                        textAlign: 'right',
                        loader: true,
                        loaderBg: '#9EC600'
                    });
                }
            },
            complete: function () {
            },
        })

    })
    // SEND EMAIL PASSWORD RECOVERY
    jQuery('.btn-SendEmailPasswordRecovery').on('click', function (e) {
        e.preventDefault();
        let email = jQuery('#username_email').val();
        jQuery.ajax({
            url: wy_ajax.ajaxurl,
            type: 'POST',
            dataType: "json",
            data: {
                action: 'wy_ajax_password_recovery',
                nonce: wy_ajax._nonce,
                 email : email,
            },
            beforeSend: function () {
            },
            success: function (response) {
                if (response.success && response.message) {
                    jQuery.toast({
                        text: response.message,
                        heading: 'موفق',
                        icon: 'success',
                        showHideTransition: 'fade',
                        allowToastClose: true,
                        hideAfter: 3000,
                        stack: false,
                        position: 'top-left',
                        textAlign: 'right',
                        loader: true,
                        loaderBg: '#9EC600'
                    });
                }
            },
            error: function (error) {
                if (error && error.responseJSON && error.responseJSON.message) {
                    jQuery.toast({
                        text: error.responseJSON.message,
                        heading: 'خطا',
                        icon: 'error',
                        showHideTransition: 'fade',
                        allowToastClose: true,
                        hideAfter: 3000,
                        stack: 5,
                        position: 'top-left',
                        textAlign: 'right',
                        loader: true,
                        loaderBg: '#9EC600'
                    });
                }
            },
            complete: function () {
            },
        })
    })
    // CHANGE PASSWORD
    jQuery('.btn-ChangePasswordRecovery').on('click', function (e) {
        e.preventDefault();
        let password_new = jQuery('#password_recovery_from').val();
        let password_repeat = jQuery('#repeat_password_recovery_form').val();
        let token = jQuery('#token').val();
        jQuery.ajax({
            url: wy_ajax.ajaxurl,
            type: 'POST',
            dataType: "json",
            data: {
                action: 'wy_ajax_change_password',
                nonce: wy_ajax._nonce,
                password_new : password_new,
                password_repeat : password_repeat,
                token : token
            },
            beforeSend: function () {
            },
            success: function (response) {
                if (response.success && response.message) {
                    jQuery.toast({
                        text: response.message,
                        heading: 'موفق',
                        icon: 'success',
                        showHideTransition: 'fade',
                        allowToastClose: true,
                        hideAfter: 3000,
                        stack: false,
                        position: 'top-left',
                        textAlign: 'right',
                        loader: true,
                        loaderBg: '#9EC600'
                    });
                }
            },
            error: function (error) {
                if (error && error.responseJSON && error.responseJSON.message) {
                    jQuery.toast({
                        text: error.responseJSON.message,
                        heading: 'خطا',
                        icon: 'error',
                        showHideTransition: 'fade',
                        allowToastClose: true,
                        hideAfter: 3000,
                        stack: 5,
                        position: 'top-left',
                        textAlign: 'right',
                        loader: true,
                        loaderBg: '#9EC600'
                    });
                }
            },
            complete: function () {
            },
        })
    })

})
