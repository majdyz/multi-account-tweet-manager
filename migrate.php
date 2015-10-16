<?php

$config = array();
require __DIR__.'/vendor/autoload.php';
require __DIR__.'/app/config/database.php';
require __DIR__.'/app/config/sentry.php';

use Illuminate\Database\Capsule\Manager as Capsule;
use Cartalyst\Sentry\Facades\Native\Sentry;

use \Cartalyst\Sentry\Hashing\BcryptHasher;
use \Cartalyst\Sentry\Hashing\NativeHasher;
use \Cartalyst\Sentry\Hashing\Sha256Hasher;
use \Cartalyst\Sentry\Hashing\WhirlpoolHasher;
use \Cartalyst\Sentry\Users\Eloquent\Provider as UserProvider;

class Migrator{

    protected $config;
    protected $sentry_config;

    public function __construct($config, $sentry_config){
        $this->config = $config;
        $this->sentry_config = $sentry_config;
        $this->makeConnection($config);
    }

    /**
     * create connection to the database based on given configuration
     */
    private function makeConnection($config){
        try{
            $capsule = new Capsule;

            $capsule->addConnection($config);
            $capsule->setAsGlobal();
            $capsule->bootEloquent();

            Sentry::createSentry(
                $this->userProviderFactory(
                    $this->hasherProviderFactory($this->sentry_config), 
                    $this->sentry_config
                )
            );
            Sentry::setupDatabaseResolver($capsule->connection()->getPdo());

        }catch(Exception $e){
            throw $e;
        }
    }

    /** Sentry specific factory, adopted from SentryServiceProvider */
    protected function hasherProviderFactory($config){
        $hasher  = $config['hasher'];
        switch ($hasher)
        {
            case 'native':
                return new NativeHasher;
                break;

            case 'bcrypt':
                return new BcryptHasher;
                break;

            case 'sha256':
                return new Sha256Hasher;
                break;

            case 'whirlpool':
                return new WhirlpoolHasher;
                break;
        }

        throw new \InvalidArgumentException("Invalid hasher [$hasher] chosen for Sentry.");
    }

    protected function userProviderFactory($hasher, $config){
            $model = $config['users']['model'];

            if (method_exists($model, 'setLoginAttributeName'))
            {
                $loginAttribute = $config['users']['login_attribute'];

                forward_static_call_array(
                    array($model, 'setLoginAttributeName'),
                    array($loginAttribute)
                );
            }

            // Define the Group model to use for relationships.
            if (method_exists($model, 'setGroupModel'))
            {
                $groupModel = $config['groups']['model'];

                forward_static_call_array(
                    array($model, 'setGroupModel'),
                    array($groupModel)
                );
            }

            // Define the user group pivot table name to use for relationships.
            if (method_exists($model, 'setUserGroupsPivot'))
            {
                $pivotTable = $config['user_groups_pivot_table'];

                forward_static_call_array(
                    array($model, 'setUserGroupsPivot'),
                    array($pivotTable)
                );
            }

            return new UserProvider($hasher, $model);
    }

