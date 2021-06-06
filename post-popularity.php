<?php
/**
 * @package PostPopularity
*/

/*
Plugin Name: Fbs Post Popularity
Plugin URI: https://github.com/fazlebarisn/post-popularity
Description: This plugin help you to like or dislike a post
Version: 1.0.0
Author: Fazle Bari
Author URI: https://github.com/fazlebarisn/
Licence: GPL Or leater
Text Domain: post-popularity
*/

/*
User can like or dislike a post 
*/

defined('ABSPATH') or die('Nice Try!');

if( file_exists(dirname( __FILE__ ). '/vendor/autoload.php')){
	require_once dirname( __FILE__ ). '/vendor/autoload.php';
}

const TABLE_NAME = 'postpopularity';

// Active Plugin
function activate_post_popularily_plugin(){
	Inc\Base\Activate::activate();
}

register_activation_hook( __FILE__, 'activate_post_popularily_plugin');

// Deactive Plugin
function deactivate_post_popularily_plugin(){
	Inc\Base\Deactivate::deactivate();
}

register_deactivation_hook( __FILE__, 'deactivate_post_popularily_plugin');

/**
 * Initialize all the core classess of the plugin
 */
if (class_exists("Inc\\Init")) {
	Inc\Init::register_services();
}



// class FbsPostPopularity{

//     private static $_instance = null;

//     public static function instance(){

//         if( ! isset( self::$_instance ) ){
//             self::$_instance = new self;
//         }

//         return self::$_instance;
//     }

//     private function __construct(){
        
//         add_action( 'wp_ajax_likes_dislikes_action', array( $this , 'likes_dislikes_action') );
//         add_action( 'wp_ajax_nopriv_likes_dislikes_action',  array( $this , 'likes_dislikes_action') );

//     }

//     public function likes_dislikes_action(){

//         if( isset( $_POST['action'] ) ): 

//             global $wpdb;
//             $state = $_POST['state'];
//             $post_id = $_POST['post'];
//             $table = $wpdb->prefix.TABLE_NAME;
//             $user_id = get_current_user_id();

//             $row = $wpdb->get_row( "SELECT * FROM `{$table}` WHERE `post_id`={$post_id} AND `user_id`={$user_id}", ARRAY_A );


//             if( $row == null ){
//                 $wpdb->insert( $table, [
//                     'user_id' => $user_id,
//                     'post_id' => $post_id,
//                     $state => 1,
//                 ]);
//             }elseif( $row['user_id'] == $user_id && $row['state'] == 0 ){
//                 $wpdb->delete( $table, [
//                     'user_id' => $user_id,
//                     'post_id' => $post_id,
//                 ]);
//                 $wpdb->insert( $table, [
//                     'user_id' => $user_id,
//                     'post_id' => $post_id,
//                     $state => 1,
//                 ]);
//             }else{
//                 $wpdb->delete( $table, [
//                     'user_id' => $user_id,
//                     'post_id' => $post_id,
//                 ]);
//             }

//         endif;

//         $likes = $wpdb->get_row( "SELECT COUNT(*) as likes FROM `{$table}` WHERE `post_id`={$post_id} AND `likes` !=0", ARRAY_A );
//         $dislikes = $wpdb->get_row( "SELECT COUNT(*) as dislikes FROM `{$table}` WHERE `post_id`={$post_id} AND `dislikes` !=0", ARRAY_A );

//         echo json_encode( array(
//             'likes' => $likes['likes'],
//             'dislikes' => $dislikes['dislikes']
//         ));

//         wp_die();
//     }




// }

