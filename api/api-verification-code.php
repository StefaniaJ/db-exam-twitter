<?php
// echo "Hi user";

//validation
if(! isset($_GET['user_id'])){ sendError(400,'missing user id', __LINE__);}
if(! isset($_GET['verification_code'])){ sendError(400,'missing user verification code', __LINE__);}

if(! ctype_digit($_GET['user_id']) ){ sendError(400, 'user id is incorrect', __LINE__); }
// if(! ctype_digit($_GET['verification_code']) ){ sendError(400, 'user verification code is incorrect', __LINE__); }


//connection to the db
require_once(__DIR__.'/../private/mariadb.php');

try {
$q = $db->prepare('SELECT users.user_id, users.user_verification_code FROM users WHERE user_id = :user_id AND user_verification_code = :user_verification_code LIMIT 1');
$q->bindValue(':user_id', $_GET['user_id']);
$q->bindValue(':user_verification_code', $_GET['verification_code']);
$q->execute();

$rowUser = $q->fetch();

//if the user id and user verification code doesn't match/exist
if(!$rowUser){ sendError(400, 'wrong ids', __LINE__);}


//if the user id and user verification code match
header('Content-Type: application/json');
echo json_encode($rowUser);

$q = $db->prepare('UPDATE users SET user_active = :user_active WHERE user_id = :user_id LIMIT 1');
$q->bindValue(':user_id', $_GET['user_id']);
$q->bindValue(':user_active', 1);
$q->execute();

header('Location: /db-exam-twitter/page_index/index.php');

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
