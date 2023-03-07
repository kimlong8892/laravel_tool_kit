<?php
/*
Plugin Name: Simple HTTPS Redirect
Plugin URI: https://lightplugins.com/plugins/simple-https-redirect/
Description: The plugin forcibly redirects your website to https protocol, keep your website safe and fix the mixed content problems.
Author: LightPlugins
Author URI: https://lightplugins.com/
Version: 1.0.0
Text Domain: shr
*/

// don't allow to load this file directly.
if (!defined('ABSPATH')) {
    die('-1');
}


// textdomain
function shr_load_plugin_textdomain() {
    load_plugin_textdomain('shr', false, dirname(plugin_basename(__FILE__)) . '/lang' );
}

add_action( 'plugins_loaded', 'shr_load_plugin_textdomain' );


// gettings the subdomain
function shr_get_subdomain($host){
	return substr_count($host, '.') > 1 ? substr($host, 0, strpos($host, '.')) : '';
}


// Checks if the website supports https
function shr_support_test(){

	// capability required: manage_options
	if (!current_user_can("manage_options")){
		return __("You are not authorized to perform this operation.", "shr");
	}

	// Home URL in HTTPS protocol
	$httpsURL = get_home_url(null, '', "https");

	// Get Response
	$response = wp_remote_get($httpsURL, array('timeout' => 5, 'redirection' => 0, 'sslverify' => true));

	// No SSL Support
	if (is_array($response) == false || is_wp_error($response)) {
		return __("No SSL certificates were found on your domain. Make sure you have an SSL certificate.", "shr");
	}

	// No error
	return "";

}


// updating url file
function shr_update_url($type, $method){

	// capability required: manage_options
	if (!current_user_can("manage_options")){
		return false;
	}

	// get site url
	$siteurl = get_option("siteurl");
	$home = get_option("home");

	// htaccess
	$htaccess_file = ABSPATH . ".htaccess";

	// getting the website protocol
	$protocol = (is_ssl() ? 'https://' : 'http://');

	// force https
	if($type == "https"){

		// redirect rules
		$rules = "<IfModule mod_rewrite.c>
RewriteEngine on
RewriteCond %{HTTPS} !=on [NC]
RewriteRule ^(.*)$ https://%{HTTP_HOST}/$1 [R=301,L]
</IfModule>";
		
		// Use HTTPS
		update_option("siteurl", str_replace("http://", "https://", $siteurl));
		update_option("home", str_replace("http://", "https://", $home));

	// force http
	}else if($type == "http"){

		// Use HTTP
		update_option("siteurl", str_replace("https://", "http://", $siteurl));
		update_option("home", str_replace("https://", "http://", $home));

	}

	// checks if htaccess file is exists
	if (file_exists($htaccess_file)){

		// remove insert
		if($method == "deactivate" || $type == "http"){
			insert_with_markers($htaccess_file, "Simple https Redirect", array());

		// insert
		}else if($type == "https"){
			insert_with_markers($htaccess_file, "Simple https Redirect", explode("\n", $rules));
		}

	}

}


// the plugin deactivate hook
function shr_deactivate_hook(){

	// delete redirect lines from htaccess file when deactivated
    shr_update_url(null, "deactivate");

}

register_deactivation_hook( __FILE__, 'shr_deactivate_hook' );


// add option page to settings page
function shr_add_option_page() {

	//create new top-level menu
	add_options_page( 'Simple https Redirect',  'Simple https Redirect',  'manage_options',  'simple-https-redirect',  'shr_option_page_content');

}

add_action('admin_menu', 'shr_add_option_page');



// register settings for admin page
function shr_register_plugin_settings() {

	// register the settings
	register_setting( 'shr_plugin_settings', 'shr_force_type' );

}

add_action( 'admin_init', 'shr_register_plugin_settings' );


// add scripts and styles for the plugin's admin page
function shr_admin_scripts($hook) {
    
	if($hook == "settings_page_simple-https-redirect"){
		wp_enqueue_script('shr-admin', plugins_url('js/admin.js', __FILE__));
    	wp_enqueue_style('shr-admin', plugins_url('css/admin.css', __FILE__));
    }
    
}

add_action('admin_enqueue_scripts', 'shr_admin_scripts');



// Hook into options page after save.
function shr_url_update_hook( $old, $value ) {

	// Update domain
    shr_update_url($value);

}

add_action( 'update_option_shr_force_type', 'shr_url_update_hook', 10, 2);
add_action( 'add_option_shr_force_type', 'shr_url_update_hook', 10, 2);



// adds admin page contents
function shr_option_page_content(){ ?>
<div class="wrap">
<h1>Simple https Redirect</h1>
<form method="post" action="options.php">
    <?php

    // settings save api
    settings_fields('shr_plugin_settings');
    do_settings_sections('shr_plugin_settings');

    // getting the type
    $type = get_option('shr_force_type');

	// variables
    $http = "";
    $https = "";

    // specifies which option is active
    if("http" == $type){
    	$http = " checked";
    }else if($type == "https"){
    	$https = " checked";
    }

    // get and parse siteurl
    $siteurl = get_option("siteurl");
    $siteurl = wp_parse_url($siteurl);

    // look for errors
    $errors = shr_support_test();
    $error_class = "";

    // is there an error?
    if($errors != ""){
    	$error_class = ' class="shr-has-error"';
    }

    ?>

    <div id="shr-wrap">

    <div id="shr-settings"<?php echo $error_class; ?>>

    	<p id="shr-information"><?php _e('The plugin forcibly redirects your website to https protocol, keep your website safe and fix the mixed content problems.', 'shr'); ?></p>

		<p class="shr-errors"><?php echo $errors; ?></p>

		<div class="shr-radio first-child<?php echo $https; ?>"><input type="radio" name="shr_force_type" id="https" value="https" <?php echo $https; ?> /><label for="https"><b>https</b>://<?php echo $siteurl["host"]; ?></label></div><div class="shr-radio last-child<?php echo $http; ?>"><input type="radio" name="shr_force_type" id="http" value="http" <?php echo $http; ?> /><label for="http"><b>http</b>://<?php echo $siteurl["host"]; ?></label></div>

		<?php if($errors == ""){ ?>
		<div class="shr-submit">
    		<input type="submit" class="button button-primary" name="submit" value="<?php _e("Save Changes", "shr"); ?>">
    	</div>
    	<?php } ?>

    </div>

    </div>

    <p class="light-plugins-link">This plugin total is only 6KB.<br />Do you like lightweight plugins? Check <a href="https://www.lightplugins.com/?ref=simple-https-redirect" target="_blank">lightplugins.com</a></p>

</form>
</div>
<?php

}