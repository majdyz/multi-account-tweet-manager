<?php
namespace TweetSet\Controllers;

use \App;
use \View;
use \Menu;
use \Input;
use \TweetSet;
use \Request;
use \Response;
use \Exception;
use \Admin\BaseController;

class TweetSetController extends BaseController
{
    
    public function __construct() {
        parent::__construct();
        Menu::get('admin_sidebar')->setActiveMenu('tweetset');
    }
    
    /**
     * display list of resource
     */
    public function index($page = 1) {
        $this->data['title'] = 'Tweetset List';
        $this->data['tweetsets'] = TweetSet::all()->toArray();
        
        /** load the tweetset.js app */
        $this->loadJs('app/tweetset.js');
        
        /** publish necessary js  variable */
        $this->publish('baseUrl', $this->data['baseUrl']);
        
        /** render the template */
        View::display('@tweetset/tweetset/index.twig', $this->data);
    }
    
    /**
     * display resource with specific id
     */
    public function show($id) {
        if (Request::isAjax()) {
            $tweetset = null;
            $message = '';
            
            try {
                $tweetset = TweetSet::findOrFail($id);
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
     * show edit from resource with specific id
     */
    public function edit($id) {
        try {
            $tweetset = TweetSet::findOrFail($id);
            
            //display edit form in non-ajax request
            //
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
            $input = Input::put();
            
            /** in case request come from post http form */
            $input = is_null($input) ? Input::post() : $input;
            
            $tweetset = TweetSet::findOrFail($id);
            
            $tweetset->name = $input['name'];

            
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
            
            $tweetset = new TweetSet();
            $tweetset->name = $input['name'];

            
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
            $tweetset = TweetSet::findOrFail($id);
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
