<?php
session_start();

//validation
if(! isset($_POST['userId']) ) { sendError(400,'missing user id', __LINE__); } //change it with session
// if(! isset($_SESSION['userProfileName']) ) { sendError(400,'missing user profile name', __LINE__); } //change it with session  ??
// if(! isset($_SESSION['userImagePath']) ) { sendError(400,'missing user image', __LINE__); } //change it with session  ??
if(! isset($_POST['tweetMessage']) ) { sendError(400,'missing tweet message', __LINE__); }

if(! ctype_digit($_POST['userId']) ){ sendError(400, 'user id is incorrect', __LINE__); } //change it with session

if( strlen($_POST['tweetMessage']) < 1 ){ sendError(400, 'tweet message must be at least 1 characters', __LINE__); }
if( strlen($_POST['tweetMessage']) > 140 ){ sendError(400, 'tweet message cannot be longer than 140 characters', __LINE__); }

//get the image
//  $tweet_image_path = rand(0, 3) == 1 ? 'https://source.unsplash.com/random?sig='.'/600x250/' : '';

//  $image_tweet_id = uniqid(true);
//  $iWidth = 250 ;
//  $iHeight = 250 ;
//  file_put_contents(__DIR__.'/../imagesTweets/'.$image_tweet_id.'.png', file_get_contents('https://source.unsplash.com/random/'.$iWidth.'x'.$iHeight.'/'));
//  $tweet_image_path = $image_tweet_id.'.png';



//connection to the db
require_once(__DIR__.'/../private/mariadb.php');


try {
$q = $db->prepare('INSERT INTO tweets VALUES (:tweet_id, :tweet_user_fk, :tweet_message, current_timestamp(), :tweet_active, :tweet_total_likes, :tweet_total_comments, :tweet_image) ');
$q->bindValue(':tweet_id', NULL);
$q->bindValue(':tweet_message', $_POST['tweetMessage']);
// $q->bindValue(':tweet_image_path', '$tweet_image_path');
$q->bindValue(':tweet_image', '15fca109e398ad.png');
$q->bindValue(':tweet_total_likes', 0);
$q->bindValue(':tweet_total_comments', 0);
$q->bindValue(':tweet_active', 1);

// $q->bindValue(':tweet_user_fk', $_POST['userId']);  //change
// $q->bindValue(':tweet_user_profile_name', $_POST['userProfileName']);  //change
// $q->bindValue(':tweet_user_image_path', $_POST['userImagePath']);  //change

$q->bindValue(':tweet_user_fk', $_POST['userId']);

$q->execute();

$_SESSION['tweet_message']= $_POST['tweetMessage'];
$_SESSION['tweetTotalLikes']='0';
$_SESSION['tweetTotalComments']='0';

header('Content-Type: application/json');
echo '{"message": "tweet created", "tweetId": '.$db->lastInsertId().'}';

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
