<?php
namespace app\models;

use Illuminate\Database\Eloquent\Model;
use Abraham\TwitterOAuth\TwitterOAuth;

/**
 * integer $id
 * string $name
 * integer $size
 */
class Media extends Model
{
	public function tweets() {
        return $this->belongsToMany('Tweet', 'TweetMedia', 'media_id', 'tweet_id');
    }
}
