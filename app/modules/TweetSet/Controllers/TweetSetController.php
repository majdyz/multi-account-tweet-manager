<?php
namespace TweetSet\Controllers;

use \App;
use \View;
use \Menu;
use \Input;
use \TweetSet;
use \User;
use \Request;
use \Response;
use \Tweet;
use \Exception;
use \Admin\BaseController;

class TweetSetController extends BaseController
{
    public function __construct() {
        parent::__construct();
        Menu::get('admin_sidebar')->setActiveMenu('tweetset');
    }

    /** 
    * sanitize input 
    */
    private function sanitize ($input) {
        foreach ($input as $i => $value) {
           $input[$i] = htmlspecialchars($value);
        }
        return $input;
    }

    /**
     * display list of resource
     */
    public function index($page = 1) {
        $this->data['title'] = 'Tweetset List';
        $this->data['tweetsets'] = TweetSet::getAllTweetSets()->toArray();
        
        /** load the tweetset.js app */
        $this->loadJs('app/tweetset.js');
        
        /** publish necessary js  variable */
        $this->publish('baseUrl', $this->data['baseUrl']);
        
        /** render the template */
        View::display('@tweetset/tweetset/index.twig', $this->data);
    }
    
    /**
    * distribute random tweet for each user's twitter account
    */
    public function random($id) {
        // $this->d
    }

    /**
     * display resource with specific id
     */
    public function show($id) {
        if (Request::isAjax()) {
            $tweetset = null;
            $message = '';
            
            try {
                $tweetset = TweetSet::getOneTweetSet($id);
            }
            catch(Exception $e) {
                $message = $e->getMessage();
            }
            
            Response::headers()->set('Content-Type', 'application/json');
            Response::setBody(json_encode(array('success' => !is_null($tweetset), 'data' => !is_null($tweetset) ? $tweetset->toArray() : $tweetset, 'message' => $message, 'code' => is_null($tweetset) ? 404 : 200)));
        } 
        else {
        }
    }

    /**
     * display resource with specific id
     */
    public function showTweet($tweetset_id) {
        $this->data['title'] = TweetSet::getOneTweetSet($tweetset_id)->name."'s Tweets";
        $this->data['tweets'] = Tweet::getAllTweets($tweetset_id)->toArray();
        $this->data['tweetsets'] = TweetSet::getAllTweetSets()->toArray();


        /*querying name of tweet*/
        foreach ($this->data['tweets'] as $i => $tweet) {
            try {
                $tweet = TweetSet::getOneTweetSet($tweet['tweetset_id']);
                $this->data['tweets'][$i]['tweetset_name'] = $tweet->name;
            }
            catch (Exception $ex) {
                $this->data['tweets'][$i]['tweetset_name'] = "-N/A-";
            }
        }

        /** load the tweet.js app */
        $this->loadJs('app/tweet.js');
        
        /** publish necessary js  variable */
        $this->publish('baseUrl', $this->data['baseUrl']);
        $this->publish('tweetset_id', $tweetset_id);
        
        /** render the template */
        View::display('@tweet/tweet/index.twig', $this->data);
    }
    
    /**
     * show edit from resource with specific id
     */
    public function edit($id) {
        try {
            $tweetset = TweetSet::getOneTweetSet($id);
            
            /** display edit form in non-ajax request */
            $this->data['title'] = 'Edit Tweetset';
            $this->data['tweetsets'] = $tweetset->toArray();
            
            View::display('@tweetset/tweetset/edit.twig', $this->data);
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
        $tweetset = null;
        $code = 0;
        
        try {
            $input = $this->sanitize(Input::put());

            /** in case request come from post http form */
            $input = is_null($input) ? $this->sanitize(Input::post()) : $input;
            
           
            /* update tweetset */
            $tweetset = TweetSet::updateTweetSet($id,$input);
            $success = $tweetset->save();

            $code = 200;
            $message = 'Tweetset updated sucessully';
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
            Response::setBody(json_encode(array('success' => $success, 'data' => ($tweetset) ? $tweetset->toArray() : $tweetset, 'message' => $message, 'code' => $code)));
        } 
        else {
            Response::redirect($this->siteUrl('admin/tweetset/' . $id . '/edit'));
        }
    }
    
    /**
     * create new resource
     */
    public function store() {
        
        $tweetset = null;
        $message = '';
        $success = false;
        
        try {
            $input = Input::post();
            
            /** sanitize input */
            foreach ($input as $i => $value) {
                $input[$i] = htmlspecialchars($value);
            }

            /* create new tweetset */
            $tweetset = TweetSet::createTweetSet($input);
            $success = $tweetset->save();

            
            $message = 'Tweetset created successfully';
        }
        catch(Exception $e) {
            $message = $e->getMessage();
        }
        
        if (Request::isAjax()) {
            Response::headers()->set('Content-Type', 'application/json');
            Response::setBody(json_encode(array('success' => $success, 'data' => ($tweetset) ? $tweetset->toArray() : $tweetset, 'message' => $message, 'code' => $success ? 200 : 500)));
        } 
        else {
            Response::redirect($this->siteUrl('admin/tweetset'));
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
            $tweetset = TweetSet::getOneTweetSet($id);
            $deleted = $tweetset->delete();
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
            Response::redirect($this->siteUrl('admin/tweetset'));
        }
    }
}
