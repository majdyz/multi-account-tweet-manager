<?php

namespace UserGroup;

use \App;
use \Menu;
use \Route;
use \Sentry;
use \Exception;

class Initialize extends \SlimStarter\Module\Initializer{

    public function getModuleName(){
        return 'UserGroup';
    }

    public function getModuleAccessor(){
        return 'usergroup';
    }

    public function registerAdminRoute(){
        Route::resource('/user', function(){
            if (Sentry::getUser()->id != 1) {
                throw new Exception("You're not supposed to be here.", 403);
            }
        } ,'UserGroup\Controllers\UserController');
        // Route::resource('/group', 'UserGroup\Controllers\GroupController');
    }
}