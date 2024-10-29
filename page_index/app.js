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
//Toggle on/off the drop up menu

function showUserOptions() {
    document.getElementById("myDropdown").classList.toggle("show")
}
// Show Page function

// let subPages = document.querySelectorAll(".subpage");
// let textarea = document.querySelector("#tweetMessage");

// textarea.addEventListener('click', () => {
//     subPages[0].style.display = "grid";
//     // console.log("it's working")
// })

let userId = document.querySelector("#formTweetHome").getAttribute("data-userId");
// console.log(userId)



function showPage(pageId) {
    console.log("page clicked:", pageId)
    document.querySelectorAll('.subpage').forEach(item => {
        item.style.display = "none"
    })
    document.getElementById(pageId).style.display = "grid"


    if (pageId == "homePage") {

        var limit = 11; //limit
        var offset = 0; //starting point

        // The Scroll Event
        window.addEventListener('scroll', () => {
            const { scrollHeight, scrollTop, clientHeight } = document.documentElement;

            if (scrollTop + clientHeight > scrollHeight - 100) {
                offset = limit + offset;
                getNextTweets(limit, offset);
            }
        });

        // document.querySelector("#middle #tweets").innerHTML = "";
        getTweets();
        console.log("home here")

    } else {
        console.log(pageId)
        document.querySelector("#middle #tweets").innerHTML = "";
        console.log(document.querySelector("#middle #tweets"))
        window.removeEventListener('scroll', () => {

            const { scrollHeight, scrollTop, clientHeight } = document.documentElement;

            if (scrollTop + clientHeight > scrollHeight - 100) {
                offset = limit + offset;
                getNextTweets(limit, offset);
            }

        })
    }
}


showPage("homePage");



function showprofileSubpages(subpageId) {
    console.log("page clicked:", subpageId)
    document.querySelectorAll('.profileSubpages').forEach(subpage => {
        subpage.style.display = "none"
    })
    document.getElementById(subpageId).style.display = "grid"

}
// let userId = document.querySelector("#formTweetHome").getAttribute("data-userId");
// // console.log(userId)


// var limit = 11; //limit
// var offset = 0; //starting point

// // The Scroll Event
// window.addEventListener('scroll', () => {
//     const { scrollHeight, scrollTop, clientHeight } = document.documentElement;

//     if (scrollTop + clientHeight > scrollHeight - 100) {
//         offset = limit + offset;
//         getNextTweets(limit, offset);
//     }
// });




async function getNextTweets(limit, offset) {
    // https://www.thesoftwareguy.in/ajax-scroll-pagination-php-mysql/

    let connection = await fetch(`../api/api-get-next-tweets.php?userId=${userId}&limit=` + limit + `&offset=` + offset, { headers: { 'Cache-Control': 'no-cache' } });

    if (!connection.ok) { console.log('error'); }

    let jResponse = await connection.json();
    // console.log(jResponse);

    jResponse.forEach(jTweet => {

        //create a copy of the original
        let sDivTweet = original_middle_post;

        let tweet_id = `${jTweet[3]}`; //tweet id
        let user_image = `${jTweet[2]}`; // user img
        let user_id = `${jTweet[0]}`;  //user id
        let user_name = `${jTweet[1]}`;  //user name
        let tweet_message = `${jTweet[5]}`;//tweet message
        let tweet_image = `${jTweet[8]}`; //tweet image
        let tweet_total_likes = `${jTweet[6]}`; //tweet total likes
        let tweet_total_comments = `${jTweet[7]}`; //tweet total likes

        sDivTweet = sDivTweet.replace('{{tweetId}}', tweet_id);
        sDivTweet = sDivTweet.replace('{{userId}}', user_id);
        sDivTweet = sDivTweet.replace('{{userimage}}', user_image);
        sDivTweet = sDivTweet.replace('{{username}}', user_name);
        sDivTweet = sDivTweet.replace('{{tweetmesage}}', tweet_message);
        sDivTweet = sDivTweet.replace('{{tweetimage}}', tweet_image);
        sDivTweet = sDivTweet.replace('{{tweettotallikes}}', tweet_total_likes);
        sDivTweet = sDivTweet.replace('{{tweettotalcomments}}', tweet_total_comments);

        document.querySelector('#middle').insertAdjacentHTML('beforeend', sDivTweet);
        iLatestTweetId = tweet_id
    });

}

