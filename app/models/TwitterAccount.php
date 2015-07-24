<?php

use Illuminate\Database\Eloquent\Model;
use Abraham\TwitterOAuth\TwitterOAuth;

/**
 * integer $id
 * string $username
 * string $name
 * string $oauth_token
 * string $oauth_token_secret
 * integer $joined_at
 */

class TwitterAccount extends Model
{
    protected $table = 'twitter_account';
    public $timestamps = false;

    public static function getCredentials()
    {
        global $config;
        $oauth = new TwitterOAuth($config['twitter']['consumer_key'], $config['twitter']['consumer_secret'], $config['twitter']['access_token'], $config['twitter']['access_token_secret']);
        return $oauth->get("account/verify_credentials");
    }

    public static function getToken()
    {
        global $config;
        $oauth = new TwitterOAuth($config['twitter']['consumer_key'], $config['twitter']['consumer_secret'], $config['twitter']['access_token'], $config['twitter']['access_token_secret']);
        return $oauth->oauth("oauth/request_token");
    }

    public static function autoSave()
    {
        $account = new TwitterAccount();
        $account->username = TwitterAccount::getCredentials()->screen_name;
        $account->name = TwitterAccount::getCredentials()->name;
        $account->oauth_token = TwitterAccount::getToken()['oauth_token'];
        $account->oauth_token_secret = TwitterAccount::getToken()['oauth_token_secret'];
        $account->joined_at = time();
        $account->save();
        return $account;
    }

    public function getJoinedAtPrettyAttribute()
    {
        if ($this->joined_at != null) {
            return date('d M Y H:i', $this->joined_at);
        }
    }

    public function toArray()
    {
        $array = parent::toArray();
        $array['joinedAtPretty'] = $this->joinedAtPretty;
        return $array;
    }
}