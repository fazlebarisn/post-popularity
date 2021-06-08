<?php

if( !defined( 'WP_UNINSTALL_PLUGIN' )){
	die;
}

if( ! current_user_can( 'activate_plugins') )
	return;

//query will delete the full table

/* 

global $wpdb;
$table = $wpdb->prefix.TABLE_NAME;
$sql = "DROP TABLE `{$table}`";
$wpdb->query( $sql );

*/
