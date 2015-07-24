<?php

namespace app\models;

use Illuminate\Database\Eloquent\Model;
use Abraham\TwitterOAuth\TwitterOAuth;

/**
 * integer $id
 * string $username
 * string $name
 * string $oauth_token
 * string $oauth_token_secret
 * integer $created_at
 */

class TwitterAccount extends Model
{
    protected $consumer_key = 'T8LKmlFvoJNyQFfk3IBIoPDdE';
    protected $consumer_secret = 'Uwo3arcO5a4iRNj4mG15FVEIRZTa4XNOXhmsbFFmWCn8eEXnoW';
    protected $access_token = '87912819-Lc8Bhg0xq2yD0oB1cZrkdsAYduXtLQN0QrHzFEjtL';
    protected $access_token_secret = 'SbSqkV5OjoguU3WmnhLhzQfAEBHL7VPM4HtjyaREp9avH';
    protected $table = 'twitter_account';

    public static function connection()
    {
        return new TwitterOAuth($this->consumer_key, $this->consumer_secret, $this->access_token, $this->access_token_secret);
    }

    public static function getCredentials()
    {
        return $this->connection()->get("account/verify_credentials");
    }

    public static function getToken()
    {
        return $this->connection()->oauth("oauth/request_token");
    }

    public function setCreatedAt()
    {
        $this->created_at = time();
    }

    public function getCreatedAt()
    {
        if ($this->created_at != null) {
            return date('d M Y H:i', $this->created_at);
        }
    }
}