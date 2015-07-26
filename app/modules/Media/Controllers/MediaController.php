<?php

namespace Media\Controllers;

use \App;
use \View;
use \Menu;
use \Admin\BaseController;
use Abraham\TwitterOAuth\TwitterOAuth;
use \Media;
use \TweetMedia;
use \TwitterAccount;

class MediaController extends BaseController
{

    public function __construct()
    {
        parent::__construct();
        Menu::get('admin_sidebar')->setActiveMenu('media');
    }

    public function index()
    {
        $connection = new TwitterOAuth(TwitterAccount::getCredentialsTwitter()['consumer_key'], TwitterAccount::getCredentialsTwitter()['consumer_secret'], '3292383559-hlWR7BSiczsXCDpuInyeZAmeNOvVZvI8YDZtrPv', 'QnAnW1VPBhU2XNJbrb2I17jhUHHZFJO7qfSBjyJKbfEL4');
        $media1 = $connection->upload('media/upload', array('media' => 'http://cdn-2.tstatic.net/jabar/foto/bank/images/kucing-berdoa.jpg'));
        $parameters = array(
            'status' => 'Meow Meow Meow',
            'media_ids' => implode(',', array($media1->media_id_string)),
        );
        $result = $connection->post('statuses/update', $parameters);
        var_dump($result); die();

        $this->data['title'] = 'Media';
        View::display('@media/media/index.twig', $this->data);
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