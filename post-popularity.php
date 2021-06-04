<?php
/**
 * @package PostPopularity
*/

/*
Plugin Name: Fbs Post Popularity
Plugin URI: https://github.com/fazlebarisn/post-popularity
Description: My New Plugin
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

define( 'PLUGIN_PATH' , plugin_dir_path( __FILE__ ) );
define( 'PLUGIN_URL' , plugin_dir_url(__FILE__) );
define( 'TABLE_NAME' , 'postpopularity' );

class FbsPostPopularity{

    private static $_instance = null;

    public static function instance(){

        if( ! isset( self::$_instance ) ){
            self::$_instance = new self;
        }

        return self::$_instance;
    }

    private function __construct(){
        
        add_filter( 'the_content', array( $this , 'add_likes_dislikes' ) );
        add_action( 'wp_enqueue_scripts', array( $this , 'enqueue_scripts' ) );
        add_action( 'wp_ajax_likes_dislikes_action', array( $this , 'likes_dislikes_action') );
        add_action( 'wp_ajax_nopriv_likes_dislikes_action',  array( $this , 'likes_dislikes_action') );

    }

    public function likes_dislikes_action(){

        if( isset( $_POST['action'] ) ): 

            global $wpdb;
            $state = $_POST['state'];
            $post_id = $_POST['post'];
            $table = $wpdb->prefix.TABLE_NAME;
            $user_id = get_current_user_id();

            $row = $wpdb->get_row( "SELECT * FROM `{$table}` WHERE `post_id`={$post_id} AND `user_id`={$user_id}", ARRAY_A );


            if( $row == null ){
                $wpdb->insert( $table, [
                    'user_id' => $user_id,
                    'post_id' => $post_id,
                    $state => 1,
                ]);
            }elseif( $row['user_id'] == $user_id && $row['state'] == 0 ){
                $wpdb->delete( $table, [
                    'user_id' => $user_id,
                    'post_id' => $post_id,
                ]);
                $wpdb->insert( $table, [
                    'user_id' => $user_id,
                    'post_id' => $post_id,
                    $state => 1,
                ]);
            }else{
                $wpdb->delete( $table, [
                    'user_id' => $user_id,
                    'post_id' => $post_id,
                ]);
            }

        endif;

        $likes = $wpdb->get_row( "SELECT COUNT(*) as likes FROM `{$table}` WHERE `post_id`={$post_id} AND `likes` !=0", ARRAY_A );
        $dislikes = $wpdb->get_row( "SELECT COUNT(*) as dislikes FROM `{$table}` WHERE `post_id`={$post_id} AND `dislikes` !=0", ARRAY_A );

        echo json_encode( array(
            'likes' => $likes['likes'],
            'dislikes' => $dislikes['dislikes']
        ));

        wp_die();
    }

    public function enqueue_scripts(){

        global $post;
        wp_enqueue_style( 'likes_dislikes_style', PLUGIN_URL."assets/css/app.css" );
        wp_enqueue_script( 'likes_dislikes_script', PLUGIN_URL."assets/js/app.js", array('jquery'), '1.0.0', true );
        wp_localize_script( 'likes_dislikes_script', 'ajax_object', array(
            'url' => admin_url('admin-ajax.php'),
            'post' => $post->ID
        ));

    }

    public function add_likes_dislikes( $content ){

        if( is_user_logged_in() ){

            global $wpdb;
            global $post;
            //var_dump($post->ID);
            $post_id = $post->ID;
            $table = $wpdb->prefix.TABLE_NAME;

            $likes = $wpdb->get_row( "SELECT COUNT(*) as likes FROM `{$table}` WHERE `post_id`={$post_id} AND `likes` !=0", ARRAY_A );
            $dislikes = $wpdb->get_row( "SELECT COUNT(*) as dislikes FROM `{$table}` WHERE `post_id`={$post_id} AND `dislikes` !=0", ARRAY_A );
            //var_dump($likes , $dislikes );
            $discription = "
                <ul id='like_dislike'>
                    <li><a data-val='likes' href='javascript:;'>Like</a><span>[".$likes['likes']."]</span></li>
                    <li><a data-val='dislikes' href='javascript:;'>Dislike</a><span>[".$dislikes['dislikes']."]</span></li>
                </ul>
            ";
            return $content.$discription;
        }
        return $content;
    }

    public static function do_activate( $network_wide ){

        if( ! current_user_can( 'activate_plugins' ) ){
            return;
        }

        global $wpdb;
        $table = $wpdb->prefix.TABLE_NAME;
        $collate = $wpdb->get_charset_collate();
        $sql = "CREATE TABLE IF NOT EXISTS `{$table}` (
            `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
            `user_id` int(11) DEFAULT NULL,
            `post_id` int(11) DEFAULT NULL,
            `likes` int(11) DEFAULT 0,
            `dislikes` int(11) DEFAULT 0,
            `date_created` timestamp DEFAULT NOW(),
            PRIMARY KEY (`id`)
        ){$collate};";

        require_once( ABSPATH.'wp-admin/includes/upgrade.php');
        dbDelta( $sql );
        
        // $plugin = isset( $_REQUEST['plugin'] ) ? isset( $_REQUEST['plugin'] ) : '';
        // var_dump($_REQUEST['plugin']); exit;
        // check_admin_referer( "activate-plugin_{$plugin}" );

    }

    public static function do_deactivate( $network_wide ){

        if( ! current_user_can( 'activate_plugins') ){
            return;
        }

        global $wpdb;
        $table = $wpdb->prefix.TABLE_NAME;
        $sql = "TRUNCATE TABLE `{$table}`";
        $wpdb->query( $sql );

        //$plugin = isset( $_REQUEST['plugin'] ) ? isset( $_REQUEST['plugin'] ) : '';
        //check_admin_referer( "deactivate-plugin_{$plugin}" );
    
    }

}

//new FbsPostPopularity;

add_action( 'plugins_loaded',  'FbsPostPopularity::instance' );

register_activation_hook( __FILE__, 'FbsPostPopularity::do_activate' );
register_deactivation_hook( __FILE__, 'FbsPostPopularity::do_deactivate' );
