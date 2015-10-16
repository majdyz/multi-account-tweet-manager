<?php

namespace Media;

use \App;
use \Menu;
use \Route;

class Initialize extends \SlimStarter\Module\Initializer{

    public function getModuleName(){
        return 'Media';
    }

    public function getModuleAccessor(){
        return 'media';
    }

    public function registerAdminRoute(){
        Route::resource('/media', 'Media\Controllers\MediaController');
        Route::get('/media/destroy/:id', 'Media\Controllers\MediaController:destroy');
        Route::post('/media/upload', 'Media\Controllers\MediaController:upload');
    }
}