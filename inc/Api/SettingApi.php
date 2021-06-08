<?php

namespace Inc\Api;

class SettingApi
{

    public function register(){
        add_action( 'admin_menu', array( $this ,'fbs_dev_munu' ) );
    }

    function fbs_dev_munu(){
        add_menu_page( 'Fbs Dev', 'Fbs Dev Options', 'manage_options', 'fbs_dev_options', array( $this ,'fbs_dev_menu_func'), '', null );

    }

    function fbs_dev_menu_func(){  
        echo "Oho hha d";
    }

}