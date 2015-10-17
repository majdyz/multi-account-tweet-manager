<?php

namespace TwitterAccount\Controllers;

use \App;
use \View;
use \Menu;
use \Response;
use \Admin\BaseController;
use \Sentry;
use Abraham\TwitterOAuth\TwitterOAuth;
use \TwitterAccount;
use \UserTwitterAccount;

class TwitterAccountController extends BaseController
{
    public function index()
    {
        $this->data['title'] = 'Twitter Account';
        $this->data['users'] = \User::find(Sentry::getUser()->id)->twitterAccounts()->where('status', '>', 0)->get();
        $this->data['owner'] = Sentry::getUser();
        View::display('@twitteraccount/twitter-account/index.twig', $this->data);
    }

    public function show($id)
    {
        $model = $this->findUser($id);
        if (is_null($model) || is_null($model->users()->where('id', \Sentry::getUser()->id)->first())) {
            \App::notFound();
        }

        $this->data['title'] = $model->username;
        $this->data['user'] = $model;
        View::display('@twitteraccount/twitter-account/view.twig', $this->data);
    }

    // hard delete
    public function destroy($id)
    {
        $model = $this->findUser($id);
        if (is_null($model) || is_null($model->users()->where('id', \Sentry::getUser()->id)->first())) {
            \App::notFound();
        }

        $model->deleteAccount();
        Response::redirect($this->siteUrl('admin/twitter-account'));
    }

    public function disable($id)
    {
        $model = $this->findUser($id);
        if (is_null($model) || is_null($model->users()->where('id', \Sentry::getUser()->id)->first())) {
            \App::notFound();
        }

        $model->disableAccount();
        Response::redirect($this->siteUrl('admin/twitter-account'));
    }

    public function enable($id)
    {
        $model = $this->findUser($id);
        if (is_null($model) || is_null($model->users()->where('id', \Sentry::getUser()->id)->first())) {
            \App::notFound();
        }

        $model->enableAccount();
        Response::redirect($this->siteUrl('admin/twitter-account'));
    }

    // soft delete
    public function delete($id)
    {
        $model = $this->findUser($id);
        if (is_null($model) || is_null($model->users()->where('id', \Sentry::getUser()->id)->first())) {
            \App::notFound();
        }
        
        $model->deleteAccount();
        Response::redirect($this->siteUrl('admin/twitter-account'));
    }

    public function add($id)
    {
        $this->data['title'] = 'Twitter Connect';
        $this->data['user'] = \User::find($id);
        $this->data['owner'] = Sentry::getUser();

        if(is_null($this->data['user'])){
            \App::notFound();
        }

        View::display('@twitteraccount/twitter-account/insert.twig', $this->data);
    }

    public function connect($id)
    {
        $connection         = new TwitterOAuth(TwitterAccount::getCredentialsTwitter()['consumer_key'], TwitterAccount::getCredentialsTwitter()['consumer_secret']);
        $request_token      = $connection->oauth("oauth/request_token", array("oauth_callback" => $this->siteUrl('connect/success/' . $id )));
        $oauth_token        = $request_token['oauth_token'];
        $oauth_token_secret = $request_token['oauth_token_secret'];
        $url                = $connection->url("oauth/authorize", ['oauth_token' => $oauth_token]);

        $_SESSION['twitter_connect'] = [
            'oauth_token' => $oauth_token,
            'oauth_token_secret' => $oauth_token_secret
        ];

        Response::redirect($url);
    }

    public function success($id)
    {
        $connection = new TwitterOAuth(TwitterAccount::getCredentialsTwitter()['consumer_key'], TwitterAccount::getCredentialsTwitter()['consumer_secret'], $_GET['oauth_token'], $_SESSION['twitter_connect']['oauth_token_secret']);
        $access_token = $connection->oauth("oauth/access_token", ["oauth_verifier" => $_GET['oauth_verifier']]);
        
        unset($_SESSION['twitter_connect']);

        if(TwitterAccount::where('uuid', '=', $access_token['user_id'])->get()->isEmpty()){
            $account                     = new TwitterAccount;
            $account->joined_at          = time();
            $account->uuid               = $access_token['user_id'];
            $account->username           = $access_token['screen_name'];
            $account->oauth_token        = $access_token['oauth_token'];
            $account->oauth_token_secret = $access_token['oauth_token_secret'];
            $account->status             = 2;
            $account->save();
            $account->users()->save(\User::find($id));
        }
        else {
            $account                     = TwitterAccount::where('uuid', '=', $access_token['user_id'])->first();
            $account->uuid               = $access_token['user_id'];
            $account->username           = $access_token['screen_name'];
            $account->oauth_token        = $access_token['oauth_token'];
            $account->oauth_token_secret = $access_token['oauth_token_secret'];
            $account->status             = 2;
            $account->save();
        }

        $this->data['title'] = 'Successfully';
        $this->data['account'] = TwitterAccount::where('uuid',$access_token['user_id'])->first();
        $this->data['owner'] = Sentry::getUser();
        if ($this->data['account'] == null) {
            App::notFound();
        }
        App::render('@twitteraccount/twitter-account/success.twig', $this->data);
    }

    protected function findUser($id)
    {
        if (($model = TwitterAccount::find($id)) != null) {
            return $model;
        }
        App::notFound();
    }
}