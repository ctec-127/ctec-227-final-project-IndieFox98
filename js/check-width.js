$(document).ready(function() {
    function checkWidth() {
        if (window.innerWidth >= 768) {
            $(".mobile-nav").css("height", "0");
            $("#burger-btn").attr("class", "fa fa-bars");
        }
    }

    checkWidth();

    $(window).resize(checkWidth);
});