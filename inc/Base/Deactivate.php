<?php

namespace Inc\Base;

class Deactivate
{

    public static function deactivate(){

        if( ! current_user_can( 'activate_plugins') ){
            return;
        }

        global $wpdb;
        $table = $wpdb->prefix.TABLE_NAME;
        $sql = "TRUNCATE TABLE `{$table}`";
        $wpdb->query( $sql );

        flush_rewrite_rules();
    }

}