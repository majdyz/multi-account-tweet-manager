<?php
namespace app\models;

use Illuminate\Database\Eloquent\Model;
use Abraham\TwitterOAuth\TwitterOAuth;

/**
 * integer $id
 * string $name
 * integer $id
 */
class TweetSet extends Model
{ 
    public function tweets() {
        return $this->hasMany('Tweet')
    }
}