async function getTweet() {

    let connection = await fetch(`../api/api-get-tweet.php?userId=${userId}`)
    // console.log(connection)

    //check the status of the connection
    if (connection.status != 200) {
        console.log('error')
    }

    let jResponse = await connection.json();  //getting the tweetId
    // console.log(jResponse)

    jResponse.forEach(jTweet => {

        //create a copy of the original
        let sDivTweet = original_middle_post;

        let tweet_id = `${jTweet[3]}`; //tweet id
        let user_image = `${jTweet[2]}`; // user img
        let user_id = `${jTweet[0]}`;  //user id
        let user_name = `${jTweet[1]}`;  //user name
        let tweet_message = `${jTweet[5]}`;//tweet message
        let tweet_image = `${jTweet[8]}`; //tweet image
        let tweet_total_likes = `${jTweet[6]}`; //tweet total likes
        let tweet_total_comments = `${jTweet[7]}`; //tweet total likes

        sDivTweet = sDivTweet.replace('{{tweetId}}', tweet_id);
        sDivTweet = sDivTweet.replace('{{userimage}}', user_image);
        sDivTweet = sDivTweet.replace('{{userId}}', user_id);
        sDivTweet = sDivTweet.replace('{{username}}', user_name);
        sDivTweet = sDivTweet.replace('{{tweetmesage}}', tweet_message);
        sDivTweet = sDivTweet.replace('{{tweetimage}}', tweet_image);
        sDivTweet = sDivTweet.replace('{{tweettotallikes}}', tweet_total_likes);
        sDivTweet = sDivTweet.replace('{{tweettotalcomments}}', tweet_total_comments);

        //we don't need variables to store the data, we can do it directly
        // sDivTweet = sDivTweet.replace('{{tweetmesage}}', jTweet.tweet_message);

        document.querySelector('#middle #tweets').insertAdjacentHTML('afterbegin', sDivTweet);
    });
    document.querySelector('#userTweets').innerHTML = "";
    getUserTweets();
}

async function tweet() {
    // console.log(event.target)

    let form = event.target;
    let data = new FormData(form);
    data.append('userId', userId)

    //check if the form has error class added
    if (form.querySelector(".error")) {
        console.log('can not continue');
        return;
    }

    //connect to the API if I don't have any error
    let connection = await fetch('../api/api-tweet.php', { method: "POST", body: data })
    // console.log(connection)

    //check the status of the connection
    if (connection.status != 200) {
        console.log('error');
        return
    }

    let sResponse = await connection.text()
    // console.log(sResponse)

    let jResponse = JSON.parse(sResponse)
    // console.log(jResponse)

    // console.log('tweet created')
    document.querySelector("#formTweetHome textarea").value = ""
    document.querySelector("#formTweetModal textarea").value = ""
    // document.querySelector("#formTweetModal").value = ""

    //hide the modal
    modal.style.display = "none";
    document.querySelector("body").style.overflow = 'visible';

    getTweet();
}


async function deleteTweet() {
    // console.log(event.target.parentNode.parentNode.parentNode.id)

    let tweet = event.target.parentNode.parentNode.parentNode
    let tweetId = event.target.parentNode.parentNode.parentNode.id

    let form = new FormData();
    form.append('userId', userId)
    form.append('tweetId', tweetId)

    let connection = await fetch('../api/api-delete-tweet.php', { method: "POST", body: form })
    // console.log(connection)

    //check the status of the connection
    if (connection.status != 200) {
        console.log('error');
        return
    }

    let sResponse = await connection.text()
    // console.log(sResponse)

    let jResponse = JSON.parse(sResponse)
    // console.log(jResponse)

    console.log('tweet deleted')

    document.getElementById(tweetId).remove()

    //Remove it also from the profile
    document.querySelector('#userTweets').innerHTML = "";
    getUserTweets();
}

