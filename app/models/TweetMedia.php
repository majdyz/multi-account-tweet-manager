<?php
namespace app\models;

use Illuminate\Database\Eloquent\Model;
use Abraham\TwitterOAuth\TwitterOAuth;

/**
 * integer $tweet_id
 * integer $media_id
 */
class TweetMedia extends Model
{
	public function tweet() {
        return $this->belongsTo('Tweet');
    }

    public function media() {
        return $this->belongsTo('Media');
    }
}
