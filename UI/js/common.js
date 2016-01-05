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
    var w = $(".store-ticket").width();
    $(".store-ticket .footer div").each(function(index) {
        $(this).css({width: w/3, height: "100%", float: "left"});
        if((index-1) % 3 == 0) {
            $(this).css({
                "width": w/3 - 2,
                "border-left": "1px solid #ccc",
                "border-right": "1px solid #ccc"
            });
        }
    });

    $(".store-ticket .header").each(function(index) {
        $(".thumbnail",this).css({
            height: $(this).height()
        });

        // this image tag is changed by image data lists.
        $(".thumbnail",this).append("<img src='./image/disney/one-day.jpg' alt='' />");

        var top = ($(this).height() - $(".thumbnail img",this).height()) / 2
        $(".thumbnail img",this).css({position: "relative", top: -top});
    });
})
