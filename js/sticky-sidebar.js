$(document).ready(function() {
    // var body_height = $('body').height();
    // var footer_height = $('footer').height();
    var footer_top = $('footer').offset().top;

    $(window).scroll(function() {
        // var sb_top = $('aside').offset().top;
        // var sb_height = $('aside').height();
        // var sticky_offset = sb_top + sb_height + footer_height;
        var scroll_bottom = $(window).scrollTop() + $(window).height();

        if (scroll_bottom >= footer_top) {
            $('aside').css('top', 60 + (footer_top - scroll_bottom) + 'px');
        } else {
            $('aside').css('top', '60px');
        }
        // console.log(scroll_bottom);
    });
});