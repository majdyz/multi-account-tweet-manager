<?php

use Illuminate\Database\Eloquent\Model;
use Abraham\TwitterOAuth\TwitterOAuth;

/**
 * integer $tweet_id
 * integer $media_id
 */
class TweetMedia extends Model
{
	protected $table = 'tweetmedias';
  	public $timestamps = false;

	public function tweet() {
        return $this->belongsTo('Tweet');
    }

    public function media() {
        return $this->belongsTo('Media');
    }
}
