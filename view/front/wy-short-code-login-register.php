<?php
add_shortcode('wy-short-code-login-register', 'wy_shortcode_login_register');

function wy_shortcode_login_register(): string
{
    ob_start(); ?>
    <input type="radio" name="OptionScreen" id="SignIn" hidden checked>
    <input type="radio" name="OptionScreen" id="SignUp" hidden>
    <section>
        <div id="logo">
            <img src="https://www.freepnglogos.com/uploads/spotify-logo-png/spotify-icon-marilyn-scott-0.png"
                 alt="Spotify-Logo" width="50">
            <h1>Spotify</h1>
        </div>
        <nav>
            <label for="SignIn" class="signin-wy-style">ورود</label>
            <label for="SignUp" class="signup-wy-style">ثبت نام</label>
        </nav>
        <form action="" id="SignInFormData">
            <input type="text" name="Username" id="username_SignIn" placeholder="نام کابری">
            <input type="password" name="Password" id="password_SignIn" placeholder="پسورد">
            <span>
            <input type="checkbox" id="StaySignedIn">
            <label for="StaySignedIn">من را بخاطر بسپار</label>
        </span>
            <button type="submit" class="btn-SignedIn" title="ورود">ورود</button>
            <a href="<?php echo site_url('/password-recovery'); ?>" id="ForgetPassword">فراموشی رمز عبور</a>
        </form>
        <?php $setting_data_plugin_sms_enabled = get_option('_wy_settings_plugin_worodyaar_sms_enabled', 'no');
        if ($setting_data_plugin_sms_enabled === 'yes'): ?>
            <form action="" id="SignUpFormData">
                <div class="phone_number_f">
                    <input class="phone_number" type="text" name="Name" id="Name" placeholder="شماره موبایل">
                    <button class="phone-number-send-form" type="submit" title="ادامه">ادامه</button>
                </div>
                <div class="phone_number_v">
                    <div class="felexxx">
                        <input class="verify_code" type="text" name="Name" id="Name" placeholder="کد تایید 6 رقمی">
                        <button class="verify-code-send-form" type="submit" title="ادامه">ادامه</button>
                    </div>
                </div>
                <div class="auth_form">
                    <div class="flexx2">
                        <input class="full_name" type="text" name="Name" id="Name" placeholder="نام و نام خانوادگی ">
                        <input class="email_input" type="email" name="email" id="email" placeholder="ایمیل">
                        <input class="password_input" type="password" name="Password" placeholder="پسورد">
                        <input type="hidden" class="wy-input-number-phone-hidden">
                        <button class="send-form" type="submit" title="ثبت نام">ثبت نام</button>
                    </div>
                </div>
            </form>
        <?php else : ?>
            <form action="" id="SignUpFormData">
                <input class="full_name_da_s" type="text" name="Name" id="Name" placeholder="نام و نام خانوادگی ">
                <input class="email_input_da_s" type="email" name="email" id="email" placeholder="ایمیل">
                <input class="password_input_da_s" type="password" name="Password" placeholder="پسورد">
                <button class="send_form_deactivate_sms"   type="submit" title="ثبت نام">ثبت نام</button>
            </form>
        <?php endif; ?>
    </section>
    <?php return ob_get_clean();
}
