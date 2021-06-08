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
}