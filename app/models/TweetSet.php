<?php

use Illuminate\Database\Eloquent\Model;
use Abraham\TwitterOAuth\TwitterOAuth;
use \Sentry;

/**
 * integer $id
 * string $name
 * integer $user_id
 * integer user_involved
 * timestamp updated_at
 * timestamp created_at
 */
class TweetSet extends Model
{ 
	protected $table = 'tweetsets';

    /* relation */
    public function tweets() {
        return $this->hasMany('Tweet');
    }

    /**
    *  get all user's tweetsets
    */
    public static function getAllTweetSets() {
    	$user_id = Sentry::getUser()->id;
        return TweetSet::where('user_id',$user_id)->get();
    }
    
    /**
    *  get one user's tweetset
    */
    public static function getOneTweetSet($id) {
    	$user_id = Sentry::getUser()->id;
        return TweetSet::where('user_id',$user_id)->findOrFail($id);
    }


    /**
    *  update tweetset
    */
    public static function updateTweetSet($id,$input) {
    	$tweetset = TweetSet::getOneTweetSet($id);
    	$tweetset->name = $input['name'];
        $tweetset->user_involved = $input['user_involved'];
        return $tweetset;
    }

    /**
    * create tweetset
    */
    public static function createTweetSet($input) {
        $tweetset = new TweetSet();
        $tweetset->name = $input['name'];
        $tweetset->user_involved = $input['user_involved'];
    	$tweetset->user_id = Sentry::getUser()->id;
    	return $tweetset;
    }
}
