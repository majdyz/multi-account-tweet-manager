<?php

define('APP_PATH'   , __DIR__.'/app/');

$config = array();
require __DIR__.'/vendor/autoload.php';
require __DIR__.'/app/config/database.php';

use Illuminate\Database\Capsule\Manager as Capsule;
use Cartalyst\Sentry\Facades\Native\Sentry;

class Migrator{

    protected $config;

    public function __construct($config){
        $this->config = $config;
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

            Sentry::setupDatabaseResolver($capsule->connection()->getPdo());

        }catch(Exception $e){
            throw $e;
        }
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
                $table->string('email');
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
                $table->unique('email');
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
            Capsule::schema()->create('twitter_account', function($table)
            {
                $table->increments('id');
                $table->string('username');
                $table->string('oauth_token');
                $table->string('oauth_token_secret');
                $table->integer('joined_at');
                $table->integer('status');

                // We'll need to ensure that MySQL uses the InnoDB engine to
                // support the indexes, other engines aren't affected.
                $table->engine = 'InnoDB';
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
                $table->string('mentions');
                $table->string('hashtags');
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
                $table->integer('size');
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
        if (!Capsule::schema()->hasTable('tweetmedias')){
            Capsule::schema()->create('tweetmedias', function($table)
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
            Capsule::schema()->create('user_twitter_account', function($table)
            {
                $table->unsignedInteger('user_id')->nullable();
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');

                $table->unsignedInteger('twitter_id')->nullable();
                $table->foreign('twitter_id')->references('id')->on('twitter_account')->onDelete('cascade')->onUpdate('cascade');

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
                'email'       => 'admin@admin.com',
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

$migrator = new Migrator($config['database']['connections'][$config['database']['default']]);

$migrator->migrate();
$migrator->seed();
?>