async function getTweets() {

    let connection = await fetch(`../api/api-get-tweets.php?userId=${userId}`)
    // console.log(connection)

    //check the status of the connection
    if (connection.status != 200) {
        console.log('error')
    }

    let jResponse = await connection.json();  //getting the tweetId
    // console.log(jResponse)

    jResponse.forEach(jTweet => {

        //create a copy of the original
        let sDivTweet = original_middle_post;

        let tweet_id = `${jTweet[3]}`; //tweet id
        let user_image = `${jTweet[2]}`; // user img
        let user_id = `${jTweet[0]}`;  //user id
        let user_name = `${jTweet[1]}`;  //user name
        let tweet_message = `${jTweet[5]}`;//tweet message
        let tweet_image = `${jTweet[8]}`; //tweet image
        let tweet_total_likes = `${jTweet[6]}`; //tweet total likes
        let tweet_total_comments = `${jTweet[7]}`; //tweet total likes

        sDivTweet = sDivTweet.replace('{{tweetId}}', tweet_id);
        sDivTweet = sDivTweet.replace('{{userimage}}', user_image);
        sDivTweet = sDivTweet.replace('{{userId}}', user_id);
        sDivTweet = sDivTweet.replace('{{username}}', user_name);
        sDivTweet = sDivTweet.replace('{{tweetmesage}}', tweet_message);
        sDivTweet = sDivTweet.replace('{{tweetimage}}', tweet_image);
        sDivTweet = sDivTweet.replace('{{tweettotallikes}}', tweet_total_likes);
        sDivTweet = sDivTweet.replace('{{tweettotalcomments}}', tweet_total_comments);

        //we don't need variables to store the data, we can do it directly
        // sDivTweet = sDivTweet.replace('{{tweetmesage}}', jTweet.tweet_message);

        document.querySelector('#middle #tweets').insertAdjacentHTML('beforeend', sDivTweet);
    });
}



async function confirmUpdateTweet() {

    let btn = event.target
    let form = btn.parentNode.parentNode
    let tweetId = form.getAttribute("data-tweet-id")
    console.log(form)


    let data = new FormData(form);
    data.append('userId', userId)
    data.append('tweetId', tweetId)

    let connection = await fetch('../api/api-update-tweet.php', { method: "POST", body: data })
    console.log(connection)

    //check the status of the connection
    if (connection.status != 200) {
        console.log('error');
        return
    }

    let sResponse = await connection.text()
    // console.log(sResponse)

    let jResponse = JSON.parse(sResponse)
    console.log(jResponse)

    document.querySelector('#tweets').innerHTML = "";
    form.parentNode.style.display = "none"
    // getTweet();
    getTweets();
    document.querySelector('#userTweets').innerHTML = "";
    getUserTweets();

}


