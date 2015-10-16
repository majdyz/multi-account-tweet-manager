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

    public function registerAdminRoute(){
        Route::resource('/tweet/:tweetset_id', 'Tweet\Controllers\TweetController');
    }
}