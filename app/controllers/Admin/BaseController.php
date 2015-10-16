<?php
namespace Admin;

use \App;
use \Menu;
use \Module;

class BaseController extends \BaseController
{

    public function __construct()
    {
        parent::__construct();
        $this->data['title'] = 'Dashboard';
    }
}