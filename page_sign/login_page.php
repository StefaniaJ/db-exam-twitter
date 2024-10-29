<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Twitter Page : : Clone</title>
    <link rel="stylesheet" href="app.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;700;900&display=swap" rel="stylesheet" />
</head>
<body>

<div id="loginPage">
<svg viewBox="0 0 24 24" aria-label="Twitter"><path d="M23.643 4.937c-.835.37-1.732.62-2.675.733.962-.576 1.7-1.49 2.048-2.578-.9.534-1.897.922-2.958 1.13-.85-.904-2.06-1.47-3.4-1.47-2.572 0-4.658 2.086-4.658 4.66 0 .364.042.718.12 1.06-3.873-.195-7.304-2.05-9.602-4.868-.4.69-.63 1.49-.63 2.342 0 1.616.823 3.043 2.072 3.878-.764-.025-1.482-.234-2.11-.583v.06c0 2.257 1.605 4.14 3.737 4.568-.392.106-.803.162-1.227.162-.3 0-.593-.028-.877-.082.593 1.85 2.313 3.198 4.352 3.234-1.595 1.25-3.604 1.995-5.786 1.995-.376 0-.747-.022-1.112-.065 2.062 1.323 4.51 2.093 7.14 2.093 8.57 0 13.255-7.098 13.255-13.254 0-.2-.005-.402-.014-.602.91-.658 1.7-1.477 2.323-2.41z"></path></svg>
<h2>Log in to Twitter</h2>

 <!-- Log in - Form -->
<form onsubmit= "validate(); login(); return false;">

<div class="form-group" >
    <!-- <input type="email" id="userEmail" name="userEmail" class="form-control" data-type="email" > -->
    <input type="text" id="userEmailOrProfileNameOrPhone" name="userEmailOrProfileNameOrPhone" class="form-control" data-type="string" data-min="5" data-max="20">
    <label for="userEmailOrProfileNameOrPhone" class="form-label">Email, Phone, Profile name</label>
 </div>

 <div class="form-group" >
     <input type="password" id="userPassword" name="userPassword" class="form-control" data-type="string" data-min="6" data-max="255" >
     <label for="userPassword" class="form-label">Password</label>
 </div>

    <button>Login</button>
</form>

<a href="/forgotPassword">Forgot password?</a>
<a href="signup.php">Sign up for Twitter</a>

</div>

<script src="app.js"></script>
</body>
</html>