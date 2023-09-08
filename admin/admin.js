const changeprofile = document.getElementById('btn-change-profile')
const body = document.body
const cancel = document.getElementById('update-cancel')


changeprofile.addEventListener('click', change);
function change() {
    body.style.overflowY = 'hidden'
    document.querySelector(".change-profile-container").style.opacity = "1"
    document.querySelector(".change-profile-container").style.zIndex = "9999"
    document.querySelector(".change-profile-container").style.pointerEvents = "auto"

    window.addEventListener('wheel', function (e) {
        e.preventDefault();
    });
    window.scrollTo({
        top: 0,
        behavior: 'smooth'})

}

cancel.addEventListener('click', cancelfn)
function cancelfn(){
    body.style.overflowY = 'scroll'
    document.querySelector(".change-profile-container").style.opacity = "0"
    document.querySelector(".change-profile-container").style.zIndex = "0"
    document.querySelector(".change-profile-container").style.pointerEvents = "auto"


}