function updateTweet() {
    // console.log(event.target)  //i
    // console.log(document.querySelector(".user_image img"))  //i

    let btn = event.target
    //get the value of the button
    let btnName = btn.textContent //Update
    let tweet = btn.parentNode.parentNode.parentNode
    let tweetId = tweet.id
    let userImg = document.querySelector(".user_image img")
    //empty the message
    let message = "";
    // console.log(tweet.querySelector('.tweet_message').textContent)

    if (btnName == "Update") {
        message = tweet.querySelector('.tweet_message').textContent;
        console.log(message)
    }
    // else {
    //     message = document.querySelector('#tweetNewMessage').value;
    // }


    let formUpdateTweet = `
        <form class="updateTweet" data-tweet-id="${tweetId}">

            <textarea name="tweetNewMessage" id="tweetNewMessage" type="text" value="${message}" data-type="string" data-min="1" data-max="140" rows="1" cols="50"></textarea>
            <div class="icons">
                <a href="#"><svg viewBox="0 0 24 24"><path d="M19.75 2H4.25C3.01 2 2 3.01 2 4.25v15.5C2 20.99 3.01 22 4.25 22h15.5c1.24 0 2.25-1.01 2.25-2.25V4.25C22 3.01 20.99 2 19.75 2zM4.25 3.5h15.5c.413 0 .75.337.75.75v9.676l-3.858-3.858c-.14-.14-.33-.22-.53-.22h-.003c-.2 0-.393.08-.532.224l-4.317 4.384-1.813-1.806c-.14-.14-.33-.22-.53-.22-.193-.03-.395.08-.535.227L3.5 17.642V4.25c0-.413.337-.75.75-.75zm-.744 16.28l5.418-5.534 6.282 6.254H4.25c-.402 0-.727-.322-.744-.72zm16.244.72h-2.42l-5.007-4.987 3.792-3.85 4.385 4.384v3.703c0 .413-.337.75-.75.75z"></path> <circle cx="8.868" cy="8.309" r="1.542"></circle></svg></a>
                <a href="#"><svg viewBox="0 0 24 24"><path d="M19 10.5V8.8h-4.4v6.4h1.7v-2h2v-1.7h-2v-1H19zm-7.3-1.7h1.7v6.4h-1.7V8.8zm-3.6 1.6c.4 0 .9.2 1.2.5l1.2-1C9.9 9.2 9 8.8 8.1 8.8c-1.8 0-3.2 1.4-3.2 3.2s1.4 3.2 3.2 3.2c1 0 1.8-.4 2.4-1.1v-2.5H7.7v1.2h1.2v.6c-.2.1-.5.2-.8.2-.9 0-1.6-.7-1.6-1.6 0-.8.7-1.6 1.6-1.6z"></path><path d="M20.5 2.02h-17c-1.24 0-2.25 1.007-2.25 2.247v15.507c0 1.238 1.01 2.246 2.25 2.246h17c1.24 0 2.25-1.008 2.25-2.246V4.267c0-1.24-1.01-2.247-2.25-2.247zm.75 17.754c0 .41-.336.746-.75.746h-17c-.414 0-.75-.336-.75-.746V4.267c0-.412.336-.747.75-.747h17c.414 0 .75.335.75.747v15.507z"> </path></svg> </a>
                <a href="#"> <svg viewBox="0 0 24 24"><path d="M20.222 9.16h-1.334c.015-.09.028-.182.028-.277V6.57c0-.98-.797-1.777-1.778-1.777H3.5V3.358c0-.414-.336-.75-.75-.75s-.75.336-.75.75V20.83c0 .415.336.75.75.75s.75-.335.75-.75v-1.434h10.556c.98 0 1.778-.797 1.778-1.777v-2.313c0-.095-.014-.187-.028-.278h4.417c.98 0 1.778-.798 1.778-1.778v-2.31c0-.983-.797-1.78-1.778-1.78zM17.14 6.293c.152 0 .277.124.277.277v2.31c0 .154-.125.28-.278.28H3.5V6.29h13.64zm-2.807 9.014v2.312c0 .153-.125.277-.278.277H3.5v-2.868h10.556c.153 0 .277.126.277.28zM20.5 13.25c0 .153-.125.277-.278.277H3.5V10.66h16.722c.153 0 .278.124.278.277v2.313z"></path></svg></a>
                <a href="#"><svg viewBox="0 0 24 24"><path d="M12 22.75C6.072 22.75 1.25 17.928 1.25 12S6.072 1.25 12 1.25 22.75 6.072 22.75 12 17.928 22.75 12 22.75zm0-20C6.9 2.75 2.75 6.9 2.75 12S6.9 21.25 12 21.25s9.25-4.15 9.25-9.25S17.1 2.75 12 2.75z"></path> <path d="M12 17.115c-1.892 0-3.633-.95-4.656-2.544-.224-.348-.123-.81.226-1.035.348-.226.812-.124 1.036.226.747 1.162 2.016 1.855 3.395 1.855s2.648-.693 3.396-1.854c.224-.35.688-.45 1.036-.225.35.224.45.688.226 1.036-1.025 1.594-2.766 2.545-4.658 2.545z"> </path><circle cx="14.738" cy="9.458" r="1.478"></circle> <circle cx="9.262" cy="9.458" r="1.478"></circle></svg></a>
                <a href="#"><svg viewBox="0 0 24 24"><path d="M-37.9 18c-.1-.1-.1-.1-.1-.2.1 0 .1.1.1.2z"></path> <path d="M-37.9 18c-.1-.1-.1-.1-.1-.2.1 0 .1.1.1.2zM18 2.2h-1.3v-.3c0-.4-.3-.8-.8-.8-.4 0-.8.3-.8.8v.3H7.7v-.3c0-.4-.3-.8-.8-.8-.4 0-.8.3-.8.8v.3H4.8c-1.4 0-2.5 1.1-2.5 2.5v13.1c0 1.4 1.1 2.5 2.5 2.5h2.9c.4 0 .8-.3.8-.8 0-.4-.3-.8-.8-.8H4.8c-.6 0-1-.5-1-1V7.9c0-.3.4-.7 1-.7H18c.6 0 1 .4 1 .7v1.8c0 .4.3.8.8.8.4 0 .8-.3.8-.8v-5c-.1-1.4-1.2-2.5-2.6-2.5zm1 3.7c-.3-.1-.7-.2-1-.2H4.8c-.4 0-.7.1-1 .2V4.7c0-.6.5-1 1-1h1.3v.5c0 .4.3.8.8.8.4 0 .8-.3.8-.8v-.5h7.5v.5c0 .4.3.8.8.8.4 0 .8-.3.8-.8v-.5H18c.6 0 1 .5 1 1v1.2z"> </path><path  d="M15.5 10.4c-3.4 0-6.2 2.8-6.2 6.2 0 3.4 2.8 6.2 6.2 6.2 3.4 0 6.2-2.8 6.2-6.2 0-3.4-2.8-6.2-6.2-6.2zm0 11c-2.6 0-4.7-2.1-4.7-4.7s2.1-4.7 4.7-4.7 4.7 2.1 4.7 4.7c0 2.5-2.1 4.7-4.7 4.7z"> </path> <path d="M18.9 18.7c-.1.2-.4.4-.6.4-.1 0-.3 0-.4-.1l-3.1-2v-3c0-.4.3-.8.8-.8.4 0 .8.3.8.8v2.2l2.4 1.5c.2.2.3.6.1 1z"> </path> </svg></a>
                <button onclick="confirmUpdateTweet(); return false;">Confirm</button>
            </div>
        </form>`;

    // console.log(formUpdateTweet);

    tweet.innerHTML = "";
    tweet.innerHTML = formUpdateTweet;

}

