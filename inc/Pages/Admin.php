<?php

namespace Inc\Pages;

use \Inc\Api\SettingApi;

class Admin
{

    public $settings;
    public $pages;

    function __construct()
    {
        $this->settings = new SettingApi;

        $this->pages = [
            [
                'page_title' => 'Fbs page',
                'menu_title' => 'Fbs menu',
                'capability' => 'manage_options',
                'menu_slug' => 'like_dislike_menu',
                'callback' => function(){ echo"hey"; },
                'icon_url' => '',
                'position' => 110
            ],
        ];

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

    public function register()
    {
        $this->settings->addPages( $this->pages )->withSubpages('Dashbord')->addSubpages( $this->subpages )->register();
    }
}