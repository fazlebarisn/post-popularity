<?php

namespace Inc\Api;

class SettingApi
{
    public $admin_pages = array();
    public $admin_subpages = array();

    public $settings = array();
    public $sections = array();
    public $fields = array();

    public function register(){

        // admin_menu is an action for add menu page. 
        if( ! empty( $this->admin_pages ) ){
            add_action( 'admin_menu', array( $this ,'addAdminMenu' ) );
        }
    }

    public function addPages( array $pages ){

        // pass $pages array from Admin class. inc/Pages
        $this->admin_pages = $pages;
        return $this;

    }

    public function withSubpages( string $title =null ){

        if(  empty( $this->admin_pages ) ){
            return $this;
        }

        $admin_page = $this->admin_pages[0];
        // echo "<pre>";
        // var_dump($admin_page);
        // echo "</pre>";

        $subpage = [
            [
                'parent_slug' => $admin_page['menu_slug'],
                'page_title' => $admin_page['page_title'],
                'menu_title' => ( $title ) ? $title : $admin_page['menu_title'],
                'capability' => $admin_page['capability'],
                'menu_slug' => $admin_page['menu_slug'],
                'callback' => $admin_page['callback'],
            ],
        ];

        $this->admin_subpages = $subpage;

        return $this;
    }

    public function addSubpages( array $pages ){

        // marge $admin_subpages array with $pages array
        $this->admin_subpages = array_merge( $this->admin_subpages , $pages );
        return $this;

    }

    public function addAdminMenu(){

        foreach( $this->admin_pages as $page ){
            add_menu_page( $page['page_title'], $page['menu_title'], $page['capability'], $page['menu_slug'], $page['callback'], $page['icon_url'], $page['position'] );
        }

        foreach( $this->admin_subpages as $page ){
            add_submenu_page( $page['parent_slug'], $page['page_title'], $page['menu_title'], $page['capability'], $page['menu_slug'], $page['callback'] );
        }

    }

    /**
     * Register custom filed a complax prosess. Need the thing to register one custom field. register_setting, add_settings_section and add_settings_field
     * 
     * So again i will pass an array and and register all custom fiels
     */
    public function registerCustomFields(){

        // Register setting
        foreach( $this->settings as $setting ){
            register_setting( $setting['option_group'], $setting['option_name'], isset( $setting['callback'] ) ? $setting['callback'] : '' );
        }

        // Add setting section
        foreach( $this->sections as $section ){
            add_settings_section( $section['id'], $section['title'], isset( $section['callback'] ) ? $section['callback'] : '', $section['page'] );
        }

        // Add settings field
        foreach( $this->fields as $field ){
            add_settings_field( $field['id'], $field['title'], isset( $field['callback'] ) ? $field['callback'] : '', $field['page'], $field['section'], isset( $field['args'] ) ? $field['args'] : '' );
        }

    }


}
