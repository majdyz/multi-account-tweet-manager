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
    
    public function registerAdminRoute(){
        Route::post('/tweetset/post-tweet', 'TweetSet\Controllers\TweetSetController:postTweet');
        Route::get('/tweetset/random-tweet/:tweetset_id', 'TweetSet\Controllers\TweetSetController:randomTweet');
        Route::get('/tweetset/show-tweet/:tweetset_id', 'TweetSet\Controllers\TweetSetController:showTweet');
        Route::resource('/tweetset', 'TweetSet\Controllers\TweetSetController');
    }
}