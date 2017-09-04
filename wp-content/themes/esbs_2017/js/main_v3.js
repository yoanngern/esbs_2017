// @codekit-prepend "vendor/jquery-2.2.2.js"


$(document).ready(function () {


    $("body > header").on("click", "#burger", function (event) {
        event.preventDefault();


        if ($("body > header #burger").hasClass("open")) {
            closeNav();

            closeForm();
        } else {
            openNav();
        }


    });

    $("iframe.video").each(function () {

        var iframe = $(this);

        var iframe_width = $(this).width();
        var iframe_height = $(this).height();

        $(this).attr("width", "100%");
        $(this).attr("height", "100%");


        console.log(iframe);
        console.log("width: " + iframe_width);
        console.log("height: " + iframe_height);


        var container = ' <section class="player" style="max-width: ' + iframe_width + 'px" data-width="' + iframe_width + '"><div class="container"></div></section> ';

        $(this).wrapAll(container);


    });

    $("body").on("click", 'a[href^="#join"]', function (event) {
        event.preventDefault();

        toggleForm();

    });


    $("#content.blog header").on("click", "#current_act", function (event) {
        event.preventDefault();
        $("#content.blog header select").toggleClass("show");
        $("#content.blog header #current_act").hide();

        openSelect("#content.blog header select");
    });

    $("#mc_embed_signup").on("click", "input.show_optional", function (event) {


        if ($("#mc_embed_signup input.show_optional").is(":checked")) {
            $("#mc_embed_signup fieldset.optional_fields").addClass("visible");
        } else {
            $("#mc_embed_signup fieldset.optional_fields").removeClass("visible");
        }


    });


    $("#content.blog header select").change(function (event) {
        event.preventDefault();

        $("#content.blog header option:selected").each(function () {


            var url = $("#content.blog header #current_act").data("url");

            if (this.value) {
                var slug = this.value;
            } else {
                var slug = "";
            }

            window.location.href = url + "category/" + slug;
        });

    });


    $("header #language select").on('change', function (event) {
        event.preventDefault();

        $("header #language option:selected").each(function () {


            if (this.value) {
                var url = this.value;
            } else {
                var url = "";
            }

            window.location.href = url;
        });

    });


    $("#content.blog header #search_input").blur(function (event) {
        event.preventDefault();

        var url = $(this).data("url");

        var val = this.value;


        if (val) {
            window.location.href = url + "/search/" + val + "?post_type=post";
        }


    });


    $("#content.blog header").on("click", ".search .box", function (event) {
        event.preventDefault();

        $('#search_input').focus();

    });


    $("#content.blog header #search_input").change(function (event) {
        event.preventDefault();

        var val = this.value;


        if (val) {
            window.location.href = "/search/" + val + "?post_type=post";
        }


    });

    $("#slider .bullets a").on("click", function () {

        $("#slider").addClass("stop");

        var id = $(this).data("slide");

        $("#slider .bullets a").removeClass("current");
        $("#slider > article").removeClass("current");

        $("#slider .bullets a[data-slide=" + id + "]").addClass("current");
        $("#slider > article[data-slide=" + id + "]").addClass("current");

    });


    $("header div.principal-nav div > ul > li.menu-item-has-children").on("touchstart", function () {


        if ($(this).hasClass("open")) {
            return;


        } else {
            event.preventDefault();

            var parent = $(this).parent();

            $("> li", parent).each(function () {
                $(this).removeClass("open");
            });

            $(this).addClass("open");
        }


    });


    setTimeout(showSlides, 6000);

    $(document).on( 'scroll', function(){
        scrollEvent();
    });

});


var openSelect = function (selector) {

    var element = $(selector)[0], worked = false;
    if (document.createEvent) { // all browsers
        var e = document.createEvent("MouseEvents");
        e.initMouseEvent("mousedown", true, true, window, 0, 0, 0, 0, 0, false, false, false, false, 0, null);
        worked = element.dispatchEvent(e);
    } else if (element.fireEvent) { // ie
        worked = element.fireEvent("onmousedown");
    }
    if (!worked) { // unknown browser / error
        alert("It didn't worked in your browser.");
    }
}


function scrollEvent() {


    var scrollPos = $(document).scrollTop();
    var bannerH = $("#action_banner").height();


    if(scrollPos > bannerH) {
        $("body > header").addClass("fixed");
        $("body #mc_embed_signup").addClass("fixed");

        $("body #mc_embed_signup").css("top", 0);
    } else {
        $("body > header").removeClass("fixed");
        $("body #mc_embed_signup").removeClass("fixed");

        $("body #mc_embed_signup").css("top", bannerH-scrollPos);
    }

}


function openNav() {

    console.log("test");


    $("body > header ul").addClass("show");
    $("body > header #burger").addClass("open");

    $("body > #content").addClass("hide");
    $("body > footer").addClass("hide");
    $("body").addClass("black");

    closeForm();
}


function closeNav() {

    console.log("test");

    $("body > header ul").removeClass("show");
    $("body > header #burger").removeClass("open");

    $("body > #content").removeClass("hide");
    $("body > footer").removeClass("hide");
    $("body").removeClass("black");
}

function closeForm() {
    $("#mc_embed_signup").removeClass("visible");

    var button = $("body > header .join_link a");
    button.text(button.data("text"));
    button.removeClass("close");
}


function toggleForm() {

    $("#mc_embed_signup").toggleClass("visible");
    $("#mc_embed_signup input.email").focus();

    closeNav();

    var button = $("body > header .join_link a");

    if (button.data("text") == undefined) {
        button.attr('data-text', button.text());
    }

    if (button.text() == button.data("text")) {

        button.text("Close");
        button.addClass("close");

        $("body > header #burger").addClass("open");

    } else {
        button.text(button.data("text"));
        button.removeClass("close");
    }
}


function showSlides() {

    if ($("#slider").hasClass("stop")) {

        return false;

    }


    var next_id = 1;

    $("#slider > article.current").each(function () {

        var id = $(this).data("slide");


        $(this).removeClass("current");

        var size = $("#slider > article").length;

        if (id == size) {
            next_id = 1;
        } else {
            next_id = id + 1;
        }

    });


    $("#slider .bullets a").removeClass("current");

    $("#slider .bullets a[data-slide=" + next_id + "]").addClass("current");

    $("#slider > article[data-slide=" + next_id + "]").addClass("current");

    setTimeout(showSlides, 5000); // Change image every 5 seconds
}




