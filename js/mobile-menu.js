$(document).ready(function() {

  var ANCHORS         = '#dawgdrops-mobile .menu-item a'
    , MOBILE_MENU_ULS = '#uw-mobile-panel ul.sub-menu'
    , SUB_MENUS       = 'ul.sub-menu'
    , OPEN_CLASS      = 'open'
    
  $( MOBILE_MENU_ULS ).hide()

  $('#listicon-wrapper').bind('click touchstart', function() {
    var open = $('#slide').length == 1
      , pos  = open ? '0%' : '85%'

    if ( ! open ) {
      $('body')
        .contents()
          .not('#wpadminbar, #uw-mobile-panel')
          .wrapAll('<div id="slide" style="position:relative;"/>')
    }
        
    $('#slide').css({ right:pos })

    $('#uw-mobile-panel').toggle()

    if ( open )
      $('#slide').contents().unwrap()

      return false;
  })
  
  $('body').on('click', ANCHORS , function() {

    var $this    = $(this)
      , $sibling = $this.siblings( SUB_MENUS )
      , $parent  = $this.parent()
      , $parents = $parent.siblings('li')

    if ( $parent.hasClass( OPEN_CLASS ) || ! $sibling.length )
      return true;

    $parents
      .filter( '.' + OPEN_CLASS )
        .children( SUB_MENUS )
        .slideUp()
          .end()
      .removeClass( OPEN_CLASS )

    $parent.addClass( OPEN_CLASS )

    $sibling.slideDown();
    
    return false;

  })

});
