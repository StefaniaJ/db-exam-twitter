
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

