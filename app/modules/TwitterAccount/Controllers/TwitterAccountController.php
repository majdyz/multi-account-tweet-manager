<?php

namespace TwitterAccount\Controllers;

use \App;
use \View;
use \Menu;
use \Admin\BaseController;

use \TwitterAccount;

class TwitterAccountController extends BaseController
{

    public function __construct()
    {
        parent::__construct();
        Menu::get('admin_sidebar')->setActiveMenu('twitteraccount');
    }

    public function index()
    {
        $this->data['title'] = 'Twitter Account';
        $this->data['users'] = TwitterAccount::all()->toArray();
        View::display('@twitteraccount/twitter-account/index.twig', $this->data);
    }

    public function show()
    {

    }

    public function store()
    {

    }

    public function create()
    {
        
    }

    public function edit()
    {

    }

    public function update()
    {

    }

    public function destroy()
    {

    }
}