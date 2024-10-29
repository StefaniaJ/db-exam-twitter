<?php

//validation
//GET, it will be catched, it will be fast next time

//check for GET the associative array with a variable called userProfileName
if(!isset($_GET['userProfileName']) ){ sendError(400, 'missing user profile name', __LINE__); }

//how many characters a string contains=strlen, not array= count/size of
if(strlen($_GET['userProfileName']) <1 ){ sendError(400, 'user profile name must be at least 1 character', __LINE__); }
if(strlen($_GET['userProfileName']) >100 ){ sendError(400, ' user profile name  must be max 100 characters', __LINE__); }


//connection to the db
require_once(__DIR__.'/../private/mariadb.php');

try {
    $q = $db->prepare('SELECT user_id, user_name, user_last_name, user_profile_name, user_image FROM users WHERE Match(user_profile_name) Against(:searchString IN BOOLEAN MODE) LIMIT 10');
    $q->bindValue(':searchString', '+'.$_GET['userProfileName']. '*');
    $q->execute();

    $aData = $q->fetchAll();
    header('Content-Type: application/json');
    echo json_encode($aData);

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