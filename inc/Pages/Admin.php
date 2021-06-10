<?php

namespace Inc\Pages;

use Inc\Api\SettingApi;
use Inc\Base\BaseController;
use Inc\Api\Callbacks\AdminCallbacks;

class Admin extends BaseController
{

    public $settings;
    public $callback;
    public $pages = array();
    public $subpages = array();

    public function register()
    {
        /*
            ** create new instance of SettingApi class. SettingApi call has hook and action that will
            ** active all menu page and submenu pagea
        */
        $this->settings = new SettingApi;

        // create new instance of AdminCallback calss
        $this->callback = new AdminCallbacks;

        // setPages() methord actually an array of pages
        $this->setPages();

        // setSubpages() methord actually an array of subpages
        $this->setSubpages();

        // 
        $this->setSettings();
        $this->setSections();
        $this->setFields();
        /*
            ** Here all magic happen. This is methord chaning. Here i have first call addPages() methord
            ** then withSubpages(), addSubpages() and then finally register()
             ** all methord from SettingApi class
        */
        $this->settings->addPages( $this->pages )->withSubpages('Dashbord')->addSubpages( $this->subpages )->register();

    }

    public function setPages(){

        // if need new menu page, just add another arrry. That will be it, nothing more. 
        $this->pages = [
            [
                'page_title' => 'Fbs page',
                'menu_title' => 'Fbs menu',
                'capability' => 'manage_options',
                'menu_slug' => 'like_dislike_menu',
                'callback' => array( $this->callback, 'adminDashboard' ),
                'icon_url' => '',
                'position' => 110
            ],
        ];  
    }

    public function setSubpages(){

        // if you want to add more subpage just add new array, that's it. don't need to write anything.
        $this->subpages = [
            [
                'parent_slug' => 'like_dislike_menu',
                'page_title' => 'Custom Post',
                'menu_title' => 'Cpt',
                'capability' => 'manage_options',
                'menu_slug' => 'likey_cpt',
                'callback' => function(){ echo"hey cpt"; }
            ],
            [
                'parent_slug' => 'like_dislike_menu',
                'page_title' => 'Create new',
                'menu_title' => 'New',
                'capability' => 'manage_options',
                'menu_slug' => 'likey_new',
                'callback' => function(){ echo"hey new"; }
            ],
            [
                'parent_slug' => 'like_dislike_menu',
                'page_title' => 'Taxonomy',
                'menu_title' => 'Tax',
                'capability' => 'manage_options',
                'menu_slug' => 'likey_tax',
                'callback' => function(){ echo"hey tax"; }
            ],
        ];
    }

    
    /**
     * passing array for register custom fields in Api/SettingsApi
     * 
     * If i need a new field
     * 1. Add an array in setSettings methord
     * 2. Add an array for field in  setFields methord
     * 3. update callback, where the html codes
     */

    public function setSettings(){

        $args = array(
            array(
                'option_group' => 'like_dislike_options_group',
                'option_name' => 'first_name',
                'callback' => array( $this->callback , 'likeDislikeOptionsGroup' ),
            ),
            array(
                'option_group' => 'like_dislike_options_group',
                'option_name' => 'last_name',
            )
        );

        $this->settings->setSettings( $args ); // this methord dicliar in Api/SettingsApi 

    }

    public function setSections(){

        $args = array(
            array(
                'id' => 'like_dislike_admin_index',
                'title' => 'Settings',
                'callback' => array( $this->callback , 'likeDislikeAdminSection' ),
                'page' => 'like_dislike_menu', // menu page slug, which page this section should print
            )
        );

        $this->settings->setSections( $args ); // this methord dicliar in Api/SettingsApi 

    }

    public function setFields(){

        $args = array(

            array(
                'id' => 'first_name', // same as option_name
                'title' => 'First Name', 
                'callback' => array( $this->callback , 'likeDislikeFirstName' ),
                'page' => 'like_dislike_menu', //menu page slug, which page this section should print
                'section' => 'like_dislike_admin_index', // same id as section
                'args' => array(
                    'label_for' => 'first_name',
                    'class' => 'example-class'
                    )
                ),
            array(
                'id' => 'last_name', // same as option_name
                'title' => 'Last Name', 
                'callback' => array( $this->callback , 'likeDislikeLastName' ),
                'page' => 'like_dislike_menu', //menu page slug, which page this section should print
                'section' => 'like_dislike_admin_index', // same id as section
                'args' => array(
                    'label_for' => 'last_name',
                    'class' => 'example-class'
                    )
                ),
        );

        $this->settings->setFields( $args ); // this methord dicliar in Api/SettingsApi 

    }
}