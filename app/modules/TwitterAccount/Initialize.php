<?php

namespace TwitterAccount;

use \App;
use \Menu;
use \Route;

class Initialize extends \SlimStarter\Module\Initializer{

    public function getModuleName(){
        return 'TwitterAccount';
    }

    public function getModuleAccessor(){
        return 'twitteraccount';
    }

    public function registerPublicRoute()
    {
        Route::get('/connect/:id', 'TwitterAccount\Controllers\TwitterAccountController:add');
        Route::get('/connect/start/:id', 'TwitterAccount\Controllers\TwitterAccountController:connect');
        Route::get('/connect/success/:id', 'TwitterAccount\Controllers\TwitterAccountController:success');
    }

    public function registerAdminRoute(){
        Route::resource('/twitter-account', 'TwitterAccount\Controllers\TwitterAccountController');
        Route::get('/twitter-account/destroy/:id', 'TwitterAccount\Controllers\TwitterAccountController:destroy');
        Route::get('/twitter-account/disable/:id', 'TwitterAccount\Controllers\TwitterAccountController:disable');
        Route::get('/twitter-account/enable/:id', 'TwitterAccount\Controllers\TwitterAccountController:enable');
        Route::get('/twitter-account/delete/:id', 'TwitterAccount\Controllers\TwitterAccountController:delete');
    }
}