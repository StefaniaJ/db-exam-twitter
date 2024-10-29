<?php

//validation

//check if the user is logged
if(! isset($_POST['userId']) ){ sendError(400, 'user id is missing', __LINE__); }

//make sure the user passes a tweet id
if(!isset($_POST['tweetId'] )){ sendError(400, 'missing tweet id', __LINE__); }

//make sure the id has just numbers
if( ! ctype_digit($_POST['tweetId'])  ){ sendError(400, 'tweet id must be a digit', __LINE__); }


//connection to the db
require_once(__DIR__.'/../private/mariadb.php');


try {

//delete the relation from the tweets_likes and because I used a trigger, I don't need to update the tweets table
$q= $db->prepare('DELETE FROM tweets_likes WHERE likes_user_fk = :likes_user_fk AND likes_tweet_fk = :likes_tweet_fk');
$q->bindValue(':likes_user_fk', $_POST['userId']);
$q->bindValue(':likes_tweet_fk', $_POST['tweetId']);
$q->execute();

//if no row is affected, something was wrong: there is no match between userId and tweetId
if(! $q->rowCount() ){ sendError(400, 'like was not removed', __LINE__); }

header('Content-Type: application/json');
echo '{"message": "like removed", "tweetId": '.$_POST['tweetId'].'}';


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
