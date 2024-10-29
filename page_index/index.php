<?php
session_start();

//check if the user is not logged in
if(!isset($_SESSION['userId'])){
    header('Location: ../page_sign/signup.php');
  exit(); }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Twitter Page : : Clone</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css"
    integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <link rel="stylesheet" href="app.css">

</head>
<body>

    <!-- Connection to the DB -->
    <?php require_once(__DIR__.'/../private/mariadb.php')?>


     <!-- The left component -->
     <?php require_once(__DIR__.'/left.php') ?>

    <!-- The middle component -->
    <?php require_once(__DIR__.'/middle.php') ?>

   <!-- The right component -->
   <?php require_once(__DIR__.'/right.php') ?>

   <!-- Modal -->


   <script>
let original_middle_post = `<?= file_get_contents(__DIR__.'/middle-home-tweet.html') ?>`;
// console.log(original_middle_post);

</script>



   <script src="app.js"></script>

</body>
</html>