<div id="signup-login-wrapper">

<form id="loginForm" onsubmit="validate(); login(); return false">
<div class="form-group" >
    <input type="text" id="userEmailOrProfileNameOrPhone" name="userEmailOrProfileNameOrPhone" class="form-control" data-type="string" data-min="5" data-max="20">
    <label for="userEmailOrProfileNameOrPhone" class="form-label">Email, Phone, Profile name</label>
 </div>

 <div class="form-group" >
     <input type="password" id="userPassword" name="userPassword" class="form-control" data-type="string" data-min="6" data-max="255" >
     <label for="userPassword" class="form-label">Password</label>
    <a href="/forgotPassword">Forgot password?</a>
</div>

 <button>Log in</button>

</form>
</div>