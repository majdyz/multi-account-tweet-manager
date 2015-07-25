<?php

use \Response;
use \TwitterAccount;
use Abraham\TwitterOAuth\TwitterOAuth;

class ConnectController extends BaseController
{

    public function index()
    {
        $this->data['title'] = 'Login with Twitter';
        App::render('/connect/index.twig', $this->data);
    }

    public function connect()
    {
        $connection     = new TwitterOAuth(TwitterAccount::getCredentialsTwitter()['consumer_key'], TwitterAccount::getCredentialsTwitter()['consumer_secret']);
        $request_token  = $connection->oauth("oauth/request_token", array("oauth_callback" => $this->siteUrl('connect/finish')));
        $oauth_token    = $request_token['oauth_token'];
        $token_secret   = $request_token['oauth_token_secret'];
        $url            = $connection->url("oauth/authorize", ['oauth_token' => $oauth_token]);
        setcookie("token_secret", " ", time()-3600);
        setcookie("token_secret", $token_secret, time()+60*10);
        setcookie("oauth_token", " ", time()-3600);
        setcookie("oauth_token", $oauth_token, time()+60*10);
        Response::redirect($url);
    }

    public function finish()
    {
        $connection = new TwitterOAuth(TwitterAccount::getCredentialsTwitter()['consumer_key'], TwitterAccount::getCredentialsTwitter()['consumer_secret'], $_COOKIE['oauth_token'], $_COOKIE['token_secret']);
        $access_token = $connection->oauth("oauth/access_token", ["oauth_verifier" => $_GET['oauth_verifier']]);
        if (TwitterAccount::where('username', $access_token['screen_name'])->first() == null ) {
            $account = new TwitterAccount;
            $account->username = $access_token['screen_name'];
            $account->oauth_token = $access_token['oauth_token'];
            $account->oauth_token_secret = $access_token['oauth_token_secret'];
            $account->joined_at = time();
            $account->save();
        }
        Response::redirect($this->siteUrl('connect/success/' . $access_token['screen_name']));
    }

    public function success($username)
    {
        $this->data['title'] = 'Successfully';
        $this->data['account'] = TwitterAccount::where('username', $username)->first();
        if ($this->data['account'] == null) {
            App::notFound();
        }
        App::render('/connect/success.twig', $this->data);
    }
}