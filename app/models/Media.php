<?php

use Illuminate\Database\Eloquent\Model;
use Abraham\TwitterOAuth\TwitterOAuth;

/**
 * integer $id
 * string $name
 * integer $size
 * timestamp updated_at
 * timestamp created_at
 */
class Media extends Model
{
	protected $table = 'medias';

	public function tweets() {
        return $this->belongsToMany('Tweet', 'TweetMedia', 'media_id', 'tweet_id');
    }
}
