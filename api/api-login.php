<?php

//validation

//check if the email or phone or profile name is set
if(! isset($_POST['userEmailOrProfileNameOrPhone'] )){ sendError(400,'missing user email, phone number or profile name', __LINE__);}

// if( ! filter_var( $_POST['userEmail'], FILTER_VALIDATE_EMAIL ) ){ sendError(400, 'user email is not valid', __LINE__); }

// if( strlen($_POST['userPhone']) < 5 ){ sendError(400, 'user phone must be at least 5 characters', __LINE__); }
// if( strlen($_POST['userPhone']) > 15 ){ sendError(400, 'user phone cannot be longer than 15 characters', __LINE__); }
// if(! ctype_digit($_POST['userPhone'])){ sendError(400, 'user phone must be a digit', __LINE__); }

// if( strlen($_POST['userEmail']) < 2 ){ sendError(400, 'user profile name must be at least 2 characters', __LINE__); }
// if( strlen($_POST['userEmail']) > 100 ){  sendError(400, 'user profile name cannot be longer than 100 characters', __LINE__); }

if( strlen($_POST['userPassword']) < 6 ){ sendError(400, 'user password must be at least 6 characters', __LINE__); }
if( strlen($_POST['userPassword']) > 255 ){ sendError(400, 'user password cannot be longer than 255 characters', __LINE__); }


//connection to the db
require_once(__DIR__.'/../private/mariadb.php');


// $query = ('SELECT * FROM `users` WHERE ‘$name’ IN (username, email) AND `password` = ‘$pass'');

try {
$q = $db->prepare('SELECT * FROM users WHERE :user_email_or_profileName_or_phone IN (user_email, user_profile_name, user_phone) LIMIT 1');
$q->bindValue(':user_email_or_profileName_or_phone', $_POST['userEmailOrProfileNameOrPhone']);

$q->execute();

$user = $q->fetch();
// print_r($user);

//if the email or phone number or profile name doesn't exist
if(!$user){ sendError(400, 'wrong credentials', __LINE__);}

// if the email or phone number or profile name match, but the password is not correct; without this line and in this case, we will not see any message
// if($_POST['userEmail'] == $user[4] & ! password_verify($_POST['userPassword'], $user[5]) ?? $_POST['userEmail'] == $user[3] & ! password_verify($_POST['userPassword'], $user[5])  ){
//     sendError(400, 'wrong credentials', __LINE__);}

    if($_POST['userEmailOrProfileNameOrPhone'] == $user[4] & ! password_verify($_POST['userPassword'], $user[5]) ){
        sendError(400, 'wrong credentials', __LINE__);}

    if($_POST['userEmailOrProfileNameOrPhone'] == $user[3] & ! password_verify($_POST['userPassword'], $user[5])  ){
        sendError(400, 'wrong credentials', __LINE__);}

    if($_POST['userEmailOrProfileNameOrPhone'] == $user[7] & ! password_verify($_POST['userPassword'], $user[5])  ){
        sendError(400, 'wrong credentials', __LINE__);}



//if the active status is 0, the user is inactive. The user can't login if he is inactive
if($user[11] == 0){ sendError(400, 'user is not active', __LINE__);}

//email or phone number or profile name and password must match
if($_POST['userEmailOrProfileNameOrPhone'] == $user[4] & password_verify($_POST['userPassword'], $user[5])){
    session_start();
    $_SESSION['userId'] =  $user[0];
    $_SESSION['userName'] =  $user[1];
    $_SESSION['userProfileName'] =  $user[3];
    $_SESSION['userEmail'] =  $user[4];
    $_SESSION['userImagePath'] =  $user[8];
    $_SESSION['userTotalTweets'] =  $user[12];
    $_SESSION['userCreated'] =  $user[9];
    $_SESSION['userTotalFollowers'] =  $user[13];
    $_SESSION['userTotalFollowing'] =  $user[14];

    header('Content-Type: application/json');
     echo '{"message": "match"}';
 }

if($_POST['userEmailOrProfileNameOrPhone'] == $user[3] & password_verify($_POST['userPassword'], $user[5]) ){
   session_start();
   $_SESSION['userId'] =  $user[0];
   $_SESSION['userName'] =  $user[1];
   $_SESSION['userProfileName'] =  $user[3];
   $_SESSION['userEmail'] =  $user[4];
   $_SESSION['userImagePath'] =  $user[8];
   $_SESSION['userTotalTweets'] =  $user[12];
   $_SESSION['userCreated'] =  $user[9];
   $_SESSION['userTotalFollowers'] =  $user[13];
   $_SESSION['userTotalFollowing'] =  $user[14];

   header('Content-Type: application/json');
    echo '{"message": "match"}';
}
if($_POST['userEmailOrProfileNameOrPhone'] == $user[7] & password_verify($_POST['userPassword'], $user[5]) ){
   session_start();
   $_SESSION['userId'] =  $user[0];
   $_SESSION['userName'] =  $user[1];
   $_SESSION['userProfileName'] =  $user[3];
   $_SESSION['userEmail'] =  $user[4];
   $_SESSION['userImagePath'] =  $user[8];
   $_SESSION['userTotalTweets'] =  $user[12];
   $_SESSION['userCreated'] =  $user[9];
   $_SESSION['userTotalFollowers'] =  $user[13];
   $_SESSION['userTotalFollowing'] =  $user[14];

   header('Content-Type: application/json');
    echo '{"message": "match"}';
}


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
