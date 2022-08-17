<?php 
/*
Plugin Name: DoOO Data Dashboard
Plugin URI:  https://github.com/
Description: For stuff that's magical
Version:     1.0
Author:      DLINQ
Author URI:  https://dlinq.middcreate.net
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Domain Path: /languages
Text Domain: my-toolset

*/
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );


add_action('wp_enqueue_scripts', 'dooo_data_load_scripts');

function dooo_data_load_scripts() {                           
    $deps = array('jquery');
    $version= '1.0'; 
    $in_footer = true;    
    wp_enqueue_script('dooo_data-main-js', plugin_dir_url( _FILE_) . 'js/dooo-data-main.js', $deps, $version, $in_footer); 
    wp_enqueue_style( 'dooo_data-main-css', plugin_dir_url( _FILE_) . 'css/dooo-data-main.css');
}

add_action('wp_dashboard_setup', 'dooo_data_dashboard_widgets');
  
function dooo_data_dashboard_widgets() {
   $user = wp_get_current_user();
   $allowed_roles = array( 'administrator', 'super-admin');
   if ( array_intersect( $allowed_roles, $user->roles ) ){
      global $wp_meta_boxes;
      $domain = $_SERVER['SERVER_NAME'];
      $name = explode(".", $domain)[0];
      wp_add_dashboard_widget('custom_dooo_widget', '<h2>DoOO Data</h2>', 'dooo_data_foo', '', '', 'column3', 'high');
      var_dump($name . '_last_login.csv');
      $root =  $_SERVER['DOCUMENT_ROOT'];
      var_dump($root . 'root/' . $name . '_last_login.csv');
      //Python stuff to  file in /root .... file_name = os.popen("echo $HOSTNAME").read().split(".")[0] + "_last_logins.csv"

   }
  }
//wp_add_dashboard_widget(  $widget_id,  $widget_name,  $callback,  $control_callback = null,  $callback_args = null,  $context = 'normal', string $priority = 'core' )

function dooo_data_foo(){
   echo 'foo';
}

//LOGGER -- like frogger but more useful

if ( ! function_exists('write_log')) {
   function write_log ( $log )  {
      if ( is_array( $log ) || is_object( $log ) ) {
         error_log( print_r( $log, true ) );
      } else {
         error_log( $log );
      }
   }
}

  //print("<pre>".print_r($a,true)."</pre>");
