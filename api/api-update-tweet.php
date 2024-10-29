<?php
session_start();

//validation
if(! isset($_POST['userId']) ) { sendError(400,'missing user id', __LINE__); } //change it with session
if(! isset($_POST['tweetId']) ) { sendError(400,'missing tweet id', __LINE__); } //change it with session
if(! isset($_POST['tweetNewMessage']) ) { sendError(400,'missing tweet new message', __LINE__); } //change it with session

if(! ctype_digit($_POST['userId']) ){ sendError(400, 'user id is incorrect', __LINE__); } //change it with session
if(! ctype_digit($_POST['tweetId']) ){ sendError(400, 'tweet id is incorrect', __LINE__); } //change it with session

if( strlen($_POST['tweetNewMessage']) < 1 ){ sendError(400, 'tweet new message must be at least 1 characters', __LINE__); }
if( strlen($_POST['tweetNewMessage']) > 140 ){ sendError(400, 'tweet new message cannot be longer than 140 characters', __LINE__); }



 //connection to the db
require_once(__DIR__.'/../private/mariadb.php');


try {
    $q = $db->prepare('UPDATE tweets SET tweet_message = :tweet_new_message WHERE tweet_id = :tweet_id AND tweet_user_fk = :tweet_user_fk');
    $q->bindValue(':tweet_id', $_POST['tweetId']); //session here
    $q->bindValue(':tweet_user_fk', $_POST['userId']); //session here
    $q->bindValue(':tweet_new_message', $_POST['tweetNewMessage']); //session here

    $q->execute();

//if no row is affected, something was wrong: there is no match between userId and tweetId or the tweet/ user doesn't exist
if(! $q->rowCount() ){ sendError(400, 'tweet was not updated', __LINE__); }

header('Content-Type: application/json');
echo '{"message": "tweet updated", "tweetId": '.$_POST['tweetId'].'}';


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
