
<!-- The Modal for Sign up-->
<div id="myModal" class="modal">

    <div class="modal-content modal-tweet">
        <span class="close">&times;</span>
        <hr />

        <div class="post-tweet-wrapper">
            <img src="../images/<?= $_SESSION['userImagePath'] ?>"  alt="user profile image" />

            <!-- Modal Tweet Form -->
            <?php require_once(__DIR__.'/left_modal_form.php'); ?>
        </div>
    </div>
</div>

<script>

// Display and hide the modal to tweet

// Get the modal
var modal = document.getElementById("myModal");

// Get the button that opens the modal
var btn = document.querySelector(".openModalTweet");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal
btn.onclick = function () {
    modal.style.display = "block";
    document.querySelector("body").style.overflow = 'hidden'; //can't scroll
}

// When the user clicks on <span> (x), close the modal
span.onclick = function () {
    modal.style.display = "none";
    document.querySelector("body").style.overflow = 'visible'; //can scroll
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function (event) {
    if (event.target == modal) {
        modal.style.display = "none";
        document.querySelector("body").style.overflow = 'visible'; //can scroll
    }
}
</script>