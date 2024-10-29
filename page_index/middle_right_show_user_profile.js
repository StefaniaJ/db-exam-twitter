function showprofileOtherUserSubpages(subpageOtherUserId) {
    console.log("page clicked:", subpageOtherUserId)
    document.querySelectorAll('.profileOtherUserSubpages').forEach(subpage => {
        subpage.style.display = "none"
    })
    document.getElementById(subpageOtherUserId).style.display = "grid"

}
