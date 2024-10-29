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
    //check if the user already liked the tweet
$q= $db->prepare('SELECT * FROM tweets_likes WHERE like_user_fk = :like_user_fk AND like_tweet_fk = :like_tweet_fk LIMIT 1');
$q->bindValue(':like_user_fk', $_POST['userId']);
$q->bindValue(':like_tweet_fk', $_POST['tweetId']);
$q->execute();
$userRow = $q->fetch();

if($userRow){ sendError(400, 'user already liked the tweet', __LINE__); }


//if the user didn't like the tweet, I will add this relation inside the tweets_likes and because I used a trigger, I don't need to update the tweets table
$q= $db->prepare('INSERT INTO tweets_likes VALUES (:like_user_fk, :like_tweet_fk);');
$q->bindValue(':like_user_fk', $_POST['userId']);
$q->bindValue(':like_tweet_fk', $_POST['tweetId']);
$q->execute();


// when the use likes a tweet, update the total tweets
$q = $db->prepare('UPDATE tweets SET tweet_total_likes = tweet_total_likes + 1  WHERE tweet_id = :tweet_id');
$q->bindValue(':tweet_id', $_POST['tweetId']);
$q->execute();

//we don't have to replay with anything. That's it. If something goes wrong will be just because our DB goes down and if this is the case nobody cares about 1 like. We need to concentrate putting the server up again.



} catch (Exception $ex) {
       echo $ex;
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
