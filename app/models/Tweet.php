<?php
namespace app\models;

use Illuminate\Database\Eloquent\Model;
use Abraham\TwitterOAuth\TwitterOAuth;

/**
 * integer $id
 * integer $tweetset_id
 * string $text
 * string $mentions
 * string $hashtags
 */
class Tweet extends Model
{
	public function TweetSet() {
        return $this->belongsTo('TweetSet');
    }

    public function medias() {
        return $this->belongsToMany('Media', 'TweetMedia', 'tweet_id', 'media_id');
    }
}
