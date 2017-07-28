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

die("<h4>Tweet posted</h4><a href='populate_events.php'>Return</a><br><br>");

 ?>
