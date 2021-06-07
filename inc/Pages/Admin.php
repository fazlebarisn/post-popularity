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
            [
                'page_title' => 'Fbs page 2',
                'menu_title' => 'Fbs menu 2',
                'capability' => 'manage_options',
                'menu_slug' => 'like_dislike_menu2',
                'callback' => function(){ echo"hey hey"; },
                'icon_url' => '',
                'position' => 9
            ]
        ];

    }

    public function register()
    {

        $this->settings->addPages( $this->pages )->register();
    }
}