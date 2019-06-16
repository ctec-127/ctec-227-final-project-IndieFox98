function dropMenu() {
    var nav = document.getElementsByClassName("mobile-nav")[0];
    var btn = document.getElementById("burger-btn");

    if (nav.style.height === "180px") {
        nav.style.height = "0";
        btn.className = "fa fa-bars";
    } else {
        nav.style.height = "180px";
        btn.className = "fa fa-times";
    }
}