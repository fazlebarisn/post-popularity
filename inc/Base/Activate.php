<?php

namespace Inc\Base;

class Activate
{

    public static function activate(){

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

    }

}