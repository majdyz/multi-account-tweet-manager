<?php
namespace Tweet\Controllers;

use \App;
use \View;
use \Menu;
use \Input;
use \Tweet;
use \TweetSet;
use \Request;
use \Response;
use \Exception;
use \Admin\BaseController;

class TweetController extends BaseController
{
    
    public function __construct() {
        parent::__construct();
        Menu::get('admin_sidebar')->setActiveMenu('tweet');
    }
    
    /**
     * display list of resource
     */
    public function index($page = 1) {
        $this->data['title'] = 'Tweet List';
        $this->data['tweets'] = Tweet::all()->toArray();
        $this->data['tweetsets'] = TweetSet::all()->toArray();


        /*querying name of tweet*/
        foreach ($this->data['tweets'] as $i => $tweet) {
            $tweet = TweetSet::find($tweet['tweetset_id']);
            if ($tweet) {
                $this->data['tweets'][$i]['tweetset_name'] = $tweet->name;
            }
            else {
                $this->data['tweets'][$i]['tweetset_name'] = "-N/A-";
            }
        }

        /** load the tweet.js app */
        $this->loadJs('app/tweet.js');
        
        /** publish necessary js  variable */
        $this->publish('baseUrl', $this->data['baseUrl']);
        
        /** render the template */
        View::display('@tweet/tweet/index.twig', $this->data);
    }
    
    /**
     * display resource with specific id
     */
    public function show($id) {
        if (Request::isAjax()) {
            $tweet = null;
            $message = '';
            
            try {
                $tweet = Tweet::findOrFail($id);
            }
            catch(Exception $e) {
                $message = $e->getMessage();
            }
            
            Response::headers()->set('Content-Type', 'application/json');
            Response::setBody(json_encode(array('success' => !is_null($tweet), 'data' => !is_null($tweet) ? $tweet->toArray() : $tweet, 'message' => $message, 'code' => is_null($tweet) ? 404 : 200)));
        } 
        else {
        }
    }
    
    /**
     * show edit from resource with specific id
     */
    public function edit($id) {
        try {
            $tweet = Tweet::findOrFail($id);
            
            //display edit form in non-ajax request
            //
            $this->data['title'] = 'Edit Tweet';
            $this->data['tweets'] = $tweet->toArray();
            
            View::display('@tweet/tweet/edit.twig', $this->data);
        }
        catch(NotFoundException $e) {
            App::notFound();
        }
        catch(Exception $e) {
            Response::setBody($e->getMessage());
            Response::finalize();
        }
    }
    
    /**
     * update resource with specific id
     */
    public function update($id) {
        $success = false;
        $message = '';
        $tweet = null;
        $code = 0;
        
        try {
            $input = Input::put();

            // sanitize input
            foreach ($input as $i => $value) {
                $input[$i] = htmlspecialchars($value);
            }
            
            /** in case request come from post http form */
            $input = is_null($input) ? Input::post() : $input;
            
            $tweet = Tweet::findOrFail($id);
            
            $tweet->name = $input['name'];
            $tweet->tweetset_id = $input['tweetset_id'];
            $tweet->text = $input['text'];
            $tweet->mentions = $input['mentions'];
            $tweet->hashtags = $input['hashtags'];
            
            $success = $tweet->save();
            $code = 200;
            $message = 'Tweet updated sucessully';

            $data = $tweet->toArray();
            $data['tweetset_name'] = TweetSet::find($tweet->tweetset_id)->name;
        }
        catch(NotFoundException $e) {
            $message = $e->getMessage();
            $code = 404;
        }
        catch(Exception $e) {
            $message = $e->getMessage();
            $code = 500;
        }
        
        if (Request::isAjax()) {
            Response::headers()->set('Content-Type', 'application/json');
            Response::setBody(json_encode(array('success' => $success, 'data' => ($tweet) ? $data : $tweet, 'message' => $message, 'code' => $code)));
        } 
        else {
            Response::redirect($this->siteUrl('admin/tweet/' . $id . '/edit'));
        }
    }
    
    /**
     * create new resource
     */
    public function store() {
        
        $tweet = null;
        $message = '';
        $success = false;
        
        try {
            $input = Input::post();

            // sanitize input
            foreach ($input as $i => $value) {
                $input[$i] = htmlspecialchars($value);
            }
            
            $tweet = new Tweet();
            $tweet->name = $input['name'];
            $tweet->tweetset_id = $input['tweetset_id'];
            $tweet->text = $input['text'];
            $tweet->mentions = $input['mentions'];
            $tweet->hashtags = $input['hashtags'];
            
            $success = $tweet->save();
            
            $message = 'Tweet created successfully';

            $data = $tweet->toArray();
            $data['tweetset_name'] = TweetSet::find($tweet->tweetset_id)->name;
        }
        catch(Exception $e) {
            $message = $e->getMessage();
        }
        
        if (Request::isAjax()) {
            Response::headers()->set('Content-Type', 'application/json');
            Response::setBody(json_encode(array('success' => $success, 'data' => ($tweet) ? $data : $tweet, 'message' => $message, 'code' => $success ? 200 : 500)));
        } 
        else {
            Response::redirect($this->siteUrl('admin/tweet'));
        }
    }
    
    /**
     * destroy resource with specific id
     */
    public function destroy($id) {
        $id = (int)$id;
        $deleted = false;
        $message = '';
        $code = 0;
        
        try {
            $tweet = Tweet::findOrFail($id);
            $deleted = $tweet->delete();
            $code = 200;
        }
        catch(NotFoundException $e) {
            $message = $e->getMessage();
            $code = 404;
        }
        catch(Exception $e) {
            $message = $e->getMessage();
            $code = 500;
        }
        
        if (Request::isAjax()) {
            Response::headers()->set('Content-Type', 'application/json');
            Response::setBody(json_encode(array('success' => $deleted, 'data' => array('id' => $id), 'message' => $message, 'code' => $code)));
        } 
        else {
            Response::redirect($this->siteUrl('admin/tweet'));
        }
    }
}
