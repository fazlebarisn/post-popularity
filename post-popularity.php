<?php
/**
 * @package PostPopularity
*/

/*
Plugin Name: Fbs Post Popularity
Plugin URI: https://github.com/fazlebarisn/post-popularity
Description: This plugin help you to like or dislike a post
Version: 1.1.0
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

// Define a table name. when we activate plugin, postpopularity table will create.
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


