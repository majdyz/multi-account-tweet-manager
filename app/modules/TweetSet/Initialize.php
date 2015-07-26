<?php

namespace TweetSet;

use \App;
use \Menu;
use \Route;

class Initialize extends \SlimStarter\Module\Initializer{

    public function getModuleName(){
        return 'TweetSet';
    }

    public function getModuleAccessor(){
        return 'tweetset';
    }

    public function registerAdminMenu(){

        $adminMenu = Menu::get('admin_sidebar');

        $tweetsetMenu = $adminMenu->createItem('tweetset', array(
            'label' => 'TweetSet',
            'icon'  => 'comment',
            'url'   => 'admin/tweetset'
        ));

        $tweetsetMenu->setAttribute('id','tweetset_navbar');

        $adminMenu->addItem('tweetset', $tweetsetMenu);
    }

    public function registerAdminRoute(){
        Route::resource('/tweetset', 'TweetSet\Controllers\TweetSetController');
        Route::get('/tweetset/random-tweet/:tweetset_id', 'TweetSet\Controllers\TweetSetController:randomTweet');
        Route::get('/tweetset/show-tweet/:tweetset_id', 'TweetSet\Controllers\TweetSetController:showTweet');
    }
}