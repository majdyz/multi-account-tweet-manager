<?php

use Illuminate\Database\Eloquent\Model;

/**
 * integer $user_id
 * integer $twitter_id
 */

class UserTwitterAccount extends Model
{
    protected $table = 'user_twitter_account';
    public $timestamps = false;

    public function user() {
        return $this->belongsTo('User');
    }

    public function twitterAccount() {
        return $this->belongsTo('TwitterAccount');
    }
}