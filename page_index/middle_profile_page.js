
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