//if I liked it, it's red when I load the page

async function loveTweet() {
    let heart = event.target
    let tweet = event.target.parentNode.parentNode.parentNode
    let tweetId = event.target.parentNode.parentNode.parentNode.id

    // let heartDiv = document.getElementById("lovediv")
    // console.log(heartDiv)
    // heartDiv.classList.add("love");



    // // if I liked it and press it again, take the heart back
    // if(heart.document.querySelector(".love") ){

    //     //make the heart grey
    //     heart.style.color = "grey";

    //     //decrease the number of loves
    //     let numberOfLoves = event.target.nextElementSibling.innerText;
    //     numberOfLoves--;
    //     event.target.nextElementSibling.innerText = numberOfLoves

    //     let form = new FormData();
    //     form.append('tweetId', tweetId)
    //     form.append('userId', userId)
    //     let connection = await fetch('../api/api-dislove-tweet.php', { method: "POST", body: form })

    //     // check the status of the connection
    //     if (connection.status != 200) {
    //         console.log('error');
    //         return
    //     }
    //     let sResponse = await connection.text()
    //     // console.log(sResponse)
    // }

    //make the heart red
    heart.style.color = "red";
    console.log(event.target) //i

    //increase the number of loves
    let numberOfLoves = event.target.nextElementSibling.innerText;
    numberOfLoves++;
    event.target.nextElementSibling.innerText = numberOfLoves


    let form = new FormData();
    form.append('tweetId', tweetId)
    form.append('userId', userId)

    let connection = await fetch('../api/api-love-tweet.php', { method: "POST", body: form })

    // check the status of the connection
    if (connection.status != 200) {
        console.log('error');
        return
    }

    let sResponse = await connection.text()
    // console.log(sResponse)

}
getUserTweets();
async function getUserTweets() {

    let connection = await fetch(`../api/api-get-user-tweets.php?userId=${userId}`)
    // console.log(connection)

    //check the status of the connection
    if (connection.status != 200) { console.log('error') }

    let response = await connection.json();  //getting the tweetId
    console.log(response)

    response.forEach(jTweet => {

        //create a copy of the original
        let sDivTweet = original_middle_post;

        let tweet_id = `${jTweet[3]}`; //tweet id
        let user_image = `${jTweet[2]}`; // user img
        let user_id = `${jTweet[0]}`;  //user id
        let user_name = `${jTweet[1]}`;  //user name
        let tweet_message = `${jTweet[5]}`;//tweet message
        let tweet_image = `${jTweet[8]}`; //tweet image
        let tweet_total_likes = `${jTweet[6]}`; //tweet total likes
        let tweet_total_comments = `${jTweet[7]}`; //tweet total likes

        sDivTweet = sDivTweet.replace('{{tweetId}}', tweet_id);
        sDivTweet = sDivTweet.replace('{{userimage}}', user_image);
        sDivTweet = sDivTweet.replace('{{userId}}', user_id);
        sDivTweet = sDivTweet.replace('{{username}}', user_name);
        sDivTweet = sDivTweet.replace('{{tweetmesage}}', tweet_message);
        sDivTweet = sDivTweet.replace('{{tweetimage}}', tweet_image);
        sDivTweet = sDivTweet.replace('{{tweettotallikes}}', tweet_total_likes);
        sDivTweet = sDivTweet.replace('{{tweettotalcomments}}', tweet_total_comments);

        document.querySelector('#userTweets').insertAdjacentHTML('beforeend', sDivTweet);
    });

}

