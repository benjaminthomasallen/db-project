<?php
require_once 'header.php';
require_once 'twitteroauth/autoload.php';
use Abraham\TwitterOAuth\TwitterOAuth;

if(!isset($_SESSION['twitter_login'])){
    require_once 'twitter_login.php';
}

$config = require_once 'twitter_config.php';
$token = $_SESSION['twitter_login'];
$event_tweet = $_POST['event_tweet'];

$twitter = new TwitterOAuth(
    $config['consumer_key'],
    $config['consumer_secret'],
    $token['oauth_token'],
    $token['oauth_token_secret']
);

$status = $twitter->post(
    "statuses/update", [
        "status" => "$event_tweet"
    ]
);

echo 'Tweet posted!';

/*if (!defined('CONSUMER_KEY'))
{
    define('CONSUMER_KEY', 'p8OPltdh3WuYUjD7BEemyNAYd');
}

if (!defined('CONSUMER_SECRET'))
{
    define('CONSUMER_SECRET', 'bceKcrseHqv81i7rDQGLbNHIgHyyZIxMOheq6mCnKDoElF9DoX');
}

if (!defined('OAUTH_TOKEN'))
{
    define('OAUTH_TOKEN', '1854616549-l2Za0SRq5iLS30ZEIFQXK0WXJdhasXT8OtMkdXO');
}

if (!defined('OAUTH_SECRET'))
{
    define('OAUTH_SECRET', 'J9kZSWOS7MOt3SzPsrUKvt42lYdVR7qPCC1QyXPZCSkmy');
}

$twitter_connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, OAUTH_TOKEN, OAUTH_SECRET);
$content = $twitter_connection->get('account/verify_credentials');

$twitter_connection->post('statuses/update', array('status' => "My new status update! Im going to $event_tweet"));
*/



 ?>
