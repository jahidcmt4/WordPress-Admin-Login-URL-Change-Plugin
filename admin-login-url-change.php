<?php
/**
 * Plugin Name:       Admin login URL Change
 * Plugin URI:        https://viserx.com/
 * Description:       Allows you to Change your WordPress WebSite Login URL.
 * Version:           1.0
 * Requires at least: 4.7
 * Tested up to: 5.8.2
 * Requires PHP:      5.3
 * Author:            jahidcse
 * Author URI:        https://profiles.wordpress.org/jahidcse/


 */

/**
* OOP Class WP_Login_Change
*/

class WP_Login_Change {

public function __construct() {

$file_data = get_file_data( __FILE__, array( 'Version' => 'Version' ) );

$this->plugin                           = new stdClass;
$this->plugin->name                     = 'admin-login-url-change';
$this->plugin->displayName              = 'Admin login URL Change';
$this->plugin->version                  = $file_data['Version'];
$this->plugin->folder                   = plugin_dir_path( __FILE__ );
$this->plugin->url                      = plugin_dir_url( __FILE__ );

/**
* Hooks
*/

add_action('admin_menu', array($this,'admin_login_url_change_add_page'));
add_action('admin_enqueue_scripts', array($this,'admin_login_url_change_css'));
add_action('login_head', array($this,'admin_login_url_change_redirect_error_page'));
add_action('init', array($this,'admin_login_url_change_redirect_success_page'));
add_action('wp_logout', array($this,'admin_login_url_change_redirect_login_page'));
add_action('wp_login_failed', array($this,'admin_login_url_change_redirect_failed_login_page'));

}

/**
* Admin Menu
*/

function admin_login_url_change_add_page() {
     add_submenu_page( 'options-general.php', $this->plugin->displayName, $this->plugin->displayName, 'manage_options', $this->plugin->name, array( &$this, 'settingsPanel' ) );
}

/**
* Setting Page and data store
*/

function settingsPanel() {

if ( ! current_user_can( 'manage_options' ) ) {
  wp_die( __( 'Sorry, you are not allowed to access this page.', 'admin-login-url-change' ) );
}

if(isset($_REQUEST['but_submit'])){
    if ( ! current_user_can( 'unfiltered_html' ) ) {
      wp_die( __( 'Sorry, you are not allowed to access this page.', 'admin-login-url-change' ) );
    } elseif ( !isset( $_REQUEST[ $this->plugin->name . '_nonce' ] ) ) {
      $this->errorMessage = __( 'nonce field is missing. Settings NOT saved.', 'admin-login-url-change' );
    }else{
    update_option( 'jh_new_login_url', sanitize_text_field($_REQUEST['jh_new_login_url']) );
    $this->message = __( 'Settings Saved.', 'admin-login-url-change' );
    }
  }
  $this->html_tag_replace_info = array(
    'jh_new_login_url' => esc_html( wp_unslash( get_option( 'jh_new_login_url' ) ) ),
  );
  include_once $this->plugin->folder.'/view/settings.php';

}


/**
* Admin Include CSS
*/

function admin_login_url_change_css(){
  wp_enqueue_style( 'admin_login_url_change_css', plugins_url('/assets/css/style.css', __FILE__), false, $this->plugin->version);
}



/**
* Redirect Error Page
*/

function admin_login_url_change_redirect_error_page(){

  $jh_new_login = wp_unslash(get_option( 'jh_new_login_url' ));
  if(strpos($_SERVER['REQUEST_URI'], $jh_new_login) === false){
    wp_safe_redirect( home_url( '404' ), 302 );
    exit(); 
  } 
}

/**
* Redirect Success Page
*/

function admin_login_url_change_redirect_success_page(){
  $jh_new_login = wp_unslash(get_option( 'jh_new_login_url' ));
  $jh_wp_admin_login_current_url_path=parse_url($_SERVER['REQUEST_URI']);

  if($jh_wp_admin_login_current_url_path["path"] == '/'.$jh_new_login){
    wp_safe_redirect(home_url("wp-login.php?$jh_new_login&redirect=false"));
    exit(); 
  }
}

/**
* Redirect Login Page
*/

function admin_login_url_change_redirect_login_page() {
  $jh_new_login = wp_unslash(get_option( 'jh_new_login_url' ));
  wp_safe_redirect(home_url("wp-login.php?$jh_new_login&redirect=false"));
    exit();
}

/**
* Redirect Login Page for Login Failed
*/

function admin_login_url_change_redirect_failed_login_page($username) {
  $jh_new_login = wp_unslash(get_option( 'jh_new_login_url' ));
  wp_safe_redirect(home_url("wp-login.php?$jh_new_login&redirect=false"));
  exit();
}


}

$WP_Login_Change = new WP_Login_Change();