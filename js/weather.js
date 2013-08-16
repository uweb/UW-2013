/**
* Header weather widget
*/

$(document).ready(function() {

  var data = {
    q:'http://www.atmos.washington.edu/rss/home.rss',
    v:'2.0'
  }

  $.ajax({
    url: 'https://ajax.googleapis.com/ajax/services/feed/load?callback=?',
    dataType: 'jsonp',
    data: data,
    success: function(json) { 
      var icon = $.trim(json.responseData.feed.entries[2].title.split('|')[1])
        , weat = $.trim(json.responseData.feed.entries[1].title.split('|')[1])
        , temp = $.trim(json.responseData.feed.entries[0].title.split('|')[1])
        , html = '<li class="header-weather"><a href="http://www.atmos.washington.edu/weather/forecast/" title="Forecast is '+weat+'">';
      html += '<img src="//uw.edu/news/wp-content/themes/uw/img/weather/top-nav/'+icon+'.png" alt="Forecast is '+weat+'"/>';
      html += '</a></li>';
      html += '<li class="header-forcast"><a href="http://www.atmos.washington.edu/weather/forecast/">';
      html += 'Seattle '+temp;
      html += '</a></li>';
      $('#thin-strip').find('ul').append(html)
    }
  });

})
