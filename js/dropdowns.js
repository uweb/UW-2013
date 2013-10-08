/**
 * Dropdown menu
 *
 */

$(document).ready(function() {

  var $nav           = $('#dawgdrops')
    , $submenus      = $('ul.dawgdrops-menu')
    , $caret         = $('<span/>').addClass('navbar-caret')
    , HOVER_ELEMENTS = 'li.dawgdrops-item'
    , MENU_ANCHOR    = 'a.dropdown-toggle'
    , SUB_MENU       = 'ul.dawgdrops-menu'
    , MENU_WRAP_DIVS = '<div class="menu-wrap"><div class="inner-wrap"></div></div>'
    , MENU_BLOCK_DIV = '<div class="menu-block"/>' 
    , MENU_DIVISIONS = 7
    , FULL_WIDTH     = 980
    , CARET_ADJUST   = 20
    , CARET_FADE     = 100 

  $nav
    .find('ul')
      .first()
      .before($caret)
  
  $submenus
    .each(function() {

      var $this     = $(this)
        , $children = $this.find('li')
        , init_pos  = $this.siblings('a').position().left
        , shift     = 0

      $children.wrapAll( MENU_WRAP_DIVS )

      for (var i=0; i<$children.length; i+=MENU_DIVISIONS) 
      {
        $children.slice( i , i+MENU_DIVISIONS ).wrapAll( MENU_BLOCK_DIV )
      }

      $this.find( '.menu-block' ).filter(function() {
        shift += $(this).outerWidth()
      })

      shift += init_pos 

      $this.css('left', shift > FULL_WIDTH ? init_pos - ( shift - FULL_WIDTH ) : init_pos )

    }) 

    $( HOVER_ELEMENTS ).on({

      mouseenter: function( e ) 
      {

        if ( $.uw.screensize != 'desktop' ) 
          return false;

        var $this = $(this)
          , $a    = $this.children( MENU_ANCHOR )
          , $ul   = $this.children( SUB_MENU )

        $ul
          .addClass('open')
          .attr('aria-expanded','true')

        if ( $ul.length !== 0 )
          $caret
            .css('left', $a.position().left + CARET_ADJUST )
            .fadeIn( CARET_FADE );
      },

      mouseleave: function( e ) 
      {

        if ( $.uw.screensize != 'desktop' ) 
          return false;

        var $this = $(this)
          , $ul   = $this.children( SUB_MENU )

        $ul
          .removeClass('open')
          .attr('aria-expanded','false')

        $caret.stop().hide()
                  
      },

      click: function( e ) 
      {
         return ( $.uw.screensize == 'desktop' )
      }
    })

})
