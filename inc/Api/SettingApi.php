<?php

namespace Inc\Api;

class SettingApi
{
    public $admin_pages = array();
    //public $pages = array();

    public function register(){

        if( ! empty( $this->admin_pages ) ){
            add_action( 'admin_menu', array( $this ,'AddAdminMenu' ) );
        }
    }

    public function addPages( array $pages){

        $this->admin_pages = $pages;
        return $this;

    }

    public function AddAdminMenu(){

        foreach( $this->admin_pages as $page ){
            add_menu_page( $page['page_title'], $page['menu_title'], $page['capability'], $page['menu_slug'], $page['callback'], $page['icon_url'], $page['position'] );
        }
    }

}
