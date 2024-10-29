<?php
//check if the user is not logged in
if(isset($_SESSION['userId'])){
    header('Location: ../page_index/index.php');
  exit(); }


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup Twitter Page : : Clone</title>
    <link rel="stylesheet" href="app.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;700;900&display=swap" rel="stylesheet" />
</head>
<body>

<div id="signupLayout">
<!-- Sign up Left Component -->
<?php require_once(__DIR__.'/signup_left.php');?>

<!-- Sign up Right Component -->
<?php require_once(__DIR__.'/signup_right.php');?>

<!-- The Modal for Sign up-->
<?php require_once(__DIR__.'/modal.php');?>

<!-- Sign up Bottom Component -->
<?php require_once(__DIR__.'/signup_bottom.php');?>
</div>


    <script src="app.js"></script>
</body>
</html>