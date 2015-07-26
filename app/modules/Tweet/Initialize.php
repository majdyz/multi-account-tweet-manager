<?php

namespace Tweet;

use \App;
use \Menu;
use \Route;

class Initialize extends \SlimStarter\Module\Initializer{

    public function getModuleName(){
        return 'Tweet';
    }

    public function getModuleAccessor(){
        return 'tweet';
    }

    public function registerAdminMenu(){

        /* side bar for tweet temporarily removed*/

        /*
         $adminMenu = Menu::get('admin_sidebar');

        $tweetMenu = $adminMenu->createItem('tweet', array(
            'label' => 'Tweet',
            'icon'  => 'comment',
            'url'   => 'admin/tweet'
        ));

        $adminMenu->addItem('tweet', $tweetMenu);
        */
    }

    public function registerAdminRoute(){
        Route::resource('/tweet/:tweetset_id', 'Tweet\Controllers\TweetController');
    }
}