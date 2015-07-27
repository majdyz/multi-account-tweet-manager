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

    public function __construct()
    {
        parent::__construct();
        Menu::get('admin_sidebar')->setActiveMenu('twitteraccount');
    }

    public function index()
    {
        $this->data['title'] = 'Twitter Account';
        $this->data['users'] = \User::find(Sentry::getUser()->id)->twitterAccounts()->where('status', '>', 0)->get();
        View::display('@twitteraccount/twitter-account/index.twig', $this->data);
    }

    public function show($id)
    {
        $this->data['title'] = TwitterAccount::find($id)->username;
        $this->data['user'] = TwitterAccount::find($id);
        View::display('@twitteraccount/twitter-account/view.twig', $this->data);
    }

    // hard delete
    public function destroy($id)
    {
        $this->findUser($id)->delete();
        Response::redirect($this->siteUrl('admin/twitter-account'));
    }

    public function disable($id)
    {
        $this->findUser($id)->disableAccount();
        Response::redirect($this->siteUrl('admin/twitter-account'));
    }

    public function enable($id)
    {
        $this->findUser($id)->enableAccount();
        Response::redirect($this->siteUrl('admin/twitter-account'));
    }

    // soft delete
    public function delete($id)
    {
        $this->findUser($id)->deleteAccount();
        Response::redirect($this->siteUrl('admin/twitter-account'));
    }

    public function add($id)
    {
        $this->data['title'] = 'Twitter Connect';
        $this->data['user'] = \User::find($id);
        View::display('@twitteraccount/twitter-account/insert.twig', $this->data);
    }

    public function connect($id)
    {
        $connection     = new TwitterOAuth(TwitterAccount::getCredentialsTwitter()['consumer_key'], TwitterAccount::getCredentialsTwitter()['consumer_secret']);
        $request_token  = $connection->oauth("oauth/request_token", array("oauth_callback" => $this->siteUrl('connect/success/' . $id)));
        $oauth_token    = $request_token['oauth_token'];
        $token_secret   = $request_token['oauth_token_secret'];
        $url            = $connection->url("oauth/authorize", ['oauth_token' => $oauth_token]);
        setcookie("token_secret", " ", time()-3600);
        setcookie("token_secret", $token_secret, time()+60*10);
        setcookie("oauth_token", " ", time()-3600);
        setcookie("oauth_token", $oauth_token, time()+60*10);
        Response::redirect($url);
    }

    // public function finish($id)
    // {
    //     $connection = new TwitterOAuth(TwitterAccount::getCredentialsTwitter()['consumer_key'], TwitterAccount::getCredentialsTwitter()['consumer_secret'], $_COOKIE['oauth_token'], $_COOKIE['token_secret']);
    //     $access_token = $connection->oauth("oauth/access_token", ["oauth_verifier" => $_GET['oauth_verifier']]);
    //     if (( $account = TwitterAccount::where('username', $access_token['screen_name'])->first()) == null ) {
    //         $account = new TwitterAccount;
    //         $account->username = $access_token['screen_name'];
    //         $account->oauth_token = $access_token['oauth_token'];
    //         $account->oauth_token_secret = $access_token['oauth_token_secret'];
    //         $account->joined_at = time();
    //         $account->status = 2;
    //         $account->save();
    //         $account->users()->save(\User::find(Sentry::getUser()->id));
    //     }
    //     Response::redirect($this->siteUrl('connect/success/' . $account->id));
    // }

    public function success($id)
    {
        var_dump($_COOKIE); var_dump($request_token); die();
        $connection = new TwitterOAuth(TwitterAccount::getCredentialsTwitter()['consumer_key'], TwitterAccount::getCredentialsTwitter()['consumer_secret'], $_COOKIE['oauth_token'], $_COOKIE['token_secret']);
        $access_token = $connection->oauth("oauth/access_token", ["oauth_verifier" => $_GET['oauth_verifier']]);
        if (TwitterAccount::where('username', $access_token['screen_name'])->first() == null ) {
            $account = new TwitterAccount;
            $account->username = $access_token['screen_name'];
            $account->oauth_token = $access_token['oauth_token'];
            $account->oauth_token_secret = $access_token['oauth_token_secret'];
            $account->joined_at = time();
            $account->status = 3;
            $account->save();
            $account->users()->save(\User::find($id));
        }

        $this->data['title'] = 'Successfully';
        $this->data['account'] = TwitterAccount::find($id);
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