//back to home page from profile page when I click on the arrow
function backToHome() {
    document.querySelector("#homePage").style.display = "grid"
}
function showprofileOtherUserSubpages(subpageOtherUserId) {
    console.log("page clicked:", subpageOtherUserId)
    document.querySelectorAll('.profileOtherUserSubpages').forEach(subpage => {
        subpage.style.display = "none"
    })
    document.getElementById(subpageOtherUserId).style.display = "grid"

}
function showSearchResults() {
    document.querySelector("#searchResults").style.display = "grid"
}


function hideSearchResults() {
    // document.querySelector("#searchResults").style.display = "none"
    // document.querySelector("#searchResults").style.display = "block"
}

async function startSearch() {
    // console.log("x")
    // console.log(document.querySelector("#searchText").value)

    //check if the input has data
    //if the fiels is empty, we will not run the following code
    if (document.querySelector('#searchText').value.length < 1) {   //==0
        document.querySelector('#searchResults').innerHTML = "";
        return;
    }
    let sSearchFor = document.querySelector('#searchText').value;

    let connection = await fetch(`../api/api-search-by-user-profile-name.php?userProfileName=` + sSearchFor)
    // console.log(connection)

    //if we had something, and then delete everithing, we will see this eror
    if (!connection.ok) { }

    let response = await connection.json();
    // console.log(response)

    //Everytime I search for something, when the respons arrives, first I delete the previous data
    document.querySelector('#searchResults').innerHTML = "";

    response.forEach(item => {
        // console.log(item[1]);

        let sResultDiv =
            `<form method="POST" class="formShowUser" id="${item[0]}" onsubmit="return false;">
        <input type="text" name="otherUserId" value="${item[0]}" hidden>
        <div class="result" data-userId="${item[0]}">
            <img class="img" src="/db-exam/images/${item[4]}">
            <div>
            <button onclick="showUserPage()"> <p> ${item[1]} ${item[2]}</p > </button>
                <p> @${item[3]}</p>
            </div>
            <hr>
        </div>
        </form>
        `
        document.querySelector('#searchResults').insertAdjacentHTML('afterbegin', sResultDiv)
    });
}

function showUserPage() {
    // console.log("yes");

    // document.querySelector("#searchResults").style.display = "block"

    document.querySelectorAll('.subpage').forEach(item => {
        item.style.display = "none"
    })
    document.querySelector("#userPage").style.display = "grid"
    document.querySelector("#userPage").innerHTML = ""

    // hide the search resoults
    document.querySelector("#searchResults").style.display = "none"

    //clear the search
    document.querySelector("#searchWrapper form input").value = ""

    //clear the resoults
    document.querySelector('#searchResults').innerHTML = "";

    getDataForUserPage();
}

