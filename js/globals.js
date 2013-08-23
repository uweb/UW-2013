
/*
 * Sets global varibles to the jQuery object 
 *
 *   $.fn.screen for screen size
 * 
 */

$(document).ready(function() {

  $.uw = {}

  $(window).resize(function() {
    
    $.uw.screensize = $(window).width() > 768 ? 'desktop' : 'mobile';

  }).trigger('resize')

  $('table').addClass('table')

})
