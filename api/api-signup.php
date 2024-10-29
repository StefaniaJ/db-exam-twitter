<?php

//validation
if(! isset($_POST['userName'])){ sendError(400,'missing user name', __LINE__);}
if(! isset($_POST['userLastName'])){ sendError(400,'missing user last name', __LINE__);}
if(! isset($_POST['userProfileName'])){ sendError(400,'missing user profile name', __LINE__);}
if(! isset($_POST['userEmail'])){ sendError(400,'missing user email', __LINE__);}
if(! isset($_POST['userPassword'])){ sendError(400,'missing user password', __LINE__); }
if(! isset($_POST['userConfirmPassword']) ){ sendError(400, 'missing user confirmPassword', __LINE__);}
if(! isset($_POST['userPhone']) ){ sendError(400, 'missing user phone', __LINE__);}
// if( ! isset($_POST['userImagePath']) ){echo "no img";}

if( strlen($_POST['userName']) < 2 ){ sendError(400, 'user name must be at least 2 characters', __LINE__); }
if( strlen($_POST['userName']) > 20 ){ sendError(400, 'user name cannot be longer than 20 characters', __LINE__); }

if( strlen($_POST['userLastName']) < 2 ){ sendError(400, 'user last name must be at least 2 characters', __LINE__); }
 if( strlen($_POST['userLastName']) > 20 ){ sendError(400, 'user last name cannot be longer than 20 characters', __LINE__); }

if( strlen($_POST['userProfileName']) < 2 ){ sendError(400, 'user profile name must be at least 2 characters', __LINE__); }
if( strlen($_POST['userProfileName']) > 100 ){  sendError(400, 'user profile name cannot be longer than 100 characters', __LINE__); }

if( ! filter_var( $_POST['userEmail'], FILTER_VALIDATE_EMAIL ) ){ sendError(400, 'user email is not valid', __LINE__); }

if( strlen($_POST['userPassword']) < 6 ){ sendError(400, 'user password must be at least 6 characters', __LINE__); }
if( strlen($_POST['userPassword']) > 255 ){  sendError(400, 'user password cannot be longer than 255 characters', __LINE__); }
if( $_POST['userPassword'] !=  $_POST['userConfirmPassword'] ){ sendError(400, 'user passwords do not match', __LINE__); }

if( strlen($_POST['userPhone']) < 5 ){ sendError(400, 'user phone must be at least 5 characters', __LINE__); }
if( strlen($_POST['userPhone']) > 15 ){ sendError(400, 'user phone cannot be longer than 15 characters', __LINE__); }
if(! ctype_digit($_POST['userPhone'])){ sendError(400, 'user phone must be a digit', __LINE__); }


    //   Get the image
      $image_id = uniqid(true);
      $iWidth = 250 ;
      $iHeight = 250 ;
      file_put_contents(__DIR__.'/../images/'.$image_id.'.png', file_get_contents('https://source.unsplash.com/random/'.$iWidth.'x'.$iHeight.'/'));
      $user_image_path = $image_id.'.png';


//connection to the db
require_once(__DIR__.'/../private/mariadb.php');

try {

//the email and the phone number must be unique
// $q = $db->prepare('SELECT * FROM users WHERE user_email = :user_email LIMIT 1');
$q = $db->prepare('SELECT * FROM users WHERE user_email = :user_email OR user_phone = :user_phone OR user_profile_name = :user_profile_name LIMIT 1');
$q->bindValue(':user_email', $_POST['userEmail']);
$q->bindValue(':user_phone', $_POST['userPhone']);
$q->bindValue(':user_profile_name', $_POST['userProfileName']);
$q->execute();

$userRow = $q->fetch();
// header('Content-Type: application/json');
// echo json_encode( $rowUser);

// if($userRow){ sendError(400, 'email already exist', __LINE__); }
if($userRow){ sendError(400, 'email, phone number or profile name already exist', __LINE__); }

// exit();
$verificationCode = getUuid();

    $q = $db->prepare('INSERT INTO users VALUES (:user_id, :user_name, :user_last_name, :user_profile_name, :user_email, :user_password, :user_confirm_password, :user_phone, :user_image_path, current_timestamp(), :user_active, :user_verification_code, :user_total_tweets, :user_total_followers, :user_total_following)');
    $q->bindValue(':user_id', NULL);
    $q->bindValue(':user_name', $_POST['userName']);
    $q->bindValue(':user_last_name', $_POST['userLastName']);
    $q->bindValue(':user_profile_name', $_POST['userProfileName']);
    $q->bindValue(':user_email', $_POST['userEmail']);
    $q->bindValue(':user_password', password_hash( $_POST['userPassword'], PASSWORD_DEFAULT));
    $q->bindValue(':user_confirm_password',  password_hash( $_POST['userConfirmPassword'], PASSWORD_DEFAULT));
    $q->bindValue(':user_phone', $_POST['userPhone']);
    $q->bindValue(':user_image_path', $user_image_path );
    $q->bindValue(':user_verification_code', $verificationCode );
    $q->bindValue(':user_active', 0);
    $q->bindValue(':user_total_tweets', 0);
    $q->bindValue(':user_total_followers', 0);
    $q->bindValue(':user_total_following', 0);

    $q->execute();

$lastInsertedUserId = $db->lastinsertId();

// http_response_code(200);
header('Content-Type: application/json');
echo '{"message": "user created", "userId" : '.$lastInsertedUserId.'}';

//Send the email to the user to be verified
require_once('api-send-email.php');

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

// ################################################################
// ################################################################
// ################################################################

//function to generate uuid4
function getUuid() {
    return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            // 32 bits for "time_low"
            mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),

            // 16 bits for "time_mid"
            mt_rand( 0, 0xffff ),

            // 16 bits for "time_hi_and_version",
            // four most significant bits holds version number 4
            mt_rand( 0, 0x0fff ) | 0x4000,

            // 16 bits, 8 bits for "clk_seq_hi_res",
            // 8 bits for "clk_seq_low",
            // two most significant bits holds zero and one for variant DCE1.1
            mt_rand( 0, 0x3fff ) | 0x8000,

            // 48 bits for "node"
            mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
        );
    }
