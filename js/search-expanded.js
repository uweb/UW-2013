$(document).ready( function() {

  var WIDTH         = 225
    , DIRECTORY_URL = 'http://www.washington.edu/home/peopledir/?method=name&whichdir=both&term='
    , $body         = $('body')
    , $search       = $('#search')
    , $form         = $search.find('form')
    , $inputs       = $search.find('input[type=radio]')
    , $soptions     = $search.find('.search-options')
    , $q = $('#q')

  $inputs.first().prop('checked', true)

  $inputs.change(function() {

    var str = 'Search ' + $(this).data('placeholder')

    $q.prop('placeholder', str).attr('placeholder', str);

  })

  $form.submit(function() {

    var $this  = $(this)
      , $input = $inputs.filter(':checked')
      , method = $input.val()

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

  })

  // Accessibility to close the search options 
  $soptions
    .find('input')
    .bind('focus blur', function( e ) {
  
        switch( e.type ) 
        {
          case 'focus':
            $soptions.stop().fadeIn()
            $q.css('width', '225px' );
            break;
          
          case 'blur':
            $soptions.stop().fadeOut()
            $q.css('width', '' );
            break;
        }

    })

  // Accssibility to close the search options
  $('a.wordmark').bind('focus', function() {
    $body.trigger('click') 
  })

})
