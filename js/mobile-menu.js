function dropMenu() {
    var nav = document.getElementsByClassName("mobile-nav")[0];

    if (nav.style.display === "block") {
        nav.style.display = "none";
    } else {
        nav.style.display = "block";
    }
}