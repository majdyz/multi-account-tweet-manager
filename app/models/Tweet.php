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
	protected $table = 'tweet';

	public function TweetSet() {
        return $this->belongsTo('TweetSet');
    }

    public function medias() {
        return $this->belongsToMany('Media', 'TweetMedia', 'tweet_id', 'media_id');
    }
}
