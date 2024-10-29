<?php

//validation
if(! isset($_POST['otherUserId']) ) { sendError(400,'missing user id', __LINE__); } //change it with session
if(! ctype_digit($_POST['otherUserId']) ){ sendError(400, 'user id is incorrect', __LINE__); } //change it with session


//connection to the db
require_once(__DIR__.'/../private/mariadb.php');


try {
    $query= $db->prepare('SELECT user_id ,user_name, user_total_tweets, user_image, user_profile_name, user_total_followers, user_total_following, user_date_created FROM users WHERE user_id= :user_id LIMIT 1');
    $query->bindValue('user_id', $_POST['otherUserId']);
    $query->execute();
    $user = $query->fetch();

    // make sure we have some data
    if( count($user) == 0 ){
        echo 'no user';
        exit();
    }

    header('Content-Type: application/json');
    // echo json_encode($user);
    $userjson = json_encode($user);

    } catch (Exception $ex) {
           echo $ex;
        sendError(500, 'system under maintenance', __LINE__);
    }



    try {
        // $query= $db->prepare('SELECT tweet_id, tweet_message, tweet_image, tweet_total_likes, tweet_user_profile_name, tweet_user_image_path, tweet_user_fk FROM tweets WHERE tweet_user_fk= :tweet_user_fk LIMIT 20');
        $query = $db->prepare('SELECT users.user_id, users.user_profile_name, users.user_image, tweets.tweet_id, tweets.tweet_user_fk, tweets.tweet_message, tweets.tweet_total_likes, tweets.tweet_total_comments, tweets.tweet_image FROM users JOIN tweets ON users.user_id = tweets.tweet_user_fk WHERE tweet_user_fk= :tweet_user_fk ORDER BY tweets.tweet_id DESC LIMIT 20');
        $query->bindValue('tweet_user_fk', $_POST['otherUserId']);
        $query->execute();
        $aRows = $query->fetchAll();

        header('Content-Type: application/json');
        // echo json_encode($aRows);
        $rowjson = json_encode($aRows);

        echo '{"tweets": '.$rowjson.', "user": '.$userjson.'}';


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
