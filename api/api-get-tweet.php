<?php

//validation
if(! isset($_GET['userId']) ) { sendError(400,'missing user id', __LINE__); } //change it with session
if(! ctype_digit($_GET['userId']) ){ sendError(400, 'user id is incorrect', __LINE__); } //change it with session


//connection to the db
require_once(__DIR__.'/../private/mariadb.php');


try {
    $q = $db->prepare('SELECT users.user_id, users.user_profile_name, users.user_image, tweets.tweet_id, tweets.tweet_user_fk, tweets.tweet_message, tweets.tweet_total_likes, tweets.tweet_total_comments, tweets.tweet_image FROM users JOIN tweets ON users.user_id = tweets.tweet_user_fk ORDER BY tweets.tweet_id DESC LIMIT 1');
$q->execute();

$aTweets = $q->fetchAll();

//make sure we have some data
if( count($aTweets) == 0 ){
    echo 'no tweets';
    exit();
}


header('Content-Type: application/json');
echo json_encode($aTweets);



} catch (Exception $ex) {
    //    echo $ex;
    sendError(500, 'system under maintenance', __LINE__);
    }


    // ##############################
    // ##############################
    // ##############################

    function sendError($iErrorCode ,$sMessage, $iLine){
        http_response_code($iErrorCode);
        header('Content-Type: application/json');
        echo '{"message": "'.$sMessage.'", "error": "'.$iLine.'"}';
        exit();
    }
