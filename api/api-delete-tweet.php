<?php

session_start();

//validation
if(! isset($_POST['userId']) ) { sendError(400,'missing user id', __LINE__); } //change it with session
if(! isset($_POST['tweetId']) ) { sendError(400,'missing tweet id', __LINE__); } //change it with session

if(! ctype_digit($_POST['userId']) ){ sendError(400, 'user id is incorrect', __LINE__); } //change it with session
if(! ctype_digit($_POST['tweetId']) ){ sendError(400, 'tweet id is incorrect', __LINE__); } //change it with session


//connection to the db
require_once(__DIR__.'/../private/mariadb.php');


try {
// $q = $db->prepare('DELETE FROM tweets WHERE tweet_id = :tweet_id');
$q = $db->prepare('DELETE FROM tweets WHERE tweet_id = :tweet_id AND tweet_user_fk = :tweet_user_fk');

$q->bindValue(':tweet_id', $_POST['tweetId']); //session here
$q->bindValue(':tweet_user_fk', $_POST['userId']); //session here

$q->execute();

//if no row is affected, something was wrong: there is no match between userId and tweetId or the tweet/ user doesn't exist
if(! $q->rowCount() ){ sendError(400, 'tweet was not deleted', __LINE__); }

header('Content-Type: application/json');
echo '{"message": "tweet deleted", "tweetId": '.$_POST['tweetId'].'}';


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
