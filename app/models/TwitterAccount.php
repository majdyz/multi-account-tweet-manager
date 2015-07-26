<?php

use Illuminate\Database\Eloquent\Model;
use Abraham\TwitterOAuth\TwitterOAuth;

/**
 * integer $id
 * string $username
 * string $oauth_token
 * string $oauth_token_secret
 * integer $joined_at
 * integer $status
 */

class TwitterAccount extends Model
{
    protected $table = 'twitter_account';
    public $timestamps = false;

    public static function getCredentialsTwitter()
    {
        global $config;
        return [
            'consumer_key' => $config['twitter']['consumer_key'],
            'consumer_secret' => $config['twitter']['consumer_secret']
        ];  
    }

    public function disableAccount()
    {
        $this->status = 1;
        return $this->save();
    }

    public function enableAccount()
    {
        $this->status = 2;
        return $this->save();
    }

    public function deleteAccount()
    {
        $this->status = 0;
        return $this->save();
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