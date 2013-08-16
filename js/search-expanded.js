$(document).ready( function() {

  var WIDTH         = 225
    , DIRECTORY_URL = 'http://www.washington.edu/home/peopledir/?method=name&whichdir=both&term='
    , $body         = $('body')
    , $search       = $('#search')
    , $form         = $search.find('form')
    , $inputs       = $search.find('input[type=radio]')
    , $soptions     = $search.find('.search-options')
    //, $toggle   = $search.find('.search-toggle')
    , $q = $('#q')
    //, ie = $.browser.msie //$('[id^=ie]')

  $inputs.first().prop('checked', true)

  $inputs.change(function() {

    var str = 'Search ' + $(this).data('placeholder')

    $q.prop('placeholder', str).attr('placeholder', str);

//    if ( ie ) $q.val(str)
//    if ( typeof _gaq !== 'undefined' ) _gaq.push(['_trackEvent', 'Enhanced Search', 'Options',  str ]);

  })

//  $toggle.click(function() {
//
////    if ( typeof _gaq !== 'undefined' ) _gaq.push(['_trackEvent', 'Enhanced Search', 'Toggle',  soptions.is(':hidden') ? 'Open' : 'Close' ]);
//
////    if ( !ie ) $q.css('width', $soptions.is(':hidden') ?  '225px' : '' )
//
//    $toggle.toggleClass('close-toggle')
//
//    $soptions.fadeToggle()
//
//  })

  $form.submit(function() {

    var $this  = $(this)
      , $input = $inputs.filter(':checked')
      , method = $input.val()

//    if ( typeof _gaq !== 'undefined' ) _gaq.push(['_trackEvent', 'Enhanced Search', 'Search',  method.charAt(0).toUpperCase() + method.slice(1) ]);

    if ( method === 'main' )
      return true;

    if ( method === 'directory') 
    {
      window.location.href = DIRECTORY_URL + $q.val()
      return false;
    }

    if ( method === 'site') 
    {
      window.location.href = $input.data('site') + '?s=' + $q.val()
      return false;
    }
    return true;

  })

  $q.bind('focus blur', function( e ) {

    //$toggle.fadeIn();
    $soptions.fadeIn();
    $q.css('width', '225px' );

    $body.bind( 'click', function( e ) {

      if ( ! $(e.target).closest('#search').length ) 
      {
        $body.unbind('click');
        $soptions.fadeOut();
        $q.css('width', '' );
      } 

      return true;

    })

    //if ( typeof _gaq !== 'undefined' ) _gaq.push(['_trackEvent', 'Enhanced Search','Focus',$(this).attr('placeholder')]);

  })



})