async function getDataForUserPage() {

    // //clear the search
    // document.querySelector("#searchWrapper form input").value = ""

    // //hide the search resoults
    // document.querySelector("#searchResults").style.display = "none"

    let form = new FormData()
    let userShowId = event.target.parentNode.parentNode.parentNode.parentNode.id
    // console.log(userShowId)

    form.append('otherUserId', userShowId)
    let connection = await fetch('../api/api-show-user-profile.php', { method: "POST", body: form })
    // console.log(connection)

    if (!connection.ok) {
        console.log("error")
        return;
    }

    let response = await connection.json();
    console.log(response)
    // console.log(response.tweets[0][0])
    // console.log(response.user[1])

    let userPage = `
            <!-- Row 1 -->
            <div id="profileMiddleRowOne">
                <a onclick="backToHome(); return false;"><svg viewBox="0 0 24 24"><path d="M20 11H7.414l4.293-4.293c.39-.39.39-1.023 0-1.414s-1.023-.39-1.414 0l-6 6c-.39.39-.39 1.023 0 1.414l6 6c.195.195.45.293.707.293s.512-.098.707-.293c.39-.39.39-1.023 0-1.414L7.414 13H20c.553 0 1-.447 1-1s-.447-1-1-1z"></path></svg></a>
                <div>
                   <p class="profileMiddleUserName">${response.user[1]}</p>
                   <p>${response.user[2]} Tweets</p>
               </div>
            </div>

            <!-- Row 2 -->
            <div  id="profileMiddleRowTwo">
                <div> </div> <!-- cover image goes here -->
            </div>

            <!-- Row 3 -->
            <div id="profileMiddleRowThree">
                <img src="../images/${response.user[3]}" alt="profile picture">
                <button>Edit profile</button>
             </div>

            <!-- Row 4 -->
            <div id="profileMiddleRowFour">
                <p class="profileMiddleUserName">${response.user[1]}</p>
                <p id="profileMiddleAccount">@${response.user[4]}</p>
                <p id="profileMiddleJoined"><svg viewBox="0 0 24 24"><path d="M19.708 2H4.292C3.028 2 2 3.028 2 4.292v15.416C2 20.972 3.028 22 4.292 22h15.416C20.972 22 22 20.972 22 19.708V4.292C22 3.028 20.972 2 19.708 2zm.792 17.708c0 .437-.355.792-.792.792H4.292c-.437 0-.792-.355-.792-.792V6.418c0-.437.354-.79.79-.792h15.42c.436 0 .79.355.79.79V19.71z"> </path><circle cx="7.032" cy="8.75" r="1.285"></circle><circle cx="7.032" cy="13.156" r="1.285"></circle><circle cx="16.968" cy="8.75" r="1.285"></circle><circle cx="16.968" cy="13.156" r="1.285"></circle> <circle cx="12" cy="8.75" r="1.285"></circle><circle cx="12" cy="13.156" r="1.285"></circle><circle cx="7.032" cy="17.486" r="1.285"></circle><circle cx="12" cy="17.486" r="1.285"></circle></svg> Joined <span>${response.user[7]}</span></p>
                <p id="profileMiddleFollowing"><span><b>${response.user[6]}</b></span>Following</p>
                <p id="profileMiddleFollowers"><span><b>${response.user[5]}</b> </span>Followers</p>
            </div>


            <!--  Row 5 - navigation middle box   -->
           <div class="profileMiddleRows" id="profileMiddleRowTFive">
                <a class="profileSubPageActive" href="/tweets" onclick="showprofileOtherUserSubpages('profileOtherUserTweetsSubpage'); return false">Tweets</a>
                <a href="/tweets_replies" onclick="showprofileOtherUserSubpages('profileOtherUserTweetsAndRepliesSubpage'); return false" id="replies">Tweets & replies</a>
                <a href="/media" onclick="showprofileOtherUserSubpages('profileOtherUserMediaSubpage'); return false">Media</a>
                <a href="/links" onclick="showprofileOtherUserSubpages('profileOtherUserLinksSubpage'); return false">Links</a>
            </div>
         </div>
            `
    document.querySelector('#userPage').insertAdjacentHTML('afterbegin', userPage);


    let userPageTweets = `
 <!-- Row 6 -->
 <div class="profileMiddleRows" id="profileMiddleRowTSix">

     <!-- Subpage 1 -->
     <div id="profileOtherUserTweetsSubpage" class="profileOtherUserSubpages">
         <div id="userShowTweets">
         <!-- Here are the tweets -->
         </div>
     </div>

      <!-- Subpage 2 -->
     <div id="profileOtherUserTweetsAndRepliesSubpage" class="profileOtherUserSubpages">
         <div>
             <p class="profileSubpageTitleDefould">You haven’t Tweeted yet</p>
             <p class="profileSubpageSubtitleDefould">When you post a Tweet, it’ll show up here.</p>
             <button>Tweet now</button>
         </div>
     </div>

      <!-- Subpage 3 -->
     <div id="profileOtherUserMediaSubpage" class="profileOtherUserSubpages">
         <div>
             <p class="profileSubpageTitleDefould">You haven’t Tweeted any photos or videos yet</p>
             <p class="profileSubpageSubtitleDefould">When you send Tweets with photos or videos in them, it will show up here.</p>
             <button>Tweet a photo or a video</button>
         </div>
     </div>

      <!-- Subpage 4 -->
     <div id="profileOtherUserLinksSubpage" class="profileOtherUserSubpages">
         <div>
             <p class="profileSubpageTitleDefould">You don’t have any likes yet</p>
             <p class="profileSubpageSubtitleDefould">Tap the heart on any Tweet to show it some love. When you do, it’ll show up here.</p>
         </div>
     </div>
 </div>
    `
    document.querySelector('#userPage').insertAdjacentHTML('beforeend', userPageTweets);

    //get the tweets
    response.tweets.forEach(jTweet => {

        //create a copy of the original
        let sDivTweet = original_middle_post;

        let tweet_id = `${jTweet[3]}`; //tweet id
        let user_image = `${jTweet[2]}`; // user img
        let user_id = `${jTweet[0]}`;  //user id
        let user_name = `${jTweet[1]}`;  //user name
        let tweet_message = `${jTweet[5]}`;//tweet message
        let tweet_image = `${jTweet[8]}`; //tweet image
        let tweet_total_likes = `${jTweet[6]}`; //tweet total likes
        let tweet_total_comments = `${jTweet[7]}`; //tweet total likes

        sDivTweet = sDivTweet.replace('{{tweetId}}', tweet_id);
        sDivTweet = sDivTweet.replace('{{userimage}}', user_image);
        sDivTweet = sDivTweet.replace('{{userId}}', user_id);
        sDivTweet = sDivTweet.replace('{{username}}', user_name);
        sDivTweet = sDivTweet.replace('{{tweetmesage}}', tweet_message);
        sDivTweet = sDivTweet.replace('{{tweetimage}}', tweet_image);
        sDivTweet = sDivTweet.replace('{{tweettotallikes}}', tweet_total_likes);
        sDivTweet = sDivTweet.replace('{{tweettotalcomments}}', tweet_total_comments);

        document.querySelector("#userShowTweets").insertAdjacentHTML('afterbegin', sDivTweet);
    });
}




