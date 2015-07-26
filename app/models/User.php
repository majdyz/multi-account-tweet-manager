<?php

use Illuminate\Database\Eloquent\Model;

class User extends Model {

    protected $table = 'user';
    public $timestamps = false;

    public function twitterAccounts() {
        return $this->belongsToMany('TwitterAccount', 'UserTwitterAccount', 'user_id', 'twitter_id');
    }
}