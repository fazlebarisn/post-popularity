<?php

namespace Inc\Api\Callbacks;

use Inc\Base\BaseController;

class AdminCallbacks extends BaseController
{

    public function adminDashboard(){

        return require_once( "$this->plugin_path/templates/admin.php");
        
    }

    public function likeDislikeOptionsGroup( $input ){
        return $input; 
    }

    public function likeDislikeAdminSection(){
        echo "Check this";
    }

    public function likeDislikeTextExample(){

        $value = esc_attr( get_option('text_example') );
        echo '<input type="text" name="text_example" class="regular-text" value="'.$value.'"> placeholder="Input your name"';
    }
}