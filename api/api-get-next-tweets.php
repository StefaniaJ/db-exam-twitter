<?php

//validation
$limit = (intval($_GET['limit']) != 0 ) ? $_GET['limit'] : 11;
$offset = (intval($_GET['offset']) != 0 ) ? $_GET['offset'] : 0;

if(!isset($_GET['iLatestTweetId'])){
    $_GET['iLatestTweetId'] = '1';
}

// if( ! ctype_digit($_GET['iLatestTweetId'])){ sendError(400,'page number not allowed', __LINE__); }


// if(! isset($_SESSION['userId'])){ sendError(400,'userId is missing', __LINE__);}
if(! isset($_GET['userId'])){ sendError(400,'user id is missing', __LINE__);}

// if(! ctype_digit($_SESSION['userId']) ){ sendError(400, 'userId is incorrect', __LINE__); }
if(! ctype_digit($_GET['userId']) ){ sendError(400, 'user id is incorrect', __LINE__); }


//connection to the db
require_once(__DIR__.'/../private/mariadb.php');

try {
    $q = $db->prepare('SELECT users.user_id, users.user_profile_name, users.user_image, tweets.tweet_id, tweets.tweet_user_fk, tweets.tweet_message, tweets.tweet_total_likes, tweets.tweet_total_comments, tweets.tweet_image FROM users JOIN tweets ON users.user_id = tweets.tweet_user_fk ORDER BY tweets.tweet_id DESC LIMIT '.$offset.', '.$limit.' ');
    // $q = $db->prepare('SELECT * FROM tweets ORDER BY tweets.tweet_id DESC LIMIT  '.$offset.', '.$limit.' ');
    // $q->bindValue(':offset', $offset);
    // $q->bindValue(':limit', $limit );
    $q->execute();

$ajTweets = $q->fetchAll();

//make sure we have some data
if( count($ajTweets) == 0 ){
    echo 'no tweets';
    exit();
}

echo json_encode($ajTweets);
header('Content-Type: application/json');


} catch (Exception $ex) {
    echo $ex;
    sendError(500, 'system under maintenance', __LINE__); }


// ################################################################
// ################################################################
// ################################################################

function sendError($iErrorCode ,$sMessage, $iLine){
    http_response_code($iErrorCode);
    header('Content-Type: application/json');
    echo '{"message": "'.$sMessage.'", "error": "'.$iLine.'"}';
    exit();
}
