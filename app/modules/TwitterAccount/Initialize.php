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

    public function registerAdminMenu(){

        $adminMenu = Menu::get('admin_sidebar');

        $userMenu = $adminMenu->createItem('twitteraccount', array(
            'label' => 'Twitter Account',
            'icon'  => 'twitter',
            'url'   => 'admin/twitter-account'
        ));

        $adminMenu->addItem('twitteraccount', $userMenu);
    }

    public function registerAdminRoute(){
        Route::resource('/twitter-account', 'TwitterAccount\Controllers\TwitterAccountController');
        Route::get('/twitter-account/show/:id', 'TwitterAccount\Controllers\TwitterAccountController:show');
        Route::get('/twitter-account/destroy/:id', 'TwitterAccount\Controllers\TwitterAccountController:destroy');
        Route::get('/twitter-account/disable/:id', 'TwitterAccount\Controllers\TwitterAccountController:disable');
        Route::get('/twitter-account/enable/:id', 'TwitterAccount\Controllers\TwitterAccountController:enable');
        Route::get('/twitter-account/delete/:id', 'TwitterAccount\Controllers\TwitterAccountController:delete');

        Route::get('/twitter-account/connect/add', 'TwitterAccount\Controllers\TwitterAccountController:add');
        Route::get('/twitter-account/connect/start', 'TwitterAccount\Controllers\TwitterAccountController:connect');
        Route::get('/twitter-account/connect/finish', 'TwitterAccount\Controllers\TwitterAccountController:finish');
        Route::get('/twitter-account/connect/success/:username', 'TwitterAccount\Controllers\TwitterAccountController:success');
    }
}