Multi Account Tweet Manager
===========

Web application that can manage multiple Twitter accounts for tweeting.

Built upon SlimFramewok (https://github.com/slimphp/slim) using SlimStarter (https://github.com/xsanisty/SlimStarter) and 
Twitteroauth PHP Library (https://github.com/abraham/twitteroauth) for using Twitter's OAuth REST API.

![](https://cloud.githubusercontent.com/assets/11325911/10558218/71bf56fc-74f2-11e5-9eb8-edab9cb1b95c.PNG)


####Features
* Tweet manager, manage multiple accounts to tweet automatically.
* Tweetset, you can set multiple tweets so that each account can post different tweet randomly based on provided tweetset.
* Media upload, you can use images/videos for multiple tweets without re-upload for each tweet.
* Realtime tweeting progress report, you can partially retry the tweet process if there is an error on one tweet.

####Installation

#####1 Clone this Repository
You can install Multi Account Tweet Manager by cloning this repository and run ```composer install```.
```
$git clone https://github.com/zmajdy/multi-account-tweet-manager.git
$composer install
```

#####2 Configure and Setup Database
You can access the installer by accessing install.php in your browser
```
http://localhost/path/to/multi-account-tweet-manager/public/install.php
```

#####3 Setup Permission
After composer finished install the dependencies, you need to change file and folder permission.
```
chmod -R 777 app/storage/
chmod 666 app/config/database.php
```

#####4 Configuration
Configuration file located in ```app/config```, change the consumer key and access token on ```app/config/twitter.php```. 
You can get your own access token on https://apps.twitter.com/app/new. 
You can use the provided access token for testing, but that is not recommended for security reason.

#####5 Run the app
You can access the app from your browser
```
http://localhost/path/to/multi-account-tweet-manager/public
```

#### License

Multi Account Tweet Manager is licensed under [MIT License](https://github.com/zmajdy/multi-account-tweet-manager/blob/master/LICENSE).
