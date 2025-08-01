<?php
add_action('admin_menu', 'wy_register_menu');
function wy_register_menu() {
	add_menu_page(
		 'پلاگین ورودیار'
	    ,'پلاگین ورودیار'
		,'manage_options'
		,'worodyaar_plugin'
		,'wy_plugin_menu_layout'
		,'dashicons-welcome-view-site'
		,99
	);
	add_submenu_page(
	 'worodyaar_plugin'
	,'تنظیمات ورودیار'
	,'تنظیمات ورودیار'
	,'manage_options'
	,'worodyaar_settings'
	,'wy_settings_layout'
	,99
	);
}
function wy_plugin_menu_layout(){
  require_once WY_PLUGIN_DIR . 'view/admin/wy-info-setup-plugin.php';
}
function wy_settings_layout(){
	require_once WY_PLUGIN_DIR . 'view/admin/wy-general-setting-plugin.php';
}
