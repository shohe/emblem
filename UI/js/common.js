var margin_big = 12.0;
var margin_small = 4.0;

/* base */
$(function init() {
    $("#main").css({height:$(window).height()});
    $("#side-menu").css({height:$(window).height()});
    $("#content").css({"min-height":$(window).height()-130});
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

/* store-ticket buy modal */
$(function set_modal_logo() {
    var imgPreloader = new Image();
    var loc = window.location.pathname;
    var dir = loc.substring(0, loc.lastIndexOf('/')) + "/image/logo.png";
    imgPreloader.onload = function() {
        // console.log($(this).width());
    }
    imgPreloader.src = dir;
    $('#buy-modal').on('shown.bs.modal', function () {});
});

/* setting-wrap */
$(function setup_setting_wrap() {
    $("#setting-wrap").css({height:$(window).height()});
    var size = $("#setting-wrap ul li a").width();
    $("#setting-wrap ul li a .image").css({height:size,width:size});
});
