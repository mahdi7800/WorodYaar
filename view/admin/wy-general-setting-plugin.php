<?php
if ( ! current_user_can( 'manage_options' ) ) {
	return;
}
$message         = '';
$setting_plugin_smtp = get_option( '_wy_settings_plugin_worodyaar_smtp', [] );
$setting_plugin_sms_enabled = get_option( '_wy_settings_plugin_worodyaar_sms_enabled', '' );
$setting_plugin_sms = get_option( '_wy_settings_plugin_worodyaar_sms', [] );
$setting_plugin_set_color = get_option( '_wy_settings_plugin_worodyaar_color','#1ed760' );

if ( $_SERVER['REQUEST_METHOD'] === 'POST') {
if ( ! isset( $_POST['_nonce_setting_plugin_worodyaar'] ) || ! wp_verify_nonce( $_POST['_nonce_setting_plugin_worodyaar'], '_nonce_setting_plugin_worodyaar' ) ) {
	$message = '<div class="notice notice-error is-dismissible"><p>اعتبارسنجی امنیتی انجام نشد!</p></div>';
} else {
	$setting_data_plugin_smtp = [
		'host'     => sanitize_text_field( $_POST['host-fs'] ?? ' ' ),
		'port'     => sanitize_text_field( $_POST['port-fs'] ?? ' ' ),
		'username' => sanitize_text_field( $_POST['username-fs'] ?? ' ' ),
		'password' => sanitize_text_field( $_POST['password-fs'] ?? ' ' ),
		'from'     => sanitize_text_field( $_POST['from-fs'] ?? ' ' ),
		'FormName' => sanitize_text_field( $_POST['FormName-fs'] ?? ' ' )
    ];
	$setting_data_plugin_sms_enabled = isset( $_POST['sms_enabled'] ) ? 'yes' : 'no';
	$setting_data_plugin_sms = [
		'username'    => sanitize_text_field( $_POST['sms_username'] ?? '' ),
		'password'    => sanitize_text_field( $_POST['sms_password'] ?? '' ),
		'verify_code' => sanitize_text_field( $_POST['sms_verify_code'] ?? '' ),
		'welcome'     => sanitize_text_field( $_POST['sms_welcome'] ?? '' )
    ];
	$setting_data_plugin_color = isset( $_POST['color'] ) ? sanitize_text_field( $_POST['color'] ) : '#1ed760';
	update_option( '_wy_settings_plugin_worodyaar_smtp', $setting_data_plugin_smtp );
	update_option( '_wy_settings_plugin_worodyaar_sms_enabled', $setting_data_plugin_sms_enabled );
	update_option( '_wy_settings_plugin_worodyaar_sms', $setting_data_plugin_sms);
	update_option( '_wy_settings_plugin_worodyaar_color', $setting_data_plugin_color );

	$message = '<div class="notice notice-success is-dismissible"><p>تنظیمات با موفقیت ذخیره شد!</p></div>';
}
}
?>
<div class="uk-container">
	<?php if ( ! empty( $message ) ) {
		echo $message;
	} ?>
	<div class="uk-flex-inline uk-flex-stretch uk-margin-top">
		<h4 class="uk-margin-left uk-text-right"><?php echo esc_html( get_admin_page_title() ); ?></h4>
	</div>

    <form method="post" class="uk-grid-small" uk-grid>
    <!-- SMS Activation -->
    <div class="uk-width-1-1">
        <hr class="uk-divider-icon uk-margin">
        <div class="uk-margin">
            <label>
                <input class="uk-checkbox" type="checkbox"
                       name="sms_enabled" <?php checked( $setting_plugin_sms_enabled, 'yes' ); ?>>
                فعال کردن سیستم پیامکی برای ثبت نام در وب سایت
            </label>
            <span
                    uk-icon="info"
                    uk-tooltip="title: در صورت تایید سیستم پیامکی فعال می‌شود. برای استفاده، باید یک سرویس از «وب‌سرویس ملی پیامک» تهیه فرمایید!; pos: left; delay: 300; animation: true"
                    style="cursor: help;"
            ></span>
        </div>

        <div id="sms-form-section">
            <!-- SMS Section -->
            <div class="uk-width-1-1">
                <hr class="uk-divider-icon uk-margin">
                <div class="uk-flex-inline uk-flex-stretch uk-margin-top">
                    <h4 class="uk-margin-left uk-text-right">تنظیمات <span class="uk-text-danger">SMS</span> وب سایت
                    </h4>
                </div>
            </div>

            <div class="uk-width-1-1 uk-margin-bottom">
                <div class="uk-alert-primary" uk-alert>
                    <p>توجه داشته باشید که تنظیمات سیستم اس ام اس از طریق <span class="uk-text-danger"><a
                                    href="https://www.melipayamak.com/" target="_blank">سامانه ملی پیامک</a></span>
                        کار می‌کند!</p>
                    <a class="uk-alert-close" uk-close></a>
                </div>
            </div>

            <!-- SMS Inputs Grid -->
            <div class="uk-child-width-1-2@s uk-grid-small" uk-grid>
                <!-- Username -->
                <div>
                    <label class="uk-badge uk-margin-bottom" for="sms-username">UserName</label>
                    <input class="uk-input" id="sms-username" type="text" name="sms_username"
                           placeholder="مثال: 30005000"
                           value="<?php echo esc_attr( $setting_plugin_sms['sms_username'] ?? '' ); ?>"
                           uk-tooltip="title:نام کاربری سامانه ملی پیامک; pos: bottom-right">
                </div>

                <!-- Password -->
                <div>
                    <label class="uk-badge uk-margin-bottom" for="sms-password">Password</label>
                    <input class="uk-input" id="sms-password" type="password" name="sms_password"
                           placeholder="رمز عبور سامانه ملی پیامک"
                           value="<?php echo esc_attr( $setting_plugin_sms['sms_password'] ?? '' ); ?>"
                           uk-tooltip="title:رمز عبور سامانه ملی پیامک; pos: bottom-right">
                </div>

                <!-- Verify Code -->
                <div>
                    <label class="uk-badge uk-margin-bottom" for="sms-verify-code">شماره متن کد تایید</label>
                    <input class="uk-input" id="sms-verify-code" type="text" name="sms_verify_code"
                           placeholder="شماره متن کد تایید در ثبت نام"
                           value="<?php echo esc_attr( $setting_plugin_sms['sms_verify_code'] ?? '' ); ?>"
                           uk-tooltip="title:شماره متنی که برای کد تایید ارسال می‌شود; pos: bottom-right">
                </div>

                <!-- Welcome Message -->
                <div>
                    <label class="uk-badge uk-margin-bottom" for="sms-welcome">شماره متن پیام خوش آمدگویی</label>
                    <input class="uk-input" id="sms-welcome" type="text" name="sms_welcome"
                           placeholder="شماره متن پیام خوش آمدگویی"
                           value="<?php echo esc_attr( $setting_plugin_sms['sms_welcome'] ?? '' ); ?>"
                           uk-tooltip="title:شماره متنی که برای پیام خوش آمدگویی ارسال می‌شود; pos: bottom-right">
                </div>
            </div>

        </div>
    </div>
	<div class="uk-flex-inline uk-flex-stretch uk-margin-top">
		<h4 class="uk-margin-left uk-text-right">تنظیمات <span class="uk-text-danger">SMTP</span> پلاگین  </h4>
	</div>
        <hr class="uk-divider-icon  uk-width-1-9@s">
        <!-- SMTP Host -->
        <div class="uk-width-1-2@s">
            <span class="uk-badge uk-margin-bottom">Host</span>
            <input class="uk-input" type="text" name="host-fs"
                   placeholder="مثال: smtp.example.com"
                   value="<?php echo esc_attr( $setting_plugin_smtp['host'] ?? '' ); ?>"
                   aria-label="آدرس سرور SMTP"
                   uk-tooltip="title:آدرس سرور SMTP خود را وارد کنید. مثال: smtp.example.com; pos:bottom-right">
        </div>

        <!-- SMTP Port -->
        <div class="uk-width-1-2@s">
            <span class="uk-badge uk-margin-bottom">Port</span>
            <input class="uk-input" type="number" name="port-fs"
                   placeholder="مثال: 587"
                   value="<?php echo esc_attr( $setting_plugin_smtp['port'] ?? '' ); ?>"
                   aria-label="پورت SMTP"
                   uk-tooltip="title:پورت مورد استفاده برای اتصال SMTP. معمولاً 587 برای TLS یا 465 برای SSL; pos: bottom-right">
        </div>

        <!-- Username -->
        <div class="uk-width-1-2@s">
            <span class="uk-badge uk-margin-bottom">Username</span>
            <input class="uk-input" type="text" name="username-fs"
                   placeholder="نام کاربری SMTP"
                   value="<?php echo esc_attr( $setting_plugin_smtp['username'] ?? '' ); ?>"
                   aria-label="نام کاربری SMTP"
                   uk-tooltip="title:نام کاربری حساب SMTP شما. معمولاً آدرس ایمیل کامل شماست; pos: bottom-right">
        </div>

        <!-- Password -->
        <div class="uk-width-1-2@s">
            <span class="uk-badge uk-margin-bottom">Password</span>
            <input class="uk-input" type="password" name="password-fs"
                   placeholder="رمز عبور SMTP"
                   value="<?php echo esc_attr($setting_plugin_smtp['password'] ?? '' ); ?>"
                   aria-label="رمز عبور SMTP"
                   uk-tooltip="title:رمز عبور اختصاص داده شده برای حساب SMTP شما; pos: bottom-right">
        </div>

        <!-- From Email -->
        <div class="uk-width-1-2@s">
            <span class="uk-badge uk-margin-bottom">From Email</span>
            <input class="uk-input" type="email" name="from-fs"
                   placeholder="مثال: no-reply@example.com"
                   value="<?php echo esc_attr( $setting_plugin_smtp['from'] ?? '' ); ?>"
                   aria-label="آدرس ایمیل فرستنده"
                   uk-tooltip="title:آدرس ایمیلی که می‌خواهید به عنوان فرستنده نمایش داده شود; pos: bottom-right">
        </div>

        <!-- From Name -->
        <div class="uk-width-1-2@s">
            <span class="uk-badge uk-margin-bottom">From Name</span>
            <input class="uk-input" type="text" name="FormName-fs"
                   placeholder="مثال: نام وبسایت شما"
                   value="<?php echo esc_attr( $setting_plugin_smtp['FormName'] ?? '' ); ?>"
                   aria-label="نام فرستنده"
                   uk-tooltip="title:نامی که می‌خواهید به عنوان فرستنده نمایش داده شود;pos: bottom-right">
        </div>

        <hr class="uk-divider-icon  uk-width-1-9@s">
        <div class="uk-width-1-4@s">
        <label for="exampleColorInput" class="uk-badge uk-margin-bottom">انتخاب رنگ</label>
            <input type="color" class="form-control form-control-color" id="exampleColorInput" name="color"
                   value="<?php echo esc_attr( $setting_plugin_set_color ?? '#1ed760' ); ?>" title="Choose your color">
        </div>
        <div class="uk-width-1-1">
		    <?php submit_button( 'ذخیره تنظیمات', 'primary' ); ?>
		    <?php wp_nonce_field( '_nonce_setting_plugin_worodyaar', '_nonce_setting_plugin_worodyaar' ); ?>
        </div>
    </form>
</div>