    /**
     * migrate the database schema
     */
    public function migrate(){
        /**
         * create table for sentry user
         */
        if (!Capsule::schema()->hasTable('users')){
            Capsule::schema()->create('users', function($table)
            {
                $table->increments('id');
                $table->string('username');
                $table->string('password');
                $table->text('permissions')->nullable();
                $table->boolean('activated')->default(0);
                $table->string('activation_code')->nullable();
                $table->timestamp('activated_at')->nullable();
                $table->timestamp('last_login')->nullable();
                $table->string('persist_code')->nullable();
                $table->string('reset_password_code')->nullable();
                $table->string('first_name')->nullable();
                $table->string('last_name')->nullable();
                $table->timestamps();

                // We'll need to ensure that MySQL uses the InnoDB engine to
                // support the indexes, other engines aren't affected.
                $table->engine = 'InnoDB';
                $table->unique('username');
                $table->index('activation_code');
                $table->index('reset_password_code');
            });
        }

        /**
         * create table for sentry group
         */
        if (!Capsule::schema()->hasTable('groups')){
            Capsule::schema()->create('groups', function($table)
            {
                $table->increments('id');
                $table->string('name');
                $table->text('permissions')->nullable();
                $table->timestamps();

                // We'll need to ensure that MySQL uses the InnoDB engine to
                // support the indexes, other engines aren't affected.
                $table->engine = 'InnoDB';
                $table->unique('name');
            });
        }

        /**
         * create user-group relation
         */
        if (!Capsule::schema()->hasTable('users_groups')){
            Capsule::schema()->create('users_groups', function($table)
            {
                $table->integer('user_id')->unsigned();
                $table->integer('group_id')->unsigned();

                // We'll need to ensure that MySQL uses the InnoDB engine to
                // support the indexes, other engines aren't affected.
                $table->engine = 'InnoDB';
                $table->primary(array('user_id', 'group_id'));
            });
        }

        /**
         * create throttle table
         */
        if (!Capsule::schema()->hasTable('throttle')){
            Capsule::schema()->create('throttle', function($table)
            {
                $table->increments('id');
                $table->integer('user_id')->unsigned();
                $table->string('ip_address')->nullable();
                $table->integer('attempts')->default(0);
                $table->boolean('suspended')->default(0);
                $table->boolean('banned')->default(0);
                $table->timestamp('last_attempt_at')->nullable();
                $table->timestamp('suspended_at')->nullable();
                $table->timestamp('banned_at')->nullable();

                // We'll need to ensure that MySQL uses the InnoDB engine to
                // support the indexes, other engines aren't affected.
                $table->engine = 'InnoDB';
                $table->index('user_id');
            });
        }

        /**
         * create twitter_account table
         */
        if (!Capsule::schema()->hasTable('twitteraccounts')){
            Capsule::schema()->create('twitteraccounts', function($table)
            {
                $table->increments('id');
                $table->string('uuid');
                $table->string('username');
                $table->string('oauth_token');
                $table->string('oauth_token_secret');
                $table->integer('joined_at');
                $table->integer('status');

                // We'll need to ensure that MySQL uses the InnoDB engine to
                // support the indexes, other engines aren't affected.
                $table->engine = 'InnoDB';
                $table->index('uuid');
            });
        }

        /**
         * create tweetset table
         */
        if (!Capsule::schema()->hasTable('tweetsets')){
            Capsule::schema()->create('tweetsets', function($table)
            {
                $table->increments('id');
                $table->string('name');
                $table->integer('user_involved');
                $table->timestamp('updated_at')->nullable();
                $table->timestamp('created_at')->nullable();
                $table->unsignedInteger('user_id')->nullable();;
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');

                // We'll need to ensure that MySQL uses the InnoDB engine to
                // support the indexes, other engines aren't affected.
                $table->engine = 'InnoDB';
                $table->index(array('name'));
            });
        }

        /**
         * create tweet table
         */
        if (!Capsule::schema()->hasTable('tweets')){
            Capsule::schema()->create('tweets', function($table)
            {
                $table->increments('id');
                $table->string('name');
                $table->unsignedInteger('tweetset_id')->nullable();;
                $table->foreign('tweetset_id')->references('id')->on('tweetsets')->onDelete('cascade')->onUpdate('cascade');
                $table->string('text');
                $table->timestamp('updated_at')->nullable();
                $table->timestamp('created_at')->nullable();
                
                // We'll need to ensure that MySQL uses the InnoDB engine to
                // support the indexes, other engines aren't affected.
                $table->engine = 'InnoDB';
            });
        }

         /**
         * create media table
         */
        if (!Capsule::schema()->hasTable('medias')){
            Capsule::schema()->create('medias', function($table)
            {
                $table->increments('id');
                $table->string('name');
                $table->string('url');
                $table->unsignedInteger('user_id')->nullable();
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
                $table->timestamp('updated_at')->nullable();
                $table->timestamp('created_at')->nullable();

                // We'll need to ensure that MySQL uses the InnoDB engine to
                // support the indexes, other engines aren't affected.
                $table->engine = 'InnoDB';
            });
        }
        
         /**
         * create tweetmedia table
         */
        if (!Capsule::schema()->hasTable('tweet_media')){
            Capsule::schema()->create('tweet_media', function($table)
            {

                $table->unsignedInteger('tweet_id')->nullable();
                $table->foreign('tweet_id')->references('id')->on('tweets')->onDelete('cascade')->onUpdate('cascade');
                
                $table->unsignedInteger('media_id')->nullable();
                $table->foreign('media_id')->references('id')->on('medias')->onDelete('cascade')->onUpdate('cascade');

                // We'll need to ensure that MySQL uses the InnoDB engine to
                // support the indexes, other engines aren't affected.
                $table->engine = 'InnoDB';
            });
        }

         /**
         * create user_twitter_account table
         */
        if (!Capsule::schema()->hasTable('twitteraccount_user')){
            Capsule::schema()->create('twitteraccount_user', function($table)
            {
                $table->unsignedInteger('user_id')->nullable();
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');

                $table->unsignedInteger('twitter_id')->nullable();
                $table->foreign('twitter_id')->references('id')->on('twitteraccounts')->onDelete('cascade')->onUpdate('cascade');

                // We'll need to ensure that MySQL uses the InnoDB engine to
                // support the indexes, other engines aren't affected.
                $table->engine = 'InnoDB';
                // $table->primary(array('user_id', 'twitter_id'));
            });
        }
    }

    /**
     * seed the database with initial value
     */
    public function seed(){
        try{
            Sentry::createUser(array(
                'username'       => 'admin',
                'password'    => 'password',
                'first_name'  => 'Website',
                'last_name'   => 'Administrator',
                'activated'   => 1,
                'permissions' => array(
                    'admin'     => 1
                )
            ));
        }catch(Exception $e){
            echo $e->getMessage()."\n";
        }
    }
}

$migrator = new Migrator($config['database']['connections'][$config['database']['default']], $config['sentry']);

$migrator->migrate();
$migrator->seed();
?>