<?php

use Illuminate\Database\Eloquent\Model;

class User extends Model {

    protected $table = 'users';
    public $timestamps = false;


    /* relations */
    public function twitterAccounts() {
        return $this->belongsToMany('TwitterAccount', 'twitteraccount_user', 'user_id', 'twitter_id');
    }

    public function medias()
    {
        return $this->hasMany('Media');
    }

    

    /* helpers */
    public static function getActiveAccounts() {
    	return User::find(Sentry::getUser()->id)->twitterAccounts()->where('status', '>', 1)->get();
    }

    public function hasThisAccount($id) {
    	if ($this->twitterAccounts()->where('id',$id)->count() > 0) {
    		return true;
    	}
    	else {
    		return false;
    	}
    }
}
