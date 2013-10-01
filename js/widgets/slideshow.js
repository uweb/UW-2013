$(document).ready( function() {

/**
 * Regular
 */
  var $slideshows  = $('.slideshow-widget')
    , $window      = $(window)
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

/**
 * Mobile
 */

  $slideshows
    .data('currentSlide', 0 )
    .on('touchstart touchmove touchend', '.slide', function(e) {

    if ( $.uw.screensize === 'desktop' ) return false;

    var $this   = $(this)
      , $canvas = $this.closest('.widget')
      , $slides = $this.siblings('.slide').andSelf()
      , $navs   = $canvas.find('li a')
      , width   = $this.width()
      , target  = 'IMG' //e.target.nodeName 

    switch(e.type) 
    {

      case 'touchstart':

        $window.trigger('resize')
        $slides.data({ 
          'touchStartPosition': e.originalEvent.touches[0].pageX,
          'originalLeft'  : $this.position().left
        })

        break;

      case 'touchmove':
        var del = e.originalEvent.changedTouches[0].pageX - $slides.data('touchStartPosition') + $slides.data('originalLeft')
          , left = $this.position().left

        $slides
          .data({
            'currentPosition' : left,
            'currentDiff'     : width - left
          })
          .transition({
            'x' : del + width * $canvas.data('currentSlide')
            },{ 
              queue: false 
          })

//        $slides
//          .find( target )
//          .transition({
//            'x' : del / 5
//            },{ 
//              queue: false 
//          })

        break;
      
      case 'touchend':

        var del     = e.originalEvent.changedTouches[0].pageX - $this.data('touchStartPosition')
          , current = $canvas.data('currentSlide') 
          , move    = Math.max( Math.abs(del/width), 0.3 ) == 0.3 ? 0 : del/width;

        if ( move === 0 ||
             move > 0 && ! $this.prev('.slide').length || 
             move < 0 && ! $this.next('.slide').length ) 
        {

          $slides.transition({'x':  $canvas.data('currentSlide') * width })

        } 
        else if ( move > 0.3 )
        {

          current += 1
          $canvas.data( 'currentSlide', current )
          $slides.transition({ 'x': width * current }) 

        } else {

          current -= 1
          $canvas.data( 'currentSlide', current )
          $slides.transition({ 'x' : width * current }) 
        }

        $navs.removeClass( ACTIVE_SLIDE )
          .eq( Math.abs(current) ).addClass( ACTIVE_SLIDE )


        break;

      case 'default':

        return false;

    }

    return false;
    
  })


  $window.bind( 'scroll', function() {

    if ( $.uw.screensize != 'desktop' )
      return;

    var $this = $(this)
      , diff  = Math.max( -40 * $this.scrollTop() / $this.height() , -15 )

    $slideshows
      .find('img').css('margin-top', diff + '%' )

  }).resize( function() {

    if ( $.uw.screensize != 'desktop' ) 
    {
      $('.slide').width( $window.width() ) 
    } else {
      $slideshows.removeAttr('style')
        .find('.slide').removeAttr('style')
    }

  }).trigger('resize')

});
