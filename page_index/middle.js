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
