<!--------------------- PROFILE PAGE ---------------------->
<div id="profilePage" class="subpage">

    <!-- Row 1 -->
    <div id="profileMiddleRowOne">
        <!-- <a href="index.php"><svg viewBox="0 0 24 24"><path d="M20 11H7.414l4.293-4.293c.39-.39.39-1.023 0-1.414s-1.023-.39-1.414 0l-6 6c-.39.39-.39 1.023 0 1.414l6 6c.195.195.45.293.707.293s.512-.098.707-.293c.39-.39.39-1.023 0-1.414L7.414 13H20c.553 0 1-.447 1-1s-.447-1-1-1z"></path></svg></a> -->
        <a onclick="backToHome(); return false;"><svg viewBox="0 0 24 24"><path d="M20 11H7.414l4.293-4.293c.39-.39.39-1.023 0-1.414s-1.023-.39-1.414 0l-6 6c-.39.39-.39 1.023 0 1.414l6 6c.195.195.45.293.707.293s.512-.098.707-.293c.39-.39.39-1.023 0-1.414L7.414 13H20c.553 0 1-.447 1-1s-.447-1-1-1z"></path></svg></a>
        <div>
           <p class="profileMiddleUserName"><?= $_SESSION['userName']; ?></p>
           <p><?= $_SESSION['userTotalTweets']; ?> Tweets</p>
       </div>
    </div>

    <!-- Row 2 -->
    <div id="profileMiddleRowTwo">
        <div> </div> <!-- cover image goes here -->
    </div>

    <!-- Row 3 -->
    <div id="profileMiddleRowThree">
        <img src="../images/<?= $_SESSION['userImagePath'] ?>" alt="profile picture">
        <button>Edit profile</button>
    </div>

    <!-- Row 4 -->
    <div id="profileMiddleRowFour">
        <p class="profileMiddleUserName"><?= $_SESSION['userName']; ?></p>
        <p id="profileMiddleAccount">@<?= $_SESSION['userProfileName']; ?></p>
        <p id="profileMiddleJoined"><svg viewBox="0 0 24 24"><path d="M19.708 2H4.292C3.028 2 2 3.028 2 4.292v15.416C2 20.972 3.028 22 4.292 22h15.416C20.972 22 22 20.972 22 19.708V4.292C22 3.028 20.972 2 19.708 2zm.792 17.708c0 .437-.355.792-.792.792H4.292c-.437 0-.792-.355-.792-.792V6.418c0-.437.354-.79.79-.792h15.42c.436 0 .79.355.79.79V19.71z"> </path><circle cx="7.032" cy="8.75" r="1.285"></circle><circle cx="7.032" cy="13.156" r="1.285"></circle><circle cx="16.968" cy="8.75" r="1.285"></circle><circle cx="16.968" cy="13.156" r="1.285"></circle> <circle cx="12" cy="8.75" r="1.285"></circle><circle cx="12" cy="13.156" r="1.285"></circle><circle cx="7.032" cy="17.486" r="1.285"></circle><circle cx="12" cy="17.486" r="1.285"></circle></svg> Joined <span><?= $_SESSION['userCreated']; ?></span></p>
        <p id="profileMiddleFollowing"><span><b><?= $_SESSION['userTotalFollowing']; ?></b></span>Following</p>
        <p id="profileMiddleFollowers"><span><b><?= $_SESSION['userTotalFollowers']; ?></b> </span>Followers</p>
    </div>


    <!--  Row 5 - navigation middle box   -->
    <div class="profileMiddleRows" id="profileMiddleRowTFive">
        <a class="profileSubPageActive" href="/tweets" onclick="showprofileSubpages('profileTweetsSubpage'); return false">Tweets</a>
        <a href="/tweets_replies" onclick="showprofileSubpages('profileTweetsAndRepliesSubpage'); return false" id="replies">Tweets & replies</a>
        <a href="/media" onclick="showprofileSubpages('profileMediaSubpage'); return false">Media</a>
        <a href="/links" onclick="showprofileSubpages('profileLinksSubpage'); return false">Links</a>
    </div>


    <!-- Row 6 -->
    <div class="profileMiddleRows" id="profileMiddleRowTSix">
        <!-- Subpage 1 -->
        <div id="profileTweetsSubpage" class="profileSubpages">
            <div id="userTweets">
            </div>  <!-- user tweets here -->
        </div>

         <!-- Subpage 2 -->
        <div id="profileTweetsAndRepliesSubpage" class="profileSubpages">
            <div>
                <p class="profileSubpageTitleDefould">You haven’t Tweeted yet</p>
                <p class="profileSubpageSubtitleDefould">When you post a Tweet, it’ll show up here.</p>
                <button>Tweet now</button>
            </div>
        </div>

         <!-- Subpage 3 -->
        <div id="profileMediaSubpage" class="profileSubpages">
            <div>
                <p class="profileSubpageTitleDefould">You haven’t Tweeted any photos or videos yet</p>
                <p class="profileSubpageSubtitleDefould">When you send Tweets with photos or videos in them, it will show up here.</p>
                <button>Tweet a photo or a video</button>
            </div>
        </div>

         <!-- Subpage 4 -->
        <div id="profileLinksSubpage" class="profileSubpages">
            <div>
                <p class="profileSubpageTitleDefould">You don’t have any likes yet</p>
                <p class="profileSubpageSubtitleDefould">Tap the heart on any Tweet to show it some love. When you do, it’ll show up here.</p>
            </div>
        </div>

    </div>
</div>