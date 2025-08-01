<?php
/*
Plugin Name: ورود یار | Worod year
Plugin URI: http://mahdidavoodi.ir
Description: افزونه‌ای حرفه‌ای برای مدیریت ثبت‌نام و ورود کاربران با فرم‌های سفارشی، تأیید پیامکی، بازیابی رمز عبور، و پنل تنظیمات اختصاصی.
Author: Mahdi Davoodi
Version: 1.0.0
License: GPLv2 or later
Author URI: http://mahdidavoodi.ir
*/
defined( 'ABSPATH' ) || exit();

class CoreWorodYaar {
	public function __construct() {
		$this->wp_wy_define_file();
		$this->wp_wy_init_script();
	}

	public function wp_wy_define_file() {
		define( 'WY_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
		define( 'WY_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
	}

	public function wp_wy_init_script() {
		add_action( 'get_header', [ $this, 'wp_wy_register_header_auth_assets_front' ] );
		add_action( 'get_footer', [ $this, 'wp_wy_register_header_auth_assets_front' ] );
		add_action( 'admin_enqueue_scripts', [ $this, 'wp_wy_init_assets_admin' ] );
		register_activation_hook( __FILE__, [ $this, 'wp_wy_activation_file_opp' ] );
		register_deactivation_hook( __FILE__, [ $this, 'wp_wy_deactivation_file_opp' ] );
		$this->wp_wy_loadEntities();

	}

	public function wp_wy_init_assets_front() {
		wp_register_style( 'wy-style-css', WY_PLUGIN_URL . '/assets/front/css/style.css', [], '3.0.0' );
        wp_register_style('wy-jquery-toast-css',WY_PLUGIN_URL .'/assets/front/css/jquery.toast.css','','1.0.0','');

        wp_enqueue_style('wy-jquery-toast-css');
		wp_enqueue_style( 'wy-style-css' );
		// JS
        wp_register_script('wy-jquery-toast-js',WY_PLUGIN_URL .'/assets/front/js/jquery.toast.js',['jquery'],'1.0.0', true);
        wp_enqueue_script('wy-jquery-toast-js');
        wp_enqueue_script( 'wy-ajax-js', WY_PLUGIN_URL . 'assets/front/js/wy-ajax.js', [ 'jquery' ], '3.0.0', true );
		wp_localize_script( 'wy-ajax-js', 'wy_ajax', [
			'_nonce'  => wp_create_nonce(),
			'ajaxurl' => admin_url( 'admin-ajax.php' ),
		] );

	}

	public function wp_wy_init_assets_admin() {
		//CSS
		wp_register_style( 'wy-style-css', WY_PLUGIN_URL . '/assets/admin/css/style.css', [], '1.0.0' );
		wp_register_style( 'wy-uikit-rtl-css', WY_PLUGIN_URL . '/assets/admin/css/uikit-rtl.css', [], '3.21.16' );
		wp_register_style( 'wy-bootstrap-css', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css', [], '5.3.7' );


		wp_enqueue_style( 'wy-style-css' );
		wp_enqueue_style( 'wy-uikit-rtl-css' );
		wp_enqueue_style( 'wy-bootstrap-css' );
		//JS
		wp_register_script( 'wy-main-js', WY_PLUGIN_URL . '/assets/admin/js/main.js', [ 'jquery' ], '1.0.0', true );
		wp_register_script( 'wy-uikit-min-js', WY_PLUGIN_URL . '/assets/admin/js/uikit.min.js', [ 'jquery' ], '3.21.16', true );
		wp_register_script( 'wy-uikit-icons-js', WY_PLUGIN_URL . '/assets/admin/js/uikit-icons.min.js', [ 'jquery' ], '3.21.16', true );
		wp_register_script( 'wy-bootstrap-js', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q', [ 'jquery' ], '5.3.7', true );


		wp_enqueue_script( 'wy-main-js' );
		wp_enqueue_script( 'wy-uikit-min-js' );
		wp_enqueue_script( 'wy-uikit-icons-js' );
		wp_enqueue_script( 'wy-bootstrap-js' );
	}

	public function wp_wy_activation_file_opp() {
		$this->wp_wy_create_table_database();
		$this->wp_wy_create_file_signup_and_sign_in_and_password_recovery();
		$this->wy_set_data_in_tables_options();
	}

	public function wp_wy_deactivation_file_opp() {

	}

	public function wp_wy_loadEntities() {

		require_once WY_PLUGIN_DIR . 'AutoLoadLog.php';

		//AJAX
        include_once WY_PLUGIN_DIR . '_inc/ajax_function/wy-ajax-send-code.php';
        include_once WY_PLUGIN_DIR . '_inc/ajax_function/wy-ajax-verification-code-check.php';
        include_once WY_PLUGIN_DIR . '_inc/ajax_function/wy-ajax-registration-system.php';
        include_once WY_PLUGIN_DIR . '_inc/ajax_function/wy-ajax-deactivate-sms-registration-system.php';
        include_once WY_PLUGIN_DIR . '_inc/ajax_function/wy-ajax-SignIn-system.php';

		//VIEW
		include_once WY_PLUGIN_DIR . 'view/front/wy-short-code-login-register.php';
		include_once WY_PLUGIN_DIR . 'view/front/wy-short-code-password-recovery.php';
		//_INC
		include_once WY_PLUGIN_DIR . '_inc/menu/wy-add-menu-setting.php';
	}

	public function wp_wy_register_header_auth_assets_front( $name ) {
		if ( $name == 'auth' ) {
			add_action( 'wp_enqueue_scripts', [ $this, 'wp_wy_init_assets_front' ] );
		}
	}

	public function wp_wy_create_table_database() {
		global $wpdb;

		$table_verify_code = $wpdb->prefix . 'wy_verify_code';
		$wy_verify_code    = "CREATE TABLE IF NOT EXISTS `$table_verify_code` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `verification_code` varchar(6) NOT NULL,
        `phone` varchar(15) NOT NULL,
        `status` int(11) NOT NULL DEFAULT 0 COMMENT '0: unverify, 1: verify',
        `create_date` datetime NOT NULL DEFAULT current_timestamp(),
        `update_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
        PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci";


		$table_token = $wpdb->prefix . 'wy_validate_token';

		$wy_validate_token = "CREATE TABLE IF NOT EXISTS `$table_token` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `token` varchar(256) NOT NULL,
        `email` varchar(256) NOT NULL,
        `status` int(11) NOT NULL,
        `create_at` datetime NOT NULL DEFAULT current_timestamp(),
        `update_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
        PRIMARY KEY (`id`),
        INDEX (`token`),
        INDEX (`email`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

		dbDelta( $wy_verify_code );
		dbDelta( $wy_validate_token );
	}

	public function wp_wy_create_file_signup_and_sign_in_and_password_recovery() {
		$theme_directory_path           = get_template_directory();
		$file_name_header_auth          = 'header-auth.php';
		$file_name_footer_auth          = 'footer-auth.php';
		$file_name_login_register       = 'login-register.php';
		$file_name_password_recovery    = 'password-recovery.php';
		$file_content_header_auth       = <<<HTML
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="UTF-8">
    <title><?php echo get_bloginfo('name'); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
HTML;
		$file_content_footer_auth = '<?php wp_footer(); ?></body></html>';
		$file_content_login_register = <<<PHP
<?php
/*
Template Name: ثبت نام و ورود به وب سایت
*/
if ( !is_user_logged_in() ) {
    wp_redirect( home_url() );
    exit;
} else {
    get_header('auth');
    echo do_shortcode('[wy-short-code-login-register]');
    get_footer('auth');
}
?>
PHP;
		$file_content_password_recovery = <<<PHP
<?php
/*
Template Name: فراموشی رمز عبور
*/
get_header('auth');
echo do_shortcode('[wy-short-code-password-recovery]');
get_footer('auth');
?>
PHP;
		if ( ! is_file( $file_name_header_auth ) && ! file_exists( $file_name_header_auth ) ) {
			$create_file_header_auth = fopen( $theme_directory_path . '/' . $file_name_header_auth, 'w+' );
			fwrite( $create_file_header_auth, $file_content_header_auth );
			fclose( $create_file_header_auth );
		}
		if ( ! is_file( $file_name_footer_auth  ) && ! file_exists( $file_name_footer_auth  ) ) {
			$create_file_footer_auth = fopen( $theme_directory_path . '/' . $file_name_footer_auth , 'w+' );
			fwrite( $create_file_footer_auth, $file_content_footer_auth);
			fclose( $create_file_footer_auth );
		}
		if ( ! is_file( $file_name_login_register ) && ! file_exists( $file_name_login_register ) ) {
			$create_file_login_register = fopen( $theme_directory_path . '/' . $file_name_login_register, 'w+' );
			fwrite( $create_file_login_register, $file_content_login_register );
			fclose( $create_file_login_register );
		}
		if ( ! is_file( $file_name_password_recovery ) && ! file_exists( $file_name_password_recovery ) ) {
			$create_file_password_recovery = fopen( $theme_directory_path . '/' . $file_name_password_recovery, 'w+' );
			fwrite( $create_file_password_recovery, $file_content_password_recovery );
			fclose( $create_file_password_recovery );
		}
	}

	public function wy_set_data_in_tables_options() {
		$options = [
			'_wy_settings_plugin_worodyaar_smtp'        => [
				'host'     => '',
				'port'     => '',
				'username' => '',
				'password' => '',
				'from'     => '',
				'FormName' => ''
			],
			'_wy_settings_plugin_worodyaar_sms_enabled' => 'no',
			'_wy_settings_plugin_worodyaar_sms'         => [
				'username'    => '',
				'password'    => '',
				'verify_code' => '',
				'welcome'     => ''
			],
			'_wy_settings_plugin_worodyaar_color'=> '#1ed760'
		];
		foreach ( $options as $key => $value ) {
			if ( get_option( $key ) === false ) {
				update_option( $key, $value );
			}
		}
	}

}

$coreWorodYaar = new CoreWorodYaar();
