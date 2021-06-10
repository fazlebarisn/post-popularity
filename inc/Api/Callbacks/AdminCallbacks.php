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

    public function likeDislikeFirstName(){

        $value = esc_attr( get_option('first_name') );
        echo '<input type="text" name="first_name" class="regular-text" value="'.$value.'" placeholder="Input your first name" >';
    }

    public function likeDislikeLastName(){

        $value = esc_attr( get_option('last_name') );
        echo '<input type="text" name="last_name" class="regular-text" value="'.$value.'" placeholder="Input your last name" >';
    }
}