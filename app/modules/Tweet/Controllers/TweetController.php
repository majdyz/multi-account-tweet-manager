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
    public function index($tweetset_id, $page = 1) {
        $this->data['title'] = TweetSet::getOneTweetSet($tweetset_id)->name."'s Tweets";
        $this->data['tweets'] = Tweet::getAllTweets($tweetset_id)->toArray();
        $this->data['tweetsets'] = TweetSet::getAllTweetSets()->toArray();
        $this->data['tweetset_id'] = $tweetset_id;

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
     * display resource with specific id
     */
    public function show($tweetset_id,$id) {
        if (Request::isAjax()) {
            $tweet = null;
            $message = '';
            
            try {
                $tweet = Tweet::getOneTweet($tweetset_id,$id);
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
    public function edit($tweetset_id,$id) {
        try {
            $tweet = Tweet::getOneTweet($tweetset_id,$id);
            
            /** display edit form in non-ajax request */
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
    public function update($tweetset_id,$id) {
        $success = false;
        $message = '';
        $tweet = null;
        $code = 0;
        
        try {
            $input = $this->sanitize(Input::put());
            
            /** in case request come from post http form */
            $input = is_null($input) ? Input::post() : $input;
            
            /** update tweet */
            $tweet = Tweet::updateTweet($tweetset_id,$id,$input);
            
            $success = $tweet->save();
            $code = 200;
            $message = 'Tweet updated sucessully';

            $data = $tweet->toArray();
            $data['tweetset_name'] = TweetSet::getOneTweetSet($tweet->tweetset_id)->name;
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
            Response::redirect($this->siteUrl('admin/tweet/' . $tweetset_id . '/' . $id . '/edit'));
        }
    }
    
    /**
     * create new resource
     */
    public function store($tweetset_id) {
        
        $tweet = null;
        $message = '';
        $success = false;
        
        try {
            $input = $this->sanitize(Input::post());
            $input['tweetset_id'] = $tweetset_id;
            
            /* create a tweet */
            $tweet = Tweet::createTweet($tweetset_id,$input);
            
            $success = $tweet->save();
            
            $message = 'Tweet created successfully';

            $data = $tweet->toArray();
            $data['tweetset_name'] = TweetSet::getOneTweetSet($tweet->tweetset_id)->name;
        }
        catch(Exception $e) {
            $message = $e->getMessage();
        }
        
        if (Request::isAjax()) {
            Response::headers()->set('Content-Type', 'application/json');
            Response::setBody(json_encode(array('success' => $success, 'data' => ($tweet) ? $data : $tweet, 'message' => $message, 'code' => $success ? 200 : 500)));
        } 
        else {
            Response::redirect($this->siteUrl('admin/tweet/'.$tweetset_id));
        }
    }
    
    /**
     * destroy resource with specific id
     */
    public function destroy($tweetset_id,$id) {
        $id = (int)$id;
        $deleted = false;
        $message = '';
        $code = 0;
        
        try {
            $tweet = Tweet::getOneTweet($tweetset_id,$id);
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
            Response::redirect($this->siteUrl('admin/tweet/'.$tweetset_id));
        }
    }
}
