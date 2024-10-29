<?php

//validation

//check if the user is logged
if(! isset($_POST['userId']) ){ sendError(400, 'user id is missing', __LINE__); }

//make sure the other userID is set
if(!isset($_POST['otherUserId'] )){ sendError(400, 'missing other user id', __LINE__); }


//connection to the db
require_once(__DIR__.'/../private/mariadb.php');


try {
    //check if the user already follow the other user
$q= $db->prepare('SELECT * FROM followers WHERE follower_user_fk = :follower_user_fk AND followee_user_fk = :followee_user_fk LIMIT 1');
$q->bindValue(':follower_user_fk', $_POST['otherUserId']);
$q->bindValue(':followee_user_fk', $_POST['userId']);
$q->execute();
$userRow = $q->fetch();

if($userRow){ sendError(400, 'you already follow the user', __LINE__); }


//if the user didn't follow the other user, I will add this relation inside the followers and because I used a trigger, I don't need to update the tweets table
$q= $db->prepare('INSERT INTO followers VALUES (:follower_user_fk, :followee_user_fk, current_timestamp())');
$q->bindValue(':follower_user_fk', $_POST['otherUserId']);
$q->bindValue(':followee_user_fk', $_POST['userId']);
$q->execute();


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
