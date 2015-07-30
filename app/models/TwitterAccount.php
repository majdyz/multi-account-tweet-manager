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
    protected $table = 'twitteraccounts';
    public $timestamps = false;

    public static function getCredentialsTwitter()
    {
        global $config;
        return [
            'consumer_key' => $config['twitter']['consumer_key'],
            'consumer_secret' => $config['twitter']['consumer_secret'],
            'oauth_token' => $config['twitter_seeds']['oauth_token'],
            'oauth_token_secret' => $config['twitter_seeds']['oauth_token_secret']
        ];  
    }

    public function users() {
        return $this->belongsToMany('User', 'twitteraccount_user', 'twitter_id', 'user_id');
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

    public function getStatusConstAttribute()
    {
        return [
            0 => 'Deleted',
            1 => 'Inactive',
            2 => 'Active',
            3 => 'Pending',
        ];
    }

    public function getStatusPrettyAttribute()
    {
        if ($this->status != null) {
            return $this->getStatusConstAttribute()[$this->status];
        }
    }

    public function toArray()
    {
        $array = parent::toArray();
        $array['joinedAtPretty'] = $this->joinedAtPretty;
        return $array;
    }
}