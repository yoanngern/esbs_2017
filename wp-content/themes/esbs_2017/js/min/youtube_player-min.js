function onYouTubeIframeAPIReady(){player=new YT.Player("player",{height:"360",width:"640",videoId:"M7lc1UVf-VE",events:{onReady:onPlayerReady,onStateChange:onPlayerStateChange}})}function onPlayerReady(e){e.target.playVideo()}function onPlayerStateChange(e){e.data!=YT.PlayerState.PLAYING||done||(setTimeout(stopVideo,6e3),done=!0)}function stopVideo(){player.stopVideo()}var tag=document.createElement("script");tag.src="https://www.youtube.com/iframe_api";var firstScriptTag=document.getElementsByTagName("script")[0];firstScriptTag.parentNode.insertBefore(tag,firstScriptTag);var player,done=!1;