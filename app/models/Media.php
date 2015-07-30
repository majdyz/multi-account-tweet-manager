<?php

use Illuminate\Database\Eloquent\Model;
use Abraham\TwitterOAuth\TwitterOAuth;
use \TwitterAccount;

/**
 * integer $id
 * string $name
 * string $url
 * integet $user_id
 * timestamp updated_at
 * timestamp created_at
 */
class Media extends Model
{
    protected $table = 'medias';

    public function tweets() {
        return $this->belongsToMany('Tweet', 'tweet_media', 'media_id', 'tweet_id');
    }

    public function isUserHas()
    {
        if ($this->user_id == \Sentry::getUser()->id) {
            return true;
        }
        \App::notFound();
    }
}
