var elementorSlides = [];
var timeout_resize;
var timeout_slider;
var slider_auto = true;

$(document).ready(function () {


    $(".elementor-slider").each(function () {

        container = $('.container', this);

        initElementorSlider(container);

    });

    $(".elementor-slider").on("click", ".nav", function (event) {
        event.preventDefault();

        slider_auto = false;
        window.clearTimeout(timeout_slider);

        parent_container = $(this).parent();

        container = $('.container', parent_container);

        elementorSlider(container, $(this).attr('id'));

    });

    ratio();

    $(window).on('resize', function () {

        timeout_resize = window.setTimeout(ratio, 50);

    });


    auto_slider();
});

function auto_slider() {

    if (slider_auto) {
        container = $('.elementor-slider[data-nb="3"] .container');

        window.clearTimeout(timeout_slider);

        $(".elementor-slider").each(function () {

            if ($(this).is(':visible')) {
                container = $('.container', this);
            }

        });

        timeout_slider = window.setTimeout(function () {

            elementorSlider(container, 'next');

            auto_slider();
        }, 5000);

    }
}


function ratio() {
    var h = $(window).height();
    var w = $(window).width();

    var ratio = w / h;

    $(".elementor-slider").each(function () {

        container = $('.container', this);

        initElementorSlider_size(container);
    });


    $("body").attr("data-ratio", ratio);
}


function elementorSlider(container, direction) {


    slide_width = $(container).width();

    actualPos = $(".actual", container).index();

    position = actualPos * slide_width;

    if (direction == 'next') {

        new_pos = position + slide_width;

        $(".content", container).animate({
            left: -new_pos,
            easing: 'swing'
        }, 500, function () {
            $(".actual", container).removeClass("actual").next().addClass("actual");

            $(".page", container).first().appendTo(".content", container);

            $('.content', container).css("left", -position);

        });

    } else {
        new_pos = position - slide_width;

        $(".content", container).animate({
            left: -new_pos,
            easing: 'swing'
        }, 500, function () {
            $(".actual", container).removeClass("actual").prev().addClass("actual");

            $(".page", container).last().prependTo(".content", container);

            $('.content', container).css("left", -position);


        });
    }


}

function initElementorSlider(container) {

    $(".page", container).each(function (index, value) {
        //elementorSlides[index+1] = value;

        $(value).clone().addClass("clone").appendTo($(".content", container));

        $(value).removeClass("actual");
    });

    initElementorSlider_size(container);

}

function initElementorSlider_size(container) {

    slide_width = $(container).width();

    $('.page', container).css("width", slide_width);

    nb_slide = $(".page", container).size();

    $(".content", container).width(slide_width * nb_slide);

    actualPos = $(".actual", container).index();

    position = actualPos * slide_width;

    $(".content", container).css({"left": -position});

}