<?php

//validation
if(! isset($_GET['userId']) ) { sendError(400,'missing user id', __LINE__); } //change it with session
if(! ctype_digit($_GET['userId']) ){ sendError(400, 'user id is incorrect', __LINE__); } //change it with session


//connection to the db
require_once(__DIR__.'/../private/mariadb.php');


try {
    $q = $db->prepare('SELECT user_id, user_name, user_last_name, user_profile_name, user_image FROM users ORDER BY RAND() LIMIT 3');
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
