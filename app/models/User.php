<?php

use Illuminate\Database\Eloquent\Model;

class User extends Model {

    protected $table = 'users';
    public $timestamps = false;

    public function twitterAccounts() {
        return $this->belongsToMany('TwitterAccount', 'twitteraccount_user', 'user_id', 'twitter_id');
    }
}