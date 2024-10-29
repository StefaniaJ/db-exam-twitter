<form id="signupForm" onsubmit="validate(); signup(); return false">

<div class="form-group" >
    <input type="text" id="userName" name="userName" class="form-control" data-type="string" data-min="2" data-max="20" value="aa" >
     <label for="userName" class="form-label">Name</label>
</div>

 <div class="form-group" >
     <input type="text" id="userLastName" name="userLastName" class="form-control" data-type="string" data-min="2" data-max="20" value="aa"  >
     <label for="userLastName" class="form-label">Last name</label>
 </div>

 <div class="form-group" >
     <input type="text" id="userProfileName" name="userProfileName" class="form-control" data-type="string" data-min="2" data-max="100"  value="aa" >
     <label for="userProfileName" class="form-label">Profile name</label>
 </div>

 <div class="form-group" >
     <input type="tel" id="userPhone" name="userPhone" class="form-control" data-type="string" data-min="5" data-max="15" value="12345" >
     <label for="userPhone" class="form-label">Phone</label>
 </div>

 <div class="form-group" >
     <input type="email" id="userEmailLogin" name="userEmail" class="form-control" data-type="email" value="a@a.com" >
     <label for="userEmailLogin" class="form-label">Email</label>
 </div>

 <div class="form-group" >
     <input type="password" id="userPasswordLogin" name="userPassword" class="form-control" data-type="string" data-min="6" data-max="255" data-match="password" value="123456" >
     <label for="userPasswordLogin" class="form-label">Password</label>
 </div>

 <div class="form-group" >
     <input type="password" id="userConfirmPassword" name="userConfirmPassword" class="form-control" data-type="string" data-min="6" data-max="255"  data-match="password" value="123456">
     <label for="userConfirmPassword" class="form-label">Confirm password</label>
 </div>

<button>Sign up</button>
</form>