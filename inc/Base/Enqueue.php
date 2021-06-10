<?php

namespace Inc\Base;

use \Inc\Base\BaseController;

class Enqueue extends BaseController
{
	public function register(){
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue' ) );
        add_action( 'admin_enqueue_scripts', array( $this, 'adminEnqueue' ) );
	}

	function enqueue(){
        global $post;
		wp_enqueue_style( 'likes_dislikes_style', $this->plugin_url . 'assets/css/app.css');
        wp_enqueue_script( 'likes_dislikes_script', $this->plugin_url . 'assets/js/app.js', array('jquery'), '1.0.0', true);
        wp_localize_script( 'likes_dislikes_script', 'ajax_object', array(
            'url' => admin_url('admin-ajax.php'),
            'post' => $post->ID
        ));
    }
    
    public function adminEnqueue(){
        wp_enqueue_style( 'likes_dislikes_style', $this->plugin_url . 'assets/css/app.css');
        wp_enqueue_script( 'likes_dislikes_script', $this->plugin_url . 'assets/js/app.js', array('jquery'), '1.0.0', true);
    }
}