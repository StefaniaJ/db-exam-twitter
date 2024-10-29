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