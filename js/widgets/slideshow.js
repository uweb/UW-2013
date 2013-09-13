$(document).ready( function() {

  var $slideshows  = $('.slideshow-widget')
    , ACTIVE_SLIDE = 'active-slide'
    , DURATION     = 100

  $slideshows.on('click', 'li > a', function() {

    var $this       = $(this)
      , $slideshow  = $this.closest('.widget')
      , $slides     = $slideshow.find('.slide')
      , $navs       = $slideshow.find('li a')

    if ( $this.hasClass( ACTIVE_SLIDE ))
      return false;

    $navs.removeClass( ACTIVE_SLIDE )
    $this.addClass( ACTIVE_SLIDE )

    // animation is done with css
    $slides
      .filter( '.' + ACTIVE_SLIDE )
      .removeClass( ACTIVE_SLIDE )
        .end()
      .eq( $this.parent().index() )
        .addClass( ACTIVE_SLIDE )

      $slideshow.data('currentSlide', $this.parent().index() )
  
    return false;

  } )

  $(window).bind( 'scroll', function() {

    var $this = $(this)
      , diff  = Math.max( -40 * $this.scrollTop() / $this.height() , -15 )

    $slideshows
      .find('img').css('margin-top', diff + '%' )

  } )

/*.bind('touchstart touchmove touchend', function(e) {

    var $this = $(this)
      , $img  = $(e.target)
      , $navs = $this.find('li a')
      , width = $this.width()

    switch(e.type) 
    {

      case 'touchstart':

        $this.data('touchStartPosition', e.originalEvent.touches[0].pageX )

        break;

      case 'touchmove':
        var del = e.originalEvent.changedTouches[0].pageX - $this.data('touchStartPosition')
          , next    = ( del < 0 && current < $navs.length ) ? current + 1 : 
                      ( del > 0 && current > 0 )            ? current - 1 : 0;
        
        //console.log( 10 * del/width, del, width )

        $img.css( {
          'left' : del,
          //'opacity': 1 - del/width,
          '-webkit-transform' : 'rotate( ' + (10 * del/width ) + 'deg)'
        })

        break;
      
      case 'touchend':

        var del     = e.originalEvent.changedTouches[0].pageX - $this.data('touchStartPosition')
          , current = $this.data('currentSlide') || 0
          , next    = ( del < 0 && current < $navs.length ) ? current + 1 : 
                      ( del > 0 && current > 0 )            ? current - 1 : 0;

        $this.data( 'touchStartPosition', null )

        $navs.eq( next ).trigger('click')
        
        break;

      case 'default':

        return false;

    }
    
  })
  */

});
