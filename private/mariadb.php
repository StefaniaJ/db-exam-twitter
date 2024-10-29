<?php
//this is not an API, but because it doesn't have HTML we will test it the POSTMAN

try{
  $dbUserName = 'root';
  $dbPassword = ''; //in windows is empty, in mac: root | admin
  $dbConnection = 'mysql:host=localhost; dbname=twitter_exam; charset=utf8mb4';
  // utf8 every character in the world
  // utf8mb4 every character and also emojies
  $options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // try-catch
    // PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    // PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_NUM  //arrays of arrays
  ];
  $db = new PDO(  $dbConnection,
                  $dbUserName,
                  $dbPassword ,
                  $options );

}catch(PDOException $ex){
    http_response_code(500);
    header('Content-Type: application/json');
//   echo $ex;
echo '{"message": "System error: '.__LINE__.'"}';
  exit();
}
