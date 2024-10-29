
async function signup() {
    // console.log(event.target) //the form is the targer, onsubmit is the event
    let form = event.target;

    //check if I have any error
    if (form.querySelector('.error')) {
        console.log('can not continue');
        return;
    }

    //connect to teh API if I don't have any error
    let connection = await fetch("../api/api-signup.php", { method: "POST", body: new FormData(form) });

    if (connection.status != 200) {
        console.log('contact system admin');
        return;
    }

    //when everithing is ok, go to the email and confirm the account
    alarm("Check your email and click on the link to validate the account"); //not working because I have a redirection, why?

}


async function login() {
    // console.log(event.target)
    let loginForm = event.target;

    //check if I have any error
    if (loginForm.querySelector(".error")) {
        console.log("can not continue")
        return
    }

    //If I don't have any error, connect to the API
    let connection = await fetch('../api/api-login.php', { method: "POST", body: new FormData(loginForm) });

    //If the connection is not ok/200, return
    if (!connection.ok) {
        console.log("contact system admin")
        return
    }
    //If everithing is ok, redirect
    location.href = "../page_index/index.php"


}