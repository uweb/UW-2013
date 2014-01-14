
/*
 * Sets global varibles to the jQuery object 
 *
 *   $.fn.screen for screen size
 * 
 */

$(document).ready(function() {

  $.uw = {}

  $(window).resize(function() {

    var width = $(window).width()
    
    $.uw.screensize = width > 979 ? 'desktop' :
                      width > 767 ? 'tablet'  : 'mobile';

  }).trigger('resize')

  $('table').addClass('table')

  $('li.disabled').children('a').removeAttr('href')

})
