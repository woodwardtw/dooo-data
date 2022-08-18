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

//add_action('wp_enqueue_scripts', 'dooo_data_load_scripts');

function dooo_data_load_scripts() { 
   if(get_current_screen()->base === 'dashboard'){

       $deps = array('jquery');
       $version= '1.0'; 
       $in_footer = true;    
       wp_enqueue_script('dooo_data-main-js', plugin_dir_url( __FILE__) . 'js/dooo-data-main.js', $deps, $version, $in_footer); 
       wp_enqueue_style( 'dooo_data-main-css', plugin_dir_url( __FILE__) . 'css/dooo-data-main.css');
    }
}

add_action('admin_enqueue_scripts', 'dooo_data_load_scripts');




/**
 * Remove the default welcome dashboard message
 *
 */
remove_action( 'welcome_panel', 'wp_welcome_panel' );

add_action('admin_notices', 'dooo_data_logins');



//add_action('wp_dashboard_setup', 'dooo_data_dashboard_widgets');
  
// function dooo_data_dashboard_widgets() {
//    $user = wp_get_current_user();
//    $allowed_roles = array( 'administrator', 'super-admin');
//    if ( array_intersect( $allowed_roles, $user->roles ) ){
//       global $wp_meta_boxes;
//       $domain = $_SERVER['SERVER_NAME'];
//       $name = explode(".", $domain)[0];
//       wp_add_dashboard_widget('custom_dooo_widget', '<h2>DoOO Data</h2>', 'dooo_data_foo', '', '', 'column3', 'high');           
//    }
//   }

function dooo_data_logins(){
   $user = wp_get_current_user();
   $allowed_roles = array( 'administrator', 'super-admin');
   if ( array_intersect( $allowed_roles, $user->roles ) && get_current_screen()->base === 'dashboard'){
      require_once( plugin_dir_path( __FILE__ ) . 'data/last-logins.php' );
      //$data = str_getcsv($bar);
      $data = str_getcsv($bar, "\n");
      $html = "<div id='doo-data'><h1>DoOO Data</h1>";
      //var_dump($data);
      foreach ($data as $key=>$line) {
          $row = explode(",", $line);
          $date = $row[0];
          $user = $row[1];
          $email = $row[2];
          $domain = $row[3];
          $usage = $row[4];
          $start = $row[5];
          if($key === 0){
            $html .="<h2>Last Login</h2>
                  <table class='dooo-table'><tr>
                     <th scope='col'>{$date}</th>
                     <th scope='col'>{$user}</th>
                     <th scope='col'>{$email}</th>
                     <th scope='col'>{$domain}</th>
                     <th scope='col'>{$usage}</th>
                  </tr>";
          } else {
            $html .="<tr>
                     <td>{$date}</td>
                     <td>{$user}</td>
                     <td>{$email}</td>
                     <td>{$domain}</td>
                     <td>{$usage}</td>
                  </tr>";
          }
      }
      echo $html . '</table></div>';
   }
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
