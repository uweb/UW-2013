/* Globals */
var uwplayer, playerready = false, jsonloaded = false, videos = [];

$(window).load(function() {
	if ($('#nc-video-player').length) {
		fetch_and_prep_playlist();
	}
});

/* runs as soon as the YouTube iFrame API is loaded */
function onYouTubeIframeAPIReady() {
  uwplayer = new YT.Player('customplayer', {
	  videoId: '',
	  wmode: 'transparent',
	  events: {
			'onReady': onPlayerReady,
			'onStateChange': onPlayerChangeState
	  }
  });
  
}

/* runs when the player is ready */
function onPlayerReady(){
	if (jsonloaded) {  //if json has loaded and we are just now running this, we still need to queue the first video
		play(videos[0]);
	}
	playerready = true;
}

/* when a video stops playing, we queue up the next video */
function onPlayerChangeState(event) {
	if (event.data === 0) {
		var video = $('#vidContent .vid-active').attr('id');
		var index = videos.indexOf(video);
		if (index < videos.length - 1) {
			play(videos[index + 1]);
		}
		else {
			play(videos[0]);
		}
	}
}

/* gets the playlist data from youtube and sets up the player's interface */
function fetch_and_prep_playlist() {
	if ( $('#customplayer').length < 1) return;

	var $this = $(this)
	var $vidContent = $('#vidContent');
	$vidContent.empty();
	
	if (! $this.is(':visible')) return;

	var $wrapper = $('#tube-wrapper');
	var $vidSmall = $('#vidSmall');
	var params = { allowScriptAccess: "always", wmode:'transparent' };
	var proxy = '//ajax.googleapis.com/ajax/services/feed/load?';
	var playlist = $('#customplayer').data('pid');

	$vidSmall.tinyscrollbar({ axis: 'x'});

	$.getJSON('//gdata.youtube.com/feeds/api/playlists/'+playlist+'/?callback=?',{'alt':'json','v':'2'}, function (data){
		var video = data.feed.entry[0].media$group.yt$videoid.$t;
		var count = data.feed.entry.length;
		$vidContent.append('<ul/>');
		$vidContent.width(count * 135 + 'px');
		$.each(data.feed.entry, function(index,video) {
			var img = video.media$group.media$thumbnail[0],
				video_id  =  video.media$group.yt$videoid.$t,
				title = video.title.$t,
				dur = video.media$group.yt$duration.seconds,
				minutes = Math.floor(dur/60),
				seconds = String(dur % 60).length === 1 ? '0'+dur%60 : dur % 60;

			var html = '<li><a id="'+ video_id +'" class="video" href="#">'+
				'<img class="playBtn" src="http://www.washington.edu/wp-content/themes/uw-2013/img/misc/play.png" />'+
					  '<img src="'+img.url.replace(/http?:\/\//, '//')+'" width="'+img.width+'" height="'+img.height+'" />'+
					  '<div class="text">'+
					  '<p class="title">'+title+'</p>'+
					  '<p class="duration">'+minutes+':'+seconds+'</p>'+
					  '</div>' +
					 '</a></li>';
			videos.push(video_id);

			$vidContent.children('ul').append(html).imagesLoaded(function() {
				$vidSmall.tinyscrollbar_update();
			});
			if (--count===0) {
				$vidSmall.find('.scrollbar').show();
			}
		});
		if (playerready) {  //if this code hasn't run by the time the player is ready, we should queue up the first video now
			play(videos[0]);
		}
		jsonloaded = true;
	});

	$vidSmall.delegate('a.video', 'click', function(e) {
		e.preventDefault();
		play(this.id, true);
		return false;
	});

	$vidSmall.one('mouseenter', function() {
		$(this).tinyscrollbar_update();
	});

	$(window).resize( function () {
		$vidSmall.tinyscrollbar_update();
	});

}

/* cues the video whose id is passed and moves to/highlights the playlist item  *
 * can also start playing the video if requested                                */
function play(id, playnow){
	playnow = playnow || false;
	$this = $('#' + id);
	var leftpos = $this.position().left, $vidContent = $('#vidContent'), $viewport = $('#vidSmall .viewport');
	$('a.vid-active').removeClass('vid-active');
	if (playnow) {
		uwplayer.loadVideoById(id);
	}
	else {
		uwplayer.cueVideoById(id);
	}
	if ($vidContent.width() - leftpos < $viewport.width()){
		leftpos = $vidContent.width() - $viewport.width();
	}
	$('#vidContent').animate({left: -leftpos}, 500);
	$('#vidSmall').tinyscrollbar_update(leftpos);
	$this.addClass('vid-active');
}
