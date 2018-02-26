$(document).ready(function () {

    CSSPlugin.defaultSmoothOrigin = false;

    var schema = $("#harvest_cycle_schema");

    var elem = $("#hc_2 .box", schema);

    var circle = "#lines .line";

    /*
    $(circle).each(function () {
        var speed = $(this).data('speed');

        var elem = $(this);

        TweenMax.to(elem, speed, {
            rotation: 360,
            transformOrigin: "50% 50%",
            smoothOrigin: false,
            repeat: 100,
            ease: Linear.easeNone
        });
    });
*/

    $(".box", schema).mouseenter(function () {

        var elem = $(this).parent();

        var zoom = $(this).data("zoom");

        if (!$(elem).hasClass('open')) {
            TweenMax.to(elem, 0.3, {
                scale: zoom, transformOrigin: "50% 50%", smoothOrigin: false
            });
        }


    }).mouseleave(function () {

        var elem = $(this).parent();

        if (!$(elem).hasClass('open')) {
            TweenMax.to(elem, 0.3, {scale: 1, transformOrigin: "50% 50%", smoothOrigin: false});
        }


    }).click(function () {

        var elem = $(this).parent();

        openPhase(elem, schema);

    });

    $(window).click(function () {
        closePhase(schema);
    });

    //openPhase($("#hc_2"), schema);

});


function closePhase(schema) {

}


function openPhase(elem, schema) {

    var elemOpen = $(elem).hasClass('open');

    $('.hc_round', schema).removeClass('open');

    if (elemOpen) {
        elem.removeClass("open");
    } else {
        elem.addClass("open");
    }

    var elem_w = $(elem).data("width");
    var elem_h = $(elem).data("height");

    var schema_w = $(schema).data("width");
    var schema_h = $(schema).data("height");

    var scale1 = schema_w / elem_w;
    var scale2 = schema_h / elem_h;

    var scale = scale1;

    if (scale2 > scale1) {
        scale = scale2;
    }

    scale = scale * 0.85;

    $(elem).appendTo('#svg_box');

    $('.hc_round', schema).each(function () {

        var id = $(this).attr('id');

        if ($(this).hasClass('open')) {

            TweenMax.to(elem, 0.3, {
                x: schema_w / 2 - elem_w / 2,
                y: schema_h / 2 - elem_h / 2,
                scale: scale,
                transformOrigin: '50% 50%',
                smoothOrigin: false,
            });

            $('.icon', elem).hide();
            $('[data-hc="'+ id +'"]').css("opacity", 1);

        } else {

            TweenMax.to(this, 0.3, {
                x: $(this).data("left"),
                y: $(this).data("top"),
                scale: 1,
                transformOrigin: '50% 50%',
                smoothOrigin: false

            });

            $('.icon', this).show();

            $('[data-hc="'+ id +'"]').css("opacity", 0);
        }

    });


}