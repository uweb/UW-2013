/*
* UW Alert Banner
*
* This file checks for a current emergenty from our emergency blog json feed. 
* You can also check different alerts by appending a hash #alert-{color}, where
* color is either red, orange, blue or steel to display a fake alert.
*
* Eg: uw.edu/discover/#alert-red
*/

$(document).ready(function() {

    var data = {
      number:1,
      type:'post',
      status:'publish'
    }

    var alert_url =  window.location.hash.indexOf('alert') === -1 ? 
          'https://www.washington.edu/static/UW-Alert-Banner/alert/?c=?' :
          'https://www.washington.edu/static/UW-Alert-Banner/alert/?test=true&c=?';

    $.getJSON( alert_url, data, function( res ) {

          if ( !res || res.found < 1)
            return;
          
          var post  = res.posts[0]
            , cats  = post.categories
            , slugs = []
            , css   = ''
            , colors = ['red', 'orange', 'blue', 'steel'];

          $.each(cats, function(i,val) {
            slugs += '|'+val.slug
          })

          for (var i = 0; i < colors.length; i += 1) {
            if(slugs.indexOf(colors[i]) != -1 ) {
              css = 'uwalert-'+colors[i].toLowerCase();
            }
          };

          if ( window.location.hash.indexOf('alert') != -1 )
            css = window.location.hash.replace('#','')

          if( css.length === 0 ){
            return false;
          }

          var anchor  = $('<a/>').attr({'href': 'http://emergency.uw.edu', 'title':post.title}).html('More info')
            , excerpt = $(post.excerpt.replace(' [...]','')).append( ' ' ).append( anchor.prop('outerHTML') ).prop('outerHTML')
            , html    = $('<div id="uwalert-alert-message" class="'+css+'" />')
                          .html('<div><h1>'+post.title+'</h1>'+excerpt+'</div>')
            , adjust  = $('body').hasClass('admin-bar') ? $('#wpadminbar').height() : 0;

          $('body')
            .prepend(html)
            .data('alert-height', $('#uwalert-alert-message').outerHeight() + adjust )

          var mini = $('<a id="alert-mini" class="hidden-phone"/>')
                        .attr({href:'#',title:post.title})
                        .click(function() {
                          $('body').data('scrolling',true).animate({scrollTop:0}, {duration:500, easing:'swing', complete:function() {$('body').data('scrolling',false)}})
                          $(this).slideUp()
                          return false;
                        }).html('Campus Alert: '+post.title).addClass(css)

          $('body').append(mini)
            .addClass('uw-alert')

    });

})