// setInterval(async function () {

getRandomUsers();
async function getRandomUsers() {

    let connection = await fetch(`../api/api-get-random-users.php?userId=${userId}`)
    // console.log(connection)

    //check the status of the connection
    if (connection.status != 200) { console.log('error') }

    let response = await connection.json();  //getting the tweetId
    // console.log(response)

    response.forEach(user => {

        //create a copy of the original
        let sDivUser = `
        <div class="rightRows" data-userId=${user[0]}>
        <img src="/db-exam-twitter/images/${user[4]}" alt="huawei logo image">

        <div>
          <p class="rightRowsTitle">${user[1]} ${user[2]}</p>
          <p class="rightRowsName">@${user[3]}</p>
        </div>

        <button onclick="follow(); return false;">Follow</button>
      </div>
        `
        // document.querySelector('#rightBoxThreeWrapper').innerHTML = "";

        document.querySelector('#rightBoxThreeWrapper #one').insertAdjacentHTML('afterend', sDivUser);
    });

}
// }, 3000);


async function follow() {
    console.log(event.target.parentNode.getAttribute("data-userId"))
    let otherUserId = event.target.parentNode.getAttribute("data-userId")

    //increase the number of following
    console.log(document.querySelector("#profileMiddleFollowing span ").innerText)
    let numberOfFollowing = document.querySelector("#profileMiddleFollowing span b").innerText
    numberOfFollowing++;
    document.querySelector("#profileMiddleFollowing span b").innerText = numberOfFollowing



    let form = new FormData()
    form.append('userId', userId)
    form.append('otherUserId', otherUserId)

    let connection = await fetch('../api/api-follow-user.php', { method: "POST", body: form })
    console.log(connection)

    //check the status of the connection
    if (connection.status != 200) { console.log('error') }

    // let response = await connection.json();  //getting the tweetId
    // console.log(response)


}
