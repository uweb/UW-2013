$(document).ready(function() {

  var TWITTER_URL         = 'https://api.twitter.com/1/statuses/user_timeline.json?callback=?'
    , TWITTER_AUTHOR_URL  = 'https://api.twitter.com/1/users/profile_image?size=mini&screen_name=';

  $('.twitter-feed').each(function() {
    
        var $this = $(this)

        $this.removeAttr('style')

        var data = {
          include_entities: true,
          include_rts: true,
          screen_name: $this.data('name'),
          count: $this.data('count')
        }

        $.getJSON( TWITTER_URL , data , function(json) {
          json.reverse();
          while ( json.length ) 
          {
            var tweet     = json.pop()
              , hasAuthor = tweet.entities.user_mentions.length > 0
              , hasUrl    = tweet.entities.urls.length > 0
              , img       = hasAuthor ? TWITTER_AUTHOR_URL + tweet.entities.user_mentions[0].screen_name :
                                        tweet.user.profile_image_url_https
              , name      = hasAuthor ? tweet.entities.user_mentions[0].name : tweet.user.name
              , sname     = hasAuthor ? tweet.entities.user_mentions[0].screen_name : tweet.user.screen_name
              , retweet   = tweet.text.indexOf('RT') === 0 
              , text      = tweet.text
              , retweetxt = ''

            if( retweet ) {
               var t = text.split(':');
               t.shift()
               text = t.join(':')
                
                retweetxt = '<small> Retweeted by <a href="//twitter.com/'+tweet.user.screen_name+'"> @' + tweet.user.screen_name+ '</a></small>'; 
            }

            text = text.replace(/[A-Za-z]+:\/\/[A-Za-z0-9-_]+\.[A-Za-z0-9-_:%&~\?\/.=]+/g, function(found) {
                      return found.link(found);
                    })

            text = text.replace(/[#]+[A-Za-z0-9-_]+/g, function(tag) {
                      return tag.link("http://search.twitter.com/search?q="+encodeURIComponent(tag));
                    });

            text = text.replace(/[@]+[A-Za-z0-9-_]+/g, function(u) {
                        return u.link("http://twitter.com/"+u.replace('@',''));
                    });
            
            
            var html = '<div class="tweet">' +
                        '<a href="//twitter.com/' + sname + '">' +
                          '<img src="' + img + '" alt="' + sname + '"/>'+
                        '</a>' +
                        '<p><a href="//twitter.com/' + sname + '">' + name + ' <small>@'+ sname +'</small> </a>' +
                            text + retweetxt + 
                        '</p>' +
                       '</div>';
            
            $this.append( html );
          
          }
      
    });

  });
})
