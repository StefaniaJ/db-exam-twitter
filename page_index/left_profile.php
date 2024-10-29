
<div id="profile-section" onclick="showUserOptions()">

    <div class="profile-section-grid">

        <img src="../images/<?= $_SESSION['userImagePath'] ?>" alt="" />

        <div>
          <p><strong><?= $_SESSION['userName'] ?></strong></p>
          <p style="color:#5B7083">@<?= $_SESSION['userProfileName'] ?></p>
        </div>

         <svg viewBox="0 0 24 24">
          <path d="M20.207 8.147c-.39-.39-1.023-.39-1.414 0L12 14.94 5.207 8.147c-.39-.39-1.023-.39-1.414 0-.39.39-.39 1.023 0 1.414l7.5 7.5c.195.196.45.294.707.294s.512-.098.707-.293l7.5-7.5c.39-.39.39-1.022 0-1.413z"></path>
         </svg>

    </div>



<!-- Drop up menu-->
    <div class="dropup-content" id="myDropdown">

        <div class="profile-section-grid">
            <img src="../images/<?= $_SESSION['userImagePath'] ?>" alt="" />

            <div>
                <p><strong><?= $_SESSION['userName'] ?></strong></p>
                <p style="color:#5B7083">@<?= $_SESSION['userProfileName'] ?></p>
            </div>

            <svg viewBox="0 0 24 24" class="r-13gxpu9 r-4qtqp9 r-yyyyoo r-1q142lx r-1xvli5t r-1n0xq6e r-dnmrzs r-bnwqim r-1plcrui r-lrvibr"><path d="M9 20c-.264 0-.52-.104-.707-.293l-4.785-4.785c-.39-.39-.39-1.023 0-1.414s1.023-.39 1.414 0l3.946 3.945L18.075 4.41c.32-.45.94-.558 1.395-.24.45.318.56.942.24 1.394L9.817 19.577c-.17.24-.438.395-.732.42-.028.002-.057.003-.085.003z"></path></svg>

        </div>

        <a href="/"> Add an existing account</a>
        <a href="logout.php"> Log out @<?= $_SESSION['userProfileName'] ?>  </a>

    </div>


</div>