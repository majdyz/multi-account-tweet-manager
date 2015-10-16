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

    /* 
     * get tweet owner
    */
	public function TweetSet() {
        return $this->belongsTo('TweetSet');
    }

    /**
    *   get all medias
    */
    public function medias() {
        return $this->belongsToMany('Media', 'tweet_media', 'tweet_id', 'media_id');
    }

    /**
    *   get all array of media_id
    */
    public function getMediaUrl() {
        $medias = $this->medias;
        $ret = [];
        foreach($medias as $media) {
            $ret[] = $media->url;
        }
        return $ret;
    }

    /**
    *   get all media list
    */
    public function getMediaList() {
        $first = true;
        $medias = $this->medias;
        $ret = "";
        foreach($medias as $media) {
            if (!$first) {
                $ret = $ret . "," . $media->name;
            }
            else {
                $ret = $media->name ;
                $first = false;
            }
        }
        return $ret;
    }

    

    /**
    *  get all user's tweets
    */
    public static function getAllTweets($tweetset_id) {
        if (TweetSet::getOneTweetSet($tweetset_id)) {
            return Tweet::where('tweetset_id', $tweetset_id)->get();
        }
        else {
            throw new \Illuminate\Database\Eloquent\ModelNotFoundException;
        }
    }

    /**
    *  get one user's tweet
    */
    public static function getOneTweet($tweetset_id,$tweet_id) {
        if (TweetSet::getOneTweetSet($tweetset_id)) {
            return Tweet::where('tweetset_id', $tweetset_id)->findOrFail($tweet_id);
        }
        else {
            throw new \Illuminate\Database\Eloquent\ModelNotFoundException;
        }
    }


    /**
    *  update tweet
    */
    public static function updateTweet($tweetset_id,$id,$input) {
        if (TweetSet::getOneTweetSet($tweetset_id)) {
    	    $tweet = Tweet::getOneTweet($tweetset_id,$id);
    	    $tweet->name = $input['name'];
            $tweet->tweetset_id = $input['tweetset_id'];
            $tweet->text = $input['text'];
    	    return $tweet;
        }
        else {
            throw new \Illuminate\Database\Eloquent\ModelNotFoundException;
        }
    }

    /**
    * create tweet
    */
    public static function createTweet($tweetset_id,$input) {
        if (TweetSet::getOneTweetSet($tweetset_id)) {
        	$tweet = new Tweet();
            $tweet->name = $input['name'];
            $tweet->tweetset_id = $input['tweetset_id'];
            $tweet->text = $input['text'];
    	    return $tweet;
        }
        else {
            throw new \Illuminate\Database\Eloquent\ModelNotFoundException;
        }
    }
}
