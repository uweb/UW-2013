$(document).ready(function() {

  if ( $('#youtubeapi').length < 1) return;

  
    var $this = $(this)
      , $vidContent = $('#vidContent')
      , $wrapper = $('#youtube-playlist-player')

    $vidContent.empty();


    if (! $this.is(':visible')) return;

    if (swfobject.getFlashPlayerVersion().major < 11) {
        var html = '<div class="alert alert-error">'+
                      '<strong>You need to upgrade your Adoble Flash Player to watch the UW Today videos.</strong><br/>'+
                      '<a href="http://get.adobe.com/flashplayer/" title="Flash player upgrade">Download it here from Adobe.</a>'+
                    '</div>';
      $wrapper.html(html);
      return;
    }
      
    var $vidSmall = $('#youtube-player-controls');
    var params = { allowScriptAccess: "always", wmode:'transparent' };
    var atts = { id: "customplayer" };
    var proxy = '//ajax.googleapis.com/ajax/services/feed/load?';
    var playlist = $('#youtubeapi').data('pid');

    var gets = jQuery.param({
        enablejsapi:1,
        playerapiid:'uwplayer',
        version:3,
        controls:1,
        autoplay:0,
        rel:0,
        modestbranding:1,
        theme:'light'
    });

    $vidSmall.tinyscrollbar();

    $.getJSON('//gdata.youtube.com/feeds/api/playlists/'+playlist+'/?callback=?',{'alt':'json','v':'2'}, function (data){
      var video = data.feed.entry[0].media$group.yt$videoid.$t;
      var count = data.feed.entry.length;
      swfobject.embedSWF("//www.youtube.com/v/"+video+"?"+gets,
                         "youtubeapi", "425", "356", "8", null, null, params, atts);
      $vidContent.append('<ul/>');
      $.each(data.feed.entry, function(index,video) {
          var img = video.media$group.media$thumbnail[0],
              video_id  =  video.media$group.yt$videoid.$t,
              title = video.title.$t,
              dur = video.media$group.yt$duration.seconds,

              minutes = Math.floor(dur/60),
              seconds = String(dur % 60).length === 1 ? '0'+dur%60 : dur % 60;
            
          var html = '<li><a id="'+ video_id +'" class="video" href="#">'+
                '<img class="playBtn" src="/news/wp-content/themes/news/img/play.png" />'+
                      '<img src="'+img.url.replace(/https?:\/\//, '//')+'" width="'+img.width+'" height="'+img.height+'" />'+
                      '<span class="title">'+title+'</span>'+
                      '<span class="duration">'+minutes+':'+seconds+'</span>'+
                     '</a></li>';

          $vidContent.children('ul').append(html).imagesLoaded(function() {
            $vidSmall.tinyscrollbar_update();
          })
          if ( --count===0 ) {
            $vidSmall.find('.scrollbar').show();
            $vidContent.height('+=100')
          }
        });
    });

    $wrapper.delegate('a.video', 'click', function(e) {
        e.preventDefault();
        play(this.id);
        return false;
    });

    $vidSmall.one('mouseenter', function() {
      $(this).tinyscrollbar_update();
    })


});
function onYouTubePlayerReady(playerid){
  uwplayer = document.getElementById("customplayer");
}
function play(id){
  uwplayer.loadVideoById(id);
}
