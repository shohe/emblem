var margin_big = 12.0;
var margin_small = 4.0;

/* base */
$(function init() {
    $("#side-menu").css({height:window.parent.screen.height});
})

/* setup image of ticket-author */
$(function init() {
    var h = $(".author li").height();
    $(".author .thumbnail img").each(function() {
        var top = ($(this).height() - h) / 2
        $(this).css({
            position: "relative",
            top: -top
        });
    });
})

/* store-ticket */
$(function init() {
    var w = $("#content").width();
    $(".store-ticket li").each(function(index) {
        var width = (w - (margin_big * 4)) / 3;
        $(this).css({width: width});
        if ((index - 1) % 3 == 0) $(this).css({"margin-left": margin_big, "margin-right": margin_big});
    });
})
