function validate() {
    var form = event.target
    var aElements = form.querySelectorAll("[data-type]")
    for (var i = 0; i < aElements.length; i++) {

        aElements[i].classList.remove("error")

        var sDataType = aElements[i].getAttribute("data-type")
        switch (sDataType) {
            case "string":
                isStringValid(aElements[i])
                break
            case "email":
                isEmailValid(aElements[i])
                break
        }
    }
    // Match elements like password and confirm password
    var aElements = form.querySelectorAll("[data-match='password']")
    if (aElements.length) {
        if (aElements[0].value != aElements[1].value) {
            aElements[0].classList.add("error")
            aElements[1].classList.add("error")
        }
    }
}

function isStringValid(oElement) {
    var iMin = oElement.getAttribute("data-min")
    var iMax = oElement.getAttribute("data-max")
    var sElementContent = ''
    if (oElement.nodeName == "DIV") {
        sElementContent = oElement.innerText
    } else {
        sElementContent = oElement.value
    }
    console.log('***', sElementContent.length)
    if (sElementContent.length < iMin) {
        oElement.classList.add("error")
    }
    if (sElementContent.length > iMax) {
        oElement.classList.add("error")
    }
}

function isEmailValid(oElement) {
    const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    if (!re.test(String(oElement.value).toLowerCase())) {
        oElement.classList.add("error")
    }
}
// The code for the SIgnup page for the modal is inside the modal.php in a script tag
// I placed it there because when I click on login btn, I will have an error
// This way I solved the problem
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
