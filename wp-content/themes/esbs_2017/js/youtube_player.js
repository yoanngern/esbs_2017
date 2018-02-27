// 2. This code loads the IFrame Player API code asynchronously.
var tag = document.createElement('script');

tag.src = "https://www.youtube.com/iframe_api";
var firstScriptTag = document.getElementsByTagName('script')[0];
firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

// 3. This function creates an <iframe> (and YouTube player)
//    after the API code downloads.
var player;

function onYouTubeIframeAPIReady() {

    var videoId = document.getElementById("video_id");

    var id = videoId.getAttribute("data-video");
    var end = videoId.getAttribute("data-end");

    console.log(id);

    player = new YT.Player('player', {
        height: '100%',
        width: '100%',
        videoId: id,
        events: {
            'onReady': onPlayerReady,
            'onStateChange': onPlayerStateChange
        },
        playerVars: {
            'autoplay': 0,
            'color': 'white',
            'controls': 2,
            'modestbranding': 1,
            'rel': 0,
            'showinfo': 0,
            'end': end,
        }

    });

    var url = window.location.href;

    var hash = url.substring(url.indexOf("#") + 1);

    if (hash == 'play') {
        $("body").addClass("show_full_video");

        player.playVideo();
    }
}

// 4. The API will call this function when the video player is ready.
function onPlayerReady(event) {
    event.target.playVideo();
}

// 5. The API calls this function when the player's state changes.
//    The function indicates that when playing a video (state=1),
//    the player should play for six seconds and then stop.

function onPlayerStateChange(event) {
    if (event.data == YT.PlayerState.ENDED) {

        player.stopVideo();

        $("body").removeClass("show_full_video");

    }


}

function stopVideo() {
    player.stopVideo();
}


$("section div.video_full").on("click", "a.close", function (event) {
    event.preventDefault()

    player.stopVideo();

    $("body").removeClass("show_full_video");

});

$("section").on("click", "a.play", function (event) {
    event.preventDefault();


    $("body").addClass("show_full_video");

    player.playVideo();

});

