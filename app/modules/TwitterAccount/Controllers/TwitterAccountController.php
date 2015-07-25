<?php

namespace TwitterAccount\Controllers;

use \App;
use \View;
use \Menu;
use \Response;
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

    public function show($id)
    {
        $this->data['title'] = TwitterAccount::find($id)->name;
        $this->data['user'] = TwitterAccount::find($id);
        View::display('@twitteraccount/twitter-account/view.twig', $this->data);
    }

    public function destroy($id)
    {
        $this->findUser($id)->delete();
        Response::redirect($this->siteUrl('admin/twitter-account'));
    }

    protected function findUser($id)
    {
        if (($model = TwitterAccount::find($id)) != null) {
            return $model;
        }
        App::notFound();
    }
}