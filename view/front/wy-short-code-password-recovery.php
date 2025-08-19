<?php
add_shortcode('wy-short-code-password-recovery', 'wp_wy_short_code_password_recovery');

function wp_wy_short_code_password_recovery() {
    ob_start(); ?>
     <?php
    $setting_plugin_set_color = get_option( '_wy_settings_plugin_worodyaar_color','#1ed760' );
     $get_token = isset($_GET['recovery_token']) ? $_GET['recovery_token'] : '';
     if ( $get_token ) :
         $token = '';
         $token = new TokenUrlDB();
         $token->wy_select_token($_GET['recovery_token']);
         if ( $token ) :
             ob_start();?>
             <style>
                 body {
                     background: <?php echo $setting_plugin_set_color; ?>;
                 }
                 #SignIn:checked~ section nav lable:first-child,
                 #SignUp:Checked~ section nav lable:last-child{
                     border-bottom: 2px solid <?php echo $setting_plugin_set_color; ?>;
                 }
                 button{
                     background:<?php echo $setting_plugin_set_color; ?>;
                 }
                 input[type=checkbox]{
                     accent-color: <?php echo $setting_plugin_set_color; ?>;
                 }
             </style>
             <input type="radio" name="OptionScreen" id="SignIn" hidden checked>
             <section id="password-recovery">
                 <div id="logo">
                     <?php $logo_WebSite = get_site_icon_url();
                     if (!isset($logo_WebSite)) :  ?>
                         <img src="https://www.freepnglogos.com/uploads/spotify-logo-png/spotify-icon-marilyn-scott-0.png"
                              alt="<?php  bloginfo('name'); ?>" width="50">
                     <?php else : ?>
                         <img src="<?php echo $logo_WebSite; ?>"
                              alt="<?php  bloginfo('name'); ?>" width="50">
                     <?php endif; ?>
                     <?php $site_name = get_bloginfo('name'); ?>
                     <h1><?php echo esc_html($site_name ?: 'Spotify'); ?></h1>
                 </div>
                 <nav>

                 </nav>
                 <form action="" id="SignInFormData">
                     <input type="password" name="Password" id="password_recovery_from" placeholder="پسورد جدید">
                     <input type="password" name="Password" id="repeat_password_recovery_form" placeholder="تکرار پسورد جدید">
                     <input type="hidden" value="<?php echo $_GET['recovery_token']; ?>" name="recovery_token" id="token">
                     <button type="submit" class="btn-ChangePasswordRecovery" title="ادامه">ادامه</button>
                 </form>
             </section>
          <?php else: ?>
         <div>توکن مورد نظر یافت نشد</div>
         <?php endif; ?>
         <?php return ob_get_clean();
     ?>
     <?php else : ?>
     <style>
             body {
                 background: <?php echo $setting_plugin_set_color; ?>;
             }
             #SignIn:checked~ section nav lable:first-child,
             #SignUp:Checked~ section nav lable:last-child{
                 border-bottom: 2px solid <?php echo $setting_plugin_set_color; ?>;
             }
             button{
                 background:<?php echo $setting_plugin_set_color; ?>;
             }
             input[type=checkbox]{
                 accent-color: <?php echo $setting_plugin_set_color; ?>;
             }
         </style>
    <input type="radio" name="OptionScreen" id="SignIn" hidden checked>
    <section id="password-recovery">
        <div id="logo">
            <?php $logo_WebSite = get_site_icon_url();
            if (!isset($logo_WebSite)) :  ?>
                <img src="https://www.freepnglogos.com/uploads/spotify-logo-png/spotify-icon-marilyn-scott-0.png"
                     alt="<?php  bloginfo('name'); ?>" width="50">
            <?php else : ?>
                <img src="<?php echo $logo_WebSite; ?>"
                     alt="<?php  bloginfo('name'); ?>" width="50">
            <?php endif; ?>
            <?php $site_name = get_bloginfo('name'); ?>
            <h1><?php echo esc_html($site_name ?: 'Spotify'); ?></h1>
        </div>
        <nav>
            <label for="SignIn" class="signin-wy-style">فراموشی رمز عبور</label>
        </nav>
        <form action="" id="SignInFormData">
            <input type="text" name="Username" id="username_email" placeholder="ایمیل">
            <button type="submit" class="btn-SendEmailPasswordRecovery" title="ادامه">ادامه</button>
        </form>
    </section>
     <?php endif; ?>
    <?php return ob_get_clean();
}