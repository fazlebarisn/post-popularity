<?php

namespace Inc\Base;

use \Inc\Base\BaseController;

class Enqueue extends BaseController
{
	public function register(){
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue' ) );
	}

	function enqueue(){
        global $post;
		wp_enqueue_style( 'likes_dislikes_style', $this->plugin_url . 'assets/css/app.css');
        wp_enqueue_script( 'likes_dislikes_script', $this->plugin_url . 'assets/js/app.js');
        wp_localize_script( 'likes_dislikes_script', 'ajax_object', array(
            'url' => admin_url('admin-ajax.php'),
            'post' => $post->ID
        ));
	}
}