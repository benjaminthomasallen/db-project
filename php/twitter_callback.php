<?php
require_once 'header.php';
require_once 'twitteroauth/autoload.php';
use Abraham\TwitterOAuth\TwitterOAuth;

$config = require_once 'twitter_config.php';
$oauth_verifier = filter_input(INPUT_GET, 'oauth_verifier');

if (empty($oauth_verifier) ||
    empty($_SESSION['oauth_token']) ||
    empty($_SESSION['oauth_token_secret'])
) {
    // something's missing, go and login again
    header('Location: ' . $config['url_login']);
}

// connect with application token
$twitter_connection = new TwitterOAuth(
    $config['consumer_key'],
    $config['consumer_secret'],
    $_SESSION['oauth_token'],
    $_SESSION['oauth_token_secret']
);

// request user token
$token = $twitter_connection->oauth(
    'oauth/access_token', [
        'oauth_verifier' => $oauth_verifier
    ]
);

$_SESSION['twitter_login'] = $token;

echo "Connected to twitter account, please return to event page";

?>
