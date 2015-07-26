<?php

use Illuminate\Database\Eloquent\Model;
use Abraham\TwitterOAuth\TwitterOAuth;

/**
 * integer $id
 * integer $tweetset_id
 * string $text
 * string $mentions
 * string $hashtags
 * timestamp updated_at
 * timestamp created_at
 */
class Tweet extends Model
{
	protected $table = 'tweets';

	public function TweetSet() {
        return $this->belongsTo('TweetSet');
    }

    public function medias() {
        return $this->belongsToMany('Media', 'TweetMedia', 'tweet_id', 'media_id');
    }

    /**
    *  get all user's tweets
    */
    public static function getAllTweets($tweetset_id) {
        return Tweet::where('tweetset_id', $tweetset_id)->get();
    }
    
    /**
    *  get one user's tweet
    */
    public static function getOneTweet($tweetset_id,$tweet_id) {
        return Tweet::where('tweetset_id', $tweetset_id)->findOrFail($tweet_id);
    }


    /**
    *  update tweet
    */
    public static function updateTweet($tweetset_id,$id,$input) {
    	$tweet = Tweet::getOneTweet($tweetset_id,$id);
    	$tweet->name = $input['name'];
        $tweet->tweetset_id = $input['tweetset_id'];
        $tweet->text = $input['text'];
        $tweet->mentions = $input['mentions'];
        $tweet->hashtags = $input['hashtags'];
    
    	return $tweet;
    }

    /**
    * create tweet
    */
    public static function createTweet($tweetset_id,$input) {
    	$tweet = new Tweet();
        $tweet->name = $input['name'];
        $tweet->tweetset_id = $input['tweetset_id'];
        $tweet->text = $input['text'];
        $tweet->mentions = $input['mentions'];
        $tweet->hashtags = $input['hashtags'];
    	
    	return $tweet;
    }
}
