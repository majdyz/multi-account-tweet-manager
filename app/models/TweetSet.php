<?php

use Illuminate\Database\Eloquent\Model;
use Abraham\TwitterOAuth\TwitterOAuth;

/**
 * integer $id
 * string $name
 * timestamp updated_at
 * timestamp created_at
 */
class TweetSet extends Model
{ 
	protected $table = 'tweetset';

    public function tweets() {
        return $this->hasMany('Tweet');
    }
}
