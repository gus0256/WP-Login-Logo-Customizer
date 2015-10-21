<?php
/*
Plugin Name: My login logo
Plugin URI: http://littlebigbyte.com
Description: This plug-in allows for a custom logo to be displayed at login
Author: Little Big Byte
Version: 1.0
Author URI: http://littlebigbyte.com
*/
function my_login_logo() 
{ 
    $logoLocation = get_option('image_url_field');
    $size = getimagesize($logoLocation); ?>
    <style type="text/css">
        body.login div#login h1 a 
        {
            background-image: url("<?php echo $logoLocation ?>");
            padding-bottom: 5px;
			background-size: <?php echo ''.$size[0].'px '.$size[1].'px';?>;
            width: <?php echo $size[0].'px'; ?>;
            height: <?php echo $size[1].'px'; ?>;
        }
    </style>
<?php 
}
add_action( 'login_enqueue_scripts', 'my_login_logo' );
function my_login_logo_url() {
    return get_bloginfo( 'url' );
}
add_filter( 'login_headerurl', 'my_login_logo_url' );

//Filter for changing the logo url and title
function my_login_logo_url_title() 
{
    return get_bloginfo('name','raw');
}
add_filter( 'login_headertitle', 'my_login_logo_url_title' );

//Display login setting
function my_login_settings()
{
    add_options_page("My Login Logo", "My Login Logo", "manage_options", "My_Login_Logo", "My_Login_Logo_Settings");
    add_action( 'admin_init', 'register_mysettings' );
}
add_action('admin_menu', 'my_login_settings');
add_action('admin_enqueue_scripts', 'functions_needed');

//Function displays the settings page for plugin
function My_Login_Logo_Settings()
{
    if ( !current_user_can( 'manage_options' ) )  
    {
        wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
    }
    echo '<div class="wrap">';
    echo '<h2>'.$bloginfo.' My Login Logo</h2>';
    echo '<form method="post" action="options.php">';
    settings_fields('lbb-my-login-logo');
    echo '<label for="image_url_field">
    <input id="image_url_field" type="text" size="36" name="image_url_field"  value="'.get_option('image_url_field').'" />
    <input type= "button" class="button" name="image_button" id="image_button" value="Add Login Logo Image"/><br\>
    <input type= "button" class="button" name="reset_button" id="reset_button" value="Reset back to WordPress logo"/>';
    echo '<input type="hidden" id="defaultLogoAddress" name="defaultLogoAddress" value="'.admin_url('/images/wordpress-logo.png',__FILE__).'"/><br\>';
    submit_button();
    echo '</label></form>';
}

//Functions that are needed to display media 
function functions_needed()
{
    if (isset($_GET['page']) && $_GET['page'] == 'My_Login_Logo')
    {
        wp_enqueue_media();
        wp_enqueue_script('functions_script',plugins_url('/functions.js', __FILE__ ),array( 'jquery' ));
    }
}

//Register the setting for the login logo
function register_mysettings()
{
    register_setting( 'lbb-my-login-logo', 'image_url_field' );
}